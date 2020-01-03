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

if (!function_exists('generate_package_sn')) {
    function generate_package_sn()
    {
        $randoms = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        $order_number = array_rand($randoms) . array_rand($randoms) . array_rand($randoms) . array_rand($randoms);
        list($microsecond, $second) = explode(" ", microtime());
        $micro_time = str_pad((int)round($microsecond * 1000), 3, "0", STR_PAD_LEFT);
        $number = date('ymdHis' . $micro_time, time()) . $order_number;

        return $number;
    }
}
