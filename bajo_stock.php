<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está logueado, redirigir al login
    header('Location: login.php');
    exit();
}

include('../conexion.php');

// Establecer el umbral de bajo stock
$umbral_stock = 10; // Puedes ajustar este número según tus necesidades

// Consultar los productos con bajo stock
$query = "SELECT * FROM productos WHERE cantidad < ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $umbral_stock);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos con Bajo Stock</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('navbar.php'); ?>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded">
                    <div class="card-header bg-danger text-white text-center">
                        <h4 class="mb-0">Productos con Bajo Stock</h4>
                    </div>
                    <div class="card-body">
                        <!-- Alerta de bajo stock -->
                        <?php if ($result->num_rows > 0): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>¡Atención!</strong> Hay productos con bajo stock:
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success text-center" role="alert">
                                Todos los productos tienen un nivel de stock adecuado.
                            </div>
                        <?php endif; ?>

                        <!-- Tabla de productos -->
                        <table class="table table-bordered table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['cantidad']) . "</td>";
                                        echo "<td>$" . number_format($row['precio'], 2) . "</td>";
                                        echo "<td class='text-center'>";
                                        echo "<a href='editar_producto.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm me-1'>Editar</a>";
                                        echo "<a href='eliminar_producto.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este producto?\");'>Eliminar</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No hay productos con bajo stock.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
