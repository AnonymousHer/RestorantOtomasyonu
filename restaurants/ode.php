<?php 
include("header.php");

if ($_GET) 
{
 // veritabanı bağlantımızı sayfamıza ekliyoruz.
// id'si seçilen veriyi silme sorgumuzu yazıyoruz.
if ($db->query("DELETE FROM siparisler WHERE masaid =".(int)$_GET['id'])) 
{
    header("location:index.php?durum=odendi"); // Eğer sorgu çalışırsa ekle.php sayfasına gönderiyoruz.
}
}

?>