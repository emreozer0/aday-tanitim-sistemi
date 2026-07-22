<?php
    session_start();

    // Giriş yapılmamışsa login sayfasına geri gönder
    if (!isset($_SESSION["admin_id"])) {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>

<h1>Hoş geldin, <?php echo $_SESSION["admin_kullanici_adi"]; ?>!</h1>
<p>Admin paneline başarıyla giriş yaptın.</p>
<p><a href="ayarlar.php">Ayarları Düzenle</a></p>
<p><a href="ozgecmis.php">Özgeçmişi Düzenle</a></p>
<p><a href="haberler.php">Haberleri Yönet</a></p>
<p><a href="galeri.php">Galeriyi Yönet</a></p>
<p><a href="mesajlar.php">Gelen Mesajları Görüntüle</a></p>

</body>
</html>