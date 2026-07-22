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
    $hata = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $icerik = $_POST["icerik"];
        $fotograf_adi = null;

        // Fotoğraf yüklendi mi kontrol et
        if (isset($_FILES["fotograf"]) && $_FILES["fotograf"]["error"] === 0) {
            $uzanti = pathinfo($_FILES["fotograf"]["name"], PATHINFO_EXTENSION);
            $fotograf_adi = "ozgecmis_" . time() . "." . $uzanti;
            $hedef_yol = "../upload/ozgecmis/" . $fotograf_adi;

            move_uploaded_file($_FILES["fotograf"]["tmp_name"], $hedef_yol);
        }

        // Fotoğraf yüklendiyse, veritabanında da fotoğraf alanını güncelle
        // Yüklenmediyse (kullanıcı sadece metni değiştirdiyse) eski fotoğrafı koru
        if ($fotograf_adi) {
            $sorgu = "UPDATE ozgecmis SET icerik = :icerik, fotograf = :fotograf WHERE id = 1";
            $stmt = $conn->prepare($sorgu);
            $stmt->bindParam(":icerik", $icerik);
            $stmt->bindParam(":fotograf", $fotograf_adi);
        } else {
            $sorgu = "UPDATE ozgecmis SET icerik = :icerik WHERE id = 1";
            $stmt = $conn->prepare($sorgu);
            $stmt->bindParam(":icerik", $icerik);
        }

        $stmt->execute();
        $basarili = "Özgeçmiş güncellendi.";
    }

    // Mevcut veriyi çek
    $stmt = $conn->prepare("SELECT * FROM ozgecmis WHERE id = 1");
    $stmt->execute();
    $veri = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Özgeçmiş</title>
</head>
<body>

<h1>Özgeçmiş Yönetimi</h1>
<p><a href="dashboard.php">← Panele dön</a></p>

<?php if ($basarili): ?>
    <p style="color: green;"><?php echo $basarili; ?></p>
<?php endif; ?>

<?php if ($veri["fotograf"]): ?>
    <p>Mevcut fotoğraf:</p>
    <img src="../upload/ozgecmis/<?php echo $veri["fotograf"]; ?>" width="200">
<?php endif; ?>

<form method="POST" action="ozgecmis.php" enctype="multipart/form-data">
    <label>Fotoğraf (değiştirmek istemiyorsan boş bırak):</label><br>
    <input type="file" name="fotograf"><br><br>

    <label>Özgeçmiş Metni:</label><br>
    <textarea name="icerik" rows="10" cols="50"><?php echo htmlspecialchars($veri["icerik"]); ?></textarea><br><br>

    <button type="submit">Kaydet</button>
</form>

</body>
</html>