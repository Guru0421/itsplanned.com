<?

    class urls_backend {

        private $params;

        // prepare parameteres for later use
        function __construct() {
            $url = $_SERVER["REQUEST_URI"];
            $url = str_replace(config::installpath, "", $url);

            // match both with and without trailing slash
            $sql = "SELECT params FROM ".config::dbprefix."urls WHERE url='".addslashes($url)."' OR url='".addslashes($url)."/'";
//            debug($sql);
            $query = mysql_query($sql);
            while ($result = mysql_fetch_array($query)) {
                $this->params = unserialize($result["params"]);
            }
        }

        // generate new url
        function newUrl($destination, $params, $inclhostname = 0, $addhash=1) {
            if (config::prettyurls) {
                $url = str_replace(" ", "", $destination);
            } else {
                $url = "?";
            }
            foreach($params as $key => $value) {
                if (strstr($key, "__")) {
                    if (config::prettyurls) {
                        $params["$key"] = $value;
                    } else {
                        $url .= "&amp;$key=$value";
                    }
                } else {
                    $value = str_replace(" ", "", $value);
                    if (config::prettyurls) {
                        $url .= "/$value";
                    } else {
                        $url .= "&amp;$key=$value";
                    }

                }
            }
            if (config::prettyurls) {
                $params["__itspDEST"] = $destination;
            } else {
                $url .= "&amp;__itspDEST=$destination";
            }
            $params = serialize($params);
            $url = str_replace("//", "/", $url);
            if (config::prettyurls) {
                $url = preg_replace("/[^a-z0-9\/]?/i", "$1", $url);
            }

            include_once("user_backend.php");
            $user = new user_backend("url");

            $hash = "";
            if ($addhash) {
                $hash = substr(md5(serialize($params).$user->getUserInfo("id")),0,10);
            }
            if (config::prettyurls) {
                $url .= "/$hash";
            } else {
                $url .= "&amp;hash=$hash";
            }

            if (config::prettyurls) {
                $sql = "INSERT INTO ".config::dbprefix."urls (crdate, params, url, hash) VALUES ('".time()."', '".addslashes($params)."', '/".addslashes($url)."', '$hash')";
                mysql_query($sql);
            }

            if ($destination == "frontpage") {
                $url = "";
            }
            if ($inclhostname) {
                $url = "http://" . $_SERVER["HTTP_HOST"] . "/" . config::installpath . "". $url;
            }
            return $url;
        }

        function getGP($parameter) {
            if (config::prettyurls) {
                return $this->params[$parameter];
            } else {
                return $_POST[$parameter] ? $_POST[$parameter] : $_GET[$parameter];
            }
        }

    }


?>
