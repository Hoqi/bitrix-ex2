<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//var_dump($arParams);
if (isset($arParams["CANONICAL"])){
    $arSort = false;
    $arFilter = array(
        "IBLOCK_ID" => $arParams["CANONICAL"],
        "ACTIVE" => "Y",
        "PROPERTY_news" => $arResult["ID"],
    );
    $arGroupBy = false;
    $arNavStartParams = array("nTopCount" => false);
    $arSelect = array("ID","NAME");

    $BDres = CIBlockElement::GetList(
        $arSort,
        $arFilter,
        $arGroupBy,
        $arNavStartParams,
        $arSelect,
    );
    $tmp;
    while ($elem = $BDres->GetNextElement()){
        $tmp = $elem;
    }
    if (count($tmp) == 1){
        $arResult["CANONICAL"] = $tmp;
        $comp = $this->__component;
        $comp->SetResultCacheKeys(array("CANONICAL"));
    }
}
?>