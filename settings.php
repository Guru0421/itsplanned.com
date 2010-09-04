<?php

class settings {

    function main($itsp) {

        $itsp->bLang->setLanguage($_GET["lang"]);

        include("dwoo/dwooAutoload.php");

        $tpl = new Dwoo_Template_File('templates/login.tpl'); 

        $dwoo = new Dwoo();

        $markerArray = array();
        $markerArray["headertitle"] = $itsp->bLang->getLL("title");
        $markerArray["username"] = $itsp->bLang->getLL("username");
        $markerArray["password"] = $itsp->bLang->getLL("password");
        $markerArray["loginbtn"] = "Login";

        $settings = $dwoo->get($tpl, $markerArray);

        print $settings;

    }
}

?>

