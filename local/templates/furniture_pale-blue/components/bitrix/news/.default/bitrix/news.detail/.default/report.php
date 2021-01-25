<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$ajax = "N";
if ($arParams["AJAX_REPORT"] == "Y"){
    $ajax = "Y";
}
?>

<a href="?type=<?=$ajax?>&id=<?=$arResult["ID"]?>" id="report" 
<? if ($ajax == "Y"): ?> onclick="return false;"<?endif;?>>Отправить жалобу</a>


<?if (isset($_GET["id"])){
    CModule::IncludeModule("iblock");
    $userData = '';
    if ($USER->IsAuthorized()){
        $userData = $USER->GetID() . $USER->GetLogin() . $USER->GetFullName();
    } else {
        $userData = 'Не авторизован';
    }
    $report = array(
        'IBLOCK_ID' => REPORT_IBLOCK_ID,
        'ACTIVE_FROM' => ConvertTimeStamp(time(),"FULL"),
        'NAME' => 'Новость '. $_GET["id"],
        'PROPERTY_VALUES' => [
            'USER' => $userData,
            'NEWS' => $_GET['id'],
        ],
    );
    $resultId = null;
    $CIBlockObject = new CIBlockElement();
    if ($res = $CIBlockObject->Add($report)){
        $resultId = $res;
    }
}
?>
<span id="user-text">
<?if ($resultId != null):?>
    <?if ($ajax == "N"):?>
    Спасибо, ваше мнение учетено: №<?=$resultId?>
    <?else:?>
    <?
        $APPLICATION->RestartBuffer();
        echo json_encode($resultId);
        exit;
    ?>
    <?endif;?>
<?endif;?>
</span>