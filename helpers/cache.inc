<?php
require_once dirname(__FILE__) . '/../config.php';

class Cache {
    private static $dir = CACHE_DIR;

    private static function _name($key)
    {
        return sprintf("%s/%s", Cache::$dir, sha1($key));
    }

    public static function get($key, $expiration = 3600)
    {

        if ( !is_dir(Cache::$dir) OR !is_writable(Cache::$dir))
        {
            return FALSE;
        }

        $cache_path = Cache::_name($key);

        if (!@file_exists($cache_path))
        {
            return FALSE;
        }

        if (filemtime($cache_path) < (time() - $expiration))
        {
            Cache::clear($key);
            return FALSE;
        }

        if (!$fp = @fopen($cache_path, 'rb'))
        {
            return FALSE;
        }

        flock($fp, LOCK_SH);

        $cache = '';

        if (filesize($cache_path) > 0)
        {
            $cache = unserialize(fread($fp, filesize($cache_path)));
        }
        else
        {
            $cache = NULL;
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return $cache;
    }

    public static function set($key, $data)
    {

        if ( !is_dir(Cache::$dir) OR !is_writable(Cache::$dir))
        {
            return FALSE;
        }

        $cache_path = Cache::_name($key);

        if ( ! $fp = fopen($cache_path, 'wb'))
        {
            return FALSE;
        }

        if (flock($fp, LOCK_EX))
        {
            fwrite($fp, serialize($data));
            flock($fp, LOCK_UN);
        }
        else
        {
            return FALSE;
        }
        fclose($fp);
        @chmod($cache_path, 0777);
        return TRUE;
    }


    public function clear($key)
    {
        $cache_path = Cache::_name($key);

        if (file_exists($cache_path))
        {
            unlink($cache_path);
            return TRUE;
        }

        return FALSE;
    }
}