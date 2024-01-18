<?php
$profileLink = "profile.php?id={$page->profile["id"]}";
$profileNameSurname = Utility\print_name($page->profile["id"]);
?>

<div class='site-width'>
    <div id="bio" class="profile-page">

        <div id="profile-photo">
            <a href="<?php echo $profileLink; ?>">
                <img class="profilephoto" src="<?php echo $page->profile["profilephoto_fullpath"]; ?>">
            </a>
        </div>

        <div class="p-container">

            <div id="profile-navigation">
                <a class="p-h1" href="<?php echo $profileLink; ?>"><?php echo $profileNameSurname; ?></a>
            </div>
            <div class="p-p2w">Bu senin profilin.</div>
            <div class="p-p2w">Arkadaşların ve takip izni verdiğin diğer kullanıcılar profilindeki gönderilerini görebilir.</div>

            <div id='profile-stats'>
                <a id='begeniler' href='<?php echo 'login.php?return=' . urlencode(Utility\getURL()); ?>' class='text-red'>
                    <i class='fa fa-heart' aria-hidden='true'></i>
                    <span>
                        <div class='title'>Beğeni</div>
                        <div class='number'>0</div>
                    </span>
                </a>
                <a id='goruntulemeler' href='#' class='text-yellow'>
                    <i class='fa fa-eye' aria-hidden='true'></i>
                    <span>
                        <div class='title'>Görüntülenme</div>
                        <div class='number'>0</div>
                    </span>
                </a>
                <a id='arkadaslar' href='<?php echo "$profileLink&view=friends"; ?>' class='text-blue'>
                    <i class='fa fa-users' aria-hidden='true'></i>
                    <span>
                        <div class='title'>Arkadaş</div>
                        <div class='number'><?php echo $page->userRelations->numberOfContacts($page->user["raw"]["id"], "arkadaslik"); ?></div>
                    </span>
                </a>
                <a id='paylasimlar' href='<?php echo "$profileLink&view=likes"; ?>' class='text-green'>
                    <i class='fa fa-picture-o' aria-hidden='true'></i>
                    <span>
                        <div class='title'>Paylaşım</div>
                        <div class='number'>0</div>
                    </span>
                </a>
            </div>

            <div id='profile-actions'>
                <a class='text-blue' href='<?php echo "$profileLink&view=friends"; ?>'><i class='fa fa-users fa-lg fa-fw' aria-hidden='true'></i>Kişiler</a>
                <a class='text-red' href='<?php echo "$profileLink&view=likes"; ?>'><i class='fa fa-heart fa-lg fa-fw' aria-hidden='true'></i>Beğeniler</a>
                <div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
                <div class='toggle-off' onclick='profile.actions.undoRequest()'><i class='fa fa-camera fa-lg fa-fw' aria-hidden='true'></i>Profil fotoğrafını düzenle</div>
                <div class='toggle-off' onclick='go(' login.php');'><i class='fa fa-cog fa-lg fa-fw' aria-hidden='true'></i>Hesap ayarları</div>
                <div class='toggle-off' onclick='logout();'><i class='fa fa-sign-out fa-lg fa-fw' aria-hidden='true'></i>Çıkış yap</div>
            </div>

        </div>

    </div>
</div>