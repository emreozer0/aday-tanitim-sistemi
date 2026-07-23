<?php
    session_start();
    if (!isset($_SESSION["admin_id"])) {
        header("Location: login.php");
        exit;
    }

    require_once "../core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    $basarili = "";

    // Form gönderildiyse güncelleme yap
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Logo yüklendiyse önce onu işle
        if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] === 0) {
            $uzanti = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
            $logo_adi = "logo_" . time() . "." . $uzanti;
            move_uploaded_file($_FILES["logo"]["tmp_name"], "../upload/logo/" . $logo_adi);

            $stmt = $conn->prepare("UPDATE ayarlar SET deger = :deger WHERE anahtar = 'logo'");
            $stmt->bindParam(":deger", $logo_adi);
            $stmt->execute();
        }

        // Diğer alanları (site_adi, telefon, eposta, adres, sosyal medya) güncelle
        // Not: logo input'u type="file" olduğu için $_POST içine gelmez, bu döngü onu etkilemez
        foreach ($_POST as $anahtar => $deger) {
            $sorgu = "UPDATE ayarlar SET deger = :deger WHERE anahtar = :anahtar";
            $stmt = $conn->prepare($sorgu);
            $stmt->bindParam(":deger", $deger);
            $stmt->bindParam(":anahtar", $anahtar);
            $stmt->execute();
        }

        $basarili = "Ayarlar başarıyla güncellendi.";
    }

    // Güncel ayarları çek (formu doldurmak için)
    $stmt = $conn->prepare("SELECT * FROM ayarlar");
    $stmt->execute();
    $satirlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Diziyi anahtar => deger formatına çeviriyoruz, formda kolay kullanmak için
    $ayarlar = [];
    foreach ($satirlar as $satir) {
        $ayarlar[$satir["anahtar"]] = $satir["deger"];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ayarlar</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<h1>Site Ayarları</h1>
<p><a href="dashboard.php">← Panele dön</a></p>

<?php if ($basarili): ?>
    <p style="color: green;"><?php echo $basarili; ?></p>
<?php endif; ?>

<form method="POST" action="ayarlar.php" enctype="multipart/form-data">

    <?php if (!empty($ayarlar["logo"])): ?>
        <p>Mevcut logo:</p>
        <img src="../upload/logo/<?php echo $ayarlar["logo"]; ?>" width="150"><br>
    <?php endif; ?>

    <label>Logo (değiştirmek istemiyorsan boş bırak):</label><br>
    <input type="file" name="logo"><br><br>

    <label>Site Adı:</label><br>
    <input type="text" name="site_adi" value="<?php echo htmlspecialchars($ayarlar["site_adi"]); ?>"><br><br>

    <label>Öne Çıkan Söz:</label><br>
    <textarea name="soz_metni" rows="3" cols="50"><?php echo htmlspecialchars($ayarlar["soz_metni"]); ?></textarea><br><br>

    <label>Söz Sahibinin Adı:</label><br>
    <input type="text" name="soz_sahibi" value="<?php echo htmlspecialchars($ayarlar["soz_sahibi"]); ?>"><br><br>

    <label>Söz Sahibinin Unvanı:</label><br>
    <input type="text" name="soz_unvan" value="<?php echo htmlspecialchars($ayarlar["soz_unvan"]); ?>"><br><br>

    <label>Telefon:</label><br>
    <input type="text" name="telefon" value="<?php echo htmlspecialchars($ayarlar["telefon"]); ?>"><br><br>

    <label>E-posta:</label><br>
    <input type="text" name="eposta" value="<?php echo htmlspecialchars($ayarlar["eposta"]); ?>"><br><br>

    <label>Adres:</label><br>
    <input type="text" name="adres" value="<?php echo htmlspecialchars($ayarlar["adres"]); ?>"><br><br>

    <label>Facebook:</label><br>
    <input type="text" name="facebook" value="<?php echo htmlspecialchars($ayarlar["facebook"]); ?>"><br><br>

    <label>Twitter:</label><br>
    <input type="text" name="twitter" value="<?php echo htmlspecialchars($ayarlar["twitter"]); ?>"><br><br>

    <label>Instagram:</label><br>
    <input type="text" name="instagram" value="<?php echo htmlspecialchars($ayarlar["instagram"]); ?>"><br><br>

    <button type="submit">Kaydet</button>
</form>

</body>
</html>