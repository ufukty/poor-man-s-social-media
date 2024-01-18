<?php

namespace Page {

    class Page
    {
        public  $database;
        public  $authentication;
        public  $credentials;
        public  $userRelations;

        public $user = array(
            "raw" => NULL,
            "calculated" => array(
                "language" => NULL
            )
        );
        public $profile;

        public $login;

        function __construct()
        {
            $this->database        = new Database();
            $this->authentication  = new Authentication($this);
            $this->credentials     = new Credentials($this);
            $this->userRelations   = new UserRelations($this);

            if ($this->authentication->getUserID() != false)
                $this->user["raw"] = $this->credentials->userDetails();
            $this->user["calculated"]["language"] = $this->credentials->language();

            return;
        }

        public function defineProfile()
        {
            return $this->credentials->getProfileCredentials();
        }
    }

    class Authentication
    {
        private $page;

        public $user;
        public $login;

        function __construct(&$page)
        {
            $this->page = $page;
            $this->page->login = $this->isLoggedIn();
        }

        private function startSession()
        {
            if ($this->isSessionStarted() == false) session_start();
        }
        private function continuePreviousSession()
        {
            $this->startSession();
        }
        private function isSessionStarted()
        {
            // PHP VERSION >= 5.4.0
            if (session_status() == PHP_SESSION_NONE) return false;
            else return true;
        }
        private function createSession($userID)
        {
            $this->continuePreviousSession();
            $_SESSION["userID"] = $userID;
            return;
        }
        private function destroySession()
        {
            $this->continuePreviousSession();
            session_destroy();
            return true;
        }
        private function isSessionCreated()
        {
            $this->continuePreviousSession();
            if (isset($_SESSION["userID"])) return true;
            return false;
        }
        public function getUserID()
        {
            if (isset($_SESSION["userID"])) return $_SESSION["userID"];
            return false;
        }
        public function register($username, $email, $password, $name, $surname)
        {
            if ($this->isSessionCreated() == true)
                return array(
                    "status" => false,
                    "number" => 2000,
                    "message" => "already logged in",
                    "displayMessage" => "already logged in"
                );

            // ID ve parolanın alınmaması durumunda girişin iptali
            if ($username === NULL || $email === NULL || $password === NULL || $name === NULL || $surname === NULL)
                return array(
                    "status" => false,
                    "number" => 3001,
                    "message" => "register request has missing parts",
                    "displayMessage" => "something gone wrong"
                );

            $where = "email = '$email'";
            $record = $this->page->database->searchDatabase("USERDETAILS", "*", $where);
            if ($record != false)
                return array(
                    "status" => false,
                    "number" => 13000,
                    "message" => "register request has missing parts",
                    "displayMessage" => "something gone wrong"
                );


            $where = "username = '$username'";
            $record = $this->page->database->searchDatabase("USERDETAILS", "*", $where);
            if ($record != false)
                return array(
                    "status" => false,
                    "number" => 13001,
                    "message" => "register request has missing parts",
                    "displayMessage" => "something gone wrong"
                );

            // Kaçış karakterlerinin güvenli hale getirilmesi
            $input["username"] = mysqli_real_escape_string($this->page->database->connection, $username);
            $input["email"]    = mysqli_real_escape_string($this->page->database->connection, $email);
            $input["name"]     = mysqli_real_escape_string($this->page->database->connection, $name);
            $input["surname"]  = mysqli_real_escape_string($this->page->database->connection, $surname);
            $input["password"] = password_hash($password, PASSWORD_BCRYPT);

            $record = $this->page->database->addRecord(
                "USERDETAILS",
                array(
                    "username", "'{$input["username"]}'",
                    "email", "'{$input["email"]}'",
                    "passwordhash", "'{$input["password"]}'",
                    "firstname", "'{$input["name"]}'",
                    "surname", "'{$input["surname"]}'"
                )
            );

            // Kayıt açmada başarısızlık
            if ($record === false)
                return array(
                    "status" => false,
                    "number" => 3002,
                    "message" => "there is no account related with this ID",
                    "displayMessage" => "there is no account related with this ID"
                );

            $userid = $this->page->database->searchDatabase("USERDETAILS", "id", "username='" . $input['username'] . "'");
            $record = $this->page->database->addRecord("LOGINREQUESTS", array(
                "USERDETAILS_id", $userid
            ));

            // Kayıt açmada başarısızlık
            if ($record === false)
                return array(
                    "status" => false,
                    "number" => 3002,
                    "message" => "loginrequest record couldn't be added",
                    "displayMessage" => "something went wrong"
                );

            return array(
                "status" => true,
                "number" => 3004,
                "message" => "success",
                "displayMessage" => "welcome"
            );
        }
        public function login($id, $password)
        {
            if ($this->isSessionCreated() == true)
                return array(
                    "status" => false,
                    "number" => 2000,
                    "message" => "already logged in",
                    "displayMessage" => "already logged in"
                );

            // ID ve parolanın alınmaması durumunda girişin iptali
            if ($id === NULL || $password === NULL)
                return array(
                    "status" => false,
                    "number" => 2001,
                    "message" => "login request has missing parts",
                    "displayMessage" => "something gone wrong"
                );

            // ID'nin kaçış karakterlerinin güvenli hale getirilmesi
            $input["id"] = mysqli_real_escape_string($this->page->database->connection, $id);
            $input["password"] = $password;

            // ID'nin kullanıcı adı/e-posta adresi ayrımı
            if (preg_match('/\@/', $input["id"])) $where = "email = '{$input["id"]}'";
            else $where = "username = '{$input["id"]}'";

            $record = $this->page->database->searchDatabase("USERDETAILS", "*", $where);

            // İlgili ID için kullanıcı kaydı bulunamaması durumunda girişin iptali
            if ($record === false)
                return array(
                    "status" => false,
                    "number" => 2002,
                    "message" => "there is no account related with this ID",
                    "displayMessage" => "there is no account related with this ID"
                );

            // Kullanıcıdan gelen parolanın veritabanındaki değerle karşılaştırılması
            if (password_verify($input["password"], $record["passwordhash"]) === false)
                return array(
                    "status" => false,
                    "number" => 2003,
                    "message" => "invalid password",
                    "displayMessage" => "invalid password"
                );

            // İstenen hesabın silinmiş olması durumunda giriş iptali
            if ($record["deleted"] === true)
                return array(
                    "status" => false,
                    "number" => 2005,
                    "message" => "there is no account related with this ID",
                    "displayMessage" => "there is no account related with this ID"
                );

            // Parolanın eşleşmesi durumunda kullanıcı girişinin sağlanması ve alıcıya çerez gönderimi
            $this->createSession($record["id"]);

            // Girişin yapıldığı IP adresin ve tarihin LOGINREQUEST'e eklenmesi
            #$this->page->database->updateDatabase("LOGINREQUESTS", "ip='" . RequestValidation::getRequestIp() . "', lastlogin=UTC_TIMESTAMP()", "id={$record["USERDETAILS_id"]}");

            return array(
                "status" => true,
                "number" => 2004,
                "message" => "success",
                "displayMessage" => "welcome"
            );
        }
        public function logout()
        {
            if ($this->isSessionCreated() == false) {
                return array(
                    "status" => false,
                    "message" => "no login",
                    "displayMessage" => "can't logged out because there is no login session"
                );
            }
            if ($this->destroySession() == false) {
                return array(
                    "status" => false,
                    "message" => "session couldn't be destroyed",
                    "displayMessage" => "something gone wrong"
                );
            }

            $this->user = null;
            $this->login = null;

            return array(
                "status" => true,
                "message" => "success",
                "displayMessage" => "success"
            );
        }
        public function isLoggedIn()
        {
            return $this->isSessionCreated();
        }
    }

