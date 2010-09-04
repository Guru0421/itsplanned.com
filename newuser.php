<?php

class newuser {

    function main($itsp) {

        $itsp->bLang->setLanguage($_GET["lang"]);

        include("dwoo/dwooAutoload.php");

        $displayNewUserForm = 1;
        $errormsg = "";

        if ($_POST["username"] && $_POST["password"]) {

            include_once("user_backend.php");
            $bUser = new user_backend("newuser");
            try {

                $errormsg = "";
                $errors = 0;
                $passwordok = 0;

                if ($_POST["username"]) {
                    include_once("user_backend.php");
                    if (!$bUser->isUsernameAvail($_POST["username"])) {
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
                    $bUser->createNew($_POST["username"], $_POST["password"]);
                    
                    isValidUser("create");

                    $bUser->setUserInfo("realname", $_POST["realname"]);
                    $bUser->setUserInfo("email", $_POST["email"]);
                    $bUser->setUserInfo("verified", '0');

                    $tpl = new Dwoo_Template_File('templates/newuseremail.tpl'); 
                    $dwoo = new Dwoo();
           
                    $params = array();
                    $params["s"]      = session_id();
                    $params["u"]      = $_POST["username"];
                    $verifyuserUrl = $itsp->bUrl->newUrl("verifyuser", $params, 1);
                    $rejectuserUrl = $itsp->bUrl->newUrl("rejectuser", $params, 1);

                    $markerArray = array();
                    $markerArray["emailNewuserHello"] = $itsp->bLang->getLL("email.newuser.hello");
                    $markerArray["username"] = $_POST["username"];
                    $markerArray["emailNewuserHostname"] = config::hostname;
                    $markerArray["emailNewuserMsg1"] = $itsp->bLang->getLL("email.newuser.msg1");
                    $markerArray["emailNewuserMsg2"] = $itsp->bLang->getLL("email.newuser.msg2");
                    $markerArray["emailNewuserMsg3"] = $itsp->bLang->getLL("email.newuser.msg3");
                    $markerArray["emailNewuserMsg4"] = $itsp->bLang->getLL("email.newuser.msg4");
                    $markerArray["emailNewuserMsg5"] = $itsp->bLang->getLL("email.newuser.msg5");
                    $markerArray["emailNewuserMsg6"] = $itsp->bLang->getLL("email.newuser.msg6");
                    $markerArray["emailNewuserVerifyURL"] = $verifyuserUrl;
                    $markerArray["emailNewuserRejectURL"] = $rejectuserUrl;
                    $markerArray["emailNewuserSignature"] = $itsp->bLang->getLL("email.newuser.signature");

                    $newuseremail = $dwoo->get($tpl, $markerArray);
                   
                    $emailto = $_POST["email"];
                    $emailsubject = $itsp->bLang->getLL("email.newuser.subject");
                    $emailheaders = "From: ".config::newuserFromEmail."\r\n";

                    mail($emailto, $emailsubject, $newuseremail, $emailheaders);

                    $tpl = new Dwoo_Template_File('templates/userverification.tpl');
                    $dwoo = new Dwoo();

                    $markerArray = templateArray();
                    $markerArray["pageUserverificationMsg1"] = $itsp->bLang->getLL("page.userverification.msg1");

                    $output = $dwoo->get($tpl, $markerArray);
                    print $output;

                    exit;
                }
                
            } catch (Exception $e) {
                if ($e->getMessage() == "UserExist") {
                    $errormsg = "Username is already taken";
                }
            }

        } 
        if ($displayNewUserForm) {

            $tpl = new Dwoo_Template_File('templates/myinfonew.tpl'); 
            $dwoo = new Dwoo();

            $markerArray = templateArray();
            $markerArray["url"]                         = $_SERVER["REQUEST_URI"];
            $markerArray["pageMyinfoErrorMsg"]          = $errormsg;
            $markerArray["username"]                    = $itsp->bLang->getLL("username");
            $markerArray["password"]                    = $itsp->bLang->getLL("password");
            $markerArray["pageMyinfoUsername"]          = $itsp->bLang->getLL("page.myinfo.username");
            $markerArray["pageMyinfoNewPassword"]       = $itsp->bLang->getLL("page.myinfo.newpassword");
            $markerArray["pageMyinfoNewPasswordRepeat"] = $itsp->bLang->getLL("page.myinfo.newpasswordrepeat");
            $markerArray["pageMyinfoRealname"]          = $itsp->bLang->getLL("page.myinfo.realname");
            $markerArray["pageMyinfoEmail"]             = $itsp->bLang->getLL("page.myinfo.email");
            $markerArray["pageMyinfoUpdate"]            = $itsp->bLang->getLL("page.myinfo.create");
            $markerArray["pageMyinfoLayoutLanguage"]    = $itsp->bLang->getLL("page.myinfo.layoutlanguage");
            $markerArray["usernamefield"]               = $_POST["username"];
            $markerArray["email"]                       = $_POST["email"];
            $markerArray["realname"]                    = $_POST["realname"];
            $markerArray["headertitle"]                 = $itsp->bLang->getLL("page.myinfo.newusertitle");
            $markerArray["loginbtn"]                    = $itsp->bLang->getLL("login");


            $createnewuser = $dwoo->get($tpl, $markerArray);
            print $createnewuser;

        }

    }
}

?>

