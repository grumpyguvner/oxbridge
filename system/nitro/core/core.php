<?php
require_once(DIR_SYSTEM . 'nitro/config.php');
require_once NITRO_CORE_FOLDER . 'nitro_db.php';
require_once NITRO_CORE_FOLDER . 'top.php';

if (!function_exists('np')) {
    function np($var, $exit = false, $file = false) {
        if ($file) {
            file_put_contents(NITRO_NP_FILE, var_export($var, true) . PHP_EOL . PHP_EOL, $file);
        } else {
            echo '<pre>'; var_dump($var); echo '</pre>';
        }

        if ($exit) exit;
    }
}

function clearRAMCache() {
    require_once(NITRO_LIB_FOLDER . 'NitroDbCache.php');
    NitroDbCache::clear();
}

function &nitroGetSession() {
    if (!defined('VERSION')) {
        define('VERSION', nitroGetVersion());
    }

    if (VERSION > '2.0.3.1' && !empty($_SESSION['default'])) {
        return $_SESSION['default'];
    }

    return $_SESSION;
}

function getSupportedCookiesPrefix() {
    $cookies = getSupportedCookies();
    $str = '';

    foreach ($_COOKIE as $cookieName=>$cookieValue) {
        foreach ($cookies as $cookie) {
            if (preg_match('~' . str_replace(array('~', '#asterisk#'), array('\~', '.*'), preg_quote(str_replace('*', '#asterisk#', $cookie))) . '~', $cookieName)) {
                $str .= $cookieName.'='.$cookieValue.';';
            }
        }
    }

    return substr(md5($str), 0, 16);
}

function getMobilePrefix() {
    $resp = mobileCheck();
    $prefix = "";
    $prefix .= $resp & 1 ? "mobile-" : "";
    $prefix .= $resp & 2 ? "tablet-" : "";
    return $prefix;
}

function nitroGetLanguage() {
    $session = &nitroGetSession();
    $default_language = !empty($_COOKIE['language']) ? $_COOKIE['language'] : '0';
    return strtolower((!empty($session['language']) && is_string($session['language'])) ? $session['language'] : $default_language); 
}

function nitroGetCurrency() {
    $session = &nitroGetSession();
    $default_currency = !empty($_COOKIE['currency']) ? $_COOKIE['currency'] : '0';
    return strtolower((!empty($session['currency']) && is_string($session['currency'])) ? $session['currency'] : $default_currency); 
}

function generateNameOfCacheFile() {
    if (!empty($GLOBALS['nitro.pagecache.file'])) {
        return $GLOBALS['nitro.pagecache.file'];
    }

    nitroEnableSession();

    $session = &nitroGetSession();
    if (empty($session['language']) && empty($session['currency'])) {
        $db = NitroDb::getInstance();
        // In, when the site is opened for first time

        // Store
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $store_query = $db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`ssl`, 'www.', '') = '" . $db->escape('https://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
        } else {
            $store_query = $db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`url`, 'www.', '') = '" . $db->escape('http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
        }

        $store_id = 0;

        if ($store_query->num_rows) {
            $result = $store_query->row;
            $store_id = (int)$result['store_id'];
        }

        $GLOBALS['nitro.store_id'] = $store_id;

        $resource = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE (`key`='config_language' OR `key`='config_currency') AND `store_id` = '" . $store_id . "'");

        if ($resource->num_rows) {
            $data = array();
            $config_language = 0;
            $config_currency = 0;

            foreach ($resource->rows as $result) {
                if (!empty($result['key']) && $result['key'] == 'config_language') {
                    $config_language = strtolower($result['value']);
                }
                if (!empty($result['key']) && $result['key'] == 'config_currency') {
                    $config_currency = strtolower($result['value']);
                }
            }

            if (isset($_SESSION)) {
                $session['language'] = $config_language;
                $session['currency'] = $config_currency;
            }
        }
    }

    $filename = getFullURL();

    $filename = str_replace(array('/','?',':',';','=','&amp;','&','.','--','%','~','-amp-'),'-',$filename);

    $language = nitroGetLanguage();
    $currency = nitroGetCurrency();

    $cookie_prefix = getSupportedCookiesPrefix();

    if (NITRO_DEBUG_MODE) {
        $cached_filename = $filename.'-'.$language.'-'.$currency.'-'.$cookie_prefix.'.html';
    } else {
        $cached_filename = md5($filename.'-'.$language.'-'.$currency.'-'.$cookie_prefix).'.html';
    }

    $GLOBALS['nitro.pagecache.file'] = getSSLCachePrefix() . getMobilePrefix() . $cached_filename;

    return $GLOBALS['nitro.pagecache.file'];
}

