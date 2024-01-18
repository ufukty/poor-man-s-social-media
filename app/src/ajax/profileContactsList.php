<?php
/*
  Örnek çağrılma:
    profileContactsList.php?list=friend&from=XXX

*/

namespace {
    class profileContactsList
    {
        private $page;

        function __construct()
        {
            require_once("../php/class/page.class.php");
            $this->page = new Page\Page();
            $this->start();
        }

        public function start()
        {
            if ($this->page->login == false)        $this->response("not authenticated");
            if ($this->isRequestValid() == false)   $this->response("bad request");

            $this->getContacts();
        }
        public function getContacts()
        {
            switch ($_GET["listType"]) {
                case "friend":
                    $mode = "arkadaslik";
                    break;
                case "follower":
                    $mode = "karsitaraftakipediyor";
                    break;
                case "following":
                    $mode = "kullanicitakipediyor";
                    break;
                case "requests":
                    $mode = "istegecevapverilecek";
                    break;
                case "awaiting":
                    $mode = "istegecevapbekleniyor";
                    break;
                case "blocked":
                    $mode = "karsitarafengelli' OR state='karsilikliengel";
                    break;
                default:
                    $this->response("interface error");
                    return;
            }

            $numberOfContacts = $this->page->userRelations->numberOfContacts(
                $this->page->user["raw"]["id"],
                $mode
            );

            if ($numberOfContacts == false && gettype($numberOfContacts) == "boolean")
                $this->response("bad request");
            if ($numberOfContacts == "0")
                $this->response("no friend");
            if ($numberOfContacts <= $_GET["from"])
                $this->response("no more friend");

            $contacts = $this->page->userRelations->contacts(
                $this->page->user["raw"]["id"],
                $mode,
                $_GET["from"],
                20
            );

            if ($contacts == false)  $this->response("internal server error");
            if (!is_array($contacts)) $contacts = array($contacts);
            $countContacts = count($contacts);

            for ($i = 0; $i < $countContacts; $i++) {
                $record = $this->page->database->searchDatabase(
                    "USERDETAILS",
                    "firstname, middlename, surname, profilephoto_fullpath",
                    "id='" . $contacts[$i] . "'"
                );
                $contactsArray[$i]["friendID"] = $contacts[$i];
                $contactsArray[$i]["fullname"] = Utility\print_name_fromDbRecord($record);
                $contactsArray[$i]["photo"] = $record["profilephoto_fullpath"];
                if ($contactsArray[$i]["photo"] == NULL) $contactsArray[$i]["photo"] = "img/def.png";
            }

            $this->response("success", $contactsArray, $numberOfContacts);
        }

        public function isRequestValid()
        {
            if (isset($_GET["listType"]) && isset($_GET["from"])) return true;
            else return false;
        }
        public function response($status, $list = false, $totalNumber = false)
        {
            header('Content-Type: application/json');
            $response["status"] = $status;
            $response["list"] = $list;
            $response["totalNumber"] = $totalNumber;
            Utility\json($response);
            exit();
        }
    }

    $list = new profileContactsList();
}
