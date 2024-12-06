# InventarioRequisitos del Sistema
Hardware
Procesador: Intel i3 o superior.
Memoria RAM: 4 GB mínimo.
Espacio en Disco: 1 GB mínimo.
Software
PHP: >= 7.4.
MySQL: >= 5.7.
Servidor Web: Apache (recomendado) o Nginx.
Sistema Operativo: Windows, Linux, o macOS.
Extensiones de PHP: mysqli.
Instrucciones de Instalación y Despliegue

1. Clonar el Repositorio
Asegúrate de tener Git instalado en tu máquina.
Clona este repositorio ejecutando:
bash
Copiar código
git clone https://github.com/LazcanoMario/Inventario.git
cd [CARPETA_DEL_PROYECTO]

2. Configurar la Base de Datos
Crea una base de datos en MySQL con el nombre que prefieras.
sql
Copiar código
CREATE DATABASE gestion_inventarios;
Importa el archivo de configuración inicial:
bash
Copiar código
mysql -u [USUARIO] -p gestion_inventarios < database.sql
Reemplaza [USUARIO] con tu usuario de MySQL y proporciona tu contraseña si es necesario.

3. Configurar el Archivo de Conexión
Abre el archivo conexion.php en la carpeta raíz del proyecto.
Ajusta los valores según tu configuración:
php
Copiar código
$conn = new mysqli('localhost', 'USUARIO', 'CONTRASEÑA', 'NOMBRE_BASE_DATOS');
localhost: Dirección del servidor (por defecto es localhost para entornos locales).
USUARIO: Tu usuario de MySQL.
CONTRASEÑA: Tu contraseña de MySQL.
NOMBRE_BASE_DATOS: Nombre de la base de datos que creaste (por ejemplo, gestion_inventarios).

4. Configurar el Servidor Web
Asegúrate de que tu servidor web esté instalado y configurado. Por ejemplo, si usas XAMPP:
Copia los archivos del proyecto a la carpeta htdocs (normalmente ubicada en C:\xampp\htdocs en Windows).
Accede a la aplicación en tu navegador en http://localhost/[CARPETA_DEL_PROYECTO].
Si usas un servidor web personalizado:
Configura un host virtual apuntando al directorio del proyecto.
Reinicia tu servidor web para aplicar los cambios.
5. Configurar Permisos (Linux)
Si estás trabajando en Linux, asegúrate de que el servidor web tenga acceso al directorio del proyecto:

bash
Copiar código
sudo chown -R www-data:www-data /ruta/del/proyecto
sudo chmod -R 755 /ruta/del/proyecto

6. Iniciar la Aplicación
Abre tu navegador y ve a la URL de tu proyecto:
Por ejemplo: http://localhost/[CARPETA_DEL_PROYECTO]/login.php.
Ingresa las credenciales de un usuario registrado para iniciar sesión.
Si no tienes usuarios, registra uno accediendo al formulario de registro.
7. Despliegue en un Servidor
Si deseas desplegar en un servidor remoto:

Sube los archivos del proyecto al servidor usando FTP, SFTP, o un servicio como Git.
Configura la base de datos en el servidor remoto y ajusta conexion.php con las credenciales remotas.
Configura el dominio o subdominio apuntando al directorio del proyecto.
Asegúrate de que el servidor tenga las extensiones necesarias (como mysqli).
Notas Adicionales
Roles de Usuario:
Administrador: Acceso total.
Supervisor/Usuario: Permisos restringidos.
Alerta de Bajo Stock: Se muestra automáticamente para productos con cantidades inferiores al umbral definido.



Base de datos sugerida
Base de datos a utilizar : 


CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);


CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);


CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    fecha_expiracion DATE,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);


CREATE TABLE movimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    tipo ENUM('entrada', 'salida') NOT NULL,
    cantidad INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE historial_cambios ( id INT AUTO_INCREMENT PRIMARY KEY, producto_id INT, accion VARCHAR(50), -- 'Agregar', 'Editar', 'Eliminar' usuario_id INT, -- El id del usuario que realizó el cambio fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- La fecha en que ocurrió el cambio FOREIGN KEY (producto_id) REFERENCES productos(id), FOREIGN KEY (usuario_id) REFERENCES usuarios(id) );
Partimos de estos datos 
	

-- Población inicial de roles
INSERT INTO roles (nombre) VALUES 
('Administrador'), 
('Supervisor'), 
('Usuario');

-- Población inicial de categorías (opcional, ajusta según el proyecto)
INSERT INTO categorias (nombre) VALUES 
('Electrónicos'), 
('Alimentos'), 
('Ropa');




Créditos
Desarrolladores: Ximena Y Mario
Fecha de Creación: 05/12/2024.

