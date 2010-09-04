<?

    class lang_backend {

        private $lang = array();

        function __construct($language = "en") {
            $this->setLanguage($language);
        }

        public function setLanguage($language) {
            @include("lang.en.php");
            @include("lang.$language.php");

        }

        public function getLL($field) {
            return addslashes(htmlentities(utf8_decode($this->lang["$field"])));
        }

    }


?>
