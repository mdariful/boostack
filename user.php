<?php
/**
 * Created by PhpStorm.
 * User: Md Ariful
 * Date: 18/04/2016
 * Time: 10.29
 */
require_once "core/environment_init.php";

$boostack->renderOpenHtmlHeadTags("Users");
// #######################

require_once $boostack->registerTemplateFile("boostack/header.phtml");
if($config['session_on'] && $objSession->IsLoggedIn()) {
    if(hasPrivilege($CURRENTUSER,0)){
        $users = new UserList();
        $res = $users->loadAllPaginate(1, 0);
        require_once $boostack->registerTemplateFile("boostack/content_users.phtml");
    }else{
        header("Location: " . $boostack->getFriendlyUrl("profile"));
        $error = "You don't have permission to view this page";
        require_once $boostack->registerTemplateFile("boostack/content_profile.phtml");
    }



}else
    require_once $boostack->registerTemplateFile("boostack/content_login.phtml");

require_once $boostack->registerTemplateFile("boostack/footer.phtml");

// #######################
$boostack->renderCloseHtmlTag();
$boostack->registerScriptFile("user.js");
$boostack->writeLog("Homepage Page");
// #######################
