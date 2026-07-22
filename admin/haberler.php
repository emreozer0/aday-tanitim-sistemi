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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $baslik = $_POST["baslik"];
        $icerik = $_POST["icerik"];
        $tarih = $_POST["tarih"];
        $fotograf_adi = null;

        if (isset($_FILES["fotograf"]) && $_FILES["fotograf"]["error"] === 0) {
            $uzanti = pathinfo($_FILES["fotograf"]["name"], PATHINFO_EXTENSION);
            $fotograf_adi = "haber_" . time() . "." . $uzanti;
            move_uploaded_file($_FILES["fotograf"]["tmp_name"], "../upload/haberler/" . $fotograf_adi);
        }

        $sorgu = "INSERT INTO haberler (baslik, icerik, fotograf, tarih) VALUES (:baslik, :icerik, :fotograf, :tarih)";
        $stmt = $conn->prepare($sorgu);
        $stmt->bindParam(":baslik", $baslik);
        $stmt->bindParam(":icerik", $icerik);
        $stmt->bindParam(":fotograf", $fotograf_adi);
        $stmt->bindParam(":tarih", $tarih);
        $stmt->execute();

        $basarili = "Haber eklendi.";
    }

    $stmt = $conn->prepare("SELECT * FROM haberler ORDER BY tarih DESC");
    $stmt->execute();
    $haberler = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Haberler</title>
</head>
<body>

<h1>Haber Yönetimi</h1>
<p><a href="dashboard.php">← Panele dön</a></p>

<?php if ($basarili): ?>
    <p style="color: green;"><?php echo $basarili; ?></p>
<?php endif; ?>

<h2>Yeni Haber Ekle</h2>
<form method="POST" action="haberler.php" enctype="multipart/form-data">
    <label>Başlık:</label><br>
    <input type="text" name="baslik" required><br><br>

    <label>İçerik:</label><br>
    <textarea name="icerik" rows="5" cols="50"></textarea><br><br>

    <label>Tarih:</label><br>
    <input type="date" name="tarih" required><br><br>

    <label>Fotoğraf:</label><br>
    <input type="file" name="fotograf"><br><br>

    <button type="submit">Ekle</button>
</form>

<hr>

<h2>Mevcut Haberler</h2>
<?php foreach ($haberler as $haber): ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
        <?php if ($haber["fotograf"]): ?>
            <img src="../upload/haberler/<?php echo $haber["fotograf"]; ?>" width="150"><br>
        <?php endif; ?>
        <strong><?php echo $haber["baslik"]; ?></strong> - <?php echo $haber["tarih"]; ?>
        <p><?php echo $haber["icerik"]; ?></p>
        <a href="haber_sil.php?id=<?php echo $haber["id"]; ?>" onclick="return confirm('Silmek istediğine emin misin?');">Sil</a>
    </div>
<?php endforeach; ?>

</body>
</html>