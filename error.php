<?php

class error {

    function main($itsp) {

        include("dwoo/dwooAutoload.php");
        
            $tpl = new Dwoo_Template_File('templates/error.tpl');
            $dwoo = new Dwoo();

            $markerArray = templateArray();
            $markerArray["title"] = $itsp->bLang->getLL("page.error.title");
            $markerArray["pagenotfound"] = $itsp->bLang->getLL("page.error.pagenotfound");
            $markerArray["goback"] = $itsp->bLang->getLL("page.error.goback");
            $output = $dwoo->get($tpl, $markerArray);
            print $output;

    }
}

?>
