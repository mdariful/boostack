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
        userDelete();
        Break;
    Default:
        exit;
        debug($crud);
}


//save data
function userInsert()
{
    $res = array();
    if (isset($_POST["username"]) && $_POST["name"] && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["privilege"]) && isset($_POST["active"])) {
        $username = sanitizeInput($_POST["username"]);
        $name = sanitizeInput($_POST["name"]);
        $email = sanitizeInput($_POST["email"]);
        $password = sanitizeInput($_POST["password"]);
        $privilege = sanitizeInput($_POST["privilege"]);
        $active = sanitizeInput($_POST["active"]);
        if (checkEmailFormat($email)) {
            $user = new User();
            $arr["name"] = $name;
            $arr["username"] = $email;
            $arr["email"] = $email;
            $arr["pwd"] = $password;
            $arr["privilege"] = $privilege;
            $arr["active"] = $active;
            $res = $user->insert($arr);
            echo json_encode($res);
        }
    }
}

//update data

function userUpdate($id)
{
    if (isset($_POST["username"]) && $_POST["name"] && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["privilege"]) && isset($_POST["active"])) {
        $username = sanitizeInput($_POST["username"]);
        $name = sanitizeInput($_POST["name"]);
        $email = sanitizeInput($_POST["email"]);
        $password = sanitizeInput($_POST["password"]);
        $privilege = sanitizeInput($_POST["privilege"]);
        $active = sanitizeInput($_POST["active"]);
        if (checkEmailFormat($email)) {
            $user = new User($id);
            $arr["name"] = $name;
            $arr["username"] = $username;
            $arr["email"] = $email;
            $arr["pwd"] = $password;
            $arr["privilege"] = $privilege;
            $arr["active"] = $active;
            $user->update($arr);
        }
    }
}

//delete data
function userDelete()
{
        $res = array();
        $id = $_POST["id"];
        $users = new User($id);
        $res["status"] = $users->delete($id);

}