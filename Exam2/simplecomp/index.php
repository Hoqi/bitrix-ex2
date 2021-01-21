<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent("simplecomp:ex2-70", "myComponent", Array(
	"CACHE_TIME" => "180",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"IBLOCK_NEWS_ID" => "1",	// ID инфоблока новости
		"IBLOCK_PRODUCT_ID" => "2",	// ID инфоблока продукция
		"PROP_NAME" => "NEWS",	// Своиство привязки
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>