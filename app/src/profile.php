<?php
require_once("php/class/page.class.php");
$page = new Page\Page();
$profileExists = $page->defineProfile()["status"];
if ($page->login == true && $profileExists == true) {
    require_once("php/view/template/profile_page/profile_userlogin.php");
} else if ($page->login == true && $profileExists == false) {
    $notfoundcode = 0;
    require_once("php/view/template/notfound_page/notfound_userlogin.php");
} else if ($page->login == false && $profileExists == true) {
    require_once("php/view/template/profile_page/profile_public.php");
} else if ($page->login == false && $profileExists == false) {
    $notfoundcode = 1;
    require_once("php/view/template/notfound_page/notfound_public.php");
}
