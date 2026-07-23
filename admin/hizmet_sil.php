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
        $stmt = $conn->prepare("DELETE FROM hizmet_kartlari WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    header("Location: hizmetler.php");
    exit;
?>