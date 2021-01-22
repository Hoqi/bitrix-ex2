<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


/*************************************************************************
	Processing of received parameters
*************************************************************************/
$arParams["IBLOCK_PRODUCT_ID"] = intval($arParams["IBLOCK_PRODUCT_ID"]);
$arParams["IBLOCK_NEWS_ID"] = intval($arParams["IBLOCK_NEWS_ID"]);

if($arParams["IBLOCK_PRODUCT_ID"] > 0 && $arParams["IBLOCK_NEWS_ID"] && $arParams["PROP_NAME"]  && $this->StartResultCache(false, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	/* SECTIONS SELECT */
	//SELECT
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"UF_NEWS_LINK",
	);
	//WHERE
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_PRODUCT_ID"],
		"ACTIVE"=>"Y",
		"!UF_NEWS_LINK" => false,
	);
	
	//EXECUTE
	$resIBlockSection = CIBlockSection::GetList([], $arFilter, false, $arSelect);
	$arSections = [];
	while ($section = $resIBlockSection->GetNext()){
		$arSections[] = $section;
	}
	$sectionIdColumn = array_column($arSections,"ID");

	/* NEWS SELECT */
	$arSelect = array(
		"ID",
		"NAME",
		"DATE_ACTIVE_FROM",
	);

	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_NEWS_ID"],
	);

	$resIBlockNews = CIBlockElement::GetList(false,$arFilter,false,false,$arSelect);
	$arNews = [];
	while ($element = $resIBlockNews->GetNext()){
		$arNews[] = $element;
	}
	/* PRODUCTS SELECT */

	$arSelect = array(
		"ID",
		"NAME",
		"PROPERTY_MATERIAL",
		"PROPERTY_ARTNUMBER",
		"PROPERTY_PRICE",
		"IBLOCK_SECTION_ID",
	);

	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_PRODUCT_ID"],
	);
	$resIBlockProducts = CIBlockElement::GetList(false,$arFilter,false,false,$arSelect);
	$arProducts = [];
	while($element = $resIBlockProducts->GetNext()){
		if (in_array($element["IBLOCK_SECTION_ID"],$sectionIdColumn)){
			$arProducts[] = $element;
		}
	}
	/* FINAL */
	 if (count($arProduct != 0) && count($arNews != 0)){
		$arResult["ITEMS"]= [];
		$productCount = 0;
	 	foreach($arNews as $news){
	 		$resElem = [];
	 		$resElem["TITLE"] = $news["NAME"];
	 		$resElem["DATE"] = $news["DATE_ACTIVE_FROM"];
			$resElem["SECTIONS"] = [];
			$sectionsID = [];
	 		foreach ($arSections as $section){
	 			if (in_array($news["ID"], $section["UF_NEWS_LINK"])){
					 $resElem["SECTIONS"][] = $section["NAME"];
					 $sectionsID[] = $section["ID"];
	 			}
			 }
	 		$resElem["PRODUCTS"] = [];
	 		foreach ($arProducts as $product) {
	 			if (in_array($product["IBLOCK_SECTION_ID"],$sectionsID)){
					 $resElem["PRODUCTS"][] = $product;
					 $productCount++;
	 			}
			 }
			$arResult["ITEMS"][] = $resElem;
		 }
		 $APPLICATION->SetTitle("Элементов - $productCount");
		 $this->SetResultCacheKeys(array());
		 $this->IncludeComponentTemplate();
	 }
	 else {
		$this->AbortResultCache();
	 }
}
?>
