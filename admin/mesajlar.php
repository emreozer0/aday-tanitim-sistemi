<?php
    session_start();
    if (!isset($_SESSION["admin_id"])) {
        header("Location: login.php");
        exit;
    }

    require_once "../core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    // Bir mesaj görüntülendiyse okundu_mu = 1 yap
    if (isset($_GET["okundu_id"])) {
        $id = $_GET["okundu_id"];
        $stmt = $conn->prepare("UPDATE iletisim_mesajlari SET okundu_mu = 1 WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    $stmt = $conn->prepare("SELECT * FROM iletisim_mesajlari ORDER BY gonderim_tarihi DESC");
    $stmt->execute();
    $mesajlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gelen Mesajlar</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<h1>Gelen Mesajlar</h1>
<p><a href="dashboard.php">← Panele dön</a></p>

<?php foreach ($mesajlar as $mesaj): ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; <?php echo $mesaj["okundu_mu"] ? '' : 'background-color: #fffbe6;'; ?>">
        <strong><?php echo $mesaj["ad_soyad"]; ?></strong>
        <?php if (!$mesaj["okundu_mu"]): ?>
            <span style="color: red;"> (Yeni)</span>
        <?php endif; ?>
        <br>
        E-posta: <?php echo $mesaj["eposta"]; ?><br>
        Telefon: <?php echo $mesaj["telefon"]; ?><br>
        Tarih: <?php echo $mesaj["gonderim_tarihi"]; ?><br>
        <p><?php echo $mesaj["mesaj"]; ?></p>
        <?php if (!$mesaj["okundu_mu"]): ?>
            <a href="mesajlar.php?okundu_id=<?php echo $mesaj["id"]; ?>">Okundu olarak işaretle</a>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</body>
</html>