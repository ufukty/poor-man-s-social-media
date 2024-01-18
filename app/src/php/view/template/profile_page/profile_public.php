<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title><?php lng(353); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <script src="js/kutuphane_3_0.js"></script>
    <script async src="js/common_public.js"></script>
    <script async src="js/profile.js"></script>

    <link href="css/style_public.php" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">

</head>

<body class="bg-grey">

    <?php
    require_once("php/view/part/menu_public.php");

    require_once("php/view/part/profile_public_main.php");

    require_once("php/view/part/footer.php");
    ?>

</body>

</html>