<?php

class logout {

    function main($itsp) {

        $itsp->bLang->setLanguage($_GET["lang"]);

        $valid = isValidUser();
        if ($valid) {
            logoutUser();

            include_once("urls_backend.php");
            $urls = new urls_backend;

            $params = array();
            $logouturl = $urls->newUrl("frontpage", $params);

            print '<META HTTP-EQUIV="Refresh" Content = "0;URL='.config::basehref.'">';

        } else {
            print "access denied";
        }

    }
}

?>

