<?php

class newtask {

    private $dwoo;
    private $ul;
    private $taskslist;

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

            $params = array();
            $params["task"]      = $urls->getGP("task");
            $params["__taskid"]  = $currenttask;
            $submiturl = $urls->newUrl("tasks", $params);

            include_once("tasks_backend.php");
            $tasks = new tasks_backend();

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



            $markerArray = loggedInArray();
            $markerArray["tasktitle"] = "Enter title here";
            $markerArray["taskdescription"] = "";
            $markerArray["js_list"] = $jsfiles;
            $markerArray["func"] = "create";
            $markerArray["submiturl"] = $submiturl;
            $markerArray["submitbtn"] = $itsp->bLang->getLL("page.tasks.createnew");
            $markerArray["m_list"] = $m_list;
            $markerArray["headertitle"] = $itsp->bLang->getLL("page.tasks.title");
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

