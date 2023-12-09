## Requisitos
'XAMP para correrlo de maneralocal'

'PHP versión 8.X'

## Instalación
`composer install`

`php artisan migrate`

`php artiasn db:seed`

`composer require yajra/laravel-datatables-oracle`

`php artisan vendor:publish --tag=datatables`

## Como correrlo

php artisan serve

## Credenciales

user: admin@miasistenciaupv.com

password: adminadmin

## To do

- [x] **Módulo de alumnos (registrar card ID)** 
- [x] **Módulo de maestros (registrar card ID)** 
- [x] **Módulo de materias** 
- [x] **Módulo de grupos** 
- [x] **Módulo de salones** 
- [ ] **Modulo de ESP32 o dispositivos** 
- [ ] **Módulo para relacionar alumnos con grupos** 
- [ ] **Módulo para relacionar ESP32 con salones** 
- [ ] **Modelo de horario (rango de horas, maestro, grupo y salón)** 
- [ ] **Lógica para recibir datos de ESP32 y registrarlos en asistencias**
- [ ] **Módulo de asistencias (Visualizar para alumnos)** 
- [ ] **Módulo de asistencias (Visualizar y editar para maestros, administradores)** 
- [ ] **Módulo de alumnos para ver su horario** 
- [ ] **Módulo de usuario para cambiar su contraseña** 



## Estructura de la base de datos

- **Maestros**
  - Nombre
  - Correo
  - Matrícula (va a ser el campo ID por defecto)
  - Contraseña
  - Card ID

- **Alumnos**
  - Nombre
  - Correo
  - Matrícula (va a ser el campo ID por defecto)
  - Contraseña
  - Card ID

- **Grupos**
  - Nombre

- **Materia**
  - Nombre

- **Salon**
  - Nombre

- **Grupos_Alumnos**
  - Alumno ID
  - Grupo ID

- **Hora**
  - Inicio
  - Fin
  - Día
  - Materia
  - Profesor
  - Grupo
  - Salon

- **Dispositivo**
  - ID del dispositivo
  - Salón

- **Asistencia**
  - Hora ID
  - Fecha
  - Alumno
  - ¿Asistió?