function explodeTrim($delimiter, $string) {
    return 
        !empty($string) ? 
        array_filter(array_map('trim', explode($delimiter, $string))) : 
        array();
}

function getSpecialHeaders() {
    $important_headers = array(//if the key is present and the value is not, then the headers will be saved
        'content-type' => 'html'
    );
    $headers = headers_list();
    if (!empty($headers)) {
        foreach ($headers as $header) {
            foreach ($important_headers as $h=>$v) {
                if (strpos(strtolower($header), $h) !== false && strpos(strtolower($header), $v) === false) {
                    return implode("\n", $headers);
                }
            }
        }
    }
    return '';
}

function getIgnoredUrls() {
    $ignoredUrls = explodeTrim("\n", getNitroPersistence('DisabledURLs'));

    $predefinedIgnoredUrls = array('/admin/', 'isearch');
    //See if we are in admin
    $dir = basename(DIR_APPLICATION);

    if (!in_array($dir, array('admin', 'catalog'))) {
        $predefinedIgnoredUrls[] = '/'.$dir.'/';
    }

    $ignoredUrls = array_merge($predefinedIgnoredUrls, $ignoredUrls);

    return $ignoredUrls;
}

function nitroEnableSession() {
    if (!session_id()) {
        session_start();
    }
}

function isAdminLogged() {
    nitroEnableSession();

    $session = &nitroGetSession();
    return !empty($session['user_id']);
}

function getFullURL() {
    $host = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
    $request_uri = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
    return $host . $request_uri;
}

function areWeInIgnoredUrl() {
    if (basename(DIR_APPLICATION) != 'catalog') return true;

    $url = getFullURL();

    $ignoredUrls = getIgnoredUrls();

    foreach ($ignoredUrls as $ignoredUrl) {
        if ($ignoredUrl[0] != '!') {
            if (preg_match('~' . str_replace(array('~', '#asterisk#'), array('\~', '.*'), preg_quote(str_replace('*', '#asterisk#', $ignoredUrl))) . '~', $url)) {
                return true;
            }
        } else {
            if (!preg_match('~' . str_replace(array('~', '#asterisk#'), array('\~', '.*'), preg_quote(str_replace('*', '#asterisk#', substr($ignoredUrl, 1)))) . '~', $url)) {
                return true;
            }
        }
    }

    return false;
}

function initNitroProductCacheDb() {
    if (
        (
            !getNitroPersistence('Enabled') || 
            !getNitroPersistence('PageCache.ClearCacheOnProductEdit') || 
            !getNitroPersistence('PageCache.Enabled')
        ) && !(
            !empty($_POST['Nitro']['PageCache']['ClearCacheOnProductEdit']) && 
            $_POST['Nitro']['PageCache']['ClearCacheOnProductEdit'] == 'yes'
        )
    ) return;

    if (NitroDb::$created_nitro_product_cache) return;

    $db = NitroDb::getInstance();

    $db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "nitro_product_cache` ( `product_id` int(11) NOT NULL, `cachefile` text NOT NULL, `expires` DATETIME, KEY `product_id` (`product_id`), KEY `expires` (`expires`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");

    NitroDb::$created_nitro_product_cache = true;
}

