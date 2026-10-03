# StreetConnect

StreetConnect es una plataforma web para descubrir, crear y gestionar eventos de cultura urbana: rap, graffiti, música, skate, parkour y otras actividades de la escena local.

## Tecnologías

- **Frontend:** React 19, Vite, React Router y Context API.
- **Backend:** Laravel 12, PHP 8.2+, API REST y Laravel Sanctum.
- **Tiempo real:** Laravel Reverb para chat y notificaciones mediante WebSockets.
- **Base de datos:** MySQL 8.
- **Despliegue local:** Docker Compose, Apache y Nginx.

La aplicación usa una arquitectura cliente-servidor: el frontend React consume la API REST de Laravel y el backend utiliza modelos, controladores, seeders y migraciones de Laravel.

## Requisitos

- Docker Desktop con Docker Compose.
- Git.
- Puertos disponibles `80`, `8000` y `8080`.

No es necesario instalar PHP, Composer, Node.js ni MySQL para ejecutar la demo con Docker.

## Prueba rápida en local

Desde la raíz del repositorio:

```bash
git clone <URL_DEL_REPOSITORIO>
cd SocialEvents
cp .env.example .env
docker compose up -d --build
```

En PowerShell, el segundo comando puede escribirse así:

```powershell
Copy-Item .env.example .env
docker compose up -d --build
```

El backend genera `APP_KEY`, espera a que MySQL esté disponible, ejecuta las migraciones, carga los datos de demostración y arranca Apache junto con Reverb.

URLs locales:

- Aplicación web: http://localhost
- API: http://localhost:8000
- Salud del backend: http://localhost:8000/up
- WebSockets Reverb: `ws://localhost:8080`

Para comprobar el estado:

```bash
docker compose ps
docker compose logs -f backend
```

Para detener la aplicación:

```bash
docker compose down
```

Para reiniciar la demo desde cero, incluyendo la base de datos:

```bash
docker compose down -v
docker compose up -d --build
```

## Cuentas de demostración

Las cuentas se crean automáticamente por los seeders y son idempotentes:

| Tipo | Correo | Contraseña |
| --- | --- | --- |
| Administrador | `admin@example.com` | `AdminDemo123!` |
| Usuario | `usuario@example.com` | `UsuarioDemo123!` |

La base de datos incluye varios eventos, una valoración y un evento pequeño para probar inscripciones y lista de espera.

Las contraseñas se pueden cambiar antes del primer arranque mediante `SEED_ADMIN_PASSWORD` y `SEED_USER_PASSWORD` en `.env`.

## Funcionalidades principales

- Registro e inicio de sesión con tokens Sanctum.
- Listado, búsqueda y filtrado de eventos.
- Creación y administración de eventos.
- Inscripciones, acompañantes y lista de espera.
- Chat privado en tiempo real mediante Reverb.
- Notificaciones de mensajes y eventos.
- Panel de administración de usuarios, etiquetas, categorías y pagos.
- Valoraciones y comentarios.
- Subida y consulta de imágenes de eventos.
- Recomendaciones y moderación asistidas por IA cuando se configuran sus claves.
- Pagos mediante PayPal Sandbox cuando se configuran sus credenciales.

## Integraciones opcionales

La demo funciona sin servicios externos:

- `GROK_API_KEY`: activa el dato introductorio y las recomendaciones de eventos. Sin ella, se devuelve una respuesta controlada y se registra un aviso.
- `GEMINI_API_KEY`: activa la moderación de posibles vetos. Sin ella, la moderación devuelve una lista vacía y registra un aviso.
- `PAYPAL_CLIENT_ID` y `PAYPAL_CLIENT_SECRET`: activan los pagos Sandbox. Sin ellas, la API informa de que los pagos no están disponibles en esta demo.
- `MAIL_USERNAME` y `MAIL_PASSWORD`: permiten SMTP. Por defecto `MAIL_MAILER=log`, por lo que los correos se escriben en los logs y no se envían.
- Credenciales AWS: solo son necesarias si se configura almacenamiento externo en S3.

No introduzcas claves privadas en el repositorio. Usa el archivo `.env` local, que está ignorado por Git.

## Variables principales

La plantilla completa está en `.env.example`. Las variables más importantes son:

| Variable | Uso | Valor local recomendado |
| --- | --- | --- |
| `APP_KEY` | Cifrado de Laravel | Se genera automáticamente |
| `DB_HOST` | Host MySQL dentro de Docker | `bd` |
| `DB_PORT` | Puerto MySQL interno | `3306` |
| `DB_DATABASE` | Base de datos | `street_connect` |
| `DB_USERNAME` | Usuario MySQL | `streetconnect` |
| `DB_PASSWORD` | Contraseña MySQL de demo | `root` |
| `BROADCAST_CONNECTION` | Transporte de eventos | `reverb` |
| `MAIL_MAILER` | Transporte de correo | `log` |
| `VITE_API_URL` | URL de API usada por React | `/api` |
| `VITE_REVERB_HOST` | Host WebSocket del navegador | `localhost` |
| `VITE_REVERB_PORT` | Puerto WebSocket del navegador | `8080` |

## Desarrollo sin Docker

El flujo recomendado para probar la aplicación completa es Docker Compose. Para trabajar en el frontend o backend por separado, instala sus dependencias en sus carpetas respectivas y configura los valores equivalentes del archivo `.env`.

Backend:

```bash
cd SocialEvents-SamuelAlbaDomingos-Back/laravel-proyecto
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Frontend:

```bash
cd SocialEvents-SamuelAlbaDomingos-Front/react-proyecto
npm install
npm run dev
```

## Tests y calidad

Backend:

```bash
docker compose exec backend php artisan test
```

Frontend:

```bash
cd SocialEvents-SamuelAlbaDomingos-Front/react-proyecto
npm run lint
npm run build
```

## Demo desplegada

<!-- URL_DEMO -->
