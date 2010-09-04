<?

    include_once("common_backend.php");
    include_once("config.php");
    include_once("database_backend.php");
    include_once("lang_backend.php");
    include_once("urls_backend.php");
    include_once("user_backend.php");

    $GLOBALS["debug"] = 1;

    class init_backend {

        protected $db;
        public $bLang;
        public $bUrl;

        function __construct($lang="") {
            if (!session_id()) {
                session_start();
            }
            if (!$this->db) {
                $this->db = new database_backend();
                $this->db->connect();

                if (user_backend::checkSession()) {
                    $language = user_backend::getUserSetting("layoutlanguage");
                }
                if ($language == "") {
                    $language = "en";
                }

                $this->bLang = new lang_backend($language);
                $this->bUrl = new urls_backend();

            }
        }

    }
?>
