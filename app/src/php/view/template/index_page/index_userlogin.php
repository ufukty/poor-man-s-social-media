<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <title><?php lng(1); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <script src="js/kutuphane_3_0.js"></script>
    <script async src="js/common_userlogin.js"></script>

    <link href="css/style_userlogin.php" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">

</head>

<body class='bg-grey'>

    <?php
    require_once("php/view/part/menu_userlogin.php");
    date_default_timezone_set("Europe/Istanbul");
    ?>

    <div class='site-width'>
        <div id='share--container'>
            <div id='share--label'>Yüklemek için buraya bir fotoğraf sürükle veya tıklayarak seç</div>
            <input id='share--input' type='file' accept='image/*' onchange='share.change()'>
        </div>

        <div id='feed--container'>

            <?php
            $arkadaslar = $page->userRelations->contacts($page->user["raw"]["id"], "arkadaslik", 0, 200);
            if ($arkadaslar == false) $arkadaslar = array();
            if (!is_array($arkadaslar)) $arkadaslar = array($arkadaslar);

            $takipedilenler = $page->userRelations->contacts($page->user["raw"]["id"], "kullanicitakipediyor", 0, 200);
            if ($takipedilenler == false) $takipedilenler = array();
            if (!is_array($takipedilenler)) $takipedilenler = array($takipedilenler);

            $result = array_merge($arkadaslar, $takipedilenler, array($page->user["raw"]["id"]));

            $where = "";
            for ($i = 0; $i < count($result); $i++) {
                $where .= "userID = {$result[$i]}";
                if ($i + 1 != count($result)) $where .= " OR ";
            }

            $result = $page->database->searchDatabase("POSTS", "id, userID, photopath, date", $where . " ORDER BY date DESC", 1000);
            if ($result == false) $result = array();
            if (!is_array($result)) $result = array($result);
            if (isset($result["userID"])) $result = array($result);

            for ($i = 0; $i < count($result); $i++) {
                $dateTime = new DateTime($result[$i]["date"], new DateTimeZone('GMT'));
                $dateTime->setTimeZone(new DateTimeZone("Europe/Istanbul"));
                $result[$i]["date"] =  $dateTime->format('H:i:s ― d.m.Y');
                $cred = $page->credentials->userDetails($result[$i]["userID"]);
                $result[$i]["profilephoto_fullpath"] = $cred["profilephoto_fullpath"];
                $result[$i]["firstname"] = $cred["firstname"];
                $result[$i]["surname"] = $cred["surname"];
            }

            // MARK: PRINT POSTS

            for ($i = 0; $i < count($result); $i++) {
                echo "
		<div class='pc-container'>
			<div class='pc-header'>
				<div class='pch-owner-photo'><a href='profile.php?id={$result[$i]["userID"]}'><img src='{$result[$i]["profilephoto_fullpath"]}'></a></div>
				<div class='pch-owner-name'><a href='profile.php?id={$result[$i]["userID"]}'>{$result[$i]["firstname"]}</a> bir fotoğraf paylaştı</div>";
                if ($page->user["raw"]["id"] == $result[$i]["userID"]) echo "<div class='pch-delete' onclick='post.deletePost({$result[$i]["id"]})'><i class='fa fa-trash'></i>Sil</div>";
                else echo "<div></div>";
                echo "
			</div>
			<div class='pc-body'>
				<img src='{$result[$i]["photopath"]}'>
			</div>
			<div class='pc-footer'>
				<div class='pch-time'>{$result[$i]["date"]}</div>
			</div>
		</div>
";
            }
            ?>

        </div>


    </div>

    <?php require_once("php/view/part/footer.php"); ?>
</body>

</html>