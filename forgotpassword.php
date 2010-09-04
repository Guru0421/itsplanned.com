<?php

class forgotpassword {

    function main($itsp) {

        include("dwoo/dwooAutoload.php");
        
        $displayNewUserForm=1;

        $emailsent = "";

        if ($_POST["username"]) {

            include_once("user_backend.php");
            $bUser = new user_backend("newuser");
            $sess = $bUser->resetPassword($_POST["username"]);
            if ($sess) {

                $tpl = new Dwoo_Template_File('templates/forgotpasswordemail.tpl');
                $dwoo = new Dwoo();

                $params = array();
                $params["s"]      = $sess["reset"];
                $params["u"]      = $sess["username"];
                $setnewpasswordUrl = $itsp->bUrl->newUrl("setnewpassword", $params, 1);

                $markerArray = array();
                $markerArray["emailForgotpasswordHello"] = $itsp->bLang->getLL("email.forgotpassword.hello");
                $markerArray["username"] = $sess["username"];
                $markerArray["emailForgotpasswordHostname"] = config::hostname;
                $markerArray["emailForgotpasswordMsg1"] = $itsp->bLang->getLL("email.forgotpassword.msg1");
                $markerArray["emailForgotpasswordMsg2"] = $itsp->bLang->getLL("email.forgotpassword.msg2");
                $markerArray["emailForgotpasswordMsg3"] = $itsp->bLang->getLL("email.forgotpassword.msg3");
                $markerArray["emailForgotpasswordMsg4"] = $itsp->bLang->getLL("email.forgotpassword.msg4");
                $markerArray["emailForgotpasswordMsg5"] = $itsp->bLang->getLL("email.forgotpassword.msg5");
                $markerArray["emailForgotpasswordMsg6"] = $itsp->bLang->getLL("email.forgotpassword.msg6");
                $markerArray["emailForgotpasswordURL"] = $setnewpasswordUrl;
                $markerArray["emailForgotpasswordSignature"] = $itsp->bLang->getLL("email.forgotpassword.signature");


                $forgotemail = $dwoo->get($tpl, $markerArray);

                $emailto = $sess["email"];
                $emailsubject = $itsp->bLang->getLL("email.forgotpassword.subject");
                $emailheaders = "From: ".config::resetpasswordFromEmail."\r\n";

                mail($emailto, $emailsubject, $forgotemail, $emailheaders);

                $emailsent = "Email sent";
            }

        } 
        if ($displayNewUserForm) {

            $tpl = new Dwoo_Template_File('templates/forgotpassword.tpl'); 
            $dwoo = new Dwoo();

            $markerArray = templateArray();
            $markerArray["url"]                         = $_SERVER["REQUEST_URI"];
            $markerArray["username"]                    = $itsp->bLang->getLL("username");
            $markerArray["password"]                    = $itsp->bLang->getLL("password");
            $markerArray["headertitle"]                 = $itsp->bLang->getLL("page.forgotpassword.title");
            $markerArray["loginbtn"]                    = $itsp->bLang->getLL("login");
            $markerArray["sendit"]                      = $itsp->bLang->getLL("sendit");
            $markerArray["emailsent"]                   = $emailsent;


            $createnewuser = $dwoo->get($tpl, $markerArray);
            print $createnewuser;

        }

    }
}

?>

