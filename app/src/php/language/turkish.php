<?php
function str_split_unicode($str, $l = 0)
{
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function lng($e, $arg = NULL)
{
    global $page;

    switch ($e) {

            // menu without auth
        case 1:
            echo "sosyalağ";
            break;
        case 2:
            echo "Giriş yap";
            break;
        case 3:
            echo "Kayıt ol";
            break;
        case 4:
            echo "Geri";
            break;
        case 5:
            echo "Bir kişiyi, sayfayı veya etkinliği arayın.";
            break;
        case 6:
            echo "Kullanıcı adı veya e-posta";
            break;
        case 8:
            echo "Ad";
            break;
        case 9:
            echo "Soyad";
            break;
        case 10:
            echo "Kullanıcı adı";
            break;
        case 11:
            echo "Eposta";
            break;
        case 7:
            echo "Şifre";
            break;


            // index without auth
        case 100:
            echo "sosyalağ yeni insanlarla tanışmanı ve hayatında olanları paylaşmanı sağlar";
            break;


            // login with auth
        case 250:
            echo "Zaten <b>" . \Utility\print_name_fromDbRecord($page->user["raw"]) . "</b> olarak giriş yaptın";
            break;
        case 251:
            echo "Çıkış yap";
            break;

            // login without auth
        case 270:
            echo "Şifremi unuttum";
            break;
        case 271:
            echo "Çıkış yap ve tekrar gir";
            break;
        case 272:
            echo '["", "BU ALANI BOŞ BIRAKAMAZSIN", "KULLANICI ADIN EN AZ 6 KARAKTER OLMALI", "KULLANICI ADIN EN FAZLA 20 KARAKTER OLABİLİR", "EPOSTA ADRESİN EN AZ 10 KARAKTER OLMALI", "EPOSTA ADRESİN EN FAZLA 60 KARAKTER OLABİLİR", "BU KARAKTERİ BU ALANDA KULLANAMAZSIN ", "GEÇERLİ BİR E-POSTA ADRESİ GİR"]';
            break;
        case 273:
            echo '["", "BU ALANI BOŞ BIRAKAMAZSIN", "ŞİFREN EN AZ 8 KARAKTER OLMALI", "ŞİFREN EN AZ 1 BÜYÜK HARF, 1 KÜÇÜK HARF VE RAKAM İÇERMELİ"]';
            break;
        case 274:
            echo "Kontrol ediliyor";
            break;
        case 275:
            echo "Kullanıcı adı veya şifre yanlış";
            break;
        case 276:
            echo "Başarılı";
            break;
        case 277:
            echo "";
            break;

            // signup.php
        case "email-already-registered":
            echo "Bu eposta adresi zaten kayıtlı.";
            break;
        case "email-already-registered-login":
            echo "Giriş yap.";
            break;
        case "username-already-taken":
            echo "Bu kullanıcı adı daha önce alınmış.";
            break;
        case 4000:
            echo '["", "BU ALANI BOŞ BIRAKAMAZSIN", "BU KARAKTERİ BU ALANDA KULLANAMAZSIN "]';
            break;


            // page titles
        case 350:
            echo "sosyalağ - Kayıt ol";
            break;
        case 351:
            echo "sosyalağ - Hoşgeldin";
            break;
        case 352:
            echo "sosyalağ - Giriş yap";
            break;
        case 353:
            echo "sosyalağ - {$page->profile["firstname"]} {$page->profile["surname"]} profili";
            break;
        case 354:
            echo "sosyalağ - Bulunamadı";
            break;
        case 355:
            echo "sosyalağ - Welcome";
            break;
        case 356:
            echo "sosyalağ - Welcome";
            break;



            // footer
        case 999:
            echo "Tüm hakları sosyalağ'a aittir.";
            break;



            // profile without auth
        case 1000:
            echo "{$page->profile["firstname"]} adlı kişiyi takip etmek, iletişime geçmek ve gönderilerini beğenmek için şimdi kayıt ol.";
            break;
        case 1001:
            echo "";
            break;
        case 1002:
            echo "";
            break;
        case 1003:
            echo "";
            break;
        case 1004:
            echo "";
            break;



            // notfound (notfoundcode + 2000)
        case 1999:
            echo "Ana sayfa";
            break;
        case 2000:
            echo "<p>Bu profil mevcut değil.</p><p>Sayfa adresini kontrol et ve tekrar dene.</p>";
            break;
        case 2001:
            echo "<p>Bu profil mevcut değil.</p><p>Sayfa adresini kontrol et veya giriş yaparak tekrar dene.</p>";
            break;
        case 2002:
            echo "";
            break;



            // profile with auth
        case 3000:
            echo "Profili düzenle";
            break;
        case 3001:
            echo "Takip ediyorsun";
            break;
        case 3002:
            echo "Fotoğrafları değiştir";
            break;
        case 3003:
            echo "Takip et";
            break;
        case 3004:
            echo "Takip ediyor";
            break;
        case 3005:
            echo "Engelli";
            break;
        case 3006:
            echo "Seni engelledi";
            break;
        case 3007:
            echo "Arkadaş";
            break;
        case 3008:
            echo "Bekleniyor";
            break;

        default:
            echo "<b>HATA lng($e) isteği karşılıksız.</b>";
    }
}
