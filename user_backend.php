<?

    class user_backend {

        private $userid = 0;


        function __construct($t = "direct") {
            // exit if no valid session found
            if (!$this->checkSession() && $t == "direct") {
                exit;   
            }
        }

        function resetPassword($username) {

            $newmd5 = microtime()."".$username."".$_SERVER["HTTP_HOST"];
            $newmd5 = md5($newmd5);

            $sql = "UPDATE ".config::dbprefix."users SET reset='$newmd5' WHERE (username='".addslashes($username)."' OR email='".addslashes($username)."')";
            $query = mysql_query($sql);

            $return = array();

            $sql = "SELECT username, email FROM ".config::dbprefix."users WHERE reset='$newmd5'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                $return["username"] = $result["username"];
                $return["reset"]    = $newmd5;
                $return["email"]    = $result["email"];
            }
//            sleep(5);
            return $return;
        }

        function setNewPassword($reset, $newpassword) {
            if (trim($newpassword) != "") {
                $newpassword = md5($newpassword);
                $sql = "UPDATE ".config::dbprefix."users SET password='$newpassword', reset='', verified='1' WHERE reset='".addslashes($reset)."'";
                mysql_query($sql);  
                return 1;
            }
            return 0;
        }

        function createNew($username, $password) {
            $password = md5($password);

            $sql = "SELECT id FROM ".config::dbprefix."users WHERE username='".addslashes($username)."'";
            $query = mysql_query($sql);
            if (mysql_num_rows($query) > 0) {
                throw new Exception("UserExist");
            }

            $sql = "UPDATE ".config::dbprefix."users SET session='' WHERE session='".session_id()."'";
            mysql_query($sql);

            $sql = "INSERT INTO ".config::dbprefix."users (username, password, verified) VALUES ('".addslashes($username)."', '".addslashes($password)."','2')";
            mysql_query($sql);
        }

        function checkLogin($username, $password, $type) {
            $password = md5($password);

            $verified = 1;
            if ($type == "create") {
                $verified = 2;
            }

            $sql = "SELECT id FROM ".config::dbprefix."users WHERE username!='' AND username='".addslashes($username)."' AND password='".addslashes($password)."' AND verified='$verified'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
 
                $sql = "UPDATE ".config::dbprefix."users SET session='".session_id()."' WHERE id='".$result[id]."'";
                mysql_query($sql);

                $_SESSION["user"] = session_id();
                return $result[id];
            }
        }

        // check for valid session
        function checkSession() {
            if (session_id() != "") {
                $sql = "SELECT id FROM ".config::dbprefix."users WHERE session='".session_id()."' AND username!='' AND verified='1'";
                $query = mysql_query($sql);
                while ($result = mysql_fetch_array($query)) {
                    $this->userid = $result[id];
                    return $result[id];
                }
            }
        }

        // check if username is available
        function isUsernameAvail($username) {
            $sql = "SELECT session FROM ".config::dbprefix."users WHERE username='".addslashes($username)."'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                if ($result["session"] != session_id()) {
                    return false;
                }
            }
            return true;
        }

        function setUserInfo($field, $value) {
            $fields = addslashes($field);
            $value  = addslashes($value);
            $sql = "UPDATE ".config::dbprefix."users SET `$fields`='$value' WHERE session='".session_id()."'";
            mysql_query($sql);
        }

        function getUserInfo($field) {
            $sql = "SELECT `$field` FROM ".config::dbprefix."users WHERE session='".session_id()."'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                return $result[$field];    
            }
        }

        function getUserSetting($field) {
            $sql = "SELECT value FROM ".config::dbprefix."usersettings WHERE userid='".$this->userid."' AND field='".addslashes($field)."'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                return $result["value"];
            }
        }

        function verifyUser($session, $username, $code = 1) {
            $sql = "UPDATE ".config::dbprefix."users SET verified='".addslashes($code)."' WHERE session='".addslashes($session)."' AND username='".addslashes($username)."'";
            mysql_query($sql);
        }

        function setUserSetting($field, $value) {
            $sql = "DELETE FROM ".config::dbprefix."usersettings WHERE userid='".$this->userid."' AND field='".addslashes($field)."' ";
            mysql_query($sql);

            $sql = "INSERT INTO ".config::dbprefix."usersettings (userid, field, value) VALUES ('".$this->userid."','".addslashes($field)."', '".addslashes($value)."')";
            mysql_query($sql);
        }

    }


?>
