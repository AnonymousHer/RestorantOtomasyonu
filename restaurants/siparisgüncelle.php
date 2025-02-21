<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $db = new PDO("mysql:host=localhost;dbname=restaurant_otomasyonu", 'root', '');
} catch(Exception $e) {
    error_log($e->getMessage());
    die('Database connection failed');
}

if (isset($_GET['id'])) {
    $sorgu = $db->query("SELECT * FROM siparisler WHERE masaid =".(int)$_GET['id']); 
    $sonuc = $sorgu->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['cikis'])) {
    header('Location: siparisler.php');
    exit();
}

if (isset($_POST['kaydet'])) {
    $anyItemSelected = false;
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_adet') !== false && $value !== '' && $value !== '0') {
            $anyItemSelected = true;
            break;
        }
    }

    if (!$anyItemSelected) {
        $_SESSION['message'] = array(
            'type' => 'warning',
            'text' => 'Lütfen güncellenecek ürünleri seçin!'
        );
        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']);
        exit();
    }

    $menuItems = [
        'kizartma', 'dolma', 'kurufasulye', 'patlican', 'bumbar', 'kellepaca',
        'Meysu', 'ColaTurka', 'cappy', 'limonata', 'ayran', 'salgam',
        'puding', 'sutlac', 'sekerpare', 'baklava', 'yaspasta', 'kemalpasa'
    ];

    $values = [];
    foreach ($menuItems as $item) {
        $values[$item . '_adet'] = isset($_POST[$item . '_adet']) ? $_POST[$item . '_adet'] : '0';
        $values[$item] = isset($_POST[$item]) ? $_POST[$item] : '';
        $values[$item . '_TL'] = isset($_POST[$item . '_TL']) ? $_POST[$item . '_TL'] : '0';
    }

    $sql = "UPDATE `siparisler` SET ";
    $updates = [];
    $params = [];
    
    foreach ($menuItems as $item) {
        $updates[] = "`{$item}_adet`=:${item}_adet, `{$item}`=:${item}, `{$item}_TL`=:${item}_TL";
        $params[":${item}_adet"] = $values[$item . '_adet'];
        $params[":${item}"] = $values[$item];
        $params[":${item}_TL"] = $values[$item . '_TL'];
    }
    
    $sql .= implode(', ', $updates) . " WHERE masaid=:masaid";
    $params[':masaid'] = $_GET['id'];

    try {
        $stmt = $db->prepare($sql);
        if ($stmt->execute($params)) {
            header('Location:siparisler.php?güncel=ok');
        } else {
            header('Location:siparisal.php?güncel=no');
        }
        exit();
    } catch(PDOException $e) {
        error_log($e->getMessage());
        header('Location:siparisal.php?güncel=no');
        exit();
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <title>MASA AÇ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            margin: 0;
            padding: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)),
                        url('../img/background/restaurant-bg.jpg');
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

        .bg-primary {
            background: var(--gradient-primary) !important;
        }

        .bg-secondary {
            background: var(--gradient-secondary) !important;
        }

        .bg-success {
            background: var(--gradient-success) !important;
        }

        .form-select option {
            background-color: #1e1e1e;
            color: var(--text-light);
        }

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

        .menu-item img {
            cursor: pointer;
        }

        .selection-message {
            color: #4CAF50;
            font-size: 14px;
            margin-top: 5px;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .selection-message.show {
            opacity: 1;
        }

        .alert-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert {
            padding: 15px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
            border: none;
            color: white;
            font-weight: 500;
        }

        .alert-success {
            background-color: #28a745;
        }

        .alert-warning {
            background-color: #ffc107;
            color: #000;
        }

        .alert-danger {
            background-color: #dc3545;
        }
    </style>
</head>
  <body style="background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)),
                    url('../img/background/restaurant-bg.jpg');
             background-size: cover;
             background-position: center;
             background-attachment: fixed;
             background-repeat: no-repeat;">
  <br><br><br><br>

  <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>" method="post">
  <div class="container py-5">
    <div class="menu-header text-center mb-4">
        <h1 class="display-5">Siparişleri Güncelle</h1>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" name="cikis" class="btn btn-danger btn-action me-2">İPTAL</button>
                <button type="submit" name="kaydet" class="btn btn-primary btn-action">Güncelle</button>
            </div>
        </div>
    </div>
<div class="form">
<div class="menu">
<div class="row">
            <div class="col-md-4 mb-4">
                <div class="card menu-card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">YİYECEKLER</h3>
                    </div>
                    <div class="card-body">
                        <div class="menu-item mb-3">
                            <img src="img/yiyecek/kızartma.jpg" class="img-fluid mb-2" alt="Kızartma">
                            <div class="d-flex gap-2">
                                <select name="kizartma_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['kizartma_adet']) && $sonuc['kizartma_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="kizartma" class="form-select">
                                    <option value="">Yemek</option>
                                    <option value="KIZARTMA" <?php echo ($sonuc['kizartma'] == 'KIZARTMA') ? 'selected' : ''; ?>>KIZARTMA</option>
                                </select>
                                <select name="kizartma_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="35" <?php echo ($sonuc['kizartma_TL'] == '35') ? 'selected' : ''; ?>>35 ₺</option>
                                </select>
                            </div>
                        </div>

                        <div class="menu-item mb-3">
                            <img src="img/yiyecek/dolma.jpg" class="img-fluid mb-2" alt="Dolma">
                            <div class="d-flex gap-2">
                                <select name="dolma_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['dolma_adet']) && $sonuc['dolma_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="dolma" class="form-select">
                                    <option value="">Yemek</option>
                                    <option value="DOLMA" <?php echo ($sonuc['dolma'] == 'DOLMA') ? 'selected' : ''; ?>>DOLMA</option>
                                </select>
                                <select name="dolma_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="40" <?php echo ($sonuc['dolma_TL'] == '40') ? 'selected' : ''; ?>>40 ₺</option>
                                </select>
                            </div>
                        </div>

                        <div class="menu-item mb-3">
                            <img src="img/yiyecek/kurufasulye.jpg" class="img-fluid mb-2" alt="Kuru Fasulye">
                            <div class="d-flex gap-2">
                                <select name="kurufasulye_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['kurufasulye_adet']) && $sonuc['kurufasulye_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="kurufasulye" class="form-select">
                                    <option value="">Yemek</option>
                                    <option value="KURU FASULYE" <?php echo ($sonuc['kurufasulye'] == 'KURU FASULYE') ? 'selected' : ''; ?>>KURU FASULYE</option>
                                </select>
                                <select name="kurufasulye_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="45" <?php echo ($sonuc['kurufasulye_TL'] == '45') ? 'selected' : ''; ?>>45 ₺</option>
                                </select>
                            </div>
                        </div>

                        <!-- Patlıcan Kebabı -->
                        <div class="menu-item mb-3">
                            <img src="img/yiyecek/patlıcan.jpg" class="img-fluid mb-2" alt="Patlıcan Kebabı">
                            <div class="d-flex gap-2">
                                <select name="patlican_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['patlican_adet']) && $sonuc['patlican_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="patlican" class="form-select">
                                    <option value="">Yemek</option>
                                    <option value="PATLICAN KEBABI" <?php echo ($sonuc['patlican'] == 'PATLICAN KEBABI') ? 'selected' : ''; ?>>PATLICAN KEBABI</option>
                                </select>
                                <select name="patlican_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="55" <?php echo ($sonuc['patlican_TL'] == '55') ? 'selected' : ''; ?>>55 ₺</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bumbar -->
                        <div class="menu-item mb-3">
                            <img src="img/yiyecek/bumbar.jpg" class="img-fluid mb-2" alt="Bumbar">
                            <div class="d-flex gap-2">
                                <select name="bumbar_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['bumbar_adet']) && $sonuc['bumbar_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="bumbar" class="form-select">
                                    <option value="">Yemek</option>
                                    <option value="BUMBAR" <?php echo ($sonuc['bumbar'] == 'BUMBAR') ? 'selected' : ''; ?>>BUMBAR</option>
                                </select>
                                <select name="bumbar_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="60" <?php echo ($sonuc['bumbar_TL'] == '60') ? 'selected' : ''; ?>>60 ₺</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kelle Paça -->
                        <div class="menu-item mb-3">
                            <img src="img/yiyecek/kellepaca.jpg" class="img-fluid mb-2" alt="Kelle Paça">
                            <div class="d-flex gap-2">
                                <select name="kellepaca_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['kellepaca_adet']) && $sonuc['kellepaca_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="kellepaca" class="form-select">
                                    <option value="">Yemek</option>
                                    <option value="KELLE PAÇA" <?php echo ($sonuc['kellepaca'] == 'KELLE PAÇA') ? 'selected' : ''; ?>>KELLE PAÇA</option>
                                </select>
                                <select name="kellepaca_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="50" <?php echo ($sonuc['kellepaca_TL'] == '50') ? 'selected' : ''; ?>>50 ₺</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- İçecekler ve Tatlılar için benzer card yapıları -->
            <div class="col-md-4 mb-4">
                <div class="card menu-card">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="text-center mb-0">İÇECEKLER</h3>
                    </div>
                    <div class="card-body">
                        <div class="menu-item mb-3">
                            <img src="img/icecek/Meysu.jpg" class="img-fluid mb-2" alt="MeysuKola">
                            <div class="d-flex gap-2">
                                <select name="Meysu_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['Meysu_adet']) && $sonuc['Meysu_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="Meysu" class="form-select">
                                    <option value="">İçecek</option>
                                    <option value="Meysu" <?php echo (isset($sonuc['Meysu']) && $sonuc['Meysu'] == 'Meysu') ? 'selected' : ''; ?>>Meysu</option>
                                </select>
                                <select name="Meysu_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="15" <?php echo ($sonuc['Meysu_TL'] == '15') ? 'selected' : ''; ?>>15 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/icecek/ColaTurka.jpg" class="img-fluid mb-2" alt="ColaTurka">
                            <div class="d-flex gap-2">
                                <select name="ColaTurka_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['ColaTurka_adet']) && $sonuc['ColaTurka_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="ColaTurka" class="form-select">
                                    <option value="">İçecek</option>
                                    <option value="ColaTurka" <?php echo (isset($sonuc['ColaTurka']) && $sonuc['ColaTurka'] == 'ColaTurka') ? 'selected' : ''; ?>>ColaTurka</option>
                                </select>
                                <select name="ColaTurka_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="10" <?php echo ($sonuc['ColaTurka_TL'] == '10') ? 'selected' : ''; ?>>10 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/icecek/cappy.jpg" class="img-fluid mb-2" alt="Cappy">
                            <div class="d-flex gap-2">
                                <select name="cappy_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['cappy_adet']) && $sonuc['cappy_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="cappy" class="form-select">
                                    <option value="">İçecek</option>
                                    <option value="CAPPY" <?php echo (isset($sonuc['cappy']) && $sonuc['cappy'] == 'CAPPY') ? 'selected' : ''; ?>>CAPPY</option>
                                </select>
                                <select name="cappy_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="10" <?php echo ($sonuc['cappy_TL'] == '10') ? 'selected' : ''; ?>>10 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/icecek/limonata.jpg" class="img-fluid mb-2" alt="Limonata">
                            <div class="d-flex gap-2">
                                <select name="limonata_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['limonata_adet']) && $sonuc['limonata_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="limonata" class="form-select">
                                    <option value="">İçecek</option>
                                    <option value="LİMONATA" <?php echo (isset($sonuc['limonata']) && $sonuc['limonata'] == 'LİMONATA') ? 'selected' : ''; ?>>LİMONATA</option>
                                </select>
                                <select name="limonata_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="10" <?php echo ($sonuc['limonata_TL'] == '10') ? 'selected' : ''; ?>>10 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/icecek/ayran.jpg" class="img-fluid mb-2" alt="Ayran">
                            <div class="d-flex gap-2">
                                <select name="ayran_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['ayran_adet']) && $sonuc['ayran_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="ayran" class="form-select">
                                    <option value="">İçecek</option>
                                    <option value="AYRAN" <?php echo (isset($sonuc['ayran']) && $sonuc['ayran'] == 'AYRAN') ? 'selected' : ''; ?>>AYRAN</option>
                                </select>
                                <select name="ayran_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="10" <?php echo ($sonuc['ayran_TL'] == '10') ? 'selected' : ''; ?>>10 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/icecek/salgam.jpg" class="img-fluid mb-2" alt="Şalgam">
                            <div class="d-flex gap-2">
                                <select name="salgam_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['salgam_adet']) && $sonuc['salgam_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="salgam" class="form-select">
                                    <option value="">İçecek</option>
                                    <option value="salgam" <?php echo (isset($sonuc['salgam']) && $sonuc['salgam'] == 'salgam') ? 'selected' : ''; ?>>ŞALGAM</option>
                                </select>
                                <select name="salgam_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="10" <?php echo ($sonuc['salgam_TL'] == '10') ? 'selected' : ''; ?>>10 ₺</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tatlılar için benzer card yapısı -->
            <div class="col-md-4 mb-4">
                <div class="card menu-card">
                    <div class="card-header bg-success text-white">
                        <h3 class="text-center mb-0">TATLILAR</h3>
                    </div>
                    <div class="card-body">
                        <div class="menu-item mb-3">
                            <img src="img/tatli/puding.jpg" class="img-fluid mb-2" alt="Puding">
                            <div class="d-flex gap-2">
                                <select name="puding_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['puding_adet']) && $sonuc['puding_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="puding" class="form-select">
                                    <option value="">Tatlı Seç</option>
                                    <option value="PUDİNG" <?php echo (isset($sonuc['puding']) && $sonuc['puding'] == 'PUDİNG') ? 'selected' : ''; ?>>PUDİNG</option>
                                </select>
                                <select name="puding_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="20" <?php echo ($sonuc['puding_TL'] == '20') ? 'selected' : ''; ?>>20 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/tatli/sutlac.jpg" class="img-fluid mb-2" alt="Sütlac">
                            <div class="d-flex gap-2">
                                <select name="sutlac_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['sutlac_adet']) && $sonuc['sutlac_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="sutlac" class="form-select">
                                    <option value="">Tatlı</option>
                                    <option value="SÜTLAÇ" <?php echo (isset($sonuc['sutlac']) && $sonuc['sutlac'] == 'SÜTLAÇ') ? 'selected' : ''; ?>>SÜTLAÇ</option>
                                </select>
                                <select name="sutlac_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="25" <?php echo ($sonuc['sutlac_TL'] == '25') ? 'selected' : ''; ?>>25 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/tatli/sekerpare.jpg" class="img-fluid mb-2" alt="Şekerpare">
                            <div class="d-flex gap-2">
                                <select name="sekerpare_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['sekerpare_adet']) && $sonuc['sekerpare_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="sekerpare" class="form-select">
                                    <option value="">Tatlı</option>
                                    <option value="ŞEKERPARE" <?php echo (isset($sonuc['sekerpare']) && $sonuc['sekerpare'] == 'ŞEKERPARE') ? 'selected' : ''; ?>>ŞEKERPARE</option>
                                </select>
                                <select name="sekerpare_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="25" <?php echo ($sonuc['sekerpare_TL'] == '25') ? 'selected' : ''; ?>>25 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/tatli/baklava.jpg" class="img-fluid mb-2" alt="Baklava">
                            <div class="d-flex gap-2">
                                <select name="baklava_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['baklava_adet']) && $sonuc['baklava_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="baklava" class="form-select">
                                    <option value="">Tatlı</option>
                                    <option value="BAKLAVA" <?php echo (isset($sonuc['baklava']) && $sonuc['baklava'] == 'BAKLAVA') ? 'selected' : ''; ?>>BAKLAVA</option>
                                </select>
                                <select name="baklava_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="75" <?php echo ($sonuc['baklava_TL'] == '75') ? 'selected' : ''; ?>>75 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/tatli/yaspasta.jpg" class="img-fluid mb-2" alt="Yaş Pasta">
                            <div class="d-flex gap-2">
                                <select name="yaspasta_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['yaspasta_adet']) && $sonuc['yaspasta_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="yaspasta" class="form-select">
                                    <option value="">Tatlı</option>
                                    <option value="YAŞ PASTA" <?php echo (isset($sonuc['yaspasta']) && $sonuc['yaspasta'] == 'YAŞ PASTA') ? 'selected' : ''; ?>>YAŞ PASTA</option>
                                </select>
                                <select name="yaspasta_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="90" <?php echo ($sonuc['yaspasta_TL'] == '90') ? 'selected' : ''; ?>>90 ₺</option>
                                </select>
                            </div>
                        </div>
                        <div class="menu-item mb-3">
                            <img src="img/tatli/kemalpasa.jpg" class="img-fluid mb-2" alt="Kemal Paşa">
                            <div class="d-flex gap-2">
                                <select name="kemalpasa_adet" class="form-select">
                                    <option value="0">Adet</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo (isset($sonuc['kemalpasa_adet']) && $sonuc['kemalpasa_adet'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="kemalpasa" class="form-select">
                                    <option value="">Tatlı</option>
                                    <option value="KEMAL PAŞA" <?php echo (isset($sonuc['kemalpasa']) && $sonuc['kemalpasa'] == 'KEMAL PAŞA') ? 'selected' : ''; ?>>KEMAL PAŞA</option>
                                </select>
                                <select name="kemalpasa_TL" class="form-select">
                                    <option value="0">Fiyat</option>
                                    <option value="50" <?php echo ($sonuc['kemalpasa_TL'] == '50') ? 'selected' : ''; ?>>50 ₺</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
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
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert-popup">
            <div class="alert alert-<?php echo $_SESSION['message']['type']; ?>">
                <?php echo $_SESSION['message']['text']; ?>
            </div>
        </div>  
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- Add this JavaScript before </body> -->
    <script>
        // Remove alert after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert-popup');
            if (alert) {
                setTimeout(() => {
                    alert.style.animation = 'slideOut 0.5s ease-in forwards';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
  </body>
</html>