<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$frame = $this->createFrame()->begin('');
?>
<?if ($arResult["ITEMS"]): ?>
<div class="my-component">
	<ul> 
	<b>Каталог</b>
	<?foreach($arResult["ITEMS"] as $arItem ): ?>
	<li> <b><?=$arItem["TITLE"]?></b> - <?=$arItem["DATE"]?> (<?foreach($arItem["SECTIONS"] as $section): ?> <?=$section?> ,<?endforeach;?>)
		<ul>
		<?foreach($arItem["PRODUCTS"] as $product): ?>
		<li><?=$product["NAME"]?> - <?=$product["PROPERTY_PRICE_VALUE"]?> - <?=$product["PROPERTY_MATERIAL_VALUE"]?> - <?=$product["PROPERTY_ARTNUMBER_VALUE"]?> </li>
		<?endforeach;?>
		</ul>
	</li>
	<?endforeach;?>
	</ul>
</div>
<?endif;?>
<?
$frame->end();
?>