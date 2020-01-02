<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

if (!function_exists('generate_unique_id')) {
    /**
     * 通过redis生成唯一值
     *
     * @param string $key
     * @return integer
     */
    function generate_unique_id($seed = 1000000, $key = 'logistics-primary-key')
    {
        $key = strtoupper($key);
        if ($seed > Redis::get($key)) {
            Redis::set($key, $seed);
        }
        return Redis::incr($key);
    }
}

if (!function_exists('get_last_sql')) {
    /**
     * 获取最近一次执行的指令
     *
     * @return string
     * @access public
     */
    function get_last_sql()
    {
        // Register a database query listener with the connection.
        DB::listen(function ($sql) {
            $query = $sql->sql;
            if ($sql->bindings) {
                foreach ($sql->bindings as $replace) {
                    $value = is_numeric($replace) ? $replace : "'" . $replace . "'";
                    $query = preg_replace('/\?/', $value, $query, 1);
                }
            }
            dump($query);
        });
    }
}
