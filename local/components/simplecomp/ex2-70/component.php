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
global $CACHE_MANAGER;

/*************************************************************************
	Processing of received parameters
*************************************************************************/
$arParams["IBLOCK_PRODUCT_ID"] = intval($arParams["IBLOCK_PRODUCT_ID"]);
$arParams["IBLOCK_NEWS_ID"] = intval($arParams["IBLOCK_NEWS_ID"]);

$arParams['ELEMENTS_PER_PAGE'] = (int)$arParams['ELEMENTS_PER_PAGE'];
$arParams["PAGER_TITLE"] = trim($arParams["PAGER_TITLE"]);
$arParams["PAGER_SHOW_ALL"] = $arParams["PAGER_SHOW_ALL"] == "Y";

$arNav = array(
    "nPageSize" => $arParams['ELEMENTS_PER_PAGE'],
    "bShowAll"  => $arParams["PAGER_SHOW_ALL"],
);


$arButtons = CIBlock::GetPanelButtons($this->arParams["IBLOCK_PRODUCT_ID"]);
$this->AddIncludeAreaIcon(
	[
		"TITLE"          => "Показать ИБ в админке",
		"URL"            => $arButtons['submenu']['element_list']['ACTION_URL'],
		"IN_PARAMS_MENU" => true,
	]
);


if($arParams["IBLOCK_PRODUCT_ID"] > 0 && $arParams["IBLOCK_NEWS_ID"] > 0 && $arParams["PROP_NAME"]  && 
	$this->StartResultCache(false, [$arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups(),isset($_GET["F"]),CDBResult::GetNavParams($arNav)]))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	//cache tag
	if (defined('BX_COMP_MANAGED_CACHE')) {
        $CACHE_MANAGER->RegisterTag("iblock_id_" . SERVICES_IBLOCK_ID);
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

	/* Необходимо для отбора только тех новостей, на которые ссылаются разделы 
	   Сделано для нормального отображения постраничной навигации, т.к. в дальнейшем
	   добавились новости к которым не привязаны разделы товаров из - за этого постраничная
	   навигации вела на пустые страницы
	*/

	$sectionNewsRefColumn = array_column($arSections,"UF_NEWS_LINK");
	$sectionNewsRefColumnUniq = [];
	foreach ($sectionNewsRefColumn as $refRow){
		foreach ($refRow as $refCell){
			if (!in_array($refCell,$sectionNewsRefColumnUniq)){
				$sectionNewsRefColumnUniq[] = $refCell;
			}
		}
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
		"IBLOCK_SECTION_ID" => $sectionIdColumn,
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
	$arResult["MIN_PRICE"] = 10000;
	$arResult["MAX_PRICE"] = -100;
	$resIBlockProducts = CIBlockElement::GetList($arSort,$arFilter,false,false,$arSelect);
	$resIBlockProducts->SetUrlTemplates($arParams["TEMPLATE_DETAIL_URL"]);
	$arProducts = [];
	while($element = $resIBlockProducts->GetNext()){
		if (in_array($element["IBLOCK_SECTION_ID"],$sectionIdColumn)){
			/* Отбор больших и маленьких */
			if ($element["PROPERTY_PRICE_VALUE"] < $arResult["MIN_PRICE"]){
				$arResult["MIN_PRICE"] = $element["PROPERTY_PRICE_VALUE"];
			}
			if ($element["PROPERTY_PRICE_VALUE"] > $arResult["MAX_PRICE"]){
				$arResult["MAX_PRICE"] = $element["PROPERTY_PRICE_VALUE"];
			}
			/*!Отбор больших и маленьких */
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
	
	/* NEWS SELECT */
	$arSelect = array(
		"ID",
		"NAME",
		"DATE_ACTIVE_FROM",
	);
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_NEWS_ID"],
		"ACTIVE" => "Y",
		"ID" => $sectionNewsRefColumnUniq,
	);

	$resIBlockNews = CIBlockElement::GetList(false,$arFilter,false,$arNav,$arSelect);

	$arResult["NAV_STRING"] = $resIBlockNews->GetPageNavStringEx(
		$navComponentObject,
		$arParams["PAGER_TITLE"],
		$arParams["PAGER_TEMPLATE"],
		$arParams["PAGER_SHOW_ALWAYS"]
	);

	$arNews = [];
	while ($element = $resIBlockNews->GetNext()){
		$arNews[] = $element;
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
	 if (count($arProducts) != 0 && count($arNews) != 0){
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
				if(in_array($product["IBLOCK_SECTION_ID"],$sectionsID)){
				$resElem["PRODUCTS"][] = $product;
				$productCount++;	 			
				}
			 }
			if (count($resElem["PRODUCTS"]) > 0){
			$arResult["ITEMS"][] = $resElem;
			}
		}
		$arResult["ELEM_COUNT"] = $productCount;
		$this->SetResultCacheKeys(array("ELEM_COUNT","ITEMS","MIN_PRICE","MAX_PRICE"));
		$this->IncludeComponentTemplate();
	 } else {
		$this->AbortResultCache();
	 }
}


$APPLICATION->SetTitle("Элементов - ".$arResult["ELEM_COUNT"]);

$APPLICATION->AddViewContent(
	"minPrice",
	"Минимальная цена: " . $arResult["MIN_PRICE"]
);

$APPLICATION->AddViewContent(
	"maxPrice",
	"Максимальная цена: " . $arResult["MAX_PRICE"]
);