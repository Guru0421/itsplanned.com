<?

    /**
     * tasks_backend
     */
    
    class tasks_backend {

        private $userRights = array();

        function __construct() {
            $sql = "SELECT ".config::dbprefix."tasks.* FROM ".config::dbprefix."tasks, ".config::dbprefix."userstasks, ".config::dbprefix."users WHERE ".config::dbprefix."users.session='".session_id()."' AND ".config::dbprefix."users.id = ".config::dbprefix."userstasks.userid AND ".config::dbprefix."userstasks.taskid = ".config::dbprefix."tasks.id AND ".config::dbprefix."tasks.deleted='0'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                $this->userRights[] = $result["id"];                                
            }

        }

        function getRootTasks() {
            return $this->userRights;
        }

        function updateSorting($arr) {
            $v = 0;
            foreach ($arr as $key => $value) {
                if ($this->hasRights($value)) {
                    $v+=100;
                    $this->setSort($value, $v);        
                }
            }
        }

        function setField($id, $field, $value) {
            if ($this->hasRights($id)) {
                $sql = "UPDATE ".config::dbprefix."tasks SET `$field`='".addslashes($value)."' WHERE id='".addslashes($id)."' AND deleted='0'";
                mysql_query($sql);
            }
        }

        function getNextSorting($pid) {
            $sql = "SELECT sorting FROM ".config::dbprefix."tasks WHERE pid='".addslashes($pid)."' ORDER BY sorting DESC";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                return $result["sorting"]+100;
            }
        }

        function updateTask($id, $title, $description) {
            if ($this->hasRights($id)) {
                $sql = "UPDATE ".config::dbprefix."tasks SET title='".addslashes($title)."', description='".addslashes($description)."' WHERE id='".addslashes($id)."' AND deleted='0'";
                mysql_query($sql);
            }
        }

        function createNewTask($pid, $title, $description) {

            $newid = 0;

            $now = time();
            $sorting = $this->getNextSorting($pid);
            $sql = "INSERT INTO ".config::dbprefix."tasks SET pid='".addslashes($pid)."', crdate='$now', tstamp='$now', sorting='$sorting', title='".addslashes($title)."', description='".addslashes($description)."'";
            mysql_query($sql);

            $sql = "SELECT id FROM ".config::dbprefix."tasks WHERE pid='".addslashes($pid)."' AND crdate='$now' AND sorting='$sorting' AND title='".addslashes($title)."'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                $newid = $result["id"];
            }

            include_once("user_backend.php");
            $userid = user_backend::checkSession();

            $sql = "INSERT INTO ".config::dbprefix."userstasks SET userid='$userid', taskid='$newid'";
            mysql_query($sql);

            return $newid;
        }

        function getParent($id) {
            if ($this->hasRights($id)) {
                $return = array();
                $sql = "SELECT id, pid, title, description FROM ".config::dbprefix."tasks WHERE id='".addslashes($id)."' AND deleted='0'";
                $query = mysql_query($sql);
                while ($result = mysql_fetch_array($query)) {
                    $return["id"]           = $result["id"];
                    $return["pid"]          = $result["pid"];
                    $return["title"]        = stripslashes($result["title"]);
                    $return["description"]  = stripslashes($result["description"]);
                }
                return $return;
            }
        }

        function getNumberOfSubTasks($id, $below=110) {
            $sql = "SELECT count(id) AS num FROM ".config::dbprefix."tasks WHERE pid='".addslashes($id)."' AND progress<'".addslashes($below)."' AND deleted='0'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                return $result["num"];
            }
            return 0;
        }

        function getTaskInfo($id, $field, $htmlencode = 0) {
            if ($this->hasRights($id)) {
                $sql = "SELECT `".addslashes($field)."` FROM ".config::dbprefix."tasks WHERE id='".addslashes($id)."' AND deleted='0'";
                $query = mysql_query($sql);
                while ($result = mysql_fetch_array($query)) {
                    if ($htmlencode == 1) {
                        return htmlentities(stripslashes($result["$field"]));
                    } else {
                        return stripslashes($result["$field"]);
                    }
                }
            }
        }

        function setSort($id, $sorting) {
            $sql = "UPDATE ".config::dbprefix."tasks SET sorting='".addslashes($sorting)."' WHERE id='".addslashes($id)."' AND deleted='0' ";
            mysql_query($sql);
        }

        function hasRights($id) {
            if (in_array($id, $this->userRights)) {
                return true;
            }
            return false;
        }

        function getTasks($id = 0) {
            return;
            exit;
            $return = array();

            $_id = array_pop($this->userRights);

            $sql = "SELECT * FROM ".config::dbprefix."tasks WHERE id='$_id'";
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                $return["crdate"] = $result["crdate"];
                $return["tstamp"] = $result["tstamp"];
                $return["title"]  = $result["title"];
                $return["description"] = $result["description"];

                $sql = "SELECT id FROM ".config::dbprefix."tasks WHERE pid='".$result["id"]."'";
                $pidquery = mysql_query($sql);
                while ($pidresult = mysql_fetch_array($pidquery)) {
                    array_push($this->userRights, $pidresult["id"]);
                }

                return $return;
            }
            return false;
        }

    }


?>
