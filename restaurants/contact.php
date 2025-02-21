<?php require 'header.php'; ?>

<main class="container py-5">
    <div class="row g-5">
        <!-- İletişim Bilgileri -->
        <div class="col-lg-5">
            <div class="bg-light p-4 rounded-3 shadow-sm">
                <div class="row">
                    <div class="span12">
                        <div class="title-page">
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-4">
                    <div class="icon bg-dark text-white rounded-circle p-3 me-3">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-1" style="margin-left: 10px;">Adres</h5>
                        <p class="text-muted mb-0" style="margin-left: 10px;">Kaynartepe mah. 5 nisan cad. Spor giyim karşısı Dmr Restoran /Bağlar/Diyarbakır</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="icon bg-dark text-white rounded-circle p-3 me-3">
                        <i class="fas fa-phone fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-1" style="margin-left: 10px;">Telefon</h5>
                        <p class="text-muted mb-0" style="margin-left: 10px;">0538 345 4373</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="icon bg-dark text-white rounded-circle p-3 me-3" >
                        <i class="fas fa-envelope fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-1" style="margin-left: 10px;">E-posta</h5>
                        <p class="text-muted mb-0" style="margin-left: 10px;">dmrrestoran@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Bildirim -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="messageToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <!-- Toast mesajı JavaScript ile doldurulacak -->
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- İletişim Formu -->
        <div class="col-lg-7">
            <div class="bg-light p-4 rounded-3 shadow-sm">
                <div class="row">
                    <div class="title-page">
                        <h2 class="title1" style="margin-left: 20px; color:rgb(0, 0, 0); animation: none;">Bize Ulaşın</h2>
                    </div>
                </div>
                
                <form action="sendmail.php" method="POST" id="contactForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Adınız" required>
                                <label for="name">Adınız</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-posta Adresiniz" required>
                                <label for="email">E-posta Adresiniz</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="message" name="message" placeholder="Mesajınız" style="height: 150px;" required></textarea>
                                <label for="message">Mesajınız</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark btn-lg w-100 py-3">
                                <i class="fas fa-paper-plane me-2"></i>Mesaj Gönder
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Toast için JavaScript kodu -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    
    if (status) {
        const toastElement = document.getElementById('messageToast');
        const toastBody = toastElement.querySelector('.toast-body');
        
        // Toast nesnesini oluştururken data-bs-delay özelliğini ayarlayalım
        const toast = new bootstrap.Toast(toastElement, {
            delay: 3000 // 3 saniye (3000 milisaniye)
        });
        
        if (status === 'success') {
            toastElement.classList.add('bg-success');
            toastBody.textContent = 'Mesajınız gönderildi...';
        } else {
            toastElement.classList.add('bg-danger');
            toastBody.textContent = 'Mesaj gönderilirken bir hata oluştu.';
        }
        
        toast.show();
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>

<?php require 'footer.php'; ?> 