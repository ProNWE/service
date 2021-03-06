<?php
/**
 * Created by PhpStorm.
 * User: Murod's Macbook Pro
 * Date: 16.03.2016
 * Time: 21:42
 */
class Ajax extends Dispatch {

    function before() {
        $this->auto_render = false;

        if (!self::is_ajax()) {
            throw new HTTP_Exception_403();
        }

        parent::before();

        $this->checkCsrf();

    }

    public static function is_ajax()
    {
        if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;

        return false;
    }
}