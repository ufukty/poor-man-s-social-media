<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title><?php lng(352); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <script src="js/kutuphane_3_0.js"></script>
    <script async src="js/common_userlogin.js"></script>

    <link href="css/style_userlogin.php" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

    <?php require_once("php/view/part/menu_userlogin.php"); ?>

    <div class='site-width'>
        <div id="site-message">

            <div><i class="fa fa-user" aria-hidden="true"></i></div>
            <div>
                <p><?php echo lng(250); ?></p>
            </div>
            <div>
                <div class="button-l-color" onclick="logout()"><?php echo lng(251); ?></div>
            </div>

        </div>
    </div>

    <?php require_once("php/view/part/footer.php"); ?>

</body>

</html>