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
        // Çoklu dosya geldiğinde $_FILES["fotograflar"] içindeki her alan
        // (name, type, tmp_name, error, size) kendi içinde bir DİZİ olur.
        // Yani $_FILES["fotograflar"]["name"][0], [1], [2] şeklinde erişilir.

        $dosya_sayisi = count($_FILES["fotograflar"]["name"]);

        for ($i = 0; $i < $dosya_sayisi; $i++) {
            if ($_FILES["fotograflar"]["error"][$i] === 0) {
                $orijinal_ad = $_FILES["fotograflar"]["name"][$i];
                $tmp_yol = $_FILES["fotograflar"]["tmp_name"][$i];

                $uzanti = pathinfo($orijinal_ad, PATHINFO_EXTENSION);
                $yeni_ad = "galeri_" . time() . "_" . $i . "." . $uzanti;

                move_uploaded_file($tmp_yol, "../upload/galeri/" . $yeni_ad);

                $sorgu = "INSERT INTO galeri (fotograf) VALUES (:fotograf)";
                $stmt = $conn->prepare($sorgu);
                $stmt->bindParam(":fotograf", $yeni_ad);
                $stmt->execute();
            }
        }

        $basarili = "Fotoğraflar yüklendi.";
    }

    $stmt = $conn->prepare("SELECT * FROM galeri ORDER BY id DESC");
    $stmt->execute();
    $fotograflar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Galeri</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<h1>Galeri Yönetimi</h1>
<p><a href="dashboard.php">← Panele dön</a></p>

<?php if ($basarili): ?>
    <p style="color: green;"><?php echo $basarili; ?></p>
<?php endif; ?>

<h2>Fotoğraf Yükle</h2>
<form method="POST" action="galeri.php" enctype="multipart/form-data">
    <label>Fotoğraflar (birden fazla seçebilirsin):</label><br>
    <input type="file" name="fotograflar[]" multiple><br><br>
    <button type="submit">Yükle</button>
</form>

<hr>

<h2>Mevcut Fotoğraflar</h2>
<div style="display: flex; flex-wrap: wrap; gap: 10px;">
<?php foreach ($fotograflar as $foto): ?>
    <div>
        <img src="upload/galeri/<?php echo $foto["fotograf"]; ?>" width="200" onclick="lightboxAc(this.src)">
    </div>
<?php endforeach; ?>
</div>

<div id="lightbox" class="lightbox" onclick="lightboxKapat()">
    <span class="lightbox-kapat">&times;</span>
    <img id="lightbox-img" src="">
</div>

<script>
    function lightboxAc(kaynak) {
        document.getElementById("lightbox-img").src = kaynak;
        document.getElementById("lightbox").classList.add("acik");
    }

    function lightboxKapat() {
        document.getElementById("lightbox").classList.remove("acik");
    }
</script>

</body>
</html>