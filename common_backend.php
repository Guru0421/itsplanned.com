<?

    function debug($debug) {

        if (!$GLOBALS["debug"]) {
            return;
        }

        if (is_array($debug)) {
            print _debugArray($debug);
        } else {
            print("Debug: $debug<br />");
        }

    }

    function _debugArray($array) {
        $return = "";
        $return .= "<table border='1'>";
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = _debugArray($value);
            }
            $return .= "<tr><td>$key</td><td>$value</td></tr>";
        }
        $return .= "</table><br />";
        return $return;
    }

    function isValidUser($type = "normal") {
        include_once("user_backend.php");
        $bUser = new user_backend("login");

        if ($bUser->checkSession()) {
            return 1;
        }

        if ($bUser->checkLogin($_POST["username"], $_POST["password"], $type)) {
            return 2;
        }
        return false;

    }

    function logoutUser() {
        session_start();
        $sql = "UPDATE ".config::dbprefix."users SET session='' WHERE session='".session_id()."'";
        mysql_query($sql);
    }

    function templateArray() {

        include_once("lang_backend.php");
        $lang = new lang_backend();

        include_once("urls_backend.php");
        $urls = new urls_backend;

        $params = array();
        $loggedinUrl = $urls->newUrl("home", $params);
        
        $params = array();
        $newuserUrl = $urls->newUrl("newuser", $params,0,0);
        
        $params = array();
        $forgotUrl = $urls->newUrl("forgotpassword", $params,0,0);

        $params = array();
        $rootUrl = $urls->newUrl("frontpage", $params, 0, 0);

        $array = array();
        $array["loggedinurl"] = $loggedinUrl;
        $array["newuserurl"] = $newuserUrl;
        $array["forgotpasswordurl"] = $forgotUrl;
        $array["rooturl"] = $rootUrl;
        $array["basehref"] = config::basehref;
        $array["username"] = $lang->getLL("username");
        $array["password"] = $lang->getLL("password");
        $array["loginbtn"] = $lang->getLL("login");

        return $array;
    }

    function loggedInArray() {
        session_start();
        $sql = "SELECT id, username FROM ".config::dbprefix."users WHERE session='".session_id()."'";
        $query = mysql_query($sql);

        $return = array();

        while ($result = mysql_fetch_array($query)) {

            $language = "";
            $sql = "SELECT value FROM ".config::dbprefix."usersettings WHERE userid='".addslashes($result["id"])."' AND field='layoutlanguage'";
            $query1 = mysql_query($sql);
            while ($result1 = mysql_fetch_array($query1)) {
                $language = $result1["value"];
            }

            $username = $result["username"];
            if ($username != "") {

                include_once("urls_backend.php");
                $urls = new urls_backend;
                
                include_once("lang_backend.php");
                $lang = new lang_backend($language);

                $params = array();
                $logouturl = $urls->newUrl("logout", $params);
                $params = array();
                $myinfourl = $urls->newUrl("myinfo", $params);
                $params = array();
                $tasksurl = $urls->newUrl("tasks", $params);

                $return["logouturl"] = $logouturl;
                $return["myinfourl"] = $myinfourl;
                $return["tasksurl"] = $tasksurl;
                $return["username"] = $username;
                $return["headerMyInfo"] = $lang->getLL("page.header.myinfo");
                $return["headerMyTasks"] = $lang->getLL("page.header.tasks");
                $return["headerLoggedinas"] = $lang->getLL("page.header.loggedinas");
                $return["headerLogout"] = $lang->getLL("page.header.logout");
                $return["basehref"] = config::basehref;

                return $return;
            }
        }

        return $return;

    }

?>
