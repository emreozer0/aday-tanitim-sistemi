<?php
    require_once "core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    // Ayarları çek
    $stmt = $conn->prepare("SELECT * FROM ayarlar");
    $stmt->execute();
    $satirlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ayarlar = [];
    foreach ($satirlar as $satir) {
        $ayarlar[$satir["anahtar"]] = $satir["deger"];
    }

    // Özgeçmişi çek
    $stmt = $conn->prepare("SELECT * FROM ozgecmis WHERE id = 1");
    $stmt->execute();
    $ozgecmis = $stmt->fetch(PDO::FETCH_ASSOC);

    // Son 3 haberi çek
    $stmt = $conn->prepare("SELECT * FROM haberler ORDER BY tarih DESC LIMIT 3");
    $stmt->execute();
    $son_haberler = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($ayarlar["site_adi"]); ?></title>
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
    <section>
        <h2>Hakkımda</h2>
        <?php if (!empty($ozgecmis["fotograf"])): ?>
            <img src="upload/ozgecmis/<?php echo $ozgecmis["fotograf"]; ?>" width="200">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars(substr($ozgecmis["icerik"], 0, 200))); ?>...</p>
        <a href="ozgecmis.php">Devamını Oku</a>
    </section>

    <section>
        <h2>Son Haberler</h2>
        <?php foreach ($son_haberler as $haber): ?>
            <div>
                <?php if (!empty($haber["fotograf"])): ?>
                    <img src="upload/haberler/<?php echo $haber["fotograf"]; ?>" width="150">
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($haber["baslik"]); ?></h3>
                <p><?php echo $haber["tarih"]; ?></p>
            </div>
        <?php endforeach; ?>
        <a href="haberler.php">Tüm Haberler</a>
    </section>
</main>

<footer>
    <p>Tel: <?php echo htmlspecialchars($ayarlar["telefon"]); ?></p>
    <p>E-posta: <?php echo htmlspecialchars($ayarlar["eposta"]); ?></p>
    <p>Adres: <?php echo htmlspecialchars($ayarlar["adres"]); ?></p>
</footer>

</body>
</html>