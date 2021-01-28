<? 
AddEventHandler('iblock',"OnBeforeIBlockElementUpdate", Array(
    "CIBlockHandler", 
    "onBeforeIBlockElementUpdate"));


class CIBlockHandler 
{
    function onBeforeIBlockElementUpdate(&$arFields)
    {
        if ($arFields["IBLOCK_ID"] == PRODUCT_IBLOCK_ID && $arFields['ACTIVE'] !== 'Y') {
            $CIElement = CIBlockElement::GetById($arFields["ID"]);
            $result = $CIElement->Fetch();
            // >= сделал для проверки, должно быть > 
            if ($result["SHOW_COUNTER"] >= 2) {
                global $APPLICATION;
                $APPLICATION->throwException("Количество просмотров больше 2");
                return false;
            }
        }
    }
}
?>