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

if($arParams["IBLOCK_PRODUCT_ID"] > 0 && $arParams["IBLOCK_NEWS_ID"] > 0 && $arParams["PROP_NAME"]  && 
	$this->StartResultCache(false, [$arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups(),isset($_GET["F"])]))
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
		$arParams["PROP_NAME"],
	);
	//WHERE
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_PRODUCT_ID"],
		"ACTIVE"=>"Y",
		"!". $arParams["PROP_NAME"] => false,
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
		"DETAIL_PAGE_URL",
	);

	$arSort = array(
		"NAME" => "ASC",
		"SORT" => "ASC",
	);
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_PRODUCT_ID"],
	);
	if (isset($_GET["F"])){
		$arFilter[] = array(
			"LOGIC" => "OR",
			array(
				"<=PROPERTY_PRICE" => 1700,
				"=PROPERTY_MATERIAL" => "Дерево, ткань",
			),
			array(
				"<PROPERTY_PRICE" => 1500,
				"=PROPERTY_MATERIAL" => "Металл, пластик",
			),
		);
		$this->AbortResultCache();
	}
	$resIBlockProducts = CIBlockElement::GetList($arSort,$arFilter,false,false,$arSelect);
	$resIBlockProducts->SetUrlTemplates($arParams["TEMPLATE_DETAIL_URL"]);
	$arProducts = [];
	while($element = $resIBlockProducts->GetNext()){
		if (in_array($element["IBLOCK_SECTION_ID"],$sectionIdColumn)){
			/*Эрмитаж*/
			$arButtons = CIBlock::GetPanelButtons(
				$element["IBLOCK_ID"],
				$element["ID"],
				0,
				["SECTION_BUTTONS" => false, "SESSID" => false],
			);
			$element["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
			$element["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
			/*!Эрмитаж*/
			$arProducts[] = $element;
		}
	}
	/* FINAL */
	/*Эрмитаж*/
	if($APPLICATION->GetShowIncludeAreas()){
		$arButtons = CIBlock::GetPanelButtons(
			$this->arParams["IBLOCK_PRODUCT_ID"],
			0,
			0,
			["SECTION_BUTTONS" => false],
		);
		$this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(),$arButtons));
	}
	/*!Эрмитаж*/
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
	 			if (in_array($news["ID"], $section[$arParams["PROP_NAME"]])){
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
		$arResult["ELEM_COUNT"] = $productCount;
		$this->SetResultCacheKeys(array("ELEM_COUNT","ITEMS"));
		$this->IncludeComponentTemplate();
	 }
	 else {
		$this->AbortResultCache();
	 }
}
$APPLICATION->SetTitle("Элементов - ".$arResult["ELEM_COUNT"]);

