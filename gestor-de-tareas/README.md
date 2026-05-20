# Gestor de Tareas MVC — Práctica 8

Aplicación web de gestión de tareas construida con PHP puro aplicando el patrón **MVC** (Modelo–Vista–Controlador). No requiere base de datos: los datos persisten en sesión durante la sesión activa.

## Usuarios de prueba

| Usuario | Contraseña |
|---------|----------- |
| admin   | 1234       |
| juan    | abcd       |

## Instalación y puesta en marcha

### Requisitos
- XAMPP (o cualquier servidor con PHP 8+)
- Navegador web

### Pasos

1. **Clona el repositorio** dentro de la carpeta `htdocs` de XAMPP:

```bash
cd C:/xampp/htdocs/ejercicios
git clone <url-del-repo> gestor-tareas
```

2. **Arranca Apache** desde el panel de control de XAMPP.

3. **Abre el navegador** y navega a:

```
http://localhost/ejercicios/gestor-tareas/index.php
```

4. Inicia sesión con uno de los usuarios de prueba de la tabla anterior.

## Estructura del proyecto

```
gestor-tareas/
├── index.php                        ← Enrutador (Front Controller)
├── controllers/
│   ├── AuthController.php           ← Login y logout
│   └── TareasController.php         ← CRUD de tareas
├── models/
│   ├── Usuario.php                  ← Usuarios en array estático
│   └── Tarea.php                    ← Tareas persistidas en sesión
├── views/
│   ├── auth/
│   │   └── login.php
│   ├── tareas/
│   │   ├── lista.php
│   │   └── formulario.php
│   └── layouts/
│       ├── header.php
│       └── footer.php
├── public/
│   └── css/
│       └── estilos.css
└── README.md
```

## Funcionalidades

- Login con sesión (todas las rutas protegidas)
- Cada usuario ve solo sus propias tareas
- Crear tarea (validación mínimo 3 caracteres)
- Listar tareas
- Marcar tarea como completada
- Eliminar tarea con confirmación
