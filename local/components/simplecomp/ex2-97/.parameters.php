<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"IBLOCK_NEWS_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_NEWS"),
		),
		"NEWS_PROP" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("PROP_NEWS"),
		),
		"USER_PROP" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("PROP_USER"),
			"TYPE" => "STRING",
		),		
		"CACHE_TIME"  =>  Array("DEFAULT"=>180),
	),
);

?>
