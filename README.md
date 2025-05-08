# API RESTful en PHP – Proyecto 11.back.ev2

## Descripción General

Este proyecto implementa una API RESTful en PHP utilizando el patrón MVC (Modelo–Vista–Controlador). Permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre los recursos principales del sistema: usuarios, antecedentes académicos y laborales, ofertas laborales, postulaciones, candidatos y reclutadores. La aplicación está diseñada para ser escalable, mantenible y reutilizable.

## Estructura del Proyecto

```
11.back.ev2/
├── controllers/
│   ├── AntecedenteAcademicoController.php
│   ├── AntecedenteLaboralController.php
│   ├── CandidatoController.php
│   ├── OfertaLaboralController.php
│   ├── PostulacionController.php
│   ├── ReclutadorController.php
│   └── UsuarioController.php
├── models/
│   ├── AntecedenteAcademico.php
│   ├── AntecedenteLaboral.php
│   ├── OfertaLaboral.php
│   ├── Postulacion.php
│   └── Usuario.php
├── config/
│   └── database.php
├── index.php
└── README.md
```

## Requisitos Previos

- PHP 8.x o superior
- Servidor web local (XAMPP, MAMP) o el servidor embebido de PHP
- MySQL
- Postman o herramienta similar para pruebas de API

## Configuración Inicial

1. Clona el repositorio:
   ```cmd
   git clone <repository-url>
   ```
2. Accede al directorio del proyecto:
   ```cmd
   cd 11.back.ev2
   ```
3. Configura la conexión a la base de datos en `config/database.php`:
   ```php
   private $host = 'localhost';
   private $db_name = 'nombre_base_datos';
   private $username = 'usuario';
   private $password = 'contraseña';
   ```
4. Inicia el servidor local:
   ```cmd
   php -S localhost:8000
   ```
5. Accede a la API desde tu navegador o Postman:
   ```
   http://localhost/11.back.ev2/index.php
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
-- `GET /index.php?type=usuario`
-- `GET /index.php?type=usuario&id={id}`
-- `POST /index.php?type=usuario`
-- `PUT /index.php?type=usuario&id={id}`
-- `PATCH /index.php?type=usuario&id={id}`
- `DELETE /index.php?type=usuario&id={id}`

### Antecedentes Académicos
-- `GET /index.php?type=academico`
-- `GET /index.php?type=academico&id={id}`
-- `POST /index.php?type=academico`
-- `PUT /index.php?type=academico&id={id}`
-- `PATCH /index.php?type=academico&id={id}`
-- `DELETE /index.php?type=academico&id={id}`

### Antecedentes Laborales
-- `GET /index.php?type=laboral`
-- `GET /index.php?type=laboral&id={id}`
-- `POST /index.php?type=laboral`
-- `PUT /index.php?type=laboral&id={id}`
-- `PATCH /index.php?type=laboral&id={id}`
-- `DELETE /index.php?type=laboral&id={id}`

### Ofertas Laborales
-- `GET /index.php?type=oferta`
-- `GET /index.php?type=oferta&id={id}`
-- `POST /index.php?type=oferta`
-- `PUT /index.php?type=oferta&id={id}`
-- `PATCH /index.php?type=oferta&id={id}`
-- `DELETE /index.php?type=oferta&id={id}`

### Postulaciones
-- `GET /index.php?type=postulacion`
-- `GET /index.php?type=postulacion&id={id}`
-- `POST /index.php?type=postulacion`
-- `PUT /index.php?type=postulacion&id={id}`
-- `PATCH /index.php?type=postulacion&id={id}`
-- `DELETE /index.php?type=postulacion&id={id}`

### Endpoints Personalizados – Reclutador
-- `POST /index.php?type=reclutador&action=crear_oferta`
-- `PATCH /index.php?type=reclutador&action=editar_oferta&id={id}`
-- `PATCH /index.php?type=reclutador&action=desactivar_oferta&id={id}`
-- `GET /index.php?type=reclutador&action=ver_postulantes&id_oferta={id}`
-- `PATCH /index.php?type=reclutador&action=actualizar_estado_postulacion&id_postulacion={id}`

### Endpoints Personalizados – Candidato
-- `GET /index.php?type=candidato&action=ver_ofertas`
-- `POST /index.php?type=candidato&action=postular&id_oferta={id}`
-- `GET /index.php?type=candidato&action=mis_postulaciones&id={candidato_id}`

### Vistas Especiales (GET)
-- `GET /index.php?type=oferta&vista=vigentes`
-- `GET /index.php?type=postulacion&vista=postulanteasociado_oferta`
-- `GET /index.php?type=postulacion&vista=basica_por_candidato&candidato_id={id}`

---


## Contribuciones

Las contribuciones son bienvenidas. Si deseas colaborar, crea un issue para reportar errores o proponer mejoras. También puedes enviar un pull request con tus aportes.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.

---

**Última actualización:** Mayo 2025
