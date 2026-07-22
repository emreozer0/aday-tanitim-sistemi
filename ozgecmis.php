<?php
    require_once "core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    // Ayarları çek (header/footer için her sayfada lazım)
    $stmt = $conn->prepare("SELECT * FROM ayarlar");
    $stmt->execute();
    $satirlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ayarlar = [];
    foreach ($satirlar as $satir) {
        $ayarlar[$satir["anahtar"]] = $satir["deger"];
    }

    // Tam özgeçmişi çek
    $stmt = $conn->prepare("SELECT * FROM ozgecmis WHERE id = 1");
    $stmt->execute();
    $ozgecmis = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Özgeçmiş - <?php echo htmlspecialchars($ayarlar["site_adi"]); ?></title>
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
    <h2>Özgeçmiş</h2>
    <?php if (!empty($ozgecmis["fotograf"])): ?>
        <img src="upload/ozgecmis/<?php echo $ozgecmis["fotograf"]; ?>" width="300">
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($ozgecmis["icerik"])); ?></p>
</main>

<footer>
    <p>Tel: <?php echo htmlspecialchars($ayarlar["telefon"]); ?></p>
    <p>E-posta: <?php echo htmlspecialchars($ayarlar["eposta"]); ?></p>
    <p>Adres: <?php echo htmlspecialchars($ayarlar["adres"]); ?></p>
</footer>

</body>
</html>