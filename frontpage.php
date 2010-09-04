<?php

class frontpage {

    function main($itsp) {

        $itsp->bLang->setLanguage($_GET["lang"]);

        include_once("dwoo/dwooAutoload.php");

        $params = array();
        $params["lang"] = "dk";
        $params["screen"] = "newUser";
        $newUserUrl = $itsp->bUrl->newUrl("newuser", $params,0,0);

        $params = array();
        $screenshoturl = $itsp->bUrl->newUrl("screenshots", $params,0,0);

        $params = array();
        $loginUrl = $itsp->bUrl->newUrl("home", $params);

        $tpl = new Dwoo_Template_File('templates/frontpage.tpl'); 

        $dwoo = new Dwoo();

        $jsfiles = array();
        $jsfiles[] = array('jsfile' => 'js/newuser.js');

        $markerArray = templateArray();
        $markerArray["headertitle"]     = $itsp->bLang->getLL("title") . " frontpage";
        $markerArray["username"]        = $itsp->bLang->getLL("username");
        $markerArray["password"]        = $itsp->bLang->getLL("password");
        $markerArray["title"]           = "myTasks frontpage";
        $markerArray["loginbtn"]        = "Login";
        $markerArray["createNewUser"]   = $itsp->bLang->getLL("createNewUser");
        $markerArray["url"]             = $newUserUrl;
        $markerArray["loginUrl"]        = $loginUrl;
        $markerArray["js_list"]         = $jsfiles;
        $markerArray["screenshoturl"]   = $screenshoturl;


        $output = $dwoo->get($tpl, $markerArray);

        print $output;

    }
}

?>

