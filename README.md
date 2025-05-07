# Proyecto API REST en PHP

## Descripción General

Este proyecto corresponde a una API desarrollada en PHP que implementa el patrón de arquitectura MVC (Modelo–Vista–Controlador), permitiendo realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre distintos recursos del sistema. La aplicación está diseñada para mantener una separación clara de responsabilidades, facilitando su escalabilidad, mantenibilidad y reutilización en otros entornos o proyectos.

## Estructura del Proyecto

```
11.back.ev2
├── controllers
│   ├── AntecedenteAcademicoController.php
│   ├── AntecedenteLaboralController.php
│   ├── OfertaLaboralController.php
│   ├── PostulacionController.php
│   └── UsuarioController.php
├── models
│   ├── AntecedenteAcademico.php
│   ├── AntecedenteLaboral.php
│   ├── OfertaLaboral.php
│   ├── Postulacion.php
│   └── Usuario.php
├── config
│   └── database.php
├── index.php
└── README.md
```

## Requisitos Previos

- PHP 8.x o superior  
- Servidor web local (como XAMPP o MAMP) o el servidor embebido de PHP  
- Motor de base de datos MySQL  
- Postman o herramienta similar para pruebas de API  

## Configuración Inicial

1. Clona el repositorio:
   ```bash
   git clone <repository-url>
   ```

2. Accede al directorio del proyecto:
   ```bash
   cd 11.back.ev2
   ```

3. Configura la conexión a la base de datos editando el archivo `config/database.php` con tus credenciales:
   ```php
   private $host = 'localhost';
   private $db_name = 'nombre_base_datos';
   private $username = 'usuario';
   private $password = 'contraseña';
   ```

4. Inicia el servidor local (puedes usar XAMPP o el servidor integrado de PHP):
   ```bash
   php -S localhost:8000
   ```

5. Accede a la API desde tu navegador o mediante una herramienta como Postman:
   ```
   http://localhost:8000/index.php
   ```

## Uso de la API

La API admite las siguientes operaciones HTTP para cada recurso:

- `GET`: Obtener uno o más registros  
- `POST`: Crear un nuevo registro  
- `PUT`: Reemplazar un recurso completamente  
- `PATCH`: Actualizar campos específicos  
- `DELETE`: Eliminar lógicamente un registro (estado = "Inactivo")  

## Endpoints Disponibles

### Usuarios

- `GET /index.php?type=usuario`  
- `GET /index.php?type=usuario&id={id}`  
- `POST /index.php?type=usuario`  
- `PUT /index.php?type=usuario&id={id}`  
- `PATCH /index.php?type=usuario&id={id}`  
- `DELETE /index.php?type=usuario&id={id}`  

### Antecedentes Académicos

- `GET /index.php?type=academico`  
- `GET /index.php?type=academico&id={id}`  
- `POST /index.php?type=academico`  
- `PUT /index.php?type=academico&id={id}`  
- `PATCH /index.php?type=academico&id={id}`  
- `DELETE /index.php?type=academico&id={id}`  

### Antecedentes Laborales

- `GET /index.php?type=laboral`  
- `GET /index.php?type=laboral&id={id}`  
- `POST /index.php?type=laboral`  
- `PUT /index.php?type=laboral&id={id}`  
- `PATCH /index.php?type=laboral&id={id}`  
- `DELETE /index.php?type=laboral&id={id}`  

### Ofertas Laborales

- `GET /index.php?type=oferta`  
- `GET /index.php?type=oferta&id={id}`  
- `POST /index.php?type=oferta`  
- `PUT /index.php?type=oferta&id={id}`  
- `PATCH /index.php?type=oferta&id={id}`  
- `DELETE /index.php?type=oferta&id={id}`  

### Postulaciones

- `GET /index.php?type=postulacion`  
- `GET /index.php?type=postulacion&id={id}`  
- `POST /index.php?type=postulacion`  
- `PUT /index.php?type=postulacion&id={id}`  
- `PATCH /index.php?type=postulacion&id={id}`  
- `DELETE /index.php?type=postulacion&id={id}`  

## Contribuciones

Contribuciones son bienvenidas. Si deseas colaborar, puedes crear un issue para reportar errores o proponer mejoras. También puedes enviar un pull request con tus aportes.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Puedes consultarla en el archivo `LICENSE`.