function setNitroProductCache($product_id, $cachefile) {
    if (!passesPageCacheValidation() || !getNitroPersistence('Enabled') || !getNitroPersistence('PageCache.ClearCacheOnProductEdit') || !getNitroPersistence('PageCache.Enabled')) return;

    initNitroProductCacheDb();

    $db = NitroDb::getInstance();

    $db->query("INSERT IGNORE INTO `" . DB_PREFIX . "nitro_product_cache` SET product_id='" . (int)$product_id . "', cachefile = '" . $cachefile . "', expires='" . date('Y-m-d H:i:s', time() + getPageCacheTime()) . "'");
}

function getOpenCartSetting($key, $store_id = 0) {
    if (isset($GLOBALS["nitro.opencart_setting.$store_id.$key"])) return $GLOBALS["nitro.opencart_setting.$store_id.$key"];

    $db = NitroDb::getInstance();

    nitroEnableSession();

    $store_id = $store_id == 0 && !empty($GLOBALS['nitro.store_id']) ? (int)$GLOBALS['nitro.store_id'] : $store_id;

    $query = $db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE `key`='" . $key . "' AND store_id='" . $store_id . "'");
    if (!empty($query->num_rows)) {
        $result = end($query->rows);
        if (isset($result['value'])) {
            $GLOBALS["nitro.opencart_setting.$store_id.$key"] = $result['value'];
            return $result['value'];
        }
    }
    $GLOBALS["nitro.opencart_setting.$store_id.$key"] = null;
    return null;
}

function inMaintenanceMode() {
    return getOpenCartSetting('config_maintenance') == '1';
}

function isNitroTempDisabled() {
    $lock_file = NITRO_FOLDER . 'nitro.lock';
    return file_exists($lock_file) && (time() - filemtime($lock_file) < 60);
}

function isNitroEnabled() {
    return getNitroPersistence('Enabled') && !areWeInIgnoredUrl() && !inMaintenanceMode() && !isNitroTempDisabled();
}

function mobileCheck() {
    $categorizr = DIR_SYSTEM . 'library/categorizr.php';
    $device = DIR_SYSTEM . 'library/device.php';
    $resp = 0;

    if (file_exists($categorizr)) {
        require_once($categorizr);

        $resp ^= isMobile() ? 1 : 0;
        $resp ^= isTablet() ? 2 : 0;
    } else {
        if (isset($_COOKIE['is_mobile']) && (int)$_COOKIE['is_mobile'] == 1) return 1;

        if (!function_exists('deviceIsMobile')) {
            function deviceIsMobile() {
                $mobile = false;

                if(isset($_SERVER['HTTP_USER_AGENT'])) {

                    $mobile_agents = array('iPod','iPhone','webOS','BlackBerry','windows phone','symbian','vodafone','opera mini','windows ce','smartphone','palm','midp');

                    foreach($mobile_agents as $mobile_agent){
                        if(stripos($_SERVER['HTTP_USER_AGENT'],$mobile_agent)){
                            $mobile = true;
                        }
                    }
                    if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
                        $mobile = true;
                    }

                }
                return $mobile;
            }
        }

        if (!function_exists('deviceIsTablet')) {
            function deviceIsTablet() {
                $tablet = false;

                if(isset($_SERVER['HTTP_USER_AGENT'])) {

                    $tablet_agents = array('iPad','RIM Tablet','hp-tablet','Kindle Fire','Android');

                    foreach($tablet_agents as $tablet_agent){
                        if(stripos($_SERVER['HTTP_USER_AGENT'],$tablet_agent)){
                            $tablet = true;
                        }
                    }

                    if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
                        $tablet = false;
                    }
                }
                return $tablet;
            }
        }

        $resp ^= deviceIsMobile() ? 1 : 0;
        $resp ^= deviceIsTablet() ? 2 : 0;
    }

    return $resp;
}

