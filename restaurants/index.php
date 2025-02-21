<?php
if (isset($_GET['durum'])) {
    $message = '';
    if ($_GET['durum'] == 'odendi') {
        $message = 'ÖDEME BAŞARILI';
    }
}
?>

<?php include 'header.php' ?>

<?php
if (isset($message) && $message) { ?>
    <div class="alert-popup">
        <div class="alert alert-danger">
            <strong><?php echo $message; ?></strong>
        </div>
    </div>
    <style>
        .alert-popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            min-width: 300px;
            text-align: center;
            animation: slideDown 0.5s ease-out, fadeOut 0.5s ease-out 2.5s forwards;
        }
        
        @keyframes slideDown {
            from { transform: translate(-50%, -100%); }
            to { transform: translate(-50%, 0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        .alert-popup .alert {
            margin: 0;
            padding: 15px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background-color: rgba(75, 220, 53, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
        }
    </style>
    <script>
        setTimeout(function() {
            const alert = document.querySelector('.alert-popup');
            if (alert) {
                alert.remove();
            }
        }, 3000);
    </script>
<?php } ?>

<section>
    <?php include 'tables.php' ?>
</section>

<div style="margin: 100px 0;"></div>

<section id="service" class="pattern-style-4 has-overlay">
    <div class="container raise-2">
        <h6 class="section-subtitle text-center" style="text-decoration: none;">Öne Çıkan Yemek</h6>
        <h3 class="section-title mb-6 pb-3 text-center" style="text-decoration: none;">Özel yemekler</h3>
        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="javascript:void(0)" class="custom-list" style="text-decoration: none;">
                    <div class="img-holder">
                        <img src="assets/imgs/bumbar.jpg" alt="Bumbar Yemeği">
                    </div>
                    <div class="info">
                        <div class="head clearfix">
                            <h5 class="title float-left">Bumbar Dolması</h5>
                            <p class="float-right text-warning">50 ₺</p>
                        </div>
                        <div class="body">
                            <p>Geleneksel lezzetimiz Bumbar Dolması, tatmanız için özel olarak hazırlanmıştır.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="javascript:void(0)" class="custom-list" style="text-decoration: none;">
                    <div class="img-holder">
                        <img src="assets/imgs/KellePaca.jpg" alt="Kelle Paça Çorbası">
                    </div>
                    <div class="info">
                        <div class="head clearfix">
                            <h5 class="title float-left">Kelle Paça Çorbası</h5>
                            <p class="float-right text-warning ">18 ₺</p>
                        </div>
                        <div class="body">
                            <p>Kış aylarının vazgeçilmez lezzeti, şifa kaynağı Kelle Paça Çorbası.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="javascript:void(0)" class="custom-list" style="text-decoration: none;">
                    <div class="img-holder">
                        <img src="assets/imgs/Pizza.jpg" alt="Pizza">
                    </div>
                    <div class="info">
                        <div class="head clearfix">
                            <h5 class="title float-left">Pizza</h5>
                            <p class="float-right text-warning">18 ₺</p>
                        </div>
                        <div class="body">
                            <p>Gençlerin Vazgeçilmez ürünü</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="javascrip:void(0)" class="custom-list" style="text-decoration: none;">
                    <div class="img-holder">
                        <img src="assets/imgs/Kuru Fasulye.jpg">
                    </div>
                    <div class="info">
                        <div class="head clearfix">
                            <h5 class="title float-left">Kuru Fasulye</h5>
                            <p class="float-right text-warning">30 ₺</p>
                        </div>
                        <div class="body">
                            <p>Deneyen Vazgeçemiyor.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="javascrip:void(0)" class="custom-list" style="text-decoration: none;">
                    <div class="img-holder">
                        <img src="assets/imgs/Saç Tava Kuşbaşı.jpg" >
                    </div>
                    <div class="info">
                        <div class="head clearfix">
                            <h5 class="title float-left">Saç Tava Kuşbaşı</h5>
                            <p class="float-right text-warning">24 ₺</p>
                        </div>
                        <div class="body">
                            <p>Müthiş bir lezzet.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-4">
                <a href="javascrip:void(0)" class="custom-list" style="text-decoration: none;">
                    <div class="img-holder">
                        <img src="assets/imgs/Ciğer.jpg">
                    </div>
                    <div class="info">
                        <div class="head clearfix">
                            <h5 class="title float-left">Ciğer</h5>
                            <p class="float-right text-warning">44 ₺</p>
                        </div>
                        <div class="body">
                            <p>Yemeyen Binpişman Olur.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>