<?
AddEventHandler("main","OnEpilog",
Array("ClientErrorHandler", "onNotFound"));

class ClientErrorHandler {
    function onNotFound(){      
        if (defined("ERROR_404") && ERROR_404 === "Y") {          
            global $APPLICATION;
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                "DESCRIPTION" => $APPLICATION->GetCurUri(),
            ));
        }
    }
}
