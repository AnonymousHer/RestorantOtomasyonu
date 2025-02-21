<?php 
// Start the session and include any necessary files at the very top
session_start();

// Database connection - Move this to the top
try {
    $db = new PDO("mysql:host=localhost;dbname=restaurant_otomasyonu", 'root', '');
    // echo 'Veri Tabanı Başarılı';
} catch(Exception $th) {
    echo $th->getMessage();
}

// Handle all redirects first
if(isset($_POST['cikis'])) {
    header('Location:../index.php?durum=geri');
    exit;
}

// Ürün kategorilerini ve özelliklerini array olarak tanımla
$menuItems = [
    'yiyecekler' => [
        'kizartma' => ['fiyat' => 35, 'resim' => 'img/yiyecek/kizartma.jpg'],
        'dolma' => ['fiyat' => 40, 'resim' => 'img/yiyecek/dolma.jpg'],
        'kurufasulye' => ['fiyat' => 45, 'resim' => 'img/yiyecek/kurufasulye.jpg'],
        'patlican' => ['fiyat' => 55, 'resim' => 'img/yiyecek/patlican.jpg'],
        'bumbar' => ['fiyat' => 60, 'resim' => 'img/yiyecek/bumbar.jpg'],
        'kellepaca' => ['fiyat' => 50, 'resim' => 'img/yiyecek/kellepaca.jpg']
    ],
    'icecekler' => [
        'Meysu' => ['fiyat' => 15, 'resim' => 'img/icecek/Meysu.jpg'],
        'ColaTurka' => ['fiyat' => 10, 'resim' => 'img/icecek/ColaTurka.jpg'],
        'cappy' => ['fiyat' => 10, 'resim' => 'img/icecek/cappy.jpg'],
        'limonata' => ['fiyat' => 10, 'resim' => 'img/icecek/limonata.jpg'],
        'ayran' => ['fiyat' => 10, 'resim' => 'img/icecek/ayran.jpg'],
        'salgam' => ['fiyat' => 10, 'resim' => 'img/icecek/salgam.jpg']
    ],
    'tatlilar' => [
        'puding' => ['fiyat' => 20, 'resim' => 'img/tatli/puding.jpg'],
        'sutlac' => ['fiyat' => 25, 'resim' => 'img/tatli/sutlac.jpg'],
        'sekerpare' => ['fiyat' => 25, 'resim' => 'img/tatli/sekerpare.jpg'],
        'baklava' => ['fiyat' => 75, 'resim' => 'img/tatli/baklava.jpg'],
        'yaspasta' => ['fiyat' => 90, 'resim' => 'img/tatli/yaspasta.jpg'],
        'kemalpasa' => ['fiyat' => 50, 'resim' => 'img/tatli/kemalpasa.jpg']
    ]
];

// POST verilerini işleme fonksiyonu
function processPostData($items) {
    $processedData = [];
    foreach ($items as $category => $products) {
        foreach ($products as $item => $details) {
            $processedData[$item . '_adet'] = isset($_POST[$item . '_adet']) ? $_POST[$item . '_adet'] : '0';
            $processedData[$item] = isset($_POST[$item]) ? $_POST[$item] : '';
            $processedData[$item . '_TL'] = isset($_POST[$item . '_TL']) ? $_POST[$item . '_TL'] : '0';
        }
    }
    return $processedData;
}

