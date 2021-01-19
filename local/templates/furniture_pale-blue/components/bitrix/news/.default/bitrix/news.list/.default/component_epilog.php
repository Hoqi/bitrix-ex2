<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//var_dump($arResult);
if (isset($arResult["SPECIAL_DATE"])){
    //var_dump($arResult);
    $APPLICATION->SetPageProperty("specialdate",$arResult["SPECIAL_DATE"]);
}
?>