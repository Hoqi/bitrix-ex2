<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:ex2-70", 
	"myComponent", 
	array(
		"CACHE_TIME" => "180",
		"CACHE_TYPE" => "A",
		"IBLOCK_NEWS_ID" => "1",
		"IBLOCK_PRODUCT_ID" => "2",
		"PROP_NAME" => "UF_NEWS_LINK",
		"COMPONENT_TEMPLATE" => "myComponent",
		"TEMPLATE_DETAIL_URL" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>