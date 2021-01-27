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
	<ul> 
		<b>Каталог: </b>
		<ul>
		<?$idCounter = 0?>
			<?foreach($arResult["ITEMS"] as $arItem ): ?>
				<li>
					<b><?=$arItem["ID"]?></b> - <?=$arItem["LOGIN"]?>
						<ul>
							<?foreach($arItem["NEWS"] as $news): ?>								
									<li>									
									- <?=$news["NAME"]?> 
									</li>
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