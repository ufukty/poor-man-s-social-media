<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title><?php lng(352); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <script src="js/kutuphane_3_0.js"></script>
    <script async src="js/common_public.js"></script>

    <link href="css/style_public.php" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

    <?php $hidelogin = true; ?>
    <?php require_once("php/view/part/menu_public.php"); ?>

    <div class='site-width'>
        <div id="load-message">
            <div class="one toggle-off">
                <p><?php lng(274); ?></p>
            </div>
            <div class="two toggle-off">
                <p><?php lng(275); ?></p><a href="forgot.php" class="link-m-line-color"><?php lng(270); ?></a>
            </div>
            <div class="one toggle-off">
                <p><?php lng(276); ?></p>
            </div>
        </div>

        <!-- <div id="load-message" class="toggle-off">
		<div><div><ul class="load"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul></div></div>
		<p><?php lng(274); ?></p>
	</div> -->

        <div id="login">
            <div id="username" class="firstrow">
                <input class="input-m-title" type="text" placeholder="<?php lng(6); ?>" onkeypress="login.submit.click(event, 'username')" onblur="login.username.onblur();" onfocus="login.username.onfocus();" autocapitalize="none">
            </div>

            <div id="password" class="secondrow">
                <input class="input-m-title" type="password" placeholder="<?php lng(7); ?>" onkeypress="login.submit.click(event, 'password')" onblur="login.password.onblur()" onfocus="login.password.onfocus()" autocapitalize="none">
            </div>

            <div class="thirdrow">
                <a class="link-m-line-grey" href="forgot.php"><?php lng(270); ?></a>
                <div class="button-l-color" onclick="login.submit.click(null, 'submit')"><?php lng(2); ?></div>
            </div>
        </div>
    </div>

    <?php require_once("php/view/part/footer.php"); ?>

    <script>
        var messages = {
            un: <?php lng(272); ?>,
            pw: <?php lng(273); ?>
        };
        var returnURL = <?php if (isset($_GET["return"])) echo "\"" . urldecode($_GET["return"]) . "\"";
                        else echo "undefined"; ?>;
    </script>

</body>

</html>