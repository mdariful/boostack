<?
/**
 * Boostack: registration.php
 * ========================================================================
 * Copyright 2015-2016 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 2.1
 */

// #######################
require_once "core/environment_init.php";
$boostack->renderOpenHtmlHeadTags("Home");
// #######################

require_once $boostack->registerTemplateFile("boostack/header.phtml");

if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["psw1"]) && isset($_POST["psw2"])) {
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $psw1 = sanitizeInput($_POST["psw1"]);
    $psw2 = sanitizeInput($_POST["psw2"]);
    if(checkEmailFormat($email) && $psw1 === $psw2) {
        $user = new User_Registration();
        $arr["name"] = $name;
        $arr["username"] = $email;
        $arr["email"] = $email;
        $arr["pwd"] = $psw1;
        $user->insert($arr);
            require_once $boostack->registerTemplateFile("boostack/content_login_logged.phtml");
    }
    else
        require_once $boostack->registerTemplateFile("boostack/content_registration.phtml");
}
else {
    require_once $boostack->registerTemplateFile("boostack/content_registration.phtml");
}

require_once $boostack->registerTemplateFile("boostack/footer.phtml");

// #######################
$boostack->renderCloseHtmlTag();
$boostack->registerScriptFile("registration.js");
$boostack->writeLog("Homepage Page");
// #######################
?>