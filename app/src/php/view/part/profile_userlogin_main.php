<?php
$currentState = $page->userRelations->currentState(
    $page->user["raw"]["id"],
    $page->profile["id"]
);
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

            <?php
            switch ($currentState) {
                case "baslangic":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]}'nın paylaşımlarını görmek için onu takip etmelisin.
		</div>
		<div id='profile-actions'>
			<div onclick='profile.actions.action(\"follow\")' class='text-green'><i class='fa fa-paper-plane fa-lg fa-fw' aria-hidden='true'></i>Takip isteği gönder</div>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<div class='toggle-off' onclick='profile.actions.action(\"block\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engelle</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;

                case "istegecevapbekleniyor":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]} senin takip isteğine cevap verecek.
		</div>
		<div id='profile-actions'>
			<div onclick='profile.actions.action(\"return\")' class='text-red'><i class='fa fa-reply fa-lg fa-fw' aria-hidden='true'></i>Takip isteğini geri al</div>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<div class='toggle-off' onclick='profile.actions.action(\"block\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engelle</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;

                case "istegecevapverilecek":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]} seni takip etmek istiyor.
		</div>
		<div id='profile-actions'>
			<div onclick='profile.actions.action(\"confirm\")' class='text-green'><i class='fa fa-check fa-lg fa-fw' aria-hidden='true'></i>Onayla</div>
			<div onclick='profile.actions.action(\"deny\")' class='text-red'><i class='fa fa-times fa-lg fa-fw' aria-hidden='true'></i>Reddet</div>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<div class='toggle-off' onclick='profile.actions.action(\"block\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engelle</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;

                case "kullanicitakipediyor":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]}'yı takip ediyorsun ve onun paylaşımlarını beğenebilirsin.
		</div>
		<div id='profile-actions'>
			<a class='text-red' href='profile.php?id={$page->profile["id"]}&view=likes'><i class='fa fa-heart fa-lg fa-fw' aria-hidden='true'></i>Beğeniler</a>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<div class='toggle-off' onclick='profile.actions.action(\"unfollow\")'><i class='fa fa-reply fa-lg fa-fw' aria-hidden='true'></i>Takibi bırak</div>
			<div class='toggle-off' onclick='profile.actions.action(\"block\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engelle</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;

                case "karsitaraftakipediyor":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]} seni takip ediyor ve senin paylaşımlarını beğenebilir.
		</div>
		<div id='profile-actions'>
			<div class='text-green' onclick='profile.actions.action(\"follow\")'><i class='fa fa-users fa-lg fa-fw' aria-hidden='true'></i>Takip et ve arkadaş ol</div>
			<a class='text-red' href='profile.php?id={$page->profile["id"]}&view=likes'><i class='fa fa-heart fa-lg fa-fw' aria-hidden='true'></i>Beğeniler</a>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<div class='toggle-off' onclick='profile.actions.action(\"undoapproval\")'><i class='fa fa-reply fa-lg fa-fw' aria-hidden='true'></i>Takip onayını geri al</div>
			<div class='toggle-off' onclick='profile.actions.action(\"block\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engelle</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;

                case "arkadaslik":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]} ile arkadaşsın; paylaşımlarını beğenebilir ve onunla mesajlaşabilirsin.
		</div>
		<div id='profile-actions'>
			<a class='text-blue' href='messages.php'><i class='fa fa-comments fa-lg fa-fw' aria-hidden='true'></i>Mesaj gönder</a>
			<a class='text-red' href='profile.php?id={$page->profile["id"]}&view=likes'><i class='fa fa-heart fa-lg fa-fw' aria-hidden='true'></i>Beğeniler</a>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<div class='toggle-off' onclick='profile.actions.action(\"unfollow\")'><i class='fa fa-times fa-lg fa-fw' aria-hidden='true'></i>Takibi bırak</div>
			<div class='toggle-off' onclick='profile.actions.action(\"undoapproval\")'><i class='fa fa-times fa-lg fa-fw' aria-hidden='true'></i>Takip onayını geri al</div>
			<div class='toggle-off' onclick='profile.actions.action(\"block\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engelle</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;

                case "kullaniciengelli":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]} seni engelledi.
		</div>
		<div id='profile-actions'>
			<div onclick='profile.actions.action(\"block\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engelle</div>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;

                case "karsitarafengelli":
                case "karsilikliengel":
                    echo "
		<div class='p-p2w'>
			{$page->profile["firstname"]}'yi engelledin.
		</div>
		<div id='profile-actions'>
			<div onclick='profile.actions.action(\"unblock\")'><i class='fa fa-ban fa-lg fa-fw' aria-hidden='true'></i>Engeli kaldır</div>
			<div class='other-actions toggle-on' onclick='profile.actions.othersToggle()'><i class='fa fa-chevron-down fa-lg fa-fw' aria-hidden='true'></i>Diğer eylemler</div>
			<a href='report.php?type=account&id={$page->profile["id"]}' class='toggle-off' ><i class='fa fa-exclamation fa-lg fa-fw' aria-hidden='true'></i>Sorun bildir</a>
		</div>";
                    break;
            }
            ?>

        </div>


    </div>
</div>