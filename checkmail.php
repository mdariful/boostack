<?php
/**
 * Created by PhpStorm.
 * User: Md Ariful
 * Date: 15/04/2016
 * Time: 09.57
 */
require_once "core/environment_init.php";
$res = array();
if(isset($_POST["email"])){
    $email = sanitizeInput($_POST["email"]);

    if(checkEmailFormat($email)){
    $user = new User();
    $res = $user->checkUserExistsByEmail($email,false);
    }
}
echo json_encode($res);