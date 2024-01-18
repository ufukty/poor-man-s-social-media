<?php
require_once("php/class/page.class.php");
$page = new Page\Page();
if ($page->login) {
    require_once("php/view/template/login_page/login_userlogin.php");
} else {
    require_once("php/view/template/login_page/login_public.php");
}
