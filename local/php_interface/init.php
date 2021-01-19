<?
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/const.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/const.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/event_handler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/event_handler.php');
}


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/client_error_handler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/client_error_handler.php');
}