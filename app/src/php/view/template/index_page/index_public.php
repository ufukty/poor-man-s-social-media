<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title><?php lng(351); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <script src="js/kutuphane_3_0.js"></script>
    <script async src="js/common_public.js"></script>

    <link href="css/style_public.php" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>

    <?php require_once("php/view/part/menu_public.php"); ?>

    <div class='site-width'>
        <div id="index">

            <div id="welcome">

                <div class="firstrow">

                    <img class="photo" style="--idx:0" srcset="img/homepage/tugWSzRwh9wbor4joED56xaHFd05ZGE3.jpg 3x">
                    <img class="photo" style="--idx:2" srcset="img/homepage/tJUSGFZgWwn6g3qaXDMtZJoW3rBzTTIb.jpg 3x">
                    <img class="photo" style="--idx:1" srcset="img/homepage/v6pGtoVtenw2zerYtJkb6lsQ5w06Hz3h.jpg 3x">
                    <img class="photo" style="--idx:3" srcset="img/homepage/KLqOOHvj7ccCWm1dWHtMBA9cRdGJ09YX.jpg 3x">
                    <img class="photo" style="--idx:4" srcset="img/homepage/cOxNEad4XOpO4ObgZJYrgqTqH8i0U9DL.jpg 3x">

                </div>

            </div>

            <div class="secondrow">
                <h1><?php echo lng(100); ?></h1>
            </div>
        </div>
    </div>

    <?php require_once("php/view/part/footer.php"); ?>
</body>

</html>