<?
AddEventHandler("main","OnEpilog",
Array("ClientErrorHandler", "onEpilog"));
CModule::IncludeModule("iblock");

class ClientErrorHandler {
    function onEpilog(){
        global $APPLICATION;      
        if (defined("ERROR_404") && ERROR_404 === "Y") {          
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                "DESCRIPTION" => $APPLICATION->GetCurUri(),
            ));
            return;
        }
        $page = $APPLICATION->GetCurPage();
        $arSort = false;
        $arFilter = array(
            "IBLOCK_ID" => META_IBLOCK_ID,
            "ACTIVE" => "Y",
            "NAME" => $page,
        );
        $arGroupBy = false;
        $arNavStartParams = array("nTopCount" => false);
        $arSelect = array("ID","NAME","PROPERTY_TITLE","PROPERTY_DESCRIPTION");
        //$cib = new CIBlockElement;
        $BDres = CIBlockElement::GetList(
            $arSort,
            $arFilter,
            $arGroupBy,
            $arNavStartParams,
            $arSelect,
        );
        if ($res = $BDres->GetNext()){
            $APPLICATION->SetPageProperty('title',$res["PROPERTY_TITLE_VALUE"]);
            $APPLICATION->SetPageProperty('description',$res["PROPERTY_DESCRIPTION_VALUE"]);
        }
    }
}
