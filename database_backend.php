<?

    class database_backend {

        function connect() {
            $link = mysql_connect(config::dbhostname, config::dbusername, config::dbpassword);
            mysql_select_db(config::dbtable, $link);
        }

        function disconnect() {
            mysql_close();
        }

    }


?>
