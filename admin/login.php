<?php
    session_start();
    require_once "../core/Database.php";

    $hata = "";

    // Form gönderildiyse (POST isteği geldiyse)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $kullanici_adi = $_POST["kullanici_adi"];
        $sifre = $_POST["sifre"];

        $db = new Database();
        $conn = $db->baglan();

        $sorgu = "SELECT * FROM admin_kullanicilar WHERE kullanici_adi = :kullanici_adi";
        $stmt = $conn->prepare($sorgu);
        $stmt->bindParam(":kullanici_adi", $kullanici_adi);
        $stmt->execute();

        $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($kullanici && password_verify($sifre, $kullanici["sifre"])) {
            // Şifre doğru, session'a kaydet
            $_SESSION["admin_id"] = $kullanici["id"];
            $_SESSION["admin_kullanici_adi"] = $kullanici["kullanici_adi"];

            header("Location: dashboard.php");
            exit;
        } else {
            $hata = "Kullanıcı adı veya şifre hatalı.";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Girişi</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<h1>Admin Girişi</h1>

<?php if ($hata): ?>
    <p style="color: red;"><?php echo $hata; ?></p>
<?php endif; ?>

<form method="POST" action="login.php">
    <label>Kullanıcı Adı:</label><br>
    <input type="text" name="kullanici_adi"><br><br>

    <label>Şifre:</label><br>
    <input type="password" name="sifre"><br><br>

    <button type="submit">Giriş Yap</button>
</form>

</body>
</html>