// Sipariş kaydetme işlemi
if (isset($_POST['kaydet'])) {
    $masanumara = $_POST['masa_ad'];
    $masakisi = $_POST['masa_kisi'];
    
    // Form verilerini işle
    $siparisData = processPostData($menuItems);
    
    $error_message = '';
    
    // Validasyon
    if($masanumara == "" || $masakisi == "") {
        $error_message = 'BOŞ ALAN BIRAKMAYINIZ';
    } else {
        // Masa kontrolü
        $kontrol = $db->query("SELECT * FROM siparisler WHERE masa_ad='$masanumara'")->fetch();
        if ($kontrol) {
            $error_message = 'MASA HENÜZ BOŞALMADI';
        } else {
            // Ürün seçimi kontrolü
            $urunSecildi = false;
            foreach ($siparisData as $key => $value) {
                if (strpos($key, '_adet') !== false && $value != '0' && $value != '') {
                    $urunSecildi = true;
                    break;
                }
            }
            if (!$urunSecildi) {
                $error_message = 'LÜTFEN EN AZ BİR ÜRÜN SEÇİNİZ';
            }
        }
    }
    
    if ($error_message) {
        $_SESSION['error_message'] = $error_message;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    
    // Sipariş kaydetme
    $sql = "INSERT INTO siparisler (masa_ad, masa_kisi, " . 
           implode(", ", array_keys($siparisData)) . 
           ") VALUES (?, ?, " . str_repeat("?,", count($siparisData)-1) . "?)";
    
    $kaydet = $db->prepare($sql);
    $values = array_merge([$masanumara, $masakisi], array_values($siparisData));
    
    if ($kaydet->execute($values)) {
        header('Location:../siparisler.php?durum=ok');
    } else {
        header('Location:siparisal.php?durum=no');
    }
    exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>MASA AÇ</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1e1e1e;
            --secondary-color: #2d2d2d;
            --accent-color: #424242;
            --text-light: #ffffff;
            --text-dark: #1e1e1e;
            --card-bg: rgba(255, 255, 255, 0.98);
            --card-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            --gradient-primary: linear-gradient(135deg, #1e1e1e, #2d2d2d);
            --gradient-secondary: linear-gradient(135deg, #2d2d2d, #424242);
            --gradient-success: linear-gradient(135deg, #1e1e1e, #2d2d2d);
        }
        
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)),
                        url('img/background/restaurant-bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: var(--text-light);
        }
        
        .menu-card {
            background-color: rgba(30, 30, 30, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            color: var(--text-light);
        }
        
        .menu-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu-card .card-header {
            background: var(--gradient-primary);
            border: none;
            padding: 1.8rem;
            border-radius: 25px 25px 0 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .menu-card .card-body {
            padding: 2rem;
        }

        .menu-item {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .menu-card img {
            height: 180px;
            width: 180px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid rgba(255, 255, 255, 0.1);
        }
        
        .menu-card img:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.2);
        }
        
        .menu-header {
            background: var(--gradient-primary);
            color: var(--text-light);
            padding: 2.5rem;
            border-radius: 25px;
            margin-bottom: 3rem;
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .form-select, .form-control {
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            padding: 0.9rem;
            background-color: rgba(30, 30, 30, 0.95);
            transition: all 0.3s ease;
            font-size: 0.95rem;
            color: var(--text-light);
        }
        
        .form-select:focus, .form-control:focus {
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            background-color: rgba(30, 30, 30, 0.98);
        }
        
        .btn-action {
            border-radius: 15px;
            padding: 14px 35px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .btn-action:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-danger {
            background: #2d2d2d;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .d-flex.gap-2 {
            gap: 1rem !important;
        }

        /* Card header colors */
        .bg-primary {
            background: var(--gradient-primary) !important;
        }

        .bg-secondary {
            background: var(--gradient-secondary) !important;
        }

        .bg-success {
            background: var(--gradient-success) !important;
        }

        /* Select ve option stilleri */
        .form-select option {
            background-color: #1e1e1e;
            color: var(--text-light);
        }

        /* Animasyonlar */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .menu-item {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .menu-card {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Responsive düzenlemeler */
        @media (max-width: 768px) {
            .menu-card img {
                height: 150px;
                width: 150px;
            }
            
            .btn-action {
                padding: 12px 25px;
                font-size: 0.9rem;
            }
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7) !important; /* Beyaz renk, hafif transparanlık ile */
        }

        /* Add this to ensure input text is white */
        .form-control {
            color: white !important; /* Using !important to override any Bootstrap defaults */
        }

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
            background-color: rgba(220, 53, 69, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
        }
    </style>
  </head>
  <body >

<?php 
?>

  <br><br><br><br>

  <form action="yenimasaac.php" method="post">
  <div class="container py-5">
    <div class="menu-header text-center mb-4">
        <h1 class="display-5">YENİ MASA AÇ</h1>
        <div class="row mt-4">
        <div class="col-12 text-center">
        <button type="submit" name="cikis" class="btn btn-danger btn-action me-2">İPTAL</button>
        <button type="submit" name="kaydet" class="btn btn-primary btn-action">KAYDET</button>
     </div>
    </div>
    </div>
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card menu-card">
                    <div class="card-body">
                        <select name="masa_ad" class="form-select mb-3 text-center">
                            <option value="MASA - 1">MASA - 1</option>
                            <option value="MASA - 2">MASA - 2</option>
                            <option value="MASA - 3">MASA - 3</option>
                            <option value="MASA - 4">MASA - 4</option>
                        </select>
                        <input type="text" class="form-control text-center" 
                               name="masa_kisi" maxlength="10" 
                               placeholder="KİŞİ SAYISI GİRİNİZ"
                               onkeypress="return isNumberKey(event)">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Menü kartları için fonksiyon -->
            <?php
            function renderMenuItem($item, $name, $details) {
                ?>
                <div class="menu-item mb-3">
                    <img src="<?php echo $details['resim']; ?>" class="img-fluid mb-2" alt="<?php echo ucfirst($name); ?>">
                    <div class="d-flex gap-2">
                        <select name="<?php echo $name; ?>_adet" class="form-select">
                            <option value="">Adet</option>
                            <?php for($i=1; $i<=10; $i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <select name="<?php echo $name; ?>" class="form-select">
                            <option value="">Seçiniz</option>
                            <option value="<?php echo strtoupper($name); ?>"><?php echo strtoupper($name); ?></option>
                        </select>
                        <select name="<?php echo $name; ?>_TL" class="form-select">
                            <option value="">Fiyat</option>
                            <option value="<?php echo $details['fiyat']; ?>"><?php echo $details['fiyat']; ?> ₺</option>
                        </select>
                    </div>
                </div>
                <?php
            }
            ?>

            <!-- Menü kartlarını oluştur -->
            <div class="row">
                <?php
                $cardStyles = [
                    'yiyecekler' => ['title' => 'YİYECEKLER', 'class' => 'bg-primary'],
                    'icecekler' => ['title' => 'İÇECEKLER', 'class' => 'bg-secondary'],
                    'tatlilar' => ['title' => 'TATLILAR', 'class' => 'bg-success']
                ];
                
                foreach($menuItems as $category => $items) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <div class="card-header <?php echo $cardStyles[$category]['class']; ?> text-white">
                                <h3 class="text-center mb-0"><?php echo $cardStyles[$category]['title']; ?></h3>
                            </div>
                            <div class="card-body">
                                <?php
                                foreach($items as $name => $details) {
                                    renderMenuItem($name, $name, $details);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

      
    </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Bootstrap 5 JS ve diğer gerekli scriptler -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            return !(charCode > 31 && (charCode < 48 || charCode > 57));
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tüm menü öğesi resimlerini seç
        const menuImages = document.querySelectorAll('.menu-item img');
        
        menuImages.forEach(img => {
            img.addEventListener('click', function() {
                // Resmin bulunduğu menu-item div'ini bul
                const menuItem = this.closest('.menu-item');
                
                // Menu item içindeki select elementlerini bul
                const adetSelect = menuItem.querySelector('select[name$="_adet"]');
                const yemekSelect = menuItem.querySelector('select[name$="_TL"]');
                const isimSelect = menuItem.querySelector('select:not([name$="_adet"]):not([name$="_TL"])');

                // Varsayılan değerleri ayarla
                if (adetSelect) {
                    adetSelect.value = "1"; // Adet'i 1 olarak ayarla
                }

                // İsim select'ini bul ve ilk opsiyonu seç
                if (isimSelect && isimSelect.options.length > 1) {
                    isimSelect.value = isimSelect.options[1].value;
                }

                // Fiyat select'ini bul ve ilk fiyat opsiyonunu seç
                if (yemekSelect && yemekSelect.options.length > 1) {
                    yemekSelect.value = yemekSelect.options[1].value;
                }

                // Seçim animasyonu
                menuItem.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    menuItem.style.transform = 'scale(1)';
                }, 200);

                // Seçim geri bildirimi
                const feedback = document.createElement('div');
                feedback.textContent = 'Seçildi!';
                feedback.style.cssText = `
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: rgba(0,0,0,0.8);
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-size: 14px;
                    pointer-events: none;
                    animation: fadeOut 1s forwards;
                `;
                
                menuItem.style.position = 'relative';
                menuItem.appendChild(feedback);
                
                setTimeout(() => {
                    feedback.remove();
                }, 1000);
            });
        });
    });

    // Fade out animasyonu için CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    </script>

    <!-- Add this right after <body> tag -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert-popup">
            <div class="alert alert-danger">
                <strong><?php echo $_SESSION['error_message']; ?></strong>
            </div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Add this JavaScript before </body> -->
    <script>
        // Remove alert after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert-popup');
            if (alert) {
                setTimeout(() => {
                    alert.remove();
                }, 3000);
            }
        });
    </script>
  </body>
</html>