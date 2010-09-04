<?

    include_once("../init_backend.php");
    $init = new init_backend();

    $valid = isValidUser();
    if (!$valid) {
        print "no access";
        exit;
    }

    include_once("../tasks_backend.php");
    $tasks = new tasks_backend();

    $tasks->updateSorting($_POST[liid]);

?>
