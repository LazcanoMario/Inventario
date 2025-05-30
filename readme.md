# TerMic

**TerMic** es un sistema de monitoreo y control para tanques de laboratorio diseñado para observar y gestionar variables críticas como temperatura, sanidad del agua (pH, oxígeno, salinidad, nivel), y alertas por fallas de componentes. Está enfocado en el manejo del **shock térmico en moluscos** para agilizar su reproducción.

Desarrollado como parte de un proyecto académico del **Instituto Tecnológico de Ensenada**, TerMic permite automatizar procesos térmicos, visualizar datos en tiempo real, registrar históricos y gestionar roles de usuario mediante una interfaz gráfica intuitiva.

---

## 🚀 Tecnologías Utilizadas

| Área         | Tecnologías                        |
|--------------|------------------------------------|
| **Frontend** | HTML5, CSS3, Bootstrap, JavaScript |
| **Backend**  | PHP                                |
| **Hardware** | Arduino, Celdas Peltier, Sensores DS18B20 |
| **Base de Datos** | MySQL / MariaDB              |

---

## ⚙️ Requisitos de Instalación

### Entorno de servidor recomendado:

- [XAMPP](https://www.apachefriends.org/es/index.html) (recomendado)  
O bien:
- MAMP
- Laragon
- Un servidor Linux con Apache/Nginx

### Componentes necesarios:

| Componente     | Versión mínima | Descripción                              |
|----------------|----------------|------------------------------------------|
| PHP            | 7.4            | Para ejecutar scripts del backend        |
| MySQL/MariaDB  | 5.7+           | Para almacenamiento de datos             |
| Apache/Nginx   | Cualquiera     | Servidor web                             |
| Bootstrap      | 5.x (CDN)      | Para estilos responsivos                 |
| PHPMyAdmin     | Opcional       | Para gestión visual de base de datos     |

---

## 🗃️ Estructura de la Base de Datos: `tanques_db`

### Tablas:

- `datos_acondicionamiento`
- `datos_alertas`
- `datos_graficas_acondicionamiento`
- `datos_graficas_alertas`
- `datos_historial_temperatura`
- `datos_tanques`
- `usuarios`

---

### 📊 Estructura de Tablas

#### `datos_acondicionamiento`

| Campo       | Tipo         |
|-------------|--------------|
| id          | INT, PK, AUTO_INCREMENT |
| temperatura | DECIMAL(4,1) |
| salinidad   | DECIMAL(4,1) |
| ph          | DECIMAL(4,2) |
| oxigeno     | DECIMAL(4,1) |
| bomba       | DECIMAL(5,1) |
| nivel_agua  | DECIMAL(5,1) |
| uv          | VARCHAR(10)  |
| horas_uv    | INT(11)      |

---

#### `datos_alertas`

| Campo   | Tipo      |
|---------|-----------|
| id      | INT, PK, AUTO_INCREMENT |
| tanque  | INT(11)   |
| fecha   | DATE      |
| hora    | TIME      |
| detalles| TEXT      |

---

#### `datos_graficas_acondicionamiento`

| Campo     | Tipo         |
|-----------|--------------|
| id        | INT, PK, AUTO_INCREMENT |
| hora      | TIME         |
| salinidad | DECIMAL(4,1) |
| oxigeno   | DECIMAL(4,1) |
| ph        | DECIMAL(4,2) |

---

#### `datos_graficas_alertas`

| Campo   | Tipo          |
|---------|---------------|
| id      | INT, PK, AUTO_INCREMENT |
| fecha   | DATE          |
| hora    | TIME          |
| tipo    | VARCHAR(20)   |
| titulo  | VARCHAR(100)  |
| detalles| TEXT          |
| duracion| VARCHAR(20)   |

---

#### `datos_historial_temperatura`

| Campo       | Tipo            |
|-------------|-----------------|
| id          | INT, PK, AUTO_INCREMENT |
| tanque      | INT(11)         |
| fecha       | DATE            |
| hora        | TIME            |
| temperatura | DECIMAL(4,1)    |
| alerta      | ENUM('si','no') DEFAULT 'no' |

---

#### `datos_tanques`

| Campo         | Tipo         |
|---------------|--------------|
| id            | INT, PK, AUTO_INCREMENT |
| tanque        | INT(11)      |
| temperatura   | DECIMAL(4,1) |
| estado        | VARCHAR(20)  |
| proximo_shock | TIME         |

---

#### `usuarios`

| Campo      | Tipo         |
|------------|--------------|
| id         | INT, PK, AUTO_INCREMENT |
| correo     | VARCHAR(255), UNIQUE |
| contrasena | VARCHAR(255) |
| creado_en  | TIMESTAMP DEFAULT CURRENT_TIMESTAMP |

---

## 👥 Integrantes del Proyecto

- Juan Manuel Aguilar Cañas – 22760305  
- Julio Gorosave Osuna – 22760242  
- Mario Antonio Lazcano Butcher – 22760908  
- Secundino Salinas Ximena Monserrat – 22760247  

---

## 📄 Documentación

Puedes consultar el documento oficial del proyecto aquí:  
[🔗 Documento Google Docs](https://docs.google.com/document/d/15hHVSmx6Gx1DyM3_B5P0TxtX-uWLP8DGWPVq2k5Yhx8/edit?tab=t.0)

---

