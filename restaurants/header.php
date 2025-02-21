<?php require 'baglan.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DmrRestoran</title>
    
    <!-- CSS files -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/restaurant.css">
    <link rel="stylesheet" href="yemek.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/imgs/logo.ico" type="image/x-icon">
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .blink {
            animation: blinker 3s linear infinite;
        }
        
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    <!-- First Navigation -->
    <nav class="navbar nav-first navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <span class="title1 blink">DmrRestoran</span>
            </a>
        </div>
    </nav>
    <!-- End of First Navigation --> 
    
    <!-- Second Navigation -->
    <nav class="nav-second navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="btn-group w-100" role="group" aria-label="Navigation buttons">
                    <a class="btn btn-dark" href="./siparis/yenimasaac.php">MASA AÇ</a>
                    <a class="btn btn-dark" href="siparisler.php">SİPARİŞLER</a>
                    <a class="btn btn-dark" href="about.php">Hakkımızda</a>
                    <a class="btn btn-dark" href="contact.php">İletişim</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Of Second Navigation --> 