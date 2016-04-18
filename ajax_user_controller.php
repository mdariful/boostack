<?php
/**
 * Created by PhpStorm.
 * User: Md Ariful
 * Date: 18/04/2016
 * Time: 10.29
 */
require_once "core/environment_init.php";
$crud=$_POST["type"];

switch ($crud) {
    case "insert":
        userInsert();
        Break;
    case "update":
        userUpdate($id);
        Break;
    case "delete":
        userDelete($id);
        Break;
    Default:
        exit;
        debug($crud);
}


//save data
function userInsert()
{
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["psw1"]) && isset($_POST["privilege"]) && isset($_POST["active"])) {
        $name = sanitizeInput($_POST["name"]);
        $email = sanitizeInput($_POST["email"]);
        $psw1 = sanitizeInput($_POST["psw1"]);
        $privilege = sanitizeInput($_POST["privilege"]);
        $active = sanitizeInput($_POST["active"]);
        if (checkEmailFormat($email)) {
            $user = new User();
            $arr["name"] = $name;
            $arr["username"] = $email;
            $arr["email"] = $email;
            $arr["pwd"] = $psw1;
            $arr["privilege"] = $privilege;
            $arr["active"] = $active;
            $user->insert($arr);
        }
    }
}

//update data

function userUpdate($id)
{
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["psw1"]) && isset($_POST["privilege"]) && isset($_POST["active"])) {
        $name = sanitizeInput($_POST["name"]);
        $email = sanitizeInput($_POST["email"]);
        $psw1 = sanitizeInput($_POST["psw1"]);
        $privilege = sanitizeInput($_POST["privilege"]);
        $active = sanitizeInput($_POST["active"]);
        if (checkEmailFormat($email)) {
            $user = new User($id);
            $arr["name"] = $name;
            $arr["username"] = $email;
            $arr["email"] = $email;
            $arr["pwd"] = $psw1;
            $arr["privilege"] = $privilege;
            $arr["active"] = $active;
            $user->update($arr);
        }
    }
}

//delete data
function userDelete($id)
{
    if (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $users = new User($id);
        $users->delete();
    }
}