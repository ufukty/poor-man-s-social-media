<?php
if ($page->login) {
    require_once("php/view/part/menu_userlogin.php");
} else {
    require_once("php/view/part/menu_public.php");
}
