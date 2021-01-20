<?
AddEventHandler('main',"OnBeforeEventAdd"
 , Array("MailHandler", "onMailAdd"));
class MailHandler {

    function onMailAdd(&$event, &$lid, &$arFields){
        var_dump("fsfsfasfasfasf");      
        var_dump($event);
        var_dump($lid);
        var_dump($arFields);
    }
}

?>