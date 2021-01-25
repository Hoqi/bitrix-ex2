<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"IBLOCK_PRODUCT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_PRODUCT"),
		),
		"IBLOCK_NEWS_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_NEWS"),
		),
		"PROP_NAME" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("PROP_NAME"),
			"TYPE" => "STRING",
		),

		"ELEMENTS_PER_PAGE" => array(
            "PARENT"  => "BASE",
            "NAME"    => GetMessage("ELEMENTS_ON_PAGE"),
            "TYPE"    => "STRING",
            "DEFAULT" => "2",
		),
		
		"CACHE_TIME"  =>  Array("DEFAULT"=>180),

		"TEMPLATE_DETAIL_URL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("TEMPLATE_URL"),
			"DEFAULT" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
			"TYPE" => "STRING",
		)
	),
);

CIBlockParameters::AddPagerSettings(
    $arComponentParameters,
    GetMessage("NAVIGATION_TITLE"), 
    true, 
    true, 
    false, 
    false 
);
?>
