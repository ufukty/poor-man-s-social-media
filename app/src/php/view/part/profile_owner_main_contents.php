<div class='site-width'>
    <div id='post--container'>

        <?php

        $result = $page->database->searchDatabase("POSTS", "id, userID, photopath, date", "userID = {$page->user["raw"]["id"]} ORDER BY date DESC", 1000);
        if ($result == false) $result = array();
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

        ######################### PRINT POSTS

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