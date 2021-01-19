<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (isset($arParams["SHOW_DATE"])){
    $tmp = $this->__component;
    $arResult["SPECIAL_DATE"] = $arResult["ITEMS"][0]["ACTIVE_FROM"];
    $tmp->SetResultCacheKeys(array("SPECIAL_DATE"));
}
?>