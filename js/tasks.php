<?

    include_once("../init_backend.php");
    $init = new init_backend();

    $valid = isValidUser();
    if (!$valid) {
        print "no access";
        exit;
    }

    print "$(document).ready(function(){ ";

    $output = "";

    
    $sql = "SELECT ".config::dbprefix."tasks.* FROM task, userstasks, users WHERE users.session='".session_id()."' AND users.id = userstasks.userid AND userstasks.taskid = tasks.id";
    $query = mysql_query($sql);
    while ($result = mysql_fetch_array($query)) {
        
    }


    print "});";

    function subTasks($id) {

        $sql = "SELECT * FROM ".config::dbprefix."tasks WHERE pid='$id'";
        $query = mysql_query($sql);
        while ($result = mysql_fetch_array($query)) {
            
        }

    }

?>
