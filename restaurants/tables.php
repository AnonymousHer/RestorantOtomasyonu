<?php 


require 'baglan.php';

$sorgu = $db->query("SELECT * FROM siparisler");
?>

<section class="masa">
    <h1 class="text-center">MASALAR</h1>
    <div class="resim" style="display: flex; flex-wrap: wrap; gap: 50px; justify-content: center; padding: 20px;">
        <?php while ($rev = $sorgu->fetch(PDO::FETCH_ASSOC)) { 
            $id = $rev['masaid']; 
            $masaAd = $rev['masa_ad']; 
            $masa = $rev['masa_bos']; 
        ?>
        <div class="tables" style="flex: 0 1 250px; display: flex; flex-direction: column; align-items: center; gap: 10px;">
            <?php
            // Masa numarasına göre fotoğraf seç
            $fotoNo = ($id % 6) + 3; // 1 ile 4 arasında döngüsel sayı üret
            ?>
            <a href="siparisler.php?id=<?php echo $id; ?>">
                <img src="assets/imgs/Foto-<?php echo $fotoNo; ?>.jpg" alt="" style="width: 250px; height: 400px; object-fit: cover; box-shadow: 0 4px 8px rgba(255, 0, 0, 0.49); border-radius: 8px; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.filter='brightness(1.1)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.4)'" onmouseout="this.style.transform='scale(1)'; this.style.filter='brightness(1)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.3)'">
            </a>
            <div class="buton text-center" style="width: 100%;">
                <a href="#?id=<?php echo $id; ?>" style="text-decoration: none; width: 100%; display: block;">
                    <?php 
                    if ($rev['masa_bos'] == 0) {
                        echo '<button type="submit" class="btn bg-success" style="color:white; font-size:16px;">'.$masaAd.' BOŞ</button>';
                    } else {
                        echo '<button type="submit" class="btn bg-danger" style="color:white; font-size:16px;">'.$masaAd.' DOLU</button>';
                    }
                    ?>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
  
    
    


