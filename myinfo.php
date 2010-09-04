<?php

class myinfo {

    function main($itsp) {


        include_once("dwoo/dwooAutoload.php");

        $valid = isValidUser();
        if ($valid) {

            include_once("user_backend.php");
            $userb = new user_backend();

            if ($_POST) {
                $errormsg = "";
                $errors = 0;
                $passwordok = 0;
                if ($_POST["username"]) {
                    include_once("user_backend.php");
                    $userb = new user_backend();
                    if (!$userb->isUsernameAvail($_POST["username"])) {
                        if ($errormsg != "") {
                            $errormsg .= "<br />";
                        }   
                        $errormsg .= $itsp->bLang->getLL("page.myinfo.usernamenotavailable");
                        $errors++;
                    }
                }
                if ($_POST["password"] != $_POST["repeatpassword"]) {
                    if ($errormsg != "") {
                        $errormsg .= "<br />";
                    }   
                    $errormsg .= $itsp->bLang->getLL("page.myinfo.notidenticalpasswords");
                    $errors++;
                } else {
                    if ($_POST["password"] != "itsplanned") {
                        $passwordok = 1;
                    }
                }
            
                if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $_POST["email"])) {
                    if ($errormsg != "") {
                        $errormsg .= "<br />";
                    }   
                    $errormsg .= $itsp->bLang->getLL("page.myinfo.novalidemail");
                    $errors++;
                }

                if ($errors == 0) {

                    $userb->setUserInfo("realname", $_POST["realname"]);
                    $userb->setUserInfo("username", $_POST["username"]);
                    $userb->setUserInfo("email", $_POST["email"]);
                    if ($passwordok) {
                        $userb->setUserInfo("password", md5($_POST["password"]));
                    }
                    $userb->setUserSetting("layoutlanguage", $_POST["language"]);
                    $itsp->bLang->setLanguage($_POST["language"]);
                }
            }

            $tpl = new Dwoo_Template_File('templates/myinfo.tpl');
            $dwoo = new Dwoo();

            $language = $userb->getUserSetting("layoutlanguage");

            $markerArray = loggedInArray();
            $markerArray["pageMyinfoUsername"]      = $itsp->bLang->getLL("page.myinfo.username");
            $markerArray["pageMyinfoNewPassword"]   = $itsp->bLang->getLL("page.myinfo.newpassword");
            $markerArray["pageMyinfoNewPasswordRepeat"]   = $itsp->bLang->getLL("page.myinfo.newpasswordrepeat");
            $markerArray["pageMyinfoRealname"]      = $itsp->bLang->getLL("page.myinfo.realname");
            $markerArray["pageMyinfoEmail"]         = $itsp->bLang->getLL("page.myinfo.email");
            $markerArray["pageMyinfoUpdate"]        = $itsp->bLang->getLL("page.myinfo.update");
            $markerArray["pageMyinfoLayoutLanguage"] = $itsp->bLang->getLL("page.myinfo.layoutlanguage");
            $markerArray["pageMyinfoErrorMsg"]      = $errormsg;
            $markerArray["password"]                = "itsplanned";
            $markerArray["email"]                   = $userb->getUserInfo("email");
            $markerArray["realname"]                = $userb->getUserInfo("realname");
            $markerArray["languageset".$language]   = " selected=selected ";
            $markerArray["headertitle"] = $itsp->bLang->getLL("page.myinfo.title");

            $page = $dwoo->get($tpl, $markerArray);
            print $page;
        } else {
            print "access denied";
        }

    }
}

?>

