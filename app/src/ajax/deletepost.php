<?php
header('Content-Type: application/json');

if (isset($_POST["postID"]) == false || empty($_POST["postID"])) {
    echo json_encode(array(
        "status" => false,
        "code" => "100x" . __LINE__
    ));
    exit();
}

require_once("../php/class/page.class.php");
$page = new Page\Page();

if ($page->login == false) {
    echo json_encode(array(
        "status" => false,
        "code" => "100x" . __LINE__
    ));
    exit();
}

$post = $page->database->searchDatabase("POSTS", "userID", "id = {$_POST["postID"]}");

if ($post == false) {
    echo json_encode(array(
        "status" => false,
        "code" => "100x" . __LINE__
    ));
    exit();
}

if ($post != $page->user["raw"]["id"]) {
    echo json_encode(array(
        "status" => false,
        "code" => "100x" . __LINE__
    ));
    exit();
}

$page->database->connection->query("DELETE FROM `POSTS` WHERE `id` = {$_POST["postID"]}");

if ($page == false) {
    echo json_encode(array(
        "status" => false,
        "code" => "100x" . __LINE__
    ));
    exit();
}

echo json_encode(array(
    "status" => true,
    "code" => "0"
));
