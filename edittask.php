<?php

class edittask {

    private $dwoo;
    private $ul;
    private $tasklist;

    function main($itsp) {

        include("dwoo/dwooAutoload.php");

        $valid = isValidUser();
        if ($valid) {

            $tpl = new Dwoo_Template_File('templates/newedittask.tpl');
            $this->dwoo = new Dwoo();

            $jsfiles = array();
            $jsfiles[] = array('jsfile' => 'js/newtask.js');
            $jsfiles[] = array('jsfile' => 'js/tiny_mce/jquery.tinymce.js');
            $jsfiles[] = array('jsfile' => 'js/tinymce.js');

            include_once("urls_backend.php");
            $urls = new urls_backend;
            $currenttask = $urls->getGP("__taskid");

            include_once("tasks_backend.php");
            $tasks = new tasks_backend();

            $submiturl = $_SERVER["HTTP_REFERER"];


            $parent = $tasks->getParent($currenttask);
            while ($parent["id"] > 0) {
                $params = array();
                $params["task"]      = $parent["title"];
                $params["__taskid"]  = $parent["id"];
                $breadcrumburl = $urls->newUrl("tasks", $params);
                $m_list[] = array('breadcrumburl' => ''.$breadcrumburl.'', 'breadcrumbitem' => ''.htmlentities($parent["title"]).'', 'sepstart' => '&#187;&nbsp;');
                $parent = $tasks->getParent($parent["pid"]);
            }
            $params = array();
            $breadcrumburl = $urls->newUrl("tasks", $params);
            $m_list[] = array('breadcrumburl' => ''.$breadcrumburl.'', 'breadcrumbitem' => 'Main');

            $m_list = array_reverse($m_list);


            $markerArray = loggedInArray();
            $markerArray["tasktitle"] = $tasks->getTaskInfo($currenttask, "title", 1);
            $markerArray["taskdescription"] = $tasks->getTaskInfo($currenttask, "description", 1 );
            $markerArray["js_list"] = $jsfiles;
            $markerArray["taskid"] = $currenttask;
            $markerArray["submiturl"] = $submiturl;
            $markerArray["func"] = "update";
            $progress = $tasks->getTaskInfo($currenttask, "progress");
            $markerArray["p".$progress] = "selected";
            $markerArray["submitbtn"] = $itsp->bLang->getLL("page.tasks.updatetask");
            $markerArray["m_list"] = $m_list;
            $markerArray["headertitle"] = $tasks->getTaskInfo($currenttask, "title");
            $markerArray["selectedtask"] = $itsp->bLang->getLL("page.tasks.selectedtask");
            $markerArray["tasktitletxt"] = $itsp->bLang->getLL("page.tasks.tasktitle");
            $markerArray["taskdescriptiontxt"] = $itsp->bLang->getLL("page.tasks.description");
            $markerArray["taskprogress"] = $itsp->bLang->getLL("page.tasks.progress");
            $markerArray["tasknotstarted"] = $itsp->bLang->getLL("page.tasks.notstarted");
            $markerArray["taskfinished"] = $itsp->bLang->getLL("closed");


            $output = $this->dwoo->get($tpl, $markerArray);
            print $output;
        } else {
            print "access denied";
        }

    }
}

?>

