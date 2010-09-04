<?php

class screenshots {

    function main($itsp) {

        include("dwoo/dwooAutoload.php");
        
            $tpl = new Dwoo_Template_File('templates/screenshots.tpl');
            $dwoo = new Dwoo();

            $markerArray = templateArray();
            $markerArray["title"] = "screenshots";
            $output = $dwoo->get($tpl, $markerArray);
            print $output;

    }
}

?>
