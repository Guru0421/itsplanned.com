<?php

class setnewpassword {

    function main($itsp) {

        include_once("dwoo/dwooAutoload.php");
        
        $displayNewUserForm=1;

        $emailsent = "";

        $reset = $itsp->bUrl->getGP("s");
        $username = $itsp->bUrl->getGP("u");

        $showform = 1;
        $errormsg = "";

        if ($_POST["reset"]) {
            include_once("user_backend.php");
            $user = new user_backend("reset");
            if ($user->setNewPassword($_POST["reset"], $_POST["password"])) {
                $showform = 0;        
            
                $tpl = new Dwoo_Template_File('templates/setnewpassword1.tpl');
                $dwoo = new Dwoo();

                $markerArray = templateArray();

                $output = $dwoo->get($tpl, $markerArray);
                print $output;

                exit;
            } else {
                $errormsg = "Please enter a valid password";
            }
        }

        if ($reset != "" && $username != "" && $showform) {

            $tpl = new Dwoo_Template_File('templates/setnewpassword.tpl');
            $dwoo = new Dwoo();

            $markerArray = templateArray();
            $markerArray["url"] = $_SERVER["REQUEST_URI"];
            $markerArray["reset"] = $reset;
            $markerArray["errormsg"] = $errormsg;

            $output = $dwoo->get($tpl, $markerArray);
            print $output;
        }
    }
}

?>

