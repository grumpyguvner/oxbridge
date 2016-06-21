<?php
class NitroBrowser {
    public static $connections = array();
    public $hosts_cache = array();
    public $URL;
    public $sock;
    public $timeout;
    public $read_chunk_size = 4096;
    public $max_response_size;
    public $buffer = '';
    public $headers = array();
    public $request_headers = array();
    public $status_code = 200;
    public $body = '';

    public function __construct($URL) {
        $this->URL = $URL;

        $this->timeout = 5;//in seconds
        $this->max_response_size = 1024 * 1024 * 5;
    }

    public function __destruct() {
        //$this->disconnect(); this is commented so we can keep the connection-alive
    }

    public function disconnect() {
        if (is_resource($this->sock)) {
            fclose($this->sock);
        }
    }

    public function setURL($URL) {
        $this->URL = $URL;
    }

    public function parseURL() {
        if (!empty($this->URL)) {
            $info = parse_url($this->URL);
            if (count($info) == 1 && !empty($info['path'])) { // for some reason example.com is considered path
                $this->host = $info['path'];
                $this->port = 80;
                $this->path = '/';
            } else {
                if (!empty($info['host'])) {
                    $this->host = $info['host'];
                } else {
                    throw new URLInvalidException('Invalid URL');
                }

                if (!empty($info['scheme']) && !in_array($info['scheme'], array('http', 'https'))) {
                    throw new URLUnsupportedProtocolException('Unsupported protocol');
                }

                $this->port = !empty($info['port']) ? $info['port'] : ( (!empty($info['scheme']) && $info['scheme'] == 'https') ? 443 : 80 );

                $this->path = !empty($info['path']) ? $info['path'] : '/';

                if (!empty($info['query'])) {
                    $this->path .= '?' . $info['query'];
                }
            }
            $this->addr = $this->gethostbyname($this->host);
        } else {
            throw new URLEmptyException('URL is empty');
        }
    }

    public function gethostbyname($host) {
        if (!isset($this->hosts_cache[$host])) {
            $this->hosts_cache[$host] = gethostbyname($host);
        }

        return $this->hosts_cache[$host];
    }

    public function fetch($follow_redirects = true, $method = "GET") {
        $this->buffer = '';

        $this->http_method = strtoupper($method);

        $this->parseURL();
        $this->connect();
        $this->sendRequest($this->getRequestHeaders());
        $this->download();

        if ($follow_redirects && !empty($this->headers['Location'])) {
            $this->setURL($this->headers['Location']);
            $this->fetch(true, $this->http_method);
        }
    }

