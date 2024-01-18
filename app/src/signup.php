<?php
require_once("php/class/page.class.php");
$page = new Page\Page();
if ($page->login) {
    header("location: index.php");
} else {
    require_once("php/view/template/signup_page/signup_public.php");
}
