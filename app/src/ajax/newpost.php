<?php
header('Content-Type: application/json');

if (isset($_FILES["image"]) == false || empty($_FILES["image"])) {
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

$filename = hash("sha256", $_FILES["image"]["name"] . time()) . ".jpg";
$relativePath = "store/posts/" . $filename;
$dst = "../" . $relativePath;
move_uploaded_file($_FILES["image"]["tmp_name"], $dst);

if (file_exists($dst) == false) {
    echo json_encode(array(
        "status" => false,
        "code" => "100x" . __LINE__
    ));
    exit();
}

$result = $page->database->addRecord("POSTS", array(
    "userID", "'{$page->user["raw"]["id"]}'",
    "photopath", "'$relativePath'"
));

if ($result == false) {
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
