<?
/**
 * Boostack: api.php
 * ========================================================================
 * Copyright 2015-2016 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 2.1
 */

// #######################
require_once "core/environment_init.php";

if (! array_key_exists('HTTP_ORIGIN', $_SERVER))
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];

try {
    $api = new Rest_Api(sanitizeInput($_REQUEST['request']), sanitizeInput($_SERVER['HTTP_ORIGIN']));
    echo $api->processAPI();
}
catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
?>