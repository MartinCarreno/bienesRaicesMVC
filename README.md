# BienesRaíces - Proyecto Full-Stack PHP (Arquitectura MVC)

## Descripción

Este es un proyecto personal desarrollado con el objetivo de consolidar mis conocimientos en PHP y el desarrollo de aplicaciones web *full-stack*. Se trata de una plataforma inmobiliaria ("BienesRaíces") que permite visualizar propiedades en venta y gestionarlas a través de un panel de administración seguro.

El gran diferencial de este proyecto es que está construido desde cero aplicando el **patrón de arquitectura MVC (Modelo-Vista-Controlador)** y programación orientada a objetos (POO), lo que garantiza un código modular, escalable y fácil de mantener.

## Stack Tecnológico y Herramientas

### Backend y Base de Datos
*   **PHP (POO & MVC):** Lógica del servidor estructurada con Modelos (bases de datos), Vistas (HTML/UI) y Controladores (lógica de negocio).
*   **Composer:** Gestor de dependencias utilizado para implementar el **autoloading** de clases siguiendo el estándar PSR-4.
*   **MySQL:** Base de datos relacional para gestionar propiedades, usuarios y vendedores.

### Workflow y Frontend
*   **Node.js & Gulp:** Entorno y automatizador de tareas encargado de compilar archivos, minificar código y optimizar recursos gráficos para producción.
*   **SCSS (Sass):** Preprocesador CSS para una arquitectura de estilos limpia y mantenible (soporte nativo para *Modo Oscuro* y *Modo Claro*).

## Características Principales

*   **Arquitectura MVC Propia:** Framework MVC construido desde cero, incluyendo un enrutador (Router) personalizado.
*   **Sistema de Autenticación:** Login seguro para administradores.
*   **Panel de Administración (CRUD):**
    *   Gestión completa de Propiedades (crear, editar, eliminar, subida de imágenes optimizadas).
    *   Gestión de Vendedores asignados.
*   **UI Responsiva:** Diseño adaptable con modo oscuro integrado.

## Vistas del Proyecto

A continuación se detallan las interfaces principales del sistema:

### 1. Página de Incio
Pestaña donde el usuario ya sea comprador o administrador pueden ver las distintas casas de la inmobiliaria
![Página Principal Inmobiliaria](https://github.com/MartinCarreno/bienesRaicesMVC/raw/main/imagenesApp/Bienes%20Raices%20Inicio.jpg)


### 2. Sistema de Autenticación
Panel de acceso protegido para el personal administrativo.
![Panel de Iniciar Sesión](https://github.com/MartinCarreno/bienesRaicesMVC/raw/main/imagenesApp/Bienes%20Raices%20Admin%20Incio.png)

### 3. Panel de Administración (Dashboard CRUD)
Vista general donde el administrador puede gestionar los registros de la base de datos de propiedades y vendedores.
![Dashboard de Administración](https://github.com/MartinCarreno/bienesRaicesMVC/raw/main/imagenesApp/Bienes%20Raices%20Panel%20de%20Admin.png)

---

## Autor

*   **Martín Carreño** - *Desarrollador* - [GitHub Perfil](https://github.com/MartinCarreno)
