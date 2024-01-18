<?php
$profileLink = "profile.php?id={$page->profile["id"]}";
$profileNameSurname = Utility\print_name($page->profile["id"]);
?>

<div class='site-width'>
    <div id="bio" class="contacts-page">

        <div id="profile-photo">
            <a href="<?php echo $profileLink; ?>">
                <img class="profilephoto" src="<?php echo $page->profile["profilephoto_fullpath"]; ?>">
            </a>
        </div>

        <div class="p-container">

            <div id="profile-navigation">
                <a class="p-h1" href="<?php echo $profileLink; ?>"><?php echo $profileNameSurname; ?></a>
                <a class="p-h3" href="<?php echo "$profileLink&view=friends"; ?>">Kişiler</a>
            </div>

        </div>

        <div id="contact-menu-hide-scrollbar">
            <div id="contact-menu">
                <div id="contact-menu-container">
                    <a href="<?php echo "$profileLink&view=friends"; ?>">
                        <i class="fa fa-users"></i>
                        <div>Arkadaşlar</div>
                    </a>
                    <a href="<?php echo "$profileLink&view=following"; ?>">
                        <i class="fa fa-user-plus"></i>
                        <div>Takip edilenler</div>
                    </a>
                    <a href="<?php echo "$profileLink&view=followers"; ?>">
                        <i class="fa fa-user-plus"></i>
                        <div>Takipçiler</div>
                    </a>
                    <a href="<?php echo "$profileLink&view=requests"; ?>">
                        <i class="fa fa-user"></i>
                        <div>Gelen istekler</div>
                    </a>
                    <a href="<?php echo "$profileLink&view=awaiting"; ?>">
                        <i class="fa fa-clock-o"></i>
                        <div>Beklenenler</div>
                    </a>
                    <a href="<?php echo "$profileLink&view=blocked"; ?>" class="active">
                        <i class="fa fa-user-times"></i>
                        <div>Engelliler</div>
                    </a>
                </div>
            </div>
        </div>

        <div class="p-container">
            <div class="p-h2">Engelli</div>
            <div class="p-p3w">Engellediğin kullanıcılar gönderilerini göremez ve sana takip isteği yollayamaz.</div>
        </div>

        <div id="profile-contacts" class="p-container">
            <div id="error" class="cl-message toggle-off">
                <div class="p-h3">Bir hata oluştu</div>
                <div class="p-p3">Sayfayı yenileyebilir yada daha sonra tekrar deneyebilirsin.</div>
            </div>
            <div id="no-contacts" class="cl-message toggle-off">
                <div class="p-h3">Henüz engellediğin kimse yok</div>
                <div class="p-p3 link-m-color">Birini engellemek için profiline git ve diğer seçenekleri gör</div>
            </div>

            <div id="contacts-list">
            </div>
        </div>
    </div>
</div>
<script>
    var contactListMode = "blocked";
</script>