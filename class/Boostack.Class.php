<?php
/**
 * Boostack: Boostack.Class.php
 * ========================================================================
 * Copyright 2015 Spagnolo Stefano
 * Licensed under MIT (https://github.com/offmania9/Boostack/blob/master/LICENSE)
 * ========================================================================
 * @author Spagnolo Stefano <s.spagnolo@hotmail.it>
 * @version 2
 */ 
class Boostack{
    protected $developmentMode = false;
    protected $publicUrl = "http://boostack.com/";
    protected $privateUrl = "http://localhost/boostack/";
    protected $url;
    protected $url_logo = "img/spendime_logo_x200.png";
    protected $sitename = "Boostack.com";
    protected $project_name = "Boostack";
    protected $project_sitename = "Boostack.com";
    protected $mail_admin = "info@boostack.com";
    protected $mail_noreply = "no-reply@boostack.com";
    protected $html_lang = "en";
    protected $project_mission = "Boostack.com - Improve your development and build a modern website in minutes";
    protected $facebookMetaTag = true;
    protected $og_type = "product";
    protected $og_title = "";
    protected $fb_app_id = "";
    protected $fb_app_secret = "";
    protected $fb_admins = "";
    protected $twitter = "@";
    protected $gplus = "https://plus.google.com/+Boostack/";

    protected $database_on = true;
    protected $session_on = false;  #true need database_on=true
    protected $checkcookie=false;  #true need database_on=true AND session_on=true
    protected $cookieexpire= 3600; //1 hour
    protected $cookiename= ""; //md5 key
    protected $checklanguage = true;
    protected $defaultlanguage = "en"; #must exists file: lang/[$defaultlanguage].inc.php   es:lang/en.inc.php
    protected $checkMobile = false;
    protected $log_on = true; #true need database_on=true

    protected $viewport = "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0";
    protected $site_title = "Boostack - a full stack web layer for PHP";
    protected $site_keywords = "boostack, php, framework, website, productive, simplicity, seo, secure, mysql, open-source";//comma separated
    protected $site_description = "Improve your development and build a modern website in minutes";
    protected $site_author = "stefano spagnolo";
    protected $site_shortcuticon = "img/favicon.ico";
    protected $appletouchicon_144 = "img/apple-touch-icon-144-precomposed.png";
    protected $appletouchicon_114 = "img/apple-touch-icon-114-precomposed.png";
    protected $appletouchicon_72  = "img/apple-touch-icon-72-precomposed.png";
    protected $appletouchicon_def = "img/apple-touch-icon-57-precomposed.png";

    protected $labels;

	public function __construct($developmentMode = false){
        $this->cookieexpire = 60*60*24*59;
        if($developmentMode){
            $this->url = $this->privateUrl;
            if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && !in_array('ob_gzhandler', ob_list_handlers())) ob_start("ob_gzhandler"); else ob_start();
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
        else
            $this->url = $this->publicUrl;

        $this->developmentMode = $developmentMode;
	}

    public function getLabel($key){
        $k = explode(".",$key);
        $lenght = count($k);
        if(is_array(($this->labels)))
            if($lenght == 1) {
                if (isset($this->labels[$k[0]]))
                    return $this->labels[$k[0]];
            }
            else{
                if($lenght == 2) {
                    if (isset($this->labels[$k[0]][$k[1]]))
                        return $this->labels[$k[0]][$k[1]];
                }
            }
    }

    public function registerScriptFile($fileName) {
        ?>
        <script type="text/javascript" src="<?=$this->url?>js/<?=$fileName?>"></script>
    <?
	}

    public function registerCssFile($fileName) {
        ?>
            <link href="<?=$this->url?>css/<?=$fileName?>" rel="stylesheet">
        <?
    }
    public function registerCoreServerFile($fileName) {
        #require_once(dirname(__FILE__)."/../core/".$fileName);
        $f = dirname(__FILE__)."/../core/".$fileName;
        if (!file_exists($f))
            exit($f." not found.");
        require_once($f);

    }

    public function renderOpenHtmlHeadTags($titlePrepend="") {
        ?>
        <!DOCTYPE html><html lang="<?=$this->html_lang?>" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"><head>
            <?
            $this->registerAllDefaultMetaTags($titlePrepend);
            $this->registerAllDefaultCssFiles();
            ?>
        </head>
        <body>
    <?
    }

    public function getFriendlyUrl($virtualPath){
{       return $this->url.$virtualPath;
}   }


    public function renderCloseHtmlTag($logMesg="") {
        global $db;
        $this->registerScriptFile("jquery.min.js");
        $this->registerScriptFile("bootstrap.min.js");
        $this->registerScriptFile("custom.js");
        echo "<!--[if lt IE 9]>";
        $this->registerScriptFile("html5shiv.js");
        $this->registerScriptFile("respond.min.js");
        echo "<![endif]-->";
        ?>
        <div id="fb-root"></div><div class="overlay"></div><div class="loading"></div>
        </body></html>
        <?
        $this->writeLog($logMesg);
        $db->Close();
    }

    public function writeLog($logMesg=""){
        global $db,$objSession;
        if($this->database_on){
            if($this->log_on){
                if($this->session_on)
                    DatabaseAccessLogger::getInstance($db,$objSession)->Log($logMesg);
                else
                    DatabaseAccessLogger::getInstance($db)->Log($logMesg);
            }
        }
    }

    public function __get($property_name) {
        if(isset($this->$property_name)) {
            return($this->$property_name);
        } else {
            return(NULL);
        }
    }

    public function __set($property_name, $val) {
        $this->$property_name = $val;
    }

    public function registerAllDefaultCssFiles(){
        $minified = $this->developmentMode ? "":".min";
        $this->registerCssFile("bootstrap".$minified.".css");
        $this->registerCssFile("animate".$minified.".css");
        $this->registerCssFile("custom".$minified.".css");
        $this->registerCssFile("custom_in".$minified.".css");
    }

    public function registerAllDefaultMetaTags($titlePrepend=""){?>
        <meta charset="utf-8">
        <meta name="viewport" content="<?=$this->viewport?>">
        <? if($this->facebookMetaTag){?>
            <meta property="og:title" content="<?=$this->og_title?>" />
            <meta property="og:type" content="<?=$this->og_type?>" />
            <meta property="og:url" content="<?=$this->url?>"/>
            <meta property="og:image" content="<?=$this->logo_210;?>"/>
            <meta property="og:description" content="<?=$this->site_description;?>" />
            <meta property="fb:app_id" content="<?=$this->fb_app_id?>" />
            <meta property="fb:admins" content="<?=$this->fb_admins?>" />
        <? }?>
        <title><?=($titlePrepend!="")?$titlePrepend." | ":""?><?=$this->site_title;?> | <?=$this->project_sitename?></title>
        <meta name="description" content="<?=$this->site_description?>"><meta name="author" content="<?=$this->site_author?>"><meta content="<?=$this->site_keywords;?>" name="Keywords" /><meta content="INDEX, FOLLOW" name="ROBOTS" />
        <link rel="shortcut icon" href="<?=$this->site_shortcuticon;?>" /><link rel="image_src" href="<?=$this->url_logo;?>" /><link rel="apple-touch-icon" sizes="144x144" href="<?=$this->appletouchicon_144;?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=$this->appletouchicon_114;?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=$this->appletouchicon_72;?>">
        <link rel="apple-touch-icon" href="<?=$this->appletouchicon_def;?>">
        <meta name="apple-mobile-web-app-title" content="<?=$this->sitename?>">
        <base href="<?=$this->url?>" /><meta name="apple-mobile-web-app-capable" content="yes" />
        <?
    }
}
?>