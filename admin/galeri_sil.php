<?php
    session_start();
    if (!isset($_SESSION["admin_id"])) {
        header("Location: login.php");
        exit;
    }

    require_once "../core/Database.php";
    $db = new Database();
    $conn = $db->baglan();

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sorgu = "DELETE FROM galeri WHERE id = :id";
        $stmt = $conn->prepare($sorgu);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    header("Location: galeri.php");
    exit;
?>