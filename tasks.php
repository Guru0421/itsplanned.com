<?php

class tasks {

    private $dwoo;
    private $ul;
    private $taskslist;

    function main($itsp) {

        include("dwoo/dwooAutoload.php");

        $valid = isValidUser();
        if ($valid) {

            include_once("urls_backend.php");
            $urls = new urls_backend;

            include_once("tasks_backend.php");
            $tasks = new tasks_backend();

            $this_url = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["REQUEST_URI"];
            if ($_POST["func"] == "create") {
                $_pid = $urls->getGP("__taskid");
                $_title = $_POST["tasktitle"];
                $_description = $_POST["taskdescription"];
                $tasks->createNewTask($_pid, $_title, $_description);
                header("Location: $this_url#",TRUE,302);
                exit;
            }
            if ($_POST["func"] == "update" && !isset($_POST["delete"])) {
                $_id            = $_POST["taskid"];
                $_title         = $_POST["tasktitle"];
                $_description   = $_POST["taskdescription"];
                $tasks->updateTask($_id, $_title, $_description);
                $tasks->setField($_id, "progress", $_POST["taskprogress"]);
                header("Location: $this_url#",TRUE,302);
                exit;
            }
            if (isset($_POST["delete"])) {
                $_id            = $_POST["taskid"];
                $tasks->setField($_id, "deleted", 1);
                header("Location: $this_url#",TRUE,302);
                exit;
            }

            $tpl = new Dwoo_Template_File('templates/tasks.tpl');
            $this->dwoo = new Dwoo();

            $currenttask = $urls->getGP("__taskid");
            $currenttitle = $urls->getGP("task");

            $jsfiles = array();
            $jsfiles[] = array('jsfile' => 'js/jquery-ui-1.8.4.custom.min.js');
            $jsfiles[] = array('jsfile' => 'js/tasklist.php?t='.$currenttask);
            $jsfiles[] = array('jsfile' => 'js/widgetTreeList.js');


            $tasklist = $this->getSubTasks(0, 0);
            $markerArray = array();
            $markerArray["ulid"]       = "";
            $markerArray["ulclass"]    = "newul";

            $markerArray = loggedInArray();
            $markerArray["js_list"] = $jsfiles;

            $_tasks = $this->getSubTasks($currenttask ? $currenttask : 0 ,0, 99);
            $_closedtasks = $this->getSubTasks($currenttask ? $currenttask : 0 ,0, 100, "=");

            $m_list = array();

            $getParent = 1;

            $parent = $tasks->getParent($currenttask);
            while ($parent["id"] > 0) {
                $params = array();
                $params["task"]      = $parent["title"];
                $params["__taskid"]  = $parent["id"];
                $breadcrumburl = $urls->newUrl("tasks", $params);
                $m_list[] = array('breadcrumburl' => ''.$breadcrumburl.'', 'breadcrumbitem' => ''.$parent["title"].'', 'sepstart' => '&#187;&nbsp;');
                $parent = $tasks->getParent($parent["pid"]);
            }
            $params = array();
            $breadcrumburl = $urls->newUrl("tasks", $params);
            $m_list[] = array('breadcrumburl' => ''.$breadcrumburl.'', 'breadcrumbitem' => 'Main');

            $m_list = array_reverse($m_list);

            $p_list = array();

            $openmsg = $itsp->bLang->getLL("open"); 
            $closedmsg = $itsp->bLang->getLL("closed"); 
            $toggleinfomsg = $itsp->bLang->getLL("page.tasks.toggleinfo"); 
            $movethismsg = $itsp->bLang->getLL("page.tasks.movethis"); 
            $dontmovethismsg = stripslashes($itsp->bLang->getLL("page.tasks.dontmovethis")); 

            $user = new user_backend; 
            $moveableTasks = unserialize($user->getUserSetting("movingTasks"));

            $moveherevisible = "show";

            if ($moveableTasks == "") {
                $moveherevisible = "hide";
            }
            if (count($moveableTasks) <1 ) {
                $moveherevisible = "hide";
            }
            

            foreach ($_tasks as $key => $value) {
                $params = array();
                $params["task"] = $currenttitle."/".$value["title"];
                $params["__taskid"] = $value["id"];
                $taskurl = $urls->newUrl("tasks", $params);
                $edittaskurl = $urls->newUrl("edittask", $params);

                $subtasks       = $tasks->getNumberOfSubTasks($value["id"]);
                $opensubtasks   = $tasks->getNumberOfSubTasks($value["id"], 100);



                $status  = $tasks->getTaskInfo($value["id"], "progress");

                if ($status < 100) {
                    $status = $openmsg;
                } else {
                    $status = $closedmsg;
                }

                $created = $tasks->getTaskInfo($value["id"], "crdate");
                if ($created > 0) {
                    $created = date("d.m.Y", $created);
                } else {
                    $created = "N/A";
                }

                $toggleonoff = "strike nolink";
                if ($value["description"] != "") {
                    $toggleonoff = "";
                }


                $p_list[] = array('liid' => "liid_".$value["id"], 
                                  'liclass' => 'taskframe', 
                                  'licontent' => ''.$value["title"], 
                                  'taskurl' => ''.$taskurl.'', 
                                  'edittaskurl' => ''.$edittaskurl.'', 
                                  'subtasks' => ''.$subtasks.'', 
                                  'opensubtasks' => ''.$opensubtasks.'', 
                                  'toggleinfomsg' => ''.$toggleinfomsg.'', 
                                  'moveablemsg' => $moveableTasks[$value["id"]] ? $dontmovethismsg : $movethismsg , 
                                  'toggleonoff' => ''.$toggleonoff.'', 
                                  'created' => ''.$created.'', 
                                  'status' => ''.$status.'', 
                                  'statustxt' => $itsp->bLang->getLL("page.tasks.statustxt"), 
                                  'createdtxt' => $itsp->bLang->getLL("page.tasks.createdtxt"), 
                                  'opensubtaskstxt' => $itsp->bLang->getLL("page.tasks.opensubtaskstxt"), 
                                  'subtaskstxt' => $itsp->bLang->getLL("page.tasks.subtasks"), 
                                  'edittask' => $itsp->bLang->getLL("page.tasks.edittask"), 
                                  'state' => 'open', 
                                  'id' => $value["id"], 
                                  'taskdescription' => ''.$value["description"].'');
            }
            foreach ($_closedtasks as $key => $value) {
                $params = array();
                $params["task"] = $currenttitle."/".$value["title"];
                $params["__taskid"] = $value["id"];
                $taskurl = $urls->newUrl("tasks", $params);
                $edittaskurl = $urls->newUrl("edittask", $params);

                $subtasks       = $tasks->getNumberOfSubTasks($value["id"]);
                $opensubtasks   = $tasks->getNumberOfSubTasks($value["id"], 100);

                $status  = $tasks->getTaskInfo($value["id"], "progress");

                if ($status < 100) {
                    $status = $openmsg;
                } else {
                    $status = $closedmsg;
                }

                $created = $tasks->getTaskInfo($value["id"], "crdate");
                if ($created > 0) {
                    $created = date("d.m.Y", $created);
                } else {
                    $created = "N/A";
                }

                $p_list[] = array('liid' => "liid_".$value["id"], 
                                  'liclass' => 'taskframe', 
                                  'licontent' => ''.$value["title"], 
                                  'taskurl' => ''.$taskurl.'', 
                                  'edittaskurl' => ''.$edittaskurl.'', 
                                  'subtasks' => ''.$subtasks.'', 
                                  'opensubtasks' => ''.$opensubtasks.'', 
                                  'created' => ''.$created.'', 
                                  'status' => ''.$status.'', 
                                  'state' => 'closed', 
                                  'toggleinfomsg' => ''.$toggleinfomsg.'', 
                                  'moveablemsg' => $moveableTasks[$value["id"]] ? $dontmovethismsg : $movethismsg , 
                                  'statustxt' => $itsp->bLang->getLL("page.tasks.statustxt"), 
                                  'createdtxt' => $itsp->bLang->getLL("page.tasks.createdtxt"), 
                                  'opensubtaskstxt' => $itsp->bLang->getLL("page.tasks.opensubtaskstxt"), 
                                  'subtaskstxt' => $itsp->bLang->getLL("page.tasks.subtasks"), 
                                  'edittask' => $itsp->bLang->getLL("page.tasks.edittask"), 
                                  'id' => $value["id"], 
                                  'taskdescription' => ''.$value["description"].'');
            }

            $p_list[] = array('liid' => "liid_newtask", 
                'liclass' => 'liid_newtask', 
                'licontent' => '', 
                'taskurl' => '', 
                'taskdescription' => '');

            $markerArray["p_list"] = $p_list;
            $markerArray["m_list"] = $m_list;

            $thistask = $urls->getGP("__taskid");

            $params = array();
            $params["task"]      = $currenttitle;
            $params["__taskid"]  = $currenttask;
            $newtask = $urls->newUrl("newtask", $params);

            $checkedall = "";
            $showclosed = "";
            if ($user->getUserSetting("showAllField") == "on" ) {
                $checkedall = " checked=checked ";   
            }
            if ($user->getUserSetting("showClosedTasks") == "on" ) {
                $showclosed = " checked=checked ";   
            }
            if ($user->getUserSetting("showCompactMode") == "on" ) {
                $showcompact = " checked=checked ";   
            }

            $_title = $tasks->getTaskInfo($thistask, "title");

            $markerArray["taskdescription"]  = $tasks->getTaskInfo($thistask, "description");
            $markerArray["taskname"]         = $_title;
            $markerArray["headertitle"]         = $_title ? $_title : $itsp->bLang->getLL("page.tasks.maintitle");
            $markerArray["newtaskurl"]          = $newtask;
            $markerArray["showallinfochecked"]  = $checkedall;
            $markerArray["showclosedchecked"]   = $showclosed;
            $markerArray["showcompactmodechecked"]   = $showcompact;
            $markerArray["movetaskshere"]       = $itsp->bLang->getLL("page.tasks.movetaskshere_1")." <span class=\"movecount\">".count($moveableTasks) ."</span>". $itsp->bLang->getLL("page.tasks.movetaskshere_2");
            $markerArray["moveherevisible"]     = $moveherevisible;
            $markerArray["selectedtask"]        = $itsp->bLang->getLL("page.tasks.selectedtask");
            $markerArray["task"]                = $itsp->bLang->getLL("page.tasks.task");
            $markerArray["description"]         = $itsp->bLang->getLL("page.tasks.description");
            $markerArray["subtasks"]            = $itsp->bLang->getLL("page.tasks.subtasks");
            $markerArray["showallinfo"]         = $itsp->bLang->getLL("page.tasks.options.showallinfo");
            $markerArray["showclosedtasks"]     = $itsp->bLang->getLL("page.tasks.options.showclosedtasks");
            $markerArray["showcompactmode"]     = $itsp->bLang->getLL("page.tasks.options.compactmode");
            $markerArray["options"]             = $itsp->bLang->getLL("page.tasks.options");
            $markerArray["newtask"]             = $itsp->bLang->getLL("page.tasks.newtask");

            $settings = $this->dwoo->get($tpl, $markerArray);
            print $settings;
        } else {
            print "access denied";
        }

    }

    // should be moved to tasks_backend.php
    function getSubTasks($pid, $level, $progress=110, $sign="<=") {
        $sql = "SELECT ".config::dbprefix."tasks.* FROM ".config::dbprefix."tasks, ".config::dbprefix."userstasks, ".config::dbprefix."users WHERE ".config::dbprefix."users.session='".session_id()."' AND ".config::dbprefix."users.id = ".config::dbprefix."userstasks.userid AND ".config::dbprefix."userstasks.taskid = ".config::dbprefix."tasks.id AND ".config::dbprefix."tasks.pid='".addslashes($pid)."' AND ".config::dbprefix."tasks.deleted = 0 AND ".config::dbprefix."tasks.progress$sign'".addslashes($progress)."' ORDER BY ".config::dbprefix."tasks.sorting ASC";
        $i = 1;
        $return = array();
        $query = mysql_query($sql);
        while ($result = mysql_fetch_array($query)) {

            $return[$i]["id"] = $result["id"];
            $return[$i]["title"] = stripslashes($result["title"]);
            $return[$i]["description"] = stripslashes($result["description"]);
    
            $i++;
        }

        return $return;
    }

}

?>
