<?

    class wizard {

        function go() {
            include_once("dwoo/dwooAutoload.php");

            if ($_POST) {

                $tpl  = new Dwoo_Template_File('templates/config.php.tpl');
                $dwoo = new Dwoo();

                $hostname = str_replace("http:", "", $_POST["hostname"]);
                $hostname = str_replace("/", "", $hostname);

                $markerArray = array();
                $markerArray["dbusername"]          = $_POST["mysqlusername"];
                $markerArray["dbpassword"]          = $_POST["mysqlpassword"];
                $markerArray["dbhostname"]          = $_POST["mysqlhostname"];
                $markerArray["dbtable"]             = $_POST["mysqldatabase"];
                $markerArray["installpath"]         = $_POST["installpath"];
                $markerArray["basehref"]            = "http://".$hostname."/".$_POST["installpath"];
                $markerArray["prefix"]              = $_POST["mysqlprefix"];
                $markerArray["prettyurls"]          = $_POST["prettyurls"] ? 1 : 0;
                $markerArray["hostname"]            = $hostname;
                $markerArray["newuseremail"]        = $_POST["newuseremail"];
                $markerArray["resetpasswordemail"]  = $_POST["resetpassword"];
                $output = "<?\n";
                $output .= $dwoo->get($tpl, $markerArray);
                $output .= "?>";

                $fp = fopen('config.php', 'w');
                fwrite($fp, $output);
                fclose($fp);

                include_once("config.php");
                include_once("database_backend.php");
                $db = new database_backend();
                $db->connect();

                $handle = fopen("database.sql", "rb");
                $databasesql = stream_get_contents($handle);
                fclose($handle);

                $databasesql = str_replace("itsp_", $_POST["mysqlprefix"], $databasesql);
 
                $sql_cmds = explode(";", $databasesql);

                for ($i=0; $i<count($sql_cmds); $i++) {
                    mysql_query($sql_cmds[$i]);
                }

                return 1;
            }
        

            $tpl  = new Dwoo_Template_File('templates/wizard.tpl');
            $dwoo = new Dwoo();

            $markerArray = array();
            $markerArray["hostname"]        = "http://".$_SERVER["HTTP_HOST"]."/";
            $markerArray["installpath"]     = substr($_SERVER["REQUEST_URI"],1);
            $markerArray["newuseremail"]    = "newuser@".$_SERVER["HTTP_HOST"];
            $markerArray["resetpassword"]   = "resetpassword@".$_SERVER["HTTP_HOST"];
            $output = $dwoo->get($tpl, $markerArray);
            print $output;
    
            return 0;

        }
    }

?>
