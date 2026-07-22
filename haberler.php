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

    // Tüm haberleri çek
    $stmt = $conn->prepare("SELECT * FROM haberler ORDER BY tarih DESC");
    $stmt->execute();
    $haberler = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Haberler - <?php echo htmlspecialchars($ayarlar["site_adi"]); ?></title>
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
    <h2>Haberler</h2>
    <?php foreach ($haberler as $haber): ?>
        <div>
            <?php if (!empty($haber["fotograf"])): ?>
                <img src="upload/haberler/<?php echo $haber["fotograf"]; ?>" width="150">
            <?php endif; ?>
            <h3><a href="haber-detay.php?id=<?php echo $haber["id"]; ?>"><?php echo htmlspecialchars($haber["baslik"]); ?></a></h3>
            <p><?php echo $haber["tarih"]; ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
</main>

<footer>
    <p>Tel: <?php echo htmlspecialchars($ayarlar["telefon"]); ?></p>
    <p>E-posta: <?php echo htmlspecialchars($ayarlar["eposta"]); ?></p>
    <p>Adres: <?php echo htmlspecialchars($ayarlar["adres"]); ?></p>
</footer>

</body>
</html>