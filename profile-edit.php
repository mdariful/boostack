<?
/**
 * 
 */

// #######################
require_once "core/environment_init.php";
$boostack->renderOpenHtmlHeadTags("Profile");
$boostack->registerAbsoluteCssFile("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
// #######################


require_once $boostack->registerTemplateFile("boostack/header.phtml");

if($config['session_on'] && $objSession->IsLoggedIn()){
if ( isset ( $_POST['submit'] ) ) {

// Checking null values in message.
try{
    //Validate the form
    //sanitize
    $id = sanitizeInput($_POST["id"]);
    $first_name = sanitizeInput($_POST["first_name"]);
    $last_name = sanitizeInput($_POST["last_name"]);
    $locale = sanitizeInput($_POST["locale"]);
    $city = sanitizeInput($_POST["city"]);
    $state = sanitizeInput($_POST["state"]);
    $country = sanitizeInput($_POST["country"]);
    $zip = sanitizeInput($_POST["zip"]);
    $about_me = sanitizeInput($_POST["about_me"]);
    $tel = sanitizeInput($_POST["tel"]);
    $cell = sanitizeInput($_POST["cell"]);
    $profession = sanitizeInput($_POST["profession"]);
    $birthday = sanitizeInput($_POST["birthday"]);
    $movies = sanitizeInput($_POST["movies"]);
    $music = sanitizeInput($_POST["music"]);
    $political = sanitizeInput($_POST["political"]);
    $interests = sanitizeInput($_POST["interests"]);
    $tv = sanitizeInput($_POST["tv"]);
    $religion = sanitizeInput($_POST["religion"]);
    $sex = sanitizeInput($_POST["sex"]);


    if(inputcheck($first_name) && inputcheck($last_name) && checkphone($cell) && checkphone($tel)){
        //check and validate the form
        $userprofile = new User_Info($id);
        //put data in the variable
        $arr["first_name"] = $first_name;
        $arr["last_name"] = $last_name;
        $arr["locale"] = $locale;
        $arr["city"] = $city;
        $arr["state"] = $state;
        $arr["country"] = $country;
        $arr["zip"] = $zip;
        $arr["about_me"] = $about_me;
        $arr["tel"] = $tel;
        $arr["cell"] = $cell;
        $arr["profession"] = $profession;
        $arr["birthday"] = $birthday;
        $arr["movies"] = $movies;
        $arr["music"] = $music;
        $arr["political"] = $political;
        $arr["interests"] = $interests;
        $arr["tv"] = $tv;
        $arr["religion"] = $religion;
        $arr["sex"] = $sex;
        $userprofile -> update($arr);
        $result= "Success";
    }
    

}catch (Exception $e) {
    $error = $e->getMessage();
}

}
    $userInfo = new User_Info($CURRENTUSER->id);
    require_once $boostack->registerTemplateFile("boostack/content_profile_edit.phtml");
}else
    require_once $boostack->registerTemplateFile("boostack/content_login.phtml");

require_once $boostack->registerTemplateFile("boostack/footer.phtml");

/**
if($config['session_on'] && $objSession->IsLoggedIn()){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $id = sanitizeInput($_POST["id"]);
    $first_name = sanitizeInput($_POST["first_name"]);
    $last_name = sanitizeInput($_POST["last_name"]);
    $locale = sanitizeInput($_POST["locale"]);
    $city = sanitizeInput($_POST["city"]);
    $state = sanitizeInput($_POST["state"]);
    $country = sanitizeInput($_POST["country"]);
    $zip = sanitizeInput($_POST["zip"]);
    $about_me = sanitizeInput($_POST["about_me"]);
    $tel = sanitizeInput($_POST["tel"]);
    $cell = sanitizeInput($_POST["cell"]);
    $profession = sanitizeInput($_POST["profession"]);
    $birthday = sanitizeInput($_POST["birthday"]);
    $movies = sanitizeInput($_POST["movies"]);
    $music = sanitizeInput($_POST["music"]);
    $political = sanitizeInput($_POST["political"]);
    $interests = sanitizeInput($_POST["interests"]);
    $tv = sanitizeInput($_POST["tv"]);
    $religion = sanitizeInput($_POST["religion"]);

    $sex = sanitizeInput($_POST["sex"]);

    if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
        $err_first_name = "Only letters and white space allowed";
    }


    $userprofile = new User_Info($id);
    $arr["first_name"] = $first_name;
    $arr["last_name"] = $last_name;
    $arr["locale"] = $locale;
    $arr["city"] = $city;
    $arr["state"] = $state;
    $arr["country"] = $country;
    $arr["zip"] = $zip;
    $arr["about_me"] = $about_me;
    $arr["tel"] = $tel;
    $arr["cell"] = $cell;
    $arr["profession"] = $profession;
    $arr["birthday"] = $birthday;
    $arr["movies"] = $movies;
    $arr["music"] = $music;
    $arr["political"] = $political;
    $arr["interests"] = $interests;
    $arr["tv"] = $tv;
    $arr["religion"] = $religion;

    $arr["sex"] = $sex;
    $userprofile -> update($arr);

}

    $userInfo = new User_Info($CURRENTUSER->id);
    require_once $boostack->registerTemplateFile("boostack/content_profile_edit.phtml");

}else
    require_once $boostack->registerTemplateFile("boostack/content_login.phtml");

require_once $boostack->registerTemplateFile("boostack/footer.phtml");
**/
// #######################

$boostack->renderCloseHtmlTag();
//import jquery ui .js
$boostack->registerAbsoluteScriptFile("//code.jquery.com/ui/1.11.4/jquery-ui.js");
$boostack->registerScriptFile("validator.js");
$boostack->writeLog("Homepage Page");
// #######################
?>