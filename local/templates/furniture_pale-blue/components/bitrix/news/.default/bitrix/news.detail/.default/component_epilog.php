<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (isset($arResult["CANONICAL"])){
    $fields = $arResult["CANONICAL"]->GetFields();
    $APPLICATION->SetPageProperty("canonical",$fields["NAME"]);
}
?>