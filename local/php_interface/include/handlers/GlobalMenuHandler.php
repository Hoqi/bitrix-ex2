<?
AddEventHandler('main',"OnBuildGlobalMenu", Array("GlobalMenuHandler", "onGlobalMenu"));
class GlobalMenuHandler {

    function onGlobalMenu(&$aGlobalMenu, &$aModuleMenu){
       global $USER;
    
       $arGroups = $USER->GetUserGroupArray();
       if (in_array(CONTENT_MANAGER_GROUP_ID,$arGroups) && !in_array(ADMIN_GROUP_ID,$arGroups)){
        foreach ($aGlobalMenu as $key => $value){
            if ($key !== 'global_menu_content'){
                unset($aGlobalMenu[$key]);
            }
        }
           foreach ($aModuleMenu as $key => $value){
               if ($aModuleMenu[$key]['parent_menu'] != 'global_menu_content' ||
                   $aModuleMenu[$key]['items_id'] == 'menu_iblock'
                   ){
                       unset($aModuleMenu[$key]);
                   }
           }
       } 
    }
}
?>