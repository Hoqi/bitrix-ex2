<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (isset($arParams["CANONICAL_IBLOCK_ID"])){
    $arSort = false;
    $arFilter = array(
        "IBLOCK_ID" => $arParams["CANONICAL_IBLOCK_ID"],
        "ACTIVE" => "Y",
        "PROPERTY_news" => $arResult["ID"],
    );
    $arGroupBy = false;
    $arNavStartParams = array("nTopCount" => 1);
    $arSelect = array("ID","NAME");

    $BDres = CIBlockElement::GetList(
        $arSort,
        $arFilter,
        $arGroupBy,
        $arNavStartParams,
        $arSelect,
    );
    if ($elem = $BDres->GetNextElement()){
        $arResult["CANONICAL"] = $elem;
        $comp = $this->__component;
        $comp->SetResultCacheKeys(array("CANONICAL"));
    }
}
?>