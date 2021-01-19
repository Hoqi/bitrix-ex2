<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (isset($arResult["CANONICAL"])){
    //var_dump($arResult["CANONICAL"]);
    $fields = $arResult["CANONICAL"]->GetFields();
    //var_dump($fields);
    $APPLICATION->SetPageProperty("canonical",$fields["NAME"]);
}
?>