    public function setHeader($header, $value) {
        $this->request_headers[$header] = $value;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getBody() {
        return $this->body;
    }

    public function getStatusCode() {
        return $this->status_code;
    }

    public function connect() {
        if (isset(self::$connections[$this->addr.':'.$this->port])) {
            $this->sock = self::$connections[$this->addr.':'.$this->port];
            if (is_resource($this->sock) && !feof($this->sock)) {// check if the connection is still alive
                return;
            }
        }

        if (stripos(ini_get('disable_functions'), 'stream_socket_client') !== FALSE) {
            throw new RuntimeException("stream_socket_client is disabled.");	
        }

        $errno = $errorMessage = NULL;
        $this->sock = stream_socket_client("tcp://$this->addr:$this->port", $errno, $errorMessage, $this->timeout);

        if($this->sock === false) {
            throw new SocketOpenException('Unable to open socket to: ' . $this->host .' on port ' . $this->port);
        }

        set_error_handler(array($this, 'error_sink'));
        if ($this->port == 443) {
            if (!@stream_socket_enable_crypto($this->sock, true, STREAM_CRYPTO_METHOD_SSLv3_CLIENT)) {
                if (!@stream_socket_enable_crypto($this->sock, true, STREAM_CRYPTO_METHOD_SSLv23_CLIENT)) {
                    if (!@stream_socket_enable_crypto($this->sock, true, STREAM_CRYPTO_METHOD_SSLv2_CLIENT)) {
                        restore_error_handler();
                        throw new SocketOpenException('Unable to establish secure connection to: ' . $this->host .' on port ' . $this->port);
                    }
                }
            }
        }
        restore_error_handler();

        self::$connections[$this->addr.':'.$this->port] = $this->sock;
    }

    public function sendRequest($request) {
        stream_set_blocking($this->sock, false);
        $startTime = microtime(true);
        do {
            $wrote = fwrite($this->sock, $request);

            if ($wrote === false) {
                fclose($this->sock);
                throw new SocketWriteException('Cannot write to socket');
            }
            fflush($this->sock);

            if ((microtime(true) - $startTime) > $this->timeout) {
                fclose($this->sock);
                throw new SocketWriteException('Writing to socket timed out');
            }

            $request = substr($request, $wrote);
        } while($request);
        stream_set_blocking($this->sock, true);
    }

    public function download() {
        stream_set_blocking($this->sock, false);
        $this->headers = array();
        $data_len = $this->max_response_size;

        $startTime = microtime(true);
        do {
            $data = fread($this->sock, $this->read_chunk_size);
            if ($data) {
                $this->buffer .= $data;
            }

            if (strlen($this->buffer) > $this->max_response_size) {
                fclose($this->sock);
                throw new ResponseTooLargeException('Response data exceeds the limit of ' . $this->max_response_size . ' bytes');
            }

            if ((microtime(true) - $startTime) > $this->timeout) {
                fclose($this->sock);
                throw new SocketConTimedOutException("Reading data from the remote host timed out");
            }

            if (!$this->headers && $this->extractHeaders()) {
                if ($this->http_method == 'HEAD') break;

                foreach ($this->headers as $name => $value) {
                    if (strtolower($name) == 'content-length') {
                        $data_len = (int)$value;
                    }

                    if (strtolower($name) == 'location') {
                        break 2;
                    }
                }
            }
        } while (strlen($this->buffer) < $data_len);

        $this->body = $this->buffer;
        $this->buffer = '';
        stream_set_blocking($this->sock, true);

        foreach ($this->headers as $name => $value) {
            if (strtolower($name) == 'connection' && $value == 'close') {
                $this->disconnect();
            }
        }
    }

    public function extractHeaders() {
        if ($this->headers) return true;

        $headers_end = strpos($this->buffer, "\r\n\r\n");

        if ($headers_end) {
            $headers_str = substr($this->buffer, 0, $headers_end);
            $this->buffer = substr($this->buffer, $headers_end+4);
            preg_match_all('/^(.*)/mi', $headers_str, $headers);
            foreach ($headers[1] as $header) {
                $parts = explode(": ", trim($header));
                $name = array_shift($parts);
                $value = implode(": ", $parts);
                $this->headers[$name] = $value;
            }

            $statusline_keys = array_keys($this->headers);
            $statusline = $statusline_keys[0];

            if (preg_match('/\d{3}/', $statusline, $matches)) {
                $this->status_code = (int)$matches[0];
            }

            return true;
        }

        return false;
    }

    public function getRequestHeaders() {
        $headers = array();
        $headers[] = $this->http_method . " " . $this->path . " HTTP/1.1";
        $headers[] = "Host: " . $this->host;
        //$headers[] = "Connection: close";

        if (!empty($this->request_headers)) {
            foreach ($this->request_headers as $name => $value) {
                $headers[] =  $name . ": " . $value;
            }
        }
        return implode("\n", $headers) . "\n\n";
    }

    private function error_sink($errno, $errstr) {}
}

class URLException extends Exception {}
class URLEmptyException extends Exception {}
class URLInvalidException extends Exception {}
class URLUnsupportedProtocolException extends Exception {}
class SocketOpenException extends Exception {}
class SocketWriteException extends Exception {}
class SocketConTimedOutException extends Exception {}
class ResponseTooLargeException extends Exception {}
