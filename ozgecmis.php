<?php
    require_once "core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    // Ayarları çek (header/footer için her sayfada lazım)
    $stmt = $conn->prepare("SELECT * FROM ayarlar");
    $stmt->execute();
    $satirlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ayarlar = [];
    foreach ($satirlar as $satir) {
        $ayarlar[$satir["anahtar"]] = $satir["deger"];
    }

    // Tam özgeçmişi çek
    $stmt = $conn->prepare("SELECT * FROM ozgecmis WHERE id = 1");
    $stmt->execute();
    $ozgecmis = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Özgeçmiş - <?php echo htmlspecialchars($ayarlar["site_adi"]); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
    <h2>Özgeçmiş</h2>
    <?php if (!empty($ozgecmis["fotograf"])): ?>
        <img src="upload/ozgecmis/<?php echo $ozgecmis["fotograf"]; ?>" width="300">
    <?php endif; ?>
    <p><?php echo nl2br(htmlspecialchars($ozgecmis["icerik"])); ?></p>
</main>

<footer>
    <p>Tel: <?php echo htmlspecialchars($ayarlar["telefon"]); ?></p>
    <p>E-posta: <?php echo htmlspecialchars($ayarlar["eposta"]); ?></p>
    <p>Adres: <?php echo htmlspecialchars($ayarlar["adres"]); ?></p>

    <div class="sosyal-medya">
        <?php if (!empty($ayarlar["facebook"])): ?>
            <a href="<?php echo htmlspecialchars($ayarlar["facebook"]); ?>" target="_blank">
                <svg viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15h-2.4v-3H10V9.5C10 7.16 11.66 6 13.68 6c.96 0 1.96.17 1.96.17v2.2h-1.1c-1.08 0-1.42.67-1.42 1.36V12h2.42l-.39 3H13.1v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
            </a>
        <?php endif; ?>
        <?php if (!empty($ayarlar["twitter"])): ?>
            <a href="<?php echo htmlspecialchars($ayarlar["twitter"]); ?>" target="_blank">
                <svg viewBox="0 0 24 24"><path d="M22 5.9c-.77.35-1.6.58-2.46.68.88-.53 1.56-1.37 1.88-2.37-.83.49-1.75.85-2.72 1.04A4.28 4.28 0 0 0 15.4 4c-2.37 0-4.29 1.94-4.29 4.33 0 .34.04.67.11.98C7.69 9.14 4.07 7.15 1.64 4.16c-.38.66-.6 1.43-.6 2.25 0 1.5.75 2.83 1.9 3.6-.7-.02-1.36-.22-1.94-.55v.06c0 2.1 1.48 3.85 3.44 4.25-.36.1-.74.15-1.13.15-.28 0-.55-.03-.81-.08.55 1.72 2.14 2.97 4.02 3-1.47 1.16-3.33 1.85-5.35 1.85-.35 0-.69-.02-1.03-.06C2.28 20.29 4.53 21 6.95 21c7.13 0 11.03-5.97 11.03-11.14 0-.17 0-.34-.01-.5.76-.55 1.42-1.24 1.94-2.03-.7.31-1.45.52-2.24.62z"/></svg>
            </a>
        <?php endif; ?>
        <?php if (!empty($ayarlar["instagram"])): ?>
            <a href="<?php echo htmlspecialchars($ayarlar["instagram"]); ?>" target="_blank">
                <svg viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85C2.38 3.9 3.9 2.38 7.15 2.23 8.42 2.17 8.8 2.16 12 2.16zM12 0C8.74 0 8.33.01 7.05.07c-4.35.2-6.78 2.62-6.98 6.98C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95C23.73 2.7 21.3.27 16.95.07 15.67.01 15.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 12 18.16 6.16 6.16 0 0 0 12 5.84zm0 10.16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.41-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
            </a>
        <?php endif; ?>
    </div>
</footer>
</body>
</html>