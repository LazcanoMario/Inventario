<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('../conexion.php');

// Verificar si se ha enviado una búsqueda
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = "%" . $_GET['search'] . "%"; // Preparamos la búsqueda (con % para hacer la búsqueda más flexible)
    $sql = "SELECT * FROM productos WHERE nombre LIKE ?"; // Filtramos los productos por nombre
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchQuery); // Ligamos el parámetro de búsqueda
} else {
    $sql = "SELECT * FROM productos"; // Si no hay búsqueda, mostramos todos los productos
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Íconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    
    <div class="container mt-4">
        <h2 class="text-center">Listado de Productos</h2>

        <!-- Formulario de búsqueda -->
        <form class="d-flex justify-content-center mb-4" method="GET" action="productos.php">
            <input type="text" class="form-control w-50 me-2" id="searchInput" name="search" placeholder="Buscar producto" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-outline-success" type="submit">
                <i class="bi bi-search"></i> Buscar
            </button>
            <a href="productos.php" class="btn btn-outline-secondary ms-2">
                <i class="bi bi-x-circle"></i> Limpiar
            </a>
        </form>

        <!-- Botón flotante para agregar un producto -->
        <a href="agregar_producto.php" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Agregar Producto
        </a>

        <!-- Tabla de productos -->
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="<?php echo ($row['cantidad'] < 5) ? 'table-danger' : ''; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                                <td><?php echo number_format($row['precio'], 2); ?> $</td>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td>
                                    <a href="editar_producto.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <a href="eliminar_producto.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No hay productos disponibles en este momento.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
