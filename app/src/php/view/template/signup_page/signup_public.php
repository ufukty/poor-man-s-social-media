<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <title><?php lng(350); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <script src="js/kutuphane_3_0.js"></script>
    <script async src="js/common_public.js"></script>

    <link href="css/style_public.php" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

    <?php $hidesignup = true; ?>
    <?php require_once("php/view/part/menu_public.php"); ?>

    <div class='site-width'>
        <div id="load-message">
            <div class="one toggle-off">
                <p><?php lng(274); ?></p>
            </div>
            <div class="two toggle-off">
                <p><?php lng("email-already-registered"); ?></p><a href="login.php" class="link-m-line-color"><?php lng("email-already-registered-login"); ?></a>
            </div>
            <div class="three toggle-off">
                <p><?php lng(276); ?></p>
            </div>
            <div class="four toggle-off">
                <p><?php lng("username-already-taken"); ?></p><a href="login.php" class="link-m-line-color"><?php lng("email-already-registered-login"); ?></a>
            </div>
        </div>

        <div id="signup">
            <div id="name" class="firstrow">
                <input class="input-m-title" type="text" placeholder="<?php lng(8); ?>" onkeypress="signup.submit.click(event, 'name')" onblur="signup.name.onblur();" onfocus="signup.name.onfocus();" autocapitalize="none">
            </div>

            <div id="surname" class="firstrow">
                <input class="input-m-title" type="text" placeholder="<?php lng(9); ?>" onkeypress="signup.submit.click(event, 'surname')" onblur="signup.surname.onblur();" onfocus="signup.surname.onfocus();" autocapitalize="none">
            </div>

            <div id="email" class="firstrow">
                <input class="input-m-title" type="text" placeholder="<?php lng(11); ?>" onkeypress="signup.submit.click(event, 'email')" onblur="signup.email.onblur();" onfocus="signup.email.onfocus();" autocapitalize="none">
            </div>

            <div id="username" class="firstrow">
                <input class="input-m-title" type="text" placeholder="<?php lng(10); ?>" onkeypress="signup.submit.click(event, 'username')" onblur="signup.username.onblur();" onfocus="signup.username.onfocus();" autocapitalize="none">
            </div>

            <div id="password" class="secondrow">
                <input class="input-m-title" type="password" placeholder="<?php lng(7); ?>" onkeypress="signup.submit.click(event, 'password')" onblur="signup.password.onblur()" onfocus="signup.password.onfocus()" autocapitalize="none">
            </div>

            <div class="thirdrow">
                <span></span>
                <div class="button-l-color" onclick="signup.submit.click(null, 'submit')"><?php lng(2); ?></div>
            </div>
        </div>
    </div>

    <?php require_once("php/view/part/footer.php"); ?>

    <script>
        var messages = {
            un: <?php lng(272); ?>,
            pw: <?php lng(273); ?>,
            na: <?php lng(4000); ?>,
            sr: <?php lng(4000); ?>
        };
        var returnURL = <?php if (isset($_GET["return"])) echo "\"" . urldecode($_GET["return"]) . "\"";
                        else echo "undefined"; ?>;
    </script>

</body>

</html>