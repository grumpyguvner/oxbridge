<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "core.php";

class NitroDbCache {
    public static $driver = null;

    public static function getMemcacheHost() {
        $host = getNitroPersistence('DBCache.MemcacheHost');
        return !$host ? 'localhost' : $host;
    }

    public static function getMemcachePort() {
        $port = getNitroPersistence('DBCache.MemcachePort');
        return !$port ? '11211' : $port;
    }

    public static function getExpireTime() {
        $ttl = getNitroPersistence('DBCache.ExpireTime');
        return !$ttl ? '3600' : $ttl;
    }

    public static function init() {
        if (self::$driver === null) {
            $ds = DIRECTORY_SEPARATOR;

            $depo = getNitroPersistence('DBCache.CacheDepo');

            switch ($depo) {
            case 'hdd':
                require_once dirname(__FILE__) . $ds . "NitroDbCache" . $ds . "NitroDbCacheHDD.php";
                self::$driver = new NitroDbCacheHDD(NITRO_DBCACHE_FOLDER, self::getExpireTime());
                break;
            case 'ram_eaccelerator':
                require_once dirname(__FILE__) . $ds . "NitroDbCache" . $ds . "NitroDbCacheEAccelerator.php";
                self::$driver = new NitroDbCacheEAccelerator();
                break;
            case 'ram_xcache':
                require_once dirname(__FILE__) . $ds . "NitroDbCache" . $ds . "NitroDbCacheXCache.php";
                self::$driver = new NitroDbCacheXCache();
                break;
            case 'ram_memcache':
                require_once dirname(__FILE__) . $ds . "NitroDbCache" . $ds . "NitroDbCacheMemcache.php";
                $host = self::getMemcacheHost();
                $port = self::getMemcachePort();
                self::$driver = new NitroDbCacheMemcache($host, $port);
                break;
            }
        }
    }

    public static function clear() {
        if (self::$driver === null) {
            self::init();
        }

        return self::$driver->clear();
    }

    public static function set($key, $value, $expire = false) {
        $ttl = $expire ? $expire : self::getExpireTime();
        $value = serialize($value);

        if (self::$driver === null) {
            self::init();
        }

        return self::$driver->set($key, $value, $ttl);
    }

    public static function get($key) {
        if (self::$driver === null) {
            self::init();
        }

        return unserialize(self::$driver->get($key));
    }
}
