<?php

use Illuminate\Support\Facades\DB;

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
