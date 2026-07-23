<?php
    session_start();

    // Giriş yapılmamışsa login sayfasına geri gönder
    if (!isset($_SESSION["admin_id"])) {
        header("Location: login.php");
        exit;
    }

    $page_title = "Panel";
    $active_page = "dashboard";
    include "includes/layout-top.php";
?>

<a href="logout.php" class="cikis-buton">Çıkış Yap</a>

<h1>Hoş geldin, <?php echo htmlspecialchars($_SESSION["admin_kullanici_adi"]); ?>!</h1>
<p class="admin-welcome-sub">Admin paneline başarıyla giriş yaptın. Yönetmek istediğin bölümü seç:</p>

<div class="dash-grid">

    <a href="ayarlar.php" class="dash-card">
        <span class="dash-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo admin_icon('settings'); ?></svg></span>
        <span class="dash-card-title">Ayarları Düzenle</span>
        <span class="dash-card-desc">Site geneli ayarlarını güncelle.</span>
    </a>

    <a href="ozgecmis.php" class="dash-card">
        <span class="dash-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo admin_icon('user'); ?></svg></span>
        <span class="dash-card-title">Özgeçmişi Düzenle</span>
        <span class="dash-card-desc">Özgeçmiş bilgilerini güncel tut.</span>
    </a>

    <a href="haberler.php" class="dash-card">
        <span class="dash-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo admin_icon('news'); ?></svg></span>
        <span class="dash-card-title">Haberleri Yönet</span>
        <span class="dash-card-desc">Haber ekle, düzenle veya sil.</span>
    </a>

    <a href="galeri.php" class="dash-card">
        <span class="dash-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo admin_icon('image'); ?></svg></span>
        <span class="dash-card-title">Galeriyi Yönet</span>
        <span class="dash-card-desc">Galeri görsellerini yönet.</span>
    </a>

    <a href="mesajlar.php" class="dash-card">
        <span class="dash-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo admin_icon('mail'); ?></svg></span>
        <span class="dash-card-title">Gelen Mesajları Görüntüle</span>
        <span class="dash-card-desc">İletişim formundan gelen mesajlar.</span>
    </a>

    <a href="hizmetler.php" class="dash-card">
        <span class="dash-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo admin_icon('layers'); ?></svg></span>
        <span class="dash-card-title">Hizmet Kartlarını Yönet</span>
        <span class="dash-card-desc">Ana sayfadaki hizmet kartlarını düzenle.</span>
    </a>

</div>

<?php include "includes/layout-bottom.php"; ?>