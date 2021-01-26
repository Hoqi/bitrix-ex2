
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<select name="site" onChange="location.href=this.value">
<?
foreach ($arResult["SITES"] as $key => $arSite):
?>
	<option value="<?=$arSite["DIR"]?>"><?=$arSite["LANG"]?></option>
<?
endforeach;
?>
</select>