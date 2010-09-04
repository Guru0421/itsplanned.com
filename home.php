<?php

class home {

    function main($itsp) {

        $itsp->bLang->setLanguage($_GET["lang"]);

        include_once("dwoo/dwooAutoload.php");

        $valid = isValidUser();
        if ($valid) {

            $tpl = new Dwoo_Template_File('templates/home.tpl');
            $dwoo = new Dwoo();

            $markerArray = loggedInArray();

            $output = $dwoo->get($tpl, $markerArray);
            print $output;
        } else {
            $tpl = new Dwoo_Template_File('templates/frontpage.tpl');
            $dwoo = new Dwoo();

            $markerArray = templateArray();
            $markerArray["loginerror"] = "Failed to login";
            $output = $dwoo->get($tpl, $markerArray);
            print $output;
        }

    }
}

?>

