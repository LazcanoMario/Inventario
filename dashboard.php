<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está logueado, redirigir al login
    header('Location: login.php');
    exit();
}

// Obtener el nombre del usuario y su rol
$nombre = $_SESSION['nombre'];
$rol_id = $_SESSION['rol_id'];

// Determinar el rol del usuario
$role = ($rol_id == 1) ? "Administrador" : (($rol_id == 2) ? "Supervisor" : "Usuario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Vincular Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Íconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-4">Bienvenido, <?php echo $nombre; ?></h1>
                <p class="lead">Rol: <span class="badge bg-primary"><?php echo $role; ?></span></p>
                <p>Este es tu panel de control para gestionar el sistema.</p>
            </div>
        </div>

        <!-- Paneles -->
        <div class="row mt-4 g-4">
            <!-- Tarjeta 1 -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-white bg-success shadow-sm h-100">
                    <div class="card-header">
                        <i class="bi bi-box-seam"></i> Estadísticas
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Productos totales</h5>
                        <p class="card-text">Consulta cuántos productos hay en el inventario.</p>
                        <a href="productos.php" class="btn btn-outline-light">Ver productos</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2 -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-white bg-info shadow-sm h-100">
                    <div class="card-header">
                        <i class="bi bi-journal-text"></i> Movimientos
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Historial de movimientos</h5>
                        <p class="card-text">Revisa las entradas y salidas recientes.</p>
                        <a href="historial_cambios.php" class="btn btn-outline-light">Ver movimientos</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3 -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-white bg-warning shadow-sm h-100">
                    <div class="card-header">
                        <i class="bi bi-exclamation-triangle"></i> Bajo Stock
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Productos con bajo stock</h5>
                        <p class="card-text">Consulta los productos con bajo stock.</p>
                        <a href="bajo_stock.php" class="btn btn-outline-light">Ver productos con bajo stock</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta solo para Administradores -->
            <?php if ($rol_id == 1): ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card text-white bg-danger shadow-sm h-100">
                    <div class="card-header">
                        <i class="bi bi-person-fill-gear"></i> Gestión
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Usuarios y roles</h5>
                        <p class="card-text">Administra a los usuarios del sistema.</p>
                        <a href="manage_users.php" class="btn btn-outline-light">Gestionar usuarios</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
