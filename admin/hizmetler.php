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
        $sira = $_POST["sira"];

        $sorgu = "INSERT INTO hizmet_kartlari (baslik, sira) VALUES (:baslik, :sira)";
        $stmt = $conn->prepare($sorgu);
        $stmt->bindParam(":baslik", $baslik);
        $stmt->bindParam(":sira", $sira);
        $stmt->execute();

        $basarili = "Kart eklendi.";
    }

    $stmt = $conn->prepare("SELECT * FROM hizmet_kartlari ORDER BY sira ASC");
    $stmt->execute();
    $kartlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hizmet Kartları</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<h1>Hizmet/Politika Kartları</h1>
<p><a href="dashboard.php">← Panele dön</a></p>

<?php if ($basarili): ?>
    <p style="color: green;"><?php echo $basarili; ?></p>
<?php endif; ?>

<h2>Yeni Kart Ekle</h2>
<form method="POST" action="hizmetler.php">
    <label>Başlık:</label><br>
    <input type="text" name="baslik" required><br><br>

    <label>Sıra (küçük sayı önce gösterilir):</label><br>
    <input type="text" name="sira" value="0"><br><br>

    <button type="submit">Ekle</button>
</form>

<hr>

<h2>Mevcut Kartlar</h2>
<?php foreach ($kartlar as $kart): ?>
    <div>
        <strong><?php echo htmlspecialchars($kart["baslik"]); ?></strong> (Sıra: <?php echo $kart["sira"]; ?>)
        <a href="hizmet_sil.php?id=<?php echo $kart["id"]; ?>" onclick="return confirm('Silmek istediğine emin misin?');">Sil</a>
    </div>
<?php endforeach; ?>

</body>
</html>