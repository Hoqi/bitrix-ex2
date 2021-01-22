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
<?if (isset($arResult["ITEMS"])): ?>
<div class="my-component">
<b>Фильтр </b> <a href="<?=$APPLICATION->GetCurDir()?>?F=Y"><?=$APPLICATION->GetCurDir()?>?F=Y</a>
	<ul> 
		<b>Каталог: </b>
		<ul>
			<?foreach($arResult["ITEMS"] as $arItem ): ?>
				<li>
					<b><?=$arItem["TITLE"]?></b> - <?=$arItem["DATE"]?> (<?foreach($arItem["SECTIONS"] as $section): ?> <?=$section?> ,<?endforeach;?>)
						<ul>
							<?foreach($arItem["PRODUCTS"] as $product): ?>
								<li><?=$product["NAME"]?> - <?=$product["PROPERTY_PRICE_VALUE"]?> - <?=$product["PROPERTY_MATERIAL_VALUE"]?> - <?=$product["PROPERTY_ARTNUMBER_VALUE"]?> (<?=$product["DETAIL_PAGE_URL"]?>) </li>
							<?endforeach;?>
						</ul>
				</li>
			<?endforeach;?>
		</ul>
	</ul>
</div>
<?endif;?>
<?
$frame->end();
?>