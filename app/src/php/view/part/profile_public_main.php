<?php
$profileLink = "profile.php?id={$page->profile["id"]}";
$profileNameSurname = Utility\print_name_fromDbRecord($page->profile);
?>

<div class='site-width'>
    <div id="bio">

        <div id="profile-photo">
            <a href="<?php echo $profileLink; ?>">
                <img class="profilephoto" src="<?php echo $page->profile["profilephoto_fullpath"]; ?>">
            </a>
        </div>

        <div class="p-container">

            <div id="profile-navigation">
                <a class="p-h1" href="<?php echo $profileLink; ?>"><?php echo $profileNameSurname; ?></a>
            </div>
            <div class="p-p2w"><?php lng(1000); ?></div>

            <?php echo "
      <div id='profile-actions'>
          <a class='text-green' href='signup.php?return=" . urlencode(Utility\getURL()) . "' class='green'><i class='fa fa-arrow-right fa-lg fa-fw' aria-hidden='true'></i>Kayıt ol</a>
          <a href='login.php?return=" . urlencode(Utility\getURL()) . "' class='green'><i class='fa fa-arrow-right fa-lg fa-fw' aria-hidden='true'></i>Giriş yap</a>
          <div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
          <div class='toggle-off' onclick='profile.actions.report()'><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</div>
      </div>";
            ?>

        </div>
    </div>
</div>