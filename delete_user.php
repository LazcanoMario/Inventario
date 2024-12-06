<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol_id'] != 1) {
    header('Location: dashboard.php');
    exit();
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    $delete_query = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header('Location: manage_users.php');
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
} else {
    header('Location: manage_users.php');
    exit();
}
?>
