# TechHub - Tienda Online
Diagrama arquitectura 
![Arquitectura TechHub](./docs/arquitectura_techhub.png)
Esta es una tienda funcional con estética Cyberpunk/Neón.

Tecnologías utilizadas
* **Lenguaje:** PHP 8.x
* **Base de Datos:** MySQL (PDO para conexiones seguras)
* **Frontend:** HTML5, CSS3 (Estilo Cyber-Flúor)
* **Herramientas:** XAMPP, Git & GitHub

 Características principales
* **Registro de Usuarios:** Con validación de correos duplicados mediante `try-catch`.
* **Login de Seguridad:** Sistema de autenticación con contraseñas encriptadas (`BCRYPT`).
* **Catálogo Dinámico:** Carga de productos desde la base de datos.
* **Interfaz:** Diseño responsivo con paleta de colores cian y magenta.

Instalación
1. Clonar el repositorio.
2. Importar el archivo `script.sql` en phpMyAdmin.
3. Configurar las credenciales en `Clases/database.php`.