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
    case "viewUser":
        getUser();
        Break;
    case "allUser":
        allUser();
        Break;
    case "delete":
        userDelete();
        Break;
    case "activeUser":
        activeUser();
        Break;
    case "activateUser":
        activateUser();
        Break;
    case "disactivateUser":
        disactiveUser();
        Break;
    case "userExist";
        userExsist();
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
            $res["data"]=$user;
        }else{
            $res = false;
            $res["status"]= "something wrong";
        }
    }
    else{
        $res = false;
    $res["status"]="something missing";
    }
    echo json_encode($res);
}

//update data

function userUpdate()
{
    $res = array();
    if (isset($_POST["active"]) && isset($_POST["name"]) && isset($_POST["privilege"]) && isset($_POST["id"]) && isset($_POST["email"]) && isset($_POST["username"])) {
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
            $res["data"]= $user;
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

        $res["status"] = !$user->delete($id);

        echo json_encode($res);

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
function allUser(){
    $res = array();
    $res["status"] = true;
    $users = new UserList();
    $res["data"]=$users->loadAllPaginate(1, 0);
    echo json_encode($res);
}
function activeUser(){
    $res = array();
    $activeid = $_POST["activeid"];
    $res["status"]=true;
    $users = new UserList();
    $res["data"]=$users->activeUser($activeid);
    echo json_encode($res);
}
function disactiveUser(){
    $res = array();
    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $user = new User($id);
        $arr=0;
        $res["status"] = $user->userActivation($arr,$id);

    }else{
        $res["status"] = false;
        $res["error"]="something missing";
    }
    echo json_encode($res);
}
function activateUser(){
    $res = array();
    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $user = new User($id);
        $arr=1;
        $res["status"] = $user->userActivation($arr,$id);

    }else{
        $res["status"] = false;
        $res["error"]="something missing";
    }
    echo json_encode($res);
}
function userExsist(){
$res = array();
if(isset($_POST["email"])){
    $email = sanitizeInput($_POST["email"]);
    if(checkEmailFormat($email)){
        $user = new User();
        $res["status"] = $user->checkUserExistsByEmail($email,false);
    }
}else{
}
echo json_encode($res);
}