<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Loader;


class Simplecomp extends CBitrixComponent
{

    

    public function onPrepareComponentParams($arParams)
    {
        global $USER;

        $arParams["IBLOCK_NEWS_ID"] = intval($arParams["IBLOCK_NEWS_ID"]);

        if (!$arParams["CACHE_TIME"]) {
            $arParams["CACHE_TIME"] = 3600;
        }


        $this->curUserId = $USER->GetID();
        $this->curUserGroup = \CUser::GetList(
        $by = "id",
        $order = "asc",
        ["ID" => $USER->GetID()],
        ["SELECT" => [$this->arParams["USER_PROP"]],],
        )->GetNext()[$this->arParams["USER_PROP"]];

        
      
        return parent::onPrepareComponentParams($arParams);
    }


    public function setResult()
    {
       $arUsers = [];
       $indexUsers = \CUser::GetList(
           $by = "id",
           $order = "asc",
           $filter = [
               $arParams["USER_PROP"] => $this->curUserGroup,
               "!ID" => $this->curUserId,
           ],
           [
            $select = [
                "LOGIN",
                "ID",
                ],
           ],
        );
        $usersId = [];
        while ($user = $indexUsers->Fetch()){
            $arUsers[$user["ID"]]["LOGIN"] = $user["LOGIN"];
            $usersId[] = $user["ID"];
        }
        $indexNews = \CIBlockElement::GetList(
            $order = false,
            $filter = [
                "IBLOCK_ID" => $this->arParams["IBLOCK_NEWS_ID"],
                "PROPERTY_".$this->arParams["NEWS_PROP"] => $usersId,
                "!PROPERTY_".$this->arParams["NEWS_PROP"] => $this->curUserId,
            ],
            false,
            false,
            [
                "ID",
                "NAME",
                "ACTIVE_FROM",
                "PROPERTY_" . $this->arParams["NEWS_PROP"],
            ],
        );
        $uniqNews = [];
        while($news = $indexNews->Fetch()){
            $userId = $news["PROPERTY_".$this->arParams["NEWS_PROP"]."_VALUE"];
            if ($userId == $this->curUserId){
                /*Я ожидал что Fetch вернет одну новость, у котого  массив id`шников пользователей
                  ,но это не так, на каждого пользователя своя новость*/
                continue;
            }
            
            $arUsers[$userId]["NEWS"][] = $news;
            if (!in_array($news["ID"],$uniqNews)){
                $uniqNews[] = $news["ID"];
            }
        }
        $this->arResult["ITEMS"] = $arUsers;
        $this->arResult["UNIQ_COUNT"] = count($uniqNews);
    }


    public function executeComponent()
    {
        if($this->startResultCache()){
            $this->setResult();
            $this->setResultCacheKeys(
                [
                    "ITEMS",
                    "UNIQ_COUNT",
                ]
                );
            $this->includeComponentTemplate();
        }
        global $APPLICATION;
        $APPLICATION->SetTitle("Количество новостей: ". $this->arResult["UNIQ_COUNT"]);
    }
}