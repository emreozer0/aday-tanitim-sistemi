<?php
    require_once "core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    // Ayarları çek (header/footer için)
    $stmt = $conn->prepare("SELECT * FROM ayarlar");
    $stmt->execute();
    $satirlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ayarlar = [];
    foreach ($satirlar as $satir) {
        $ayarlar[$satir["anahtar"]] = $satir["deger"];
    }

    $basarili = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $ad_soyad = $_POST["ad_soyad"];
        $eposta = $_POST["eposta"];
        $telefon = $_POST["telefon"];
        $mesaj = $_POST["mesaj"];

        $sorgu = "INSERT INTO iletisim_mesajlari (ad_soyad, eposta, telefon, mesaj) VALUES (:ad_soyad, :eposta, :telefon, :mesaj)";
        $stmt = $conn->prepare($sorgu);
        $stmt->bindParam(":ad_soyad", $ad_soyad);
        $stmt->bindParam(":eposta", $eposta);
        $stmt->bindParam(":telefon", $telefon);
        $stmt->bindParam(":mesaj", $mesaj);
        $stmt->execute();

        $basarili = "Mesajınız gönderildi, teşekkür ederiz.";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>İletişim - <?php echo htmlspecialchars($ayarlar["site_adi"]); ?></title>
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
    <h2>İletişim</h2>

    <?php if ($basarili): ?>
        <p style="color: green;"><?php echo $basarili; ?></p>
    <?php endif; ?>

    <form method="POST" action="iletisim.php">
        <label>Ad Soyad:</label><br>
        <input type="text" name="ad_soyad" required><br><br>

        <label>E-posta:</label><br>
        <input type="email" name="eposta" required><br><br>

        <label>Telefon:</label><br>
        <input type="text" name="telefon"><br><br>

        <label>Mesaj:</label><br>
        <textarea name="mesaj" rows="5" cols="50" required></textarea><br><br>

        <button type="submit">Gönder</button>
    </form>
</main>

<footer>
    <p>Tel: <?php echo htmlspecialchars($ayarlar["telefon"]); ?></p>
    <p>E-posta: <?php echo htmlspecialchars($ayarlar["eposta"]); ?></p>
    <p>Adres: <?php echo htmlspecialchars($ayarlar["adres"]); ?></p>
</footer>

</body>
</html>