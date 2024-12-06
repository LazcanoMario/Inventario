<?php
// Iniciar sesión para verificar el estado del usuario (si es necesario)
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Conexión a la base de datos
include('../conexion.php');

// Consultar los registros del historial
$query = "SELECT hc.*, p.nombre AS producto_nombre, u.nombre AS usuario_nombre 
          FROM historial_cambios hc
          JOIN productos p ON hc.producto_id = p.id
          JOIN usuarios u ON hc.usuario_id = u.id
          ORDER BY hc.fecha DESC"; // Ordenar por fecha (puedes modificar si deseas otro orden)
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cambios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold">Historial de Cambios</h1>
            <p class="text-muted">Consulta los movimientos registrados en el sistema.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg rounded">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Movimientos</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Acción</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['producto_nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['accion']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['usuario_nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center text-muted'>No hay cambios registrados.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="dashboard.php" class="btn btn-primary px-4">Volver al Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
