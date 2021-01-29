<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
 /* Пришлось перенести сюда подключение библиотеки
    в шаблоне не работало с кэшем
    сомневаюсь, что такое решение правильное */
<?CJSCore::Init(array("jquery"));?>
<?
if (isset($arResult["CANONICAL"])) {
    $fields = $arResult["CANONICAL"]->GetFields();
    $APPLICATION->SetPageProperty("canonical",$fields["NAME"]);
}
$resultId = null;
if (isset($_GET["id"])) {
    CModule::IncludeModule("iblock");
    $userData = '';
    if ($USER->IsAuthorized()) {
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
    $CIBlockObject = new CIBlockElement();
    if ($res = $CIBlockObject->Add($report)) {
        $resultId = $res;
    }
    if($_GET["ajax"] == "Y" && $resultId != null) {
        $APPLICATION->RestartBuffer();
        echo json_encode($resultId);
        exit;
    }
}
?>

<?if ($_GET["ajax"] == "N" && $resultId != null): ?>
    <div id="ajax-result" style="display:none">
     <?=$resultId?>
    </div>
<?endif;?>