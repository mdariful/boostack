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
        userUpdate();
        Break;
    case "get":
        getUser();
        Break;
    case "delete":
        userDelete();
        Break;
    Default:
        exit;
}


//save data
function userInsert()
{
    $res = array();
    if (isset($_POST["username"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["privilege"]) && isset($_POST["active"])) {
        $username = sanitizeInput($_POST["username"]);
        $name = sanitizeInput($_POST["name"]);
        $email = sanitizeInput($_POST["email"]);
        $password = sanitizeInput($_POST["password"]);
        $privilege = sanitizeInput($_POST["privilege"]);
        $active = sanitizeInput($_POST["active"]);
        if (checkEmailFormat($email)) {
            $user = new User();
            $arr["name"] = $name;
            $arr["username"] = $username;
            $arr["email"] = $email;
            $arr["pwd"] = $password;
            $arr["privilege"] = $privilege;
            $arr["active"] = $active;
            $res["status"] = $user->insert($arr);

        }else{
            $res = false;
            $res["status"]= "something wrong";
        }
    }
    else{
    $res["status"]="something missing";
    }
    echo json_encode($res);
}

//update data

function userUpdate()
{
    $res = array();
    if (isset($_POST["name"]) && isset($_POST["privilege"]) && isset($_POST["id"]) && isset($_POST["email"]) && isset($_POST["username"])) {
        $id = sanitizeInput($_POST["id"]);
        $name = sanitizeInput($_POST["name"]);
        $privilege = sanitizeInput($_POST["privilege"]);
        $email = sanitizeInput($_POST["email"]);
        $username = sanitizeInput($_POST["username"]);
        $active = sanitizeInput($_POST["active"]);
        if(checkEmailFormat($email)){

            $user = new User($id);
            $arr["email"]=$email;
            $arr["username"]=$username;
            $arr["name"] = $name;
            $arr["privilege"] = $privilege;
            $arr["active"]=$active;
            $res["status"] = $user->update($arr);
        }else{
            $res["status"]=false;
            $res["error"]="Email not valid";
        }


    }else{
        $res["status"] = false;
        $res["error"]="something missing";
    }
    echo json_encode($res);
}

//delete data
function userDelete()
{
        $res = array();
        $id = $_POST["id"];
        $user = new User($id);
        $res["status"] = $user->delete($id);

}

//retrive all user info
function getUser(){
    $res = array();
    $id = $_POST["id"];
    $res["status"] = true;
    $user =  new User($id);
    $res["data"]=$user;
    echo json_encode($res);

}