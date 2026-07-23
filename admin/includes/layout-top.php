<?php
/**
 * Ortak admin layout - üst kısım (sidebar + topbar açılışı)
 * Her admin sayfasında session_start() ve giriş kontrolünden SONRA
 * şu şekilde include edilir:
 *
 *   $page_title = "Sayfa Başlığı";
 *   $active_page = "dashboard"; // menüde hangi link aktif görünsün
 *   include "includes/layout-top.php";
 *
 * Sayfa içeriği bittikten sonra da:
 *   include "includes/layout-bottom.php";
 */

if (!isset($page_title)) { $page_title = "Admin Panel"; }
if (!isset($active_page)) { $active_page = ""; }

$menu = [
    "dashboard"  => ["label" => "Panel",                 "url" => "dashboard.php",  "icon" => "grid"],
    "ayarlar"    => ["label" => "Ayarları Düzenle",       "url" => "ayarlar.php",    "icon" => "settings"],
    "ozgecmis"   => ["label" => "Özgeçmişi Düzenle",      "url" => "ozgecmis.php",   "icon" => "user"],
    "haberler"   => ["label" => "Haberleri Yönet",        "url" => "haberler.php",   "icon" => "news"],
    "galeri"     => ["label" => "Galeriyi Yönet",         "url" => "galeri.php",     "icon" => "image"],
    "mesajlar"   => ["label" => "Gelen Mesajlar",         "url" => "mesajlar.php",   "icon" => "mail"],
    "hizmetler"  => ["label" => "Hizmet Kartlarını Yönet","url" => "hizmetler.php",  "icon" => "layers"],
];

function admin_icon($name) {
    $icons = [
        "grid"     => '<path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/>',
        "settings" => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
        "user"     => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        "news"     => '<path d="M4 4h13a2 2 0 0 1 2 2v13a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2V4z"/><path d="M8 8h6M8 12h6M8 16h3"/>',
        "image"    => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>',
        "mail"     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/>',
        "layers"   => '<path d="m12 2 9 5-9 5-9-5 9-5z"/><path d="m3 12 9 5 9-5"/><path d="m3 17 9 5 9-5"/>',
        "logout"   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
    ];
    return $icons[$name] ?? '';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($page_title); ?> · Admin Panel</title>
<link rel="stylesheet" href="admin-style.css">
</head>
<body>

<div class="admin-shell">

    

    <div class="admin-main">

        <main class="admin-content">