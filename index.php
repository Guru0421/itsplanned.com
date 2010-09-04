<?php

    if (! file_exists("config.php")) {
        include_once("wizard.php");
        $wizard = new wizard();
        if ( $wizard->go() ) {
                    
        } else {
            exit;
        }
    }

    include_once("init_backend.php");

    class init extends init_backend {

        function main() {
            $bUrl = new urls_backend();
            $__dest = $bUrl->getGP("__itspDEST");


            if ("/".config::installpath != $_SERVER["REQUEST_URI"] && $__dest == "") {
                header("HTTP/1.0 404 Not Found");
                $__dest = "error";
            } else {
                if (!$__dest) {
                    $__dest = "frontpage";
                }
            }

            include_once("$__dest".".php");
            $s = new $__dest;
            $s->main($this);
    
        }
    }

    $_init = new init();
    $_init->main();

?>

