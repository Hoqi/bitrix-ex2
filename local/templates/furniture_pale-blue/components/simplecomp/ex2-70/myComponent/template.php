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
<?if (count($arResult["ITEMS"]) > 0): ?>
<div class="my-component">
<span>Метка времени:  <?echo time();?></span><br>
<b>Фильтр </b> <a href="<?=$APPLICATION->GetCurDir()?>?F=Y"><?=$APPLICATION->GetCurDir()?>?F=Y</a>
	<ul> 
		<b>Каталог: </b>
		<ul>
		<?$idCounter = 0?>
			<?foreach($arResult["ITEMS"] as $arItem ): ?>
				<li>
					<b><?=$arItem["TITLE"]?></b> - <?=$arItem["DATE"]?> (<?foreach($arItem["SECTIONS"] as $section): ?> <?=$section?> ,<?endforeach;?>)
						<ul>
							<?foreach($arItem["PRODUCTS"] as $product): ?>
								<?
								$uuid = ++$idCounter;
								$this->addEditAction($uuid,$product["EDIT_LINK"],
									CIBlock::GetArrayById($product["IBLOCK_ID"],"ELEMENT_EDIT"));
								$this->addDeleteAction($uuid,$product["DELETE_LINK"],
									CIBlock::GetArrayById($product["IBLOCK_ID"],"ELEMENT_DELETE"),
									["CONFIRM" => "A U SURE?"],
								);
								?>
								<div id="<?= $this->GetEditAreaId($uuid); ?>">
									<li>
									<?=$product["NAME"]?> - 
									<?=$product["PROPERTY_PRICE_VALUE"]?> - 
									<?=$product["PROPERTY_MATERIAL_VALUE"]?> - 
									<?=$product["PROPERTY_ARTNUMBER_VALUE"]?> 
									(<?=$product["DETAIL_PAGE_URL"]?>)
									</li>
								</div>
							<?endforeach;?>
						</ul>
				</li>
			<?endforeach;?>
		</ul>
	</ul>
</div>
<br>---
<p><b><?= "Вас поситила навигация" ?></b></p>
<? echo $arResult["NAV_STRING"] ?>
<?endif;?>
<?
$frame->end();
?>