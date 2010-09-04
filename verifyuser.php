<?php

class verifyuser {

    function main($itsp) {

        include("dwoo/dwooAutoload.php");

        if ($itsp->bUrl->getGP("s")) {
            user_backend::verifyUser($itsp->bUrl->getGP("s"), $itsp->bUrl->getGP("u"), 1);
        }

        $valid = isValidUser();
        if ($valid) {

            $tpl = new Dwoo_Template_File('templates/verifieduser.tpl');
            $dwoo = new Dwoo();

            $params = array();
            $homeurl = "/".config::installpath."".$itsp->bUrl->newUrl("tasks", $params);

            $markerArray = loggedInArray();
            $markerArray["pageVerifiedUserAccepted"] = $itsp->bLang->getLL("page.verifieduser.useraccepted");
            $markerArray["pageVerifiedUserHomeUrl"] = $itsp->bLang->getLL("page.verifieduser.homeurl");
            $markerArray["homeUrl"] = $homeurl;

            $output = $dwoo->get($tpl, $markerArray);
            print $output;
        } else {
            print "access denied";
        }

    }
}

?>

