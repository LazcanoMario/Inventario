<?php
// Conexión a la base de datos
include('../conexion.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consultar los datos del producto
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

// Suponiendo que tienes un sistema de usuario con un `usuario_id` que indica el ID del usuario que hace el cambio.
// Necesitas obtener el ID del usuario actual. Por ahora, lo simulamos como un ejemplo:
$usuario_id = 1; // Esto debe ser reemplazado por el ID real del usuario logueado.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);
    $categoria_id = intval($_POST['categoria_id']);

    // 1. Actualizar el producto
    $update_query = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, cantidad = ?, categoria_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $cantidad, $categoria_id, $id);

    if ($stmt->execute()) {
        // 2. Registrar la acción en el historial
        $accion = 'Editar'; // Puedes personalizar más el tipo de acción si es necesario

        $sql_historial = "INSERT INTO historial_cambios (producto_id, accion, usuario_id) VALUES (?, ?, ?)";
        $stmt_historial = $conn->prepare($sql_historial);
        $stmt_historial->bind_param("isi", $id, $accion, $usuario_id);

        if ($stmt_historial->execute()) {
            echo "Producto actualizado y acción registrada en el historial.";
            header("Location: productos.php"); // Redirigir a la lista de productos
            exit();
        } else {
            echo "Error al registrar el historial de cambios.";
        }
    } else {
        echo "Error al actualizar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Editar Producto</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" step="0.01" 
                                   value="<?php echo $producto['precio']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                   value="<?php echo $producto['cantidad']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id" required>
                                <?php
                                // Obtener categorías
                                $categorias_query = "SELECT * FROM categorias";
                                $categorias_result = $conn->query($categorias_query);
                                while ($categoria = $categorias_result->fetch_assoc()) {
                                    $selected = $producto['categoria_id'] == $categoria['id'] ? 'selected' : '';
                                    echo "<option value='{$categoria['id']}' $selected>{$categoria['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Actualizar Producto</button>
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
