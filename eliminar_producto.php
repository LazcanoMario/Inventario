<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('../conexion.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consultar los datos del producto para obtener el nombre
    $query = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }
}

// Eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eliminar los registros del historial de cambios asociados al producto
    $sql_historial = "DELETE FROM historial_cambios WHERE producto_id = ?";
    $stmt_historial = $conn->prepare($sql_historial);
    $stmt_historial->bind_param("i", $id);
    $stmt_historial->execute();

    // Ahora eliminar el producto de la base de datos
    $delete_query = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Registrar el cambio en el historial de cambios
        $usuario_id = $_SESSION['user_id']; // Obtener el ID del usuario que realizó el cambio
        $accion = 'Eliminar'; // Acción realizada

        // Insertar en la tabla de historial_cambios
        $sql_historial = "INSERT INTO historial_cambios (producto_id, accion, usuario_id) VALUES (?, ?, ?)";
        $stmt_historial = $conn->prepare($sql_historial);
        $stmt_historial->bind_param("isi", $id, $accion, $usuario_id);
        $stmt_historial->execute();

        echo "Producto eliminado con éxito.";
        header("Location: productos.php"); // Redirigir a la lista de productos
        exit();
    } else {
        echo "Error al eliminar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Eliminar Producto</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <p>¿Estás seguro de que deseas eliminar el siguiente producto?</p>
                            <p><strong>Producto: </strong><?php echo htmlspecialchars($producto['nombre']); ?></p>
                            <p><strong>Descripción: </strong><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p><strong>Precio: </strong><?php echo $producto['precio']; ?></p>
                            <p><strong>Cantidad: </strong><?php echo $producto['cantidad']; ?></p>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Eliminar Producto</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="productos.php" class="btn btn-secondary">Volver a la lista de productos</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
