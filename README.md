# PHP API Project

## Overview
Este proyecto es una API desarrollada en PHP que implementa controladores y modelos para manejar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para múltiples recursos. Está estructurado para proporcionar una clara separación de responsabilidades, facilitando su mantenimiento y escalabilidad.

## Project Structure
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

## Setup Instructions
1. Clona el repositorio:
   ```bash
   git clone <repository-url>
   ```

2. Navega al directorio del proyecto:
   ```bash
   cd 11.back.ev2
   ```

3. Configura la conexión a la base de datos en `config/database.php` con tus credenciales de base de datos.

4. Inicia el servidor local (por ejemplo, usando XAMPP o el servidor integrado de PHP):
   ```bash
   php -S localhost:8000
   ```

5. Accede a la API en tu navegador o herramienta como Postman:
   ```
   http://localhost:8000/index.php
   ```

## API Usage
La API soporta las siguientes operaciones para cada recurso:

- **GET**: Obtener datos.
- **POST**: Crear un nuevo registro.
- **PUT**: Actualizar un registro existente.
- **DELETE**: Eliminar un registro.

### Endpoints Disponibles
- **Antecedentes Académicos**:
  - `GET /index.php?type=academico`
  - `POST /index.php?type=academico`
  - `PUT /index.php?type=academico`
  - `DELETE /index.php?type=academico`

- **Antecedentes Laborales**:
  - `GET /index.php?type=laboral`
  - `POST /index.php?type=laboral`
  - `PUT /index.php?type=laboral`
  - `DELETE /index.php?type=laboral`

- **Ofertas Laborales**:
  - `GET /index.php?type=oferta`
  - `POST /index.php?type=oferta`
  - `PUT /index.php?type=oferta`
  - `DELETE /index.php?type=oferta`

- **Postulaciones**:
  - `GET /index.php?type=postulacion`
  - `POST /index.php?type=postulacion`
  - `PUT /index.php?type=postulacion`
  - `DELETE /index.php?type=postulacion`

- **Usuarios**:
  - `GET /index.php?type=usuario`
  - `POST /index.php?type=usuario`
  - `PUT /index.php?type=usuario`
  - `DELETE /index.php?type=usuario`

## Contributing
Si deseas contribuir, siéntete libre de enviar issues o pull requests para mejoras o correcciones de errores.

## License
Este proyecto está licenciado bajo la Licencia MIT.