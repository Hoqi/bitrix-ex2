<?
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/const.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/const.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/event_handler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/event_handler.php');
}


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/client_error_handler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/client_error_handler.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/mail_handler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/mail_handler.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/global_menu_handler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/global_menu_handler.php');
}

?>