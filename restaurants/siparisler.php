<?php require 'header.php'; ?>

<!-- Add this CSS section in header or at the top -->
<style>
.order-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(255, 0, 0, 0.81);
    margin: 20px;
    max-width: 350px;
    padding: 20px;
    display: inline-block;
    vertical-align: top;
}

.order-header {
    border-bottom: 2px solid rgba(255, 0, 0, 0.21);
    margin-bottom: 20px;
    padding: 15px;
    background: linear-gradient(to bottom, rgba(255, 0, 0, 0.4), transparent);
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.category-header {
    background:rgba(0, 0, 0, 0.15);
    color:rgb(0, 0, 0);
    padding: 10px;
    margin: 15px 0;
    border-radius: 5px;
    font-weight: 600;
}

.order-table {
    width: 100%;
    margin-bottom: 1rem;
}

.order-table th {
    background:rgba(255, 0, 0, 0.7);
    padding: 12px;
    font-weight: 600;
}

.order-table td {
    padding: 12px;
    vertical-align: middle;
}

.total-row {
    background:rgba(0, 0, 0, 0.35);
    color:rgb(0, 0, 0);
    font-weight: bold;
    font-size: 1.1em;
}

.action-buttons {
    margin-top: 20px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.action-buttons .btn {
    padding: 8px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.alert {
    position: fixed;
    top: -100px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    min-width: 300px;
    text-align: center;
    transition: top 0.5s ease-in-out;
    background: rgba(75, 220, 53, 0.35) !important;
    backdrop-filter: blur(10px);
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
    padding: 15px 35px;
    border-radius: 8px;
    color: white;
}

.siparis {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}
</style>

<!-- Status messages -->
<div class="container mt-4">
    <?php if (isset($_GET['durum']) && $_GET['durum'] == 'odendi') { ?>
        <div id="paymentAlert" class="alert" role="alert">
            <strong>ÖDEME BAŞARILI</strong>
        </div>
    <?php } ?>
</div>

<script>
function showAlert(alertId) {
    const alert = document.getElementById(alertId);
    if (alert) {
        setTimeout(() => {
            alert.style.top = '20px';
        }, 100);
        
        setTimeout(() => {
            alert.style.top = '-100px';
        }, 3000);
    }
}

// Check and show alerts if they exist
document.addEventListener('DOMContentLoaded', function() {
    showAlert('paymentAlert');
});
</script>

<div class="siparis">
    <?php 
    
    $kaydet= $db->query("SELECT * FROM siparisler ");
    foreach ($kaydet as $yemek) {


        $masa = $yemek['masaid'];
        $masaad = $yemek['masa_ad'];       
        $kizartma_adet = $yemek['kizartma_adet'];
        $kizartma = $yemek['kizartma'];
        $kizartmatl = $yemek['kizartma_TL'];
        $dolma_adet = $yemek['dolma_adet'];
        $dolma = $yemek['dolma'];
        $dolmatl = $yemek['dolma_TL'];
        $kurufasulye_adet = $yemek['kurufasulye_adet'];
        $kurufasulye = $yemek['kurufasulye'];
        $kurufasulyetl = $yemek['kurufasulye_TL'];
        $patlican_adet = $yemek['patlican_adet'];
        $patlican = $yemek['patlican'];
        $patlicantl = $yemek['patlican_TL'];
        $bumbar_adet = $yemek['bumbar_adet'];
        $bumbar = $yemek['bumbar'];
        $bumbartl = $yemek['bumbar_TL'];
        $kellepaca_adet = $yemek['kellepaca_adet'];
        $kellepaca = $yemek['kellepaca'];
        $kellepacatl = $yemek['kellepaca_TL'];

        $yiyecekToplam =  ($kizartma_adet * $kizartmatl) + ($dolma_adet * $dolmatl) +($kurufasulye_adet * $kurufasulyetl) + ($patlican_adet * $patlicantl) + ($bumbar_adet * $bumbartl) + ($kellepaca_adet * $kellepacatl);

        $Meysu_adet = $yemek['Meysu_adet'];
        $Meysu = $yemek['Meysu'];
        $Meysutl = $yemek['Meysu_TL'];
        $ColaTurka_adet = $yemek['ColaTurka_adet'];
        $ColaTurka = $yemek['ColaTurka'];
        $ColaTurkatl = $yemek['ColaTurka_TL'];
        $cappy_adet = $yemek['cappy_adet'];
        $cappy = $yemek['cappy'];
        $cappytl = $yemek['cappy_TL'];
        $limonata_adet = $yemek['limonata_adet'];
        $limonata = $yemek['limonata'];
        $limonatatl = $yemek['limonata_TL'];
        $ayran_adet = $yemek['ayran_adet'];
        $ayran = $yemek['ayran'];
        $ayrantl = $yemek['ayran_TL'];
        $salgam_adet = $yemek['salgam_adet'];
        $salgam = $yemek['salgam'];
        $salgamtl = $yemek['salgam_TL'];

        $icecekToplam = ($Meysu_adet * $Meysutl) + ($ColaTurka_adet * $ColaTurkatl) +($cappy_adet * $cappytl) + ($limonata_adet * $limonatatl) + ($ayran_adet * $ayrantl) + ($salgam_adet * $salgamtl);

        $puding_adet = $yemek['puding_adet'];
        $puding = $yemek['puding'];
        $pudingtl = $yemek['puding_TL'];
        $sutlac_adet = $yemek['sutlac_adet'];
        $sutlac = $yemek['sutlac'];
        $sutlactl = $yemek['sutlac_TL'];
        $sekerpare_adet = $yemek['sekerpare_adet'];
        $sekerpare = $yemek['sekerpare'];
        $sekerparetl = $yemek['sekerpare_TL'];
        $baklava_adet = $yemek['baklava_adet'];
        $baklava = $yemek['baklava'];
        $baklavatl = $yemek['baklava_TL'];
        $yaspasta_adet = $yemek['yaspasta_adet'];
        $yaspasta = $yemek['yaspasta'];
        $yaspastatl = $yemek['yaspasta_TL'];
        $kemalpasa_adet = $yemek['kemalpasa_adet'];
        $kemalpasa = $yemek['kemalpasa'];
        $kemalpasatl = $yemek['kemalpasa_TL'];
        
        $tatliToplam = ($puding_adet * $pudingtl) + ($sutlac_adet * $sutlactl) +($sekerpare_adet * $sekerparetl) + ($baklava_adet * $baklavatl) + ($yaspasta_adet * $yaspastatl) + ($kellepaca_adet * $kemalpasatl);
  
        $toplam = $yiyecekToplam + $icecekToplam + $tatliToplam;

    ?>
        <div class="order-card">
            <div class="order-header text-center">
                <h2><?php echo $masaad ?></h2>
                <h4 class="text-muted"><?php echo $yemek['masa_kisi'] ?> KİŞİ</h4>
            </div>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>ADET</th>
                        <th>SİPARİŞLER</th>
                        <th>FİYAT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="category-header">
                        <td colspan="3">YİYECEKLER</td>
                    </tr>
                    <tr>
                        <?php if ($yemek['kizartma_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kizartma_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['kizartma'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$kizartma.' </td>' ;
                        }?>
                        <?php if ($yemek['kizartma_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kizartmatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['dolma_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$dolma_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['dolma'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$dolma.' </td>' ;
                        }?>
                        <?php if ($yemek['dolma_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$dolmatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['kurufasulye_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kurufasulye_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['kurufasulye'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$kurufasulye.' </td>' ;
                        }?>
                        <?php if ($yemek['kurufasulye_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kurufasulyetl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['patlican_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$patlican_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['patlican'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$patlican.' </td>' ;
                        }?>
                        <?php if ($yemek['patlican_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$patlicantl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['bumbar_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$bumbar_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['bumbar'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$bumbar.' </td>' ;
                        }?>
                        <?php if ($yemek['bumbar_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$bumbartl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['kellepaca_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kellepaca_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['kellepaca'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$kellepaca.' </td>' ;
                        }?>
                        <?php if ($yemek['kellepaca_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kellepacatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr class="category-header">
                        <td colspan="3">İÇECEKLER</td>
                    </tr>
                    <tr>
                        <?php if ($yemek['Meysu_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$Meysu_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['Meysu'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$Meysu.' </td>' ;
                        }?>
                        <?php if ($yemek['Meysu_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$Meysutl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['ColaTurka_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$ColaTurka_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['ColaTurka'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$ColaTurka.' </td>' ;
                        }?>
                        <?php if ($yemek['ColaTurka_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$ColaTurkatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['cappy_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$cappy_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['cappy'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$cappy.' </td>' ;
                        }?>
                        <?php if ($yemek['cappy_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$cappytl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['limonata_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$limonata_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['limonata'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$limonata.' </td>' ;
                        }?>
                        <?php if ($yemek['limonata_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$limonatatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['ayran_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$ayran_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['ayran'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$ayran.' </td>' ;
                        }?>
                        <?php if ($yemek['ayran_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$ayrantl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['salgam_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$salgam_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['salgam'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$salgam.' </td>' ;
                        }?>
                        <?php if ($yemek['salgam_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$salgamtl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr class="category-header">
                        <td colspan="3">TATLILAR</td>
                    </tr>
                    <tr>
                        <?php if ($yemek['puding_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$puding_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['puding'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$puding.' </td>' ;
                        }?>
                        <?php if ($yemek['puding_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$pudingtl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['sutlac_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$sutlac_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['sutlac'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$sutlac.' </td>' ;
                        }?>
                        <?php if ($yemek['sutlac_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$sutlactl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['sekerpare_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$sekerpare_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['sekerpare'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$sekerpare.' </td>' ;
                        }?>
                        <?php if ($yemek['sekerpare_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$sekerparetl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['baklava_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$baklava_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['baklava'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$baklava.' </td>' ;
                        }?>
                        <?php if ($yemek['baklava_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$baklavatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['yaspasta_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$yaspasta_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['yaspasta'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$yaspasta.' </td>' ;
                        }?>
                        <?php if ($yemek['yaspasta_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$yaspastatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr>
                        <?php if ($yemek['kemalpasa_adet'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kemalpasa_adet.' </td>' ;
                        } ?>
                        <?php if ($yemek['kemalpasa'] == "") {
                            echo '';
                        }else {
                            echo '<td>'.$kemalpasa.' </td>' ;
                        }?>
                        <?php if ($yemek['kemalpasa_TL'] == 0) {
                            echo ' ';
                        }else {
                            echo '<td>'.$kemalpasatl.' </td>' ;
                        } ?> 
                    </tr>
                    <tr class="total-row">
                        <td colspan="2">GENEL TOPLAM</td>
                        <td><?php echo $toplam ?> ₺</td>
                    </tr>
                </tbody>
            </table>

            <div class="action-buttons">
                <a href="siparisgüncelle.php?id=<?php echo $masa ?>" class="btn btn-success">
                    GÜNCELLE
                </a>
                <a href="ode.php?id=<?php echo $masa ?>" class="btn btn-danger">
                    ÖDE
                </a>
            </div>
        </div>
                <?php } ?>

       
</div>  