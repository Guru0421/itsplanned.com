<?

    include_once("../init_backend.php");
    $init = new init_backend();

    $valid = isValidUser();
    if (!$valid) {
        print "no access";
        exit;
    }

    include_once("../user_backend.php");
    $user = new user_backend();

    $user->setUserSetting($_POST["field"], $_POST["value"]);

?>
