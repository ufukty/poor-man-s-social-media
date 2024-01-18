<?php

/*
  Örnek çağrılış:
    authentication.php?action=login
    id = xxx
    password = xxx

*/

header('Content-Type: application/json');

require_once("../php/class/page.class.php");
$page = new Page\Page();

if (!isset($_GET["action"])) {
    Utility\json(array("action" => "undefined", "response" => "bad request"));
    exit();
}

$action = $_GET["action"];

if ($action != "login" && $action != "signup" && $action != "logout")
    return Utility\json(array("action" => "undefined", "response" => "bad request"));

if ($action == "login") {
    if ($page->login === true) {
        return Utility\json(array("action" => "login", "response" => "already logged in"));
    }

    if (
        !isset($_POST["id"]) ||
        !isset($_POST["password"])
    )
        return Utility\json(array("action" => "login", "response" => "bad request"));

    $attempt = $page->authentication->login($_POST["id"], $_POST["password"]);

    if ($attempt["status"] == false) {
        switch ($attempt["number"]) {
            case 2000:
                return Utility\json(array("action" => "login", "response" => "already logged in"));
            case 2001:
                return Utility\json(array("action" => "login", "response" => "bad request"));
            case 2002:
            case 2005:
                // Hesap yok
            case 2003:
                // Şifre yanlış
                return Utility\json(array("action" => "login", "response" => "incorrect"));
            case 2006:
            default:
                return Utility\json(array("action" => "login", "response" => "internal server error"));
        }
    }

    return Utility\json(array("action" => "login", "response" => "success"));
}

if ($action == "logout") {
    if ($page->login == null) return Utility\json(array("action" => "logout", "response" => "already logged out"));
    if ($page->authentication->logout()["status"] === false) return Utility\json(array("action" => "logout", "response" => "error"));
    return Utility\json(array("action" => "logout", "response" => "success"));
}

if ($action == "signup") {
    if ($page->login === true) {
        return Utility\json(array("action" => "signup", "response" => "already logged in"));
    }

    if (
        !isset($_POST["username"]) ||
        !isset($_POST["email"]) ||
        !isset($_POST["password"]) ||
        !isset($_POST["name"]) ||
        !isset($_POST["surname"])
    )
        return Utility\json(array("action" => "signup", "response" => "bad request"));

    $attempt = $page->authentication->register($_POST["username"], $_POST["email"], $_POST["password"], $_POST["name"], $_POST["surname"]);

    if ($attempt["status"] == false) {
        switch ($attempt["number"]) {
            case 2000:
                return Utility\json(array("action" => "signup", "response" => "already logged in"));
            case 2001:
                return Utility\json(array("action" => "signup", "response" => "bad request"));
            case 2002:
            case 2005:
                // Hesap yok
            case 2003:
                // Şifre yanlış
                return Utility\json(array("action" => "signup", "response" => "incorrect"));
            case 13000:
                // Şifre yanlış
                return Utility\json(array("action" => "signup", "response" => "email-registered"));
            case 13001:
                // Şifre yanlış
                return Utility\json(array("action" => "signup", "response" => "username-taken"));
            case 2006:
            default:
                return Utility\json(array("action" => "signup", "response" => "internal server error"));
        }
    }

    return Utility\json(array("action" => "signup", "response" => "success"));
}

return Utility\json(array("action" => "undefined", "response" => "undefined"));
