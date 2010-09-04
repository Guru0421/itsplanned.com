<?php

class rejectuser {

    function main($itsp) {

        include("dwoo/dwooAutoload.php");

        if ($itsp->bUrl->getGP("s")) {
            user_backend::verifyUser($itsp->bUrl->getGP("s"), $itsp->bUrl->getGP("u"), 9);
        
            $tpl = new Dwoo_Template_File('templates/rejectuser.tpl');
            $dwoo = new Dwoo();

            $markerArray = templateArray();
            $markerArray["pageRejectedMsg1"] = $itsp->bLang->getLL("page.rejecteduser.msg1");

            $output = $dwoo->get($tpl, $markerArray);
            print $output;
        } else {
            print "access denied";
        }

    }
}

?>

