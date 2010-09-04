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

    $return = 0;

    if ($_POST["moveto"]) {

        include_once("../user_backend.php");
        $user = new user_backend();
    
        $movingtasks = $user->getUserSetting("movingTasks");
        $movingtasks = unserialize($movingtasks);

        foreach ($movingtasks as $key => $value) {
            if ($task->hasRights($_POST["moveto"])) {
                $task->setField($key, "pid", $_POST["moveto"]);
            }
        }

        $user->setUserSetting("movingTasks", "");

        print "$('.movehere').hide();";
        print "location.reload(true);";
        exit;
    }

    if ($task->hasRights($_POST["task"])) {

        include_once("../user_backend.php");
        $user = new user_backend();
    
        $movingtasks = $user->getUserSetting("movingTasks");
        $movingtasks = unserialize($movingtasks);
    
        if ($movingtasks[$_POST["task"]]) {
            $return = "off";
            unset($movingtasks[$_POST["task"]]); 
        } else {
            $return = "on";
            $movingtasks[$_POST["task"]] = "on";
        }

        $return .= "-".count($movingtasks);

        $movingtasks = serialize($movingtasks);
        $user->setUserSetting("movingTasks", $movingtasks);

    }

    print $return;
?>