function refreshNitroPersistenceGlobal() {
    $data = file_get_contents(NITRO_PERSISTENCE);
    $data = base64_decode($data);
    $returnData = json_decode($data, true);
    $GLOBALS['nitro.persistence'] = $returnData;
    return $returnData;
}

function getNitroPersistence($key = '') {
    if (empty($GLOBALS['nitro.persistence']) && file_exists(NITRO_PERSISTENCE)) {
        $returnData = refreshNitroPersistenceGlobal();
    } else {
        if (!empty($GLOBALS['nitro.persistence'])) {
            $returnData = $GLOBALS['nitro.persistence'];
        } else {
            $returnData = false;	
        }
    }

    if (!empty($key)) {
        if (!empty($GLOBALS['nitro.persistence.' . $key])) {
            $returnData = $GLOBALS['nitro.persistence.' . $key];
        } else {
            $subkeys = explode('.', $key);
            array_unshift($subkeys, 'Nitro');

            while (!empty($subkeys)) {
                $subkey = array_shift($subkeys);

                if (!empty($returnData[$subkey])) {
                    $returnData = $returnData[$subkey];

                    if (is_string($returnData)) {
                        $returnData = trim($returnData);
                    }
                } else {
                    $returnData = false;
                    break;
                }
            }

            $GLOBALS['nitro.persistence.' . $key] = $returnData;
        }

        switch ($returnData) {
        case 'yes' : $returnData = true; break;
        case 'no' : $returnData = false; break;
        }

        $result = $returnData;

    } else {

        $result = !empty($returnData) ? $returnData : false;
    }

    return $result;
}

function nitroCheckFolder($folder) {
    if (!is_dir($folder)) {
        mkdir($folder, NITRO_FOLDER_PERMISSIONS);	
    }
}

function setNitroPersistence($data) {
    nitroCheckFolder(NITRO_FOLDER . 'data');

    file_put_contents(NITRO_PERSISTENCE, base64_encode(json_encode($data)));

    refreshNitroPersistenceGlobal();

    return true;
}

function getNitroSmushitPersistence() {
    $file = NITRO_SMUSHIT_PERSISTENCE;

    $data = array(
        'smushed_images_count' => 0,
        'already_smushed_images_count' => 0,
        'total_images' => false,
        'kb_saved' => 0,
        'last_smush_timestamp' => 0
    );

    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
    } else {
        file_put_contents($file, json_encode($data));
    }

    return $data;
}

function setNitroSmushitPersistence($data) {
    if (is_array($data)) {
        $file = NITRO_SMUSHIT_PERSISTENCE;
        $old_data = getNitroSmushitPersistence();
        $new_data = array_merge($old_data, $data);
        file_put_contents($file, json_encode($new_data));
        return true;
    }

    return false;
}

function setGooglePageSpeedReport($data, $strategy) {
    nitroCheckFolder(NITRO_FOLDER . 'data');

    file_put_contents(NITRO_FOLDER . 'data' . DS .'googlepagespeed-' . $strategy . '.tpl', base64_encode($data));

    return true;
}

function refreshGooglePageSpeedReport($strategies = array('mobile', 'desktop')) {
    foreach($strategies as $strategy) {
        if (file_exists(NITRO_FOLDER . 'data/googlepagespeed-' . $strategy . '.tpl')) {
            if (!unlink(NITRO_FOLDER . 'data/googlepagespeed-' . $strategy . '.tpl')) {
                return 'There was a permission issue - please make sure the file system/nitro/data/googlepagespeed-' . $strategy . '.tpl has at least 644 permissions!';
            }
        }
    }

    return 'Google Page Speed Report was refreshed!';
}

