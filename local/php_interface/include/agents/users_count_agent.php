<?
CModule::IncludeModule("iblock");

function newUsersCount(){
    $lastDate = COption::GetOptionInt("main","lastDateUserCountAgent");

    $arFilter = [];
    
    $dateNow = time();
    
    $days = 0;
    if (!empty($lastDate)){
        $arFilter["DATE_REGISTER_1"] = $lastDate;
        $diff = $dateNow - $lastDate;
        $days = intval($diff / (60*60*24));
    }
    
    $CUserResult = CUser::GetList($by = "id",$order = "desc",$arFilter);
    
    $users = [];
    
    while ($user = $CUserResult->GetNext()){
        $users[] = $user;
    }
    
    $arFilter = ["GROUPS_ID" => 1];
    $CUserResult = CUser::GetList($by = "id",$order = "desc",$arFilter);
    
    
    while($admin = $CUserResult->GetNext()){
        CEvent::Send(
            "NEW_USERS_COUNT",
            SITE_ID,
            array(
                "EMAIL-TO" => $admin["EMAIL"],
                "DAYS" => $days,
                "COUNT" => count($users),
            ),
            "N",
            "32",
        );
    }
    
    COption::SetOptionInt("main","lastDateUserCountAgent",$dateNow);
    
    
    return "newUsersCount()";
}
?>