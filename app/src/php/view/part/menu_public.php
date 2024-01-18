<div id="menu" class="public">
    <div class='site-width'>
        <div id="standartmenu" class="active">
            <div class="left">
                <a id="menu_logo" href="index.php"><?php lng(1); ?></a>
            </div>


            <div class="right">
                <!--<?php if (!isset($hidelogin)) {
                        echo '<div id="menu_login" onclick="menu(\'loginmenu\');">';
                        lng(2);
                        echo "</div>";
                    } ?>-->
                <a id="menu_login" class="link-m" href="login.php?return=<?php echo urlencode(Utility\getURL()); ?>"><?php lng(2); ?></a>
                <a id="menu_signup" class="button-m-color" href="signup.php?return=<?php echo urlencode(Utility\getURL()); ?>"><?php lng(3); ?></a>
            </div>
        </div>
    </div>
</div>