function getGooglePageSpeedReport($setting = null, $strategies = array('mobile', 'desktop')) {
    foreach ($strategies as $strategy) {
        if (!file_exists(NITRO_FOLDER . 'data/googlepagespeed-' . $strategy . '.tpl')) {
            // Fetch the report and save it
            $catalogURL = (defined('HTTP_SERVER') && HTTP_SERVER != '') ? dirname(HTTP_SERVER) . '/' : false;
            if (!$catalogURL) return false;

            $persistence = getNitroPersistence();
            $persistence = $persistence['Nitro'];

            $key = !empty($persistence['GooglePageSpeedApiKey']) ? $persistence['GooglePageSpeedApiKey'] : 'AIzaSyCxptR6CbHYrHkFfsO_XN3nkf6FjoQp2Mg';

            $url = "https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=" . $catalogURL . "&key=" . $key . "&strategy=" . $strategy;

            $output = fetchRemoteContent($url);

            if (!empty($output)) {
                setGooglePageSpeedReport($output, $strategy);
            }
        }
    }

    $returnData = false;

    foreach ($strategies as $strategy) {

        if (file_exists(NITRO_FOLDER . 'data/googlepagespeed-' . $strategy . '.tpl')) {
            if (!is_array($returnData)) {
                $returnData = array();
            }

            $returnData[$strategy] = base64_decode(file_get_contents(NITRO_FOLDER . 'data' . DS . 'googlepagespeed-' . $strategy . '.tpl'));
        }
    }

    return $returnData;
}

function fetchRemoteContent($url) {
    if (strpos($url, '//') === 0) {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $url = 'https:'.$url;
        } else {
            $url = 'http:'.$url;
        }
    }

    $user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : false;

    loadNitroLib('browser');

    try {
        $browser = new NitroBrowser($url);

        if ($user_agent) {
            $browser->setHeader("User-Agent", $user_agent);
        }

        $browser->fetch();
        $content = $browser->getStatusCode() == 200 ? $browser->getBody() : '';
        $headers = $browser->getHeaders();
        if (!empty($headers['Content-Encoding']) && $headers['Content-Encoding'] == 'gzip' && !empty($headers['Content-Length'])) {
            $content = gzinflate(substr($content, 10, -8));//hack when gzencode is not available
        }
        return $content;
    } catch(Exception $e) {
        if (ini_get('allow_url_fopen')) {
            if (!function_exists('nitro_error_handler')) {
                function nitro_error_handler($errno, $errstr, $errfile, $errline) {
                    return true;
                }
            }
            set_error_handler('nitro_error_handler');
            try {
                if ($user_agent) {
                    $opts = array(
                        'http'=>array(
                            'method'=>"GET",
                            'header'=>"User-Agent: $user_agent\r\n"
                        )
                    );
                    $context = stream_context_create($opts);
                    $content = file_get_contents($url, false, $context);
                } else {
                    $content = file_get_contents($url);
                }
            } catch (Exception $e) {}
                restore_error_handler();

            if (!$content) {
                return ''; 
            }
            return $content;
        } else {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_ENCODING, "");

            if ($user_agent) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: $user_agent"));
            }

            $content = curl_exec($ch);
            curl_close($ch);
            return $content;
        }
    }
    return false;
}

function getPageCacheTime() {
    $pagecache_time = getNitroPersistence('PageCache.ExpireTime');

    return !empty($pagecache_time) && is_numeric($pagecache_time) ? (int)$pagecache_time : NITRO_PAGECACHE_TIME;
}

function minifyHTML($html) {
    require_once NITRO_FOLDER . 'lib' . DS . 'minifier' . DS . 'HTMLMin.php';

    $htmlMinifier = new Nitro_Minify_HTML($html, array(
        'jsCleanComments' => false,
        'keepHTMLComments' => getNitroPersistence('Mini.HTMLComments')
    )
);

    $html =  $htmlMinifier->process();

    return $html;
}

function getSSLCachePrefix() {
    return isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1')) ? '1-' : '0-';
}

function isExecEnabled() {
    $command = function_exists('exec') &&
        !in_array('exec', array_map('trim', explode(',', ini_get('disable_functions')))) &&
        !in_array('exec', array_map('trim', explode(',', ini_get('suhosin.executor.func.blacklist')))) &&
        !(strtolower(ini_get('safe_mode')) != 'off' && ini_get('safe_mode') != 0) && stripos(php_uname(), 'windows') === false;

    if ($command) {
        $result = array();
        exec('whoami', $result);
        return !empty($result);
    }

    return false;
}

