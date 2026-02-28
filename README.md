# Pinterest Web (Laravel + Docker + PostgreSQL + MongoDB)

## Requisitos
- Docker Desktop (con `docker compose`)
- Git

Si ejecutas Composer/PHP fuera de Docker, asegúrate de tener activas las extensiones `fileinfo` y `mongodb`.

## Ejecutar localmente
1. Construir y levantar servicios:
   ```bash
   docker compose up -d --build
   ```
2. Crear `.env` desde ejemplo:
   ```bash
   cp .env.example .env
   ```
3. Instalar dependencias PHP dentro del contenedor:
   ```bash
   docker compose exec -T laravel composer install --no-interaction --no-progress
   ```
4. Generar clave de Laravel:
   ```bash
   docker compose exec -T laravel php artisan key:generate --force
   ```
5. Ejecutar migraciones:
   ```bash
   docker compose exec -T laravel php artisan migrate --force
   ```
6. Abrir la app:
   - Web: `http://localhost:8080`
   - Mongo Express: `http://localhost:8081`
   - PgAdmin: `http://localhost:8090`

## CI en GitHub Actions
- Workflow: `.github/workflows/tests.yml`
- Dispara en `push` y `pull_request` sobre `main`/`master`
- Matriz de PHP: `8.2`, `8.3`, `8.4`
- Incluye extensión `mongodb` para que Composer pueda instalar dependencias del proyecto.

## Importante sobre GitHub
- GitHub no ejecuta tu app Laravel en producción por sí mismo; solo CI/CD.
- Para “correr la página” en internet necesitas desplegar en un servidor (VPS, Render, Railway, etc.).
- Si ves `account is locked due to a billing issue`, primero debes desbloquear facturación en GitHub para que Actions inicie.
