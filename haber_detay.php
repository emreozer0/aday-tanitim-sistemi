<?php
    require_once "core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    $stmt = $conn->prepare("SELECT * FROM ayarlar");
    $stmt->execute();
    $satirlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ayarlar = [];
    foreach ($satirlar as $satir) {
        $ayarlar[$satir["anahtar"]] = $satir["deger"];
    }

    // URL'den gelen id'ye göre tek bir haberi çek
    $id = $_GET["id"];
    $stmt = $conn->prepare("SELECT * FROM haberler WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $haber = $stmt->fetch(PDO::FETCH_ASSOC);

    // Haber bulunamadıysa (geçersiz id gönderilirse) ana haberler sayfasına yönlendir
    if (!$haber) {
        header("Location: haberler.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($haber["baslik"]); ?> - <?php echo htmlspecialchars($ayarlar["site_adi"]); ?></title>
</head>
<body>

<header>
    <?php if (!empty($ayarlar["logo"])): ?>
        <img src="upload/logo/<?php echo $ayarlar["logo"]; ?>" alt="Logo" height="80">
    <?php endif; ?>
    <h1><?php echo htmlspecialchars($ayarlar["site_adi"]); ?></h1>
    <nav>
        <a href="index.php">Anasayfa</a> |
        <a href="ozgecmis.php">Özgeçmiş</a> |
        <a href="haberler.php">Haberler</a> |
        <a href="galeri.php">Galeri</a> |
        <a href="iletisim.php">İletişim</a>
    </nav>
</header>

<main>
    <p><a href="haberler.php">← Tüm haberlere dön</a></p>
    <h2><?php echo htmlspecialchars($haber["baslik"]); ?></h2>
    <p><?php echo $haber["tarih"]; ?></p>
    <?php if (!empty($haber["fotograf"])): ?>
        <img src="upload/haberler/<?php echo $haber["fotograf"]; ?>" width="400">
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($haber["icerik"])); ?></p>
</main>

<footer>
    <p>Tel: <?php echo htmlspecialchars($ayarlar["telefon"]); ?></p>
    <p>E-posta: <?php echo htmlspecialchars($ayarlar["eposta"]); ?></p>
    <p>Adres: <?php echo htmlspecialchars($ayarlar["adres"]); ?></p>
</footer>

</body>
</html>