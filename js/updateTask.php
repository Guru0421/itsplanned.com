<?

    include_once("../init_backend.php");
    $init = new init_backend();

    $valid = isValidUser();
    if (!$valid) {
        print "no access";
        exit;
    }

    include_once("../tasks_backend.php");
    $task = new tasks_backend();

    $task->setField($_POST["task"], "progress", $_POST["progress"]);

?>