    class RequestValidation
    {
        static function getRequestIp()
        {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                return $_SERVER['REMOTE_ADDR'];
            }
        }
    }

    class Database
    {
        public $connection;

        function __construct()
        {
            $hostname = getenv("MYSQL_HOST");
            $username = getenv("MYSQL_USERNAME");
            $password = getenv("MYSQL_ROOT_PASSWORD");
            $dbname = getenv("MYSQL_DATABASE");

            $this->connection = mysqli_connect($hostname, $username, $password, $dbname);
            if (mysqli_connect_errno()) die("[ERRROR] connection/initialize " . mysqli_connect_error());
            if (!mysqli_set_charset($this->connection, "utf8")) die("[ERROR] connection/charset " . mysqli_error($this->connection));
        }
        function __destruct()
        {
            $this->connection->close();
        }
        public function destruct()
        {
            $this->connection->close();
        }
        /*
        @param: table
            Hedef tablonun adını içeren bir string
        @param: select
            Komple bir SELECT cümlesi
            "id, username, password"
        @param: where
            Komple bir WHERE cümlesi
            "id='loremipsum'" 
        @param: limit (opsiyonel)
            Etkilenecek toplam satır sayısı
        @return: Eğer sonuç bulunamadıysa false,
            Sonuç birden fazla alan içeriyorsa associative array,
            Sonuç sadece bir alan içeriyorsa string döndürür.
        */
        public function searchDatabase($table, $select, $where, $limit = 1, $offset = 0)
        {

            $result = $this->connection->query("SELECT $select FROM $table WHERE $where LIMIT $limit OFFSET $offset");
            if ($result === false) return false;
            $rows = $result->num_rows;

            if ($rows < 1) return false;

            if ($rows == 1) {
                $array = $result->fetch_array(MYSQLI_ASSOC);
                if (count($array) == 1) return reset($array);
                else return $array;
            }

            if ($rows > 1) {
                for ($i = 0; $row = $result->fetch_array(MYSQLI_ASSOC); $i++) {
                    if (count($row) == 1) $row = reset($row);
                    $multiArray[$i] = $row;
                }
                return $multiArray;
            }
        }
        /*
            @param: table
                Hedef tablonun adını içeren bir string
            @param: where
                Komple bir WHERE cümlesi
                "id='loremipsum'" 
            @param: set
                Düzenlenecek sütunları ve yeni değerleri içeren komple bir SET cümlesi
                "id='loremipsum', time=UTC_TIMESTAMP()"
            @param: limit (opsiyonel)
                Etkilenecek toplam satır sayısı
        */
        public function updateDatabase($table, $set, $where, $limit = 1)
        {

            if ($this->connection->query("UPDATE $table SET $set WHERE $where LIMIT $limit") === false) return false;
            return true;
        }
        public function addRecord($table, $values)
        {
            /*
        $table değişkenindeki tabloya $values dizisindeki değerleri içeren
        kaydı aktarır.

        $values bir dizisidir. Sırasıyla tablodaki bir alanı ve alacağı
        değerlerden oluşan ikilileri taşır. Örnek

          $values = array("name", "'john''", "surname", "'walter''", "age", "'27''", "time", "UTC_TIMESTAMP()");
      */
            $count = count($values);
            if ($count % 2 != 0) return false;

            $query = "INSERT INTO $table ({$values[0]}";
            for ($i = 1; 2 * $i < $count; $i++) $query .= ", {$values[2 *$i]}";
            $query .= ") VALUES ({$values[1]}";
            for ($i = 1; 2 * $i < $count; $i++) $query .= ", {$values[2 *$i + 1]}";
            $query .= ")";
            if ($this->connection->query($query) == false) return false;
            return true;
        }
    }

    class Credentials
    {
        private $page;

        function __construct(&$page)
        {
            $this->page = &$page;
        }
        public function userDetails($userID = false)
        {
            if ($userID == false) {
                if ($this->page->login == true)
                    $userID = $_SESSION["userID"];
                else
                    return false;
            }
            $ret = $this->page->database->searchDatabase("USERDETAILS", "*", "id = $userID");
            if ($ret["profilephoto_fullpath"] == NULL) $ret["profilephoto_fullpath"] = "user/pp/def.png";
            return $ret;
        }
        public function getProfileCredentials()
        {
            // Fonksiyon içinde erişmek için kısayollar
            $page = &$this->page;
            $user = &$this->page->user;
            $profile = &$this->page->profile;

            // Üye girişi yoksa ve hedef profil numarası URL'de belirtilmediyse;
            if (!($this->page->login || isset($_GET["id"]))) return array(
                "status" => false,
                "number" => 4001,
                "message" => "Target profile doesn't specified."
            );

            if (isset($_GET["id"])) {
                $tempProfileID = $_GET["id"];
            } else {
                $tempProfileID = $_SESSION["userID"];
            }

            $profile = $page->database->searchDatabase("USERDETAILS", "*", "id = $tempProfileID");

            // Profil sahibinin bilgileri veritabanında bulunamadıysa
            if ($profile == false) return array(
                "status" => false,
                "number" => 4003,
                "message" => "Profile doesn't exists."
            );

            if ($page->login && ($_SESSION["userID"] == $profile["id"]))
                $page->profile["owner"] = true;
            else
                $profile["owner"] = false;

            if ($profile["profilephoto_fullpath"] == NULL) $profile["profilephoto_fullpath"] = "user/pp/def.png";

            return array(
                "status" => true,
                "number" => 4002,
                "message" => "Success."
            );
        }
        public function language()
        {
            if ($this->page->login == true)
                $language = $this->page->user["raw"]["language"];
            else
                $language = \Utility\autoLanguage();

            switch ($language) {
                case "tr-TR":
                    if (file_exists("php/language/turkish.php")) require_once("php/language/turkish.php");
                    else if (file_exists("../php/language/turkish.php")) require_once("../php/language/turkish.php");
                    break;
                case "en-UK":
                case "en-US":
                default:
                    if (file_exists("php/language/english.php")) require_once("php/language/english.php");
                    else if (file_exists("../php/language/english.php")) require_once("../php/language/english.php");
                    break;
            }

            return $language;
        }
    }

    class UserRelations
    {
        private $page;
        private $database;
        private $states;
        private $actions;

        function __construct(&$page)
        {
            $this->page = &$page;
            $this->database = &$page->database;

            $this->states = array(
                "baslangic",
                "istegecevapbekleniyor",
                "istegecevapverilecek",
                "kullanicitakipediyor",
                "karsitaraftakipediyor",
                "arkadaslik",
                "kullaniciengelli",
                "karsitarafengelli",
                "karslikliengel"
            );
            $this->actions = array(
                "istekyollama",
                "istegigerialma",
                "onaylama",
                "onayıgerialma",
                "reddetme",
                "takibibirakma",
                "engelleme",
                "engelikaldirma"
            );

            return;
        }
        private function isValidState($state)
        {
            return in_array($state, $this->states);
        }
        private function isValidAction($action)
        {
            return in_array($action, $this->actions);
        }
        private function databaseRecordState($firstUserID, $secondUserID)
        {
            $currentState = $this->database->searchDatabase(
                "USERRELATIONS",
                "state",
                "firstUserID = '$firstUserID' AND secondUserID = '$secondUserID'"
            );
            return array(
                "currentState" => ($currentState != false) ? $currentState : "baslangic",
                "isRecordCreated" => ($currentState != false) ? true : false
            );
        }
        public function createStateRecord($firstUserID, $secondUserID)
        {
            if ($this->database->addRecord("USERRELATIONS", array(
                "firstUserID", "'$firstUserID'",
                "secondUserID", "'$secondUserID'",
                "state", "'baslangic'"
            )) == false) return false;
            if ($this->database->addRecord("USERRELATIONS", array(
                "firstUserID", "'$secondUserID'",
                "secondUserID", "'$firstUserID'",
                "state", "'baslangic'"
            )) == false) return false;
            return true;
        }
        private function nextState($currentState, $action)
        {
            switch ($currentState) {
                case "baslangic": {
                        switch ($action) {
                            case "istekyollama":
                                return array(
                                    "forFirstUser" => "istegecevapbekleniyor",
                                    "forSecondUser" => "istegecevapverilecek"
                                );
                            case "engelleme":
                                return array(
                                    "forFirstUser" => "karsitarafengelli",
                                    "forSecondUser" => "kullaniciengelli"
                                );
                        }
                    }
                case "istegecevapbekleniyor": {
                        switch ($action) {
                            case "istegigerialma":
                                return array(
                                    "forFirstUser" => "baslangic",
                                    "forSecondUser" => "baslangic"
                                );
                            case "engelleme":
                                return array(
                                    "forFirstUser" => "karsitarafengelli",
                                    "forSecondUser" => "kullaniciengelli"
                                );
                        }
                    }
                case "istegecevapverilecek": {
                        switch ($action) {
                            case "istekyollama":
                                return array(
                                    "forFirstUser" => "arkadaslik",
                                    "forSecondUser" => "arkadaslik"
                                );
                            case "onaylama":
                                return array(
                                    "forFirstUser" => "karsitaraftakipediyor",
                                    "forSecondUser" => "kullanicitakipediyor"
                                );
                            case "reddetme":
                                return array(
                                    "forFirstUser" => "baslangic",
                                    "forSecondUser" => "baslangic"
                                );
                            case "engelleme":
                                return array(
                                    "forFirstUser" => "karsitarafengelli",
                                    "forSecondUser" => "kullaniciengelli"
                                );
                        }
                    }
                case "kullanicitakipediyor": {
                        switch ($action) {
                            case "takibibirakma":
                                return array(
                                    "forFirstUser" => "baslangic",
                                    "forSecondUser" => "baslangic"
                                );
                            case "engelleme":
                                return array(
                                    "forFirstUser" => "karsitarafengelli",
                                    "forSecondUser" => "kullaniciengelli"
                                );
                        }
                    }
                case "karsitaraftakipediyor": {
                        switch ($action) {
                            case "istekyollama":
                                return array(
                                    "forFirstUser" => "arkadaslik",
                                    "forSecondUser" => "arkadaslik"
                                );
                            case "onayıgerialma":
                                return array(
                                    "forFirstUser" => "baslangic",
                                    "forSecondUser" => "baslangic"
                                );
                            case "engelleme":
                                return array(
                                    "forFirstUser" => "karsitarafengelli",
                                    "forSecondUser" => "kullaniciengelli"
                                );
                        }
                    }
                case "arkadaslik": {
                        switch ($action) {
                            case "takibibirakma":
                                return array(
                                    "forFirstUser" => "karsitaraftakipediyor",
                                    "forSecondUser" => "kullanicitakipediyor"
                                );
                            case "onayıgerialma":
                                return array(
                                    "forFirstUser" => "kullanicitakipediyor",
                                    "forSecondUser" => "karsitaraftakipediyor"
                                );
                            case "engelleme":
                                return array(
                                    "forFirstUser" => "karsitarafengelli",
                                    "forSecondUser" => "kullaniciengelli"
                                );
                        }
                    }
                case "kullaniciengelli": {
                        switch ($action) {
                            case "engelleme":
                                return array(
                                    "forFirstUser" => "karsilikliengel",
                                    "forSecondUser" => "karsilikliengel"
                                );
                        }
                    }
                case "karsitarafengelli": {
                        switch ($action) {
                            case "engelikaldirma":
                                return array(
                                    "forFirstUser" => "baslangic",
                                    "forSecondUser" => "baslangic"
                                );
                        }
                    }
                case "karsilikliengel": {
                        switch ($action) {
                            case "engelikaldirma":
                                return array(
                                    "forFirstUser" => "kullaniciengelli",
                                    "forSecondUser" => "karsitarafengelli"
                                );
                        }
                    }
            }
        }
        private function isActionPossibleForCurrentState($currentState, $action)
        {
            switch ($currentState) {
                case "baslangic": {
                        switch ($action) {
                            case "istekyollama":
                            case "engelleme":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "istegecevapbekleniyor": {
                        switch ($action) {
                            case "istegigerialma":
                            case "engelleme":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "istegecevapverilecek": {
                        switch ($action) {
                            case "istekyollama":
                            case "onaylama":
                            case "reddetme":
                            case "engelleme":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "kullanicitakipediyor": {
                        switch ($action) {
                            case "takibibirakma":
                            case "engelleme":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "karsitaraftakipediyor": {
                        switch ($action) {
                            case "istekyollama":
                            case "onayıgerialma":
                            case "engelleme":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "arkadaslik": {
                        switch ($action) {
                            case "takibibirakma":
                            case "onayıgerialma":
                            case "engelleme":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "kullaniciengelli": {
                        switch ($action) {
                            case "engelleme":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "karsitarafengelli": {
                        switch ($action) {
                            case "engelikaldirma":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                case "karsilikliengel": {
                        switch ($action) {
                            case "engelikaldirma":
                                return true;
                            default:
                                echo "\n[" . __LINE__ . " $action]";
                                return false;
                        }
                    }
                default:
                    echo "\n[" . __LINE__ . " $action]";
                    return false;
            }

            return false;
        }
        private function executeAction($currentState, $firstUserID, $secondUserID, $action)
        {
            $nextState = $this->nextState($currentState, $action);
            if ($this->database->updateDatabase("USERRELATIONS", "state = '{$nextState["forFirstUser"]}'", "firstUserID = '$firstUserID' AND secondUserID = '$secondUserID'") == false) return false;
            if ($this->database->updateDatabase("USERRELATIONS", "state = '{$nextState["forSecondUser"]}'", "firstUserID = '$secondUserID' AND secondUserID = '$firstUserID'") == false) return false;
            return true;
        }
        private function addRecordToHistory()
        {
            return true;
        }
        public function currentState($firstUserID, $secondUserID)
        {
            return $this->databaseRecordState($firstUserID, $secondUserID)["currentState"];
        }
        public function acceptNewRequestFromUser($firstUserID, $secondUserID, $action)
        {
            // STEP 1: CHECK PRECONDITIONS

            if ($this->isValidAction($action) == false) {
                return array(
                    "result" => false,
                    "message" => "bad request",
                    "displayMessage" => "something gone wrong"
                );
            }
            if ($this->page->login == false) {
                return array(
                    "result" => false,
                    "message" => "authentication required",
                    "displayMessage" => "something gone wrong"
                );
            }
            if ($this->page->user["raw"]["id"] != "$firstUserID") {
                return array(
                    "result" => false,
                    "message" => "user doesn't have authority to this action",
                    "displayMessage" => "something gone wrong"
                );
            }
            if ($firstUserID == $secondUserID) {
                return array(
                    "result" => false,
                    "message" => "target user same with the base user",
                    "displayMessage" => "this cannot be possible"
                );
            }

            $databaseRecordState = $this->databaseRecordState($firstUserID, $secondUserID);
            $currentState = $databaseRecordState["currentState"];
            $isRecordCreated = $databaseRecordState["isRecordCreated"];

            if ($isRecordCreated == false) {
                if ($this->createStateRecord($firstUserID, $secondUserID) == false) return array(
                    "result" => false,
                    "message" => "database error",
                    "displayMessage" => "something gone wrong"
                );
                $currentState = "baslangic";
            }
            if ($result = $this->isActionPossibleForCurrentState($currentState, $action) == false) {
                return array(
                    "result" => false,
                    "message" => "action isn't possible",
                    "displayMessage" => "this cannot be possible"
                );
            }

            // STEP 2: READY TO EXECUTION

            if ($this->executeAction($currentState, $firstUserID, $secondUserID, $action) == false) {
                return array(
                    "result" => false,
                    "message" => "database error",
                    "displayMessage" => "something gone wrong"
                );
            }

            // STEP 3: ADD RECORD TO ACTION HISTORY

            if ($this->addRecordToHistory() == false) {
                return array(
                    "result" => true,
                    "message" => "record failed",
                    "displayMessage" => ""
                );
            }

            // MARK: create notification

            return array(
                "result" => true,
                "message" => "success",
                "displayMessage" => "success"
            );
        }
        public function numberOfContacts($userID, $state)
        {
            $numberOfFriends = $this->database->searchDatabase(
                "USERRELATIONS",
                "count(*)",
                "firstUserID='$userID' AND (state='$state')"
            );

            return (int)$numberOfFriends;
        }
        public function contacts($userID, $state, $from = 0, $limit = 20)
        {
            $friends = $this->database->searchDatabase(
                "USERRELATIONS",
                "secondUserID",
                "firstUserID='$userID' AND (state='$state')",
                $limit,
                $from
            );
            return $friends;
        }
    }
}

namespace Utility {
    function swap(&$first, &$second)
    {
        $temp = $first;
        $first = $second;
        $second = $temp;
    }
    // MARK: PAGE SINIFININ KULLANACAĞI FONKSİYONLAR
    function autoLanguage()
    {
        return "tr-TR";
    }
    // MARK: SAYFA OLUŞTURMADA KULLANILACAK FONKSİYONLAR
    function print_name($userID)
    {
        global $page;
        $record = $page->database->searchDatabase("USERDETAILS", "firstname, middlename, surname", "id = '$userID'");
        if ($record === false) return false;
        $return = $record["firstname"];
        if ($record["middlename"] !== "") $return .= " {$record["middlename"]}";
        $return .= " {$record["surname"]}";
        return $return;
    }
    function print_name_fromDbRecord(&$record)
    {
        $return = $record["firstname"];
        if ($record["middlename"] !== "") $return .= " {$record["middlename"]}";
        $return .= " {$record["surname"]}";
        return $return;
    }
    function print_follow($contentOwnerID)
    {
        global $page;

        if ($page->login === false) return false;

        if ($contentOwnerID === $page->user["raw"]["id"]) return false;
    }
    function getURL()
    {
        return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }
    function json($return)
    {
        echo json_encode($return);
        return;
    }
}