function isCli() {
    return php_sapi_name() == 'cli' || defined('STDIN');
}

function sendNitroMail($to, $subject, $message) {
    require_once realpath(DIR_SYSTEM . 'library/mail.php');

    $mail = new Mail();
    $mail->protocol = getOpenCartSetting('config_mail_protocol');
    $mail->parameter = getOpenCartSetting('config_mail_parameter');
    $mail->hostname = getOpenCartSetting('config_smtp_host');
    $mail->username = getOpenCartSetting('config_smtp_username');
    $mail->password = getOpenCartSetting('config_smtp_password');
    $mail->port = getOpenCartSetting('config_smtp_port');
    $mail->timeout = getOpenCartSetting('config_smtp_timeout');       
    $mail->setTo($to);
    $mail->setFrom(getOpenCartSetting('config_email'));
    $mail->setSender(getOpenCartSetting('config_name'));
    $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
    $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
    $mail->send();
}

function truncateNitroProductCache() {
    $db = NitroDb::getInstance();
    if (!empty($db->query("SHOW TABLES LIKE '" . DB_PREFIX . "nitro_product_cache'")->num_rows)) {
        $db->query("TRUNCATE TABLE " . DB_PREFIX . "nitro_product_cache");
    }
}

function deleteExpiredNitroProductCache() {
    $db = NitroDb::getInstance();
    if (!empty($db->query("SHOW TABLES LIKE '" . DB_PREFIX . "nitro_product_cache'")->num_rows)) {
        $db->query("DELETE FROM " . DB_PREFIX . "nitro_product_cache WHERE expires < NOW()");
    }
}

function cleanNitroCacheFolders($touch = false, $time = false) {
    cleanFolder(NITRO_PAGECACHE_FOLDER, $touch, $time);
    cleanFolder(NITRO_DBCACHE_FOLDER, $touch, $time);
    cleanFolder(NITRO_FOLDER . 'temp' . DS, $touch, $time);
    cleanFolder(dirname(DIR_APPLICATION) . DS . 'assets' . DS . 'css' . DS, $touch, $time);
    cleanFolder(dirname(DIR_APPLICATION) . DS . 'assets' . DS . 'js' . DS, $touch, $time);

    clearRAMCache();

    deleteExpiredNitroProductCache();
}

function folderEmpty($dir, $time) {
    require_once NITRO_LIB_FOLDER . 'NitroFiles.php';

    $config = array(
        'root' => realpath($dir) . DS,
        'start' => '',
        'batch' => 0
    );

    if (!empty($time)) {
        $config['rules'][] = array(
            'delete_time' => $time
        );
    }

    $files = new NitroFiles($config);

    return $files->isEmpty();
}

function cleanNitroFiles($dir, $time) {
    require_once NITRO_LIB_FOLDER . 'NitroFiles.php';

    $config = array(
        'root' => realpath($dir) . DS,
        'batch' => 0
    );

    if (!empty($time)) {
        $config['rules'][] = array(
            'delete_time' => $time
        );
    }

    $files = new NitroFiles($config);

    $files->delete();
}

function cleanFolder($dir, $touch = false, $time = false) {
    if (!is_dir($dir)) return;

    if (isExecEnabled()) {
        exec('find ' . $dir . ' -type f -delete', $output);
    }

    cleanNitroFiles($dir, $time);

    if (is_string($touch)) {
        touch(realpath($dir) . DS . $touch);
    }
}

function loadNitroLib($lib) {
    $target = NITRO_LIB_FOLDER . preg_replace('/\.php$/', '', $lib) . '.php';
    if (file_exists($target)) {
        require_once $target;
    }
}

function getQuickCacheRefreshFilename() {
    return NITRO_PAGECACHE_FOLDER . 'clearcache';
}
