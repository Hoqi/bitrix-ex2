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
		"CACHE_TIME"  =>  Array("DEFAULT"=>180),
		"TEMPLATE_DETAIL_URL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("TEMPLATE_URL"),
			"DEFAULT" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
			"TYPE" => "STRING",
		)
	),
);
?>