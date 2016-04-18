<?
/**
 * Boostack: profile.php
 * ========================================================================
 * Copyright 2015-2016 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 2.1
 */

// #######################
require_once "core/environment_init.php";
$boostack->renderOpenHtmlHeadTags("Profile");
// #######################


require_once $boostack->registerTemplateFile("boostack/header.phtml");
if($config['session_on'] && $objSession->IsLoggedIn()){
        $userInfo = new User_Info($CURRENTUSER->id);
        require_once $boostack->registerTemplateFile("boostack/content_profile.phtml");

}else
        require_once $boostack->registerTemplateFile("boostack/content_login.phtml");

        require_once $boostack->registerTemplateFile("boostack/footer.phtml");

// #######################
$boostack->renderCloseHtmlTag();
$boostack->writeLog("Homepage Page");
// #######################
?>