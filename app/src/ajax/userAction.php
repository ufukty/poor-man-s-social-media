<?php
/*
  Örnek çağrılma:
    userAction.php?action=XXX&targetID=YYY

    XXX:
      follow,
      unfollow,
      confirm,
      deny,
      return,
      block,
      unblock
    YYY:
      [int]
*/

namespace {
    class starter
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

            switch ($_GET["action"]) {
                case "follow":
                    $event = "istekyollama";
                    break;
                case "unfollow":
                    $event = "takibibirakma";
                    break;
                case "confirm":
                    $event = "onaylama";
                    break;
                case "deny":
                    $event = "reddetme";
                    break;
                case "return":
                    $event = "istegigerialma";
                    break;
                case "undoapproval":
                    $event = "onayıgerialma";
                    break;
                case "block":
                    $event = "engelleme";
                    break;
                case "unblock":
                    $event = "engelikaldirma";
                    break;
                default:
                    $this->response("bad request");
            }

            $result = $this->page->userRelations->acceptNewRequestFromUser(
                $this->page->user["raw"]["id"],
                $_GET["targetID"],
                $event
            )["result"];

            if ($result == true) $this->response("success", $event);
            else $this->response("something gone wrong", $event);
        }

        public function isRequestValid()
        {
            if (isset($_GET["action"]) && isset($_GET["targetID"])) return true;
            else return false;
        }
        public function response($status, $event = false)
        {
            header('Content-Type: application/json');
            $response["status"] = $status;
            $response["event"] = $event;
            Utility\json($response);
            exit();
        }
    }

    $start = new starter();
}
