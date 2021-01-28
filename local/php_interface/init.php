<?
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/const.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/const.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/CIBlockHandler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/CIBlockHandler.php');
}


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/ClientErrorHandler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/ClientErrorHandler.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/MailHandler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/MailHandler.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/GlobalMenuHandler.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/handlers/GlobalMenuHandler.php');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/agents/users_count_agent.php')){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/agents/users_count_agent.php');
}
?>