<?php 

try{
    $db = NEW PDO ("mysql:host=localhost;dbname=restaurant_otomasyonu",'root','');
    // echo 'Veri Tabanı Başarılı';
}catch(Exception $th){
    echo $th -> getMessage();
}

?>