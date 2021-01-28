<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (isset($arParams["SHOW_DATE"])){
    $component = $this->__component;

    if (isset($arResult["ITEMS"][0]["ACTIVE_FROM"]){
        $arResult["SPECIAL_DATE"] = $arResult["ITEMS"][0]["ACTIVE_FROM"];
        $component->SetResultCacheKeys(array("SPECIAL_DATE"));
    }
}
?>