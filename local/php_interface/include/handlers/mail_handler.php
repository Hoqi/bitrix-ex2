<?
AddEventHandler('main',"OnBeforeEventAdd"
 , Array("MailHandler", "onMailAdd"));
class MailHandler {


    function onMailAdd(&$event, &$lid, &$arFields){
        if ($event == 'FEEDBACK_FORM'){
            global $USER;
            var_dump($event);
            var_dump($lid);
            var_dump($arFields);
            if (!$USER->IsAuthorized()){
                $name = $arFields['AUTHOR'];
                $arFields['AUTHOR'] = "Пользователь не авторизован, данные из формы: $name";
            }
            else {
                $name = $arFields['AUTHOR'];
                $login = $USER->GetLogin();
                $id = $USER->GetId();
                $username = $USER->GetFirstName();
                $arFields['AUTHOR'] = "Пользователь авторизован, $id ($login) $username, данные из формы: $name";
            }
            CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => "Замена данных",
                "MODULE_ID" => "main",
                "DESCRIPTION" => "Замена данных в отсылаемом письме - ". $arFields['AUTHOR'],
            ));
        }
    }
}

?>