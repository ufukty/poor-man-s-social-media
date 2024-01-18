<?php
function str_split_unicode($str, $l = 0)
{
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function lng($e, $arg = NULL)
{
    global $page;

    switch ($e) {

            // menu without auth
        case 1:
            echo "sosyalağ";
            break;
        case 2:
            echo "Login";
            break;
        case 3:
            echo "Signup";
            break;
        case 4:
            echo "Back";
            break;
        case 5:
            echo "Search a person, a page or an event.";
            break;
        case 6:
            echo "Username or e-mail";
            break;
        case 8:
            echo "Name";
            break;
        case 9:
            echo "Surname";
            break;
        case 10:
            echo "Username";
            break;
        case 11:
            echo "E-mail";
            break;
        case 7:
            echo "Password";
            break;


            // index without auth
        case 100:
            echo "sosyalag helps you to meet new people and share moments in your life.";
            break;


            // login with auth
        case 250:
            echo "Already logged in as <b>" . \Utility\print_name_fromDbRecord($page->user["raw"]) . "</b>.";
            break;
        case 251:
            echo "Signout";
            break;

            // login without auth
        case 270:
            echo "Forget password";
            break;
        case 271:
            echo "Signout and login again";
            break;
        case 272:
            echo '["", "REQUIRED", "USERNAME MUST BE AT LEAST 6 CHARACTERS LONG", "USERNAME CAN BE MAXIMUM 20 CHARACTERS LONG", "E-MAIL MUST BE AT LEAST 10 CHARACTERS LONG", "E-MAIL ADDRESS CAN BE MAXIMUM 60 CHARACTERS LONG", "INVALID CHARACTER: ", "TYPE VALID E-MAIL ADDRESS"]';
            break;
        case 273:
            echo '["", "REQUIRED", "PASSWORD MUST BE AT LEAST 8 CHARACTERS LONG", "USERNAME MUST BE CONTAINS AT LEAST 1 UPPER, 1 LOWER CHARACTER AND 1 NUMBER"]';
            break;
        case 274:
            echo "Checking...";
            break;
        case 275:
            echo "Password didn't match.";
            break;
        case 276:
            echo "Success";
            break;
        case 277:
            echo "";
            break;

            // signup.php
        case "email-already-registered":
            echo "This e-mail adress already registered.";
            break;
        case "email-already-registered-login":
            echo "Login.";
            break;
        case "username-already-taken":
            echo "This username already taken.";
            break;
        case 4000:
            echo '["", "REQUIERED", "INVALID CHARACTER: "]';
            break;


            // page titles
        case 350:
            echo "sosyalağ - Signup";
            break;
        case 351:
            echo "sosyalağ - Welcome";
            break;
        case 352:
            echo "sosyalağ - Login";
            break;
        case 353:
            echo "sosyalağ - {$page->profile["firstname"]} {$page->profile["surname"]}'s profile";
            break;
        case 354:
            echo "sosyalağ - Not found";
            break;
        case 355:
            echo "sosyalağ - Welcome";
            break;
        case 356:
            echo "sosyalağ - Welcome";
            break;



            // profile without auth
        case 1000:
            echo "Signup to follow and get in touch to {$page->profile["firstname"]}.";
            break;
        case 1001:
            echo "";
            break;
        case 1002:
            echo "";
            break;
        case 1003:
            echo "";
            break;
        case 1004:
            echo "";
            break;



            // notfound (notfoundcode + 2000)
        case 1999:
            echo "Home";
            break;
        case 2000:
            echo "<p>This profile unavailable.</p><p>Check page address and try it again.</p>";
            break;
        case 2001:
            echo "<p>This profile unavailable.</p><p>Check page address and try it again.</p>";
            break;
        case 2002:
            echo "";
            break;



            // profile with auth
        case 3000:
            echo "Edit profile";
            break;
        case 3001:
            echo "Following";
            break;
        case 3002:
            echo "Change photos";
            break;
        case 3003:
            echo "Follow";
            break;
        case 3004:
            echo "Follows";
            break;
        case 3005:
            echo "Blocked";
            break;
        case 3006:
            echo "You're blocked";
            break;
        case 3007:
            echo "Friend";
            break;
        case 3008:
            echo "Waiting.";
            break;

        default:
            echo "<b>ERROR lng($e) call is invalid.</b>";
    }
}
