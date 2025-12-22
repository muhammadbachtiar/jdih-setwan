Docker (PHP 7.4) setup for this project

Prerequisites:
- Docker and docker-compose installed

## Production Setup

Quick start:

```bash
docker-compose up -d --build
```

Open the app in your browser at http://localhost:8080

## Development Setup

For development with xdebug, file watching, and auto-imported database:

```bash
docker-compose -f docker-compose.yml -f docker-compose.override.yml up -d --build
```

This will:
- Install xdebug for debugging (connects to port 9003)
- Auto-import `DATABASE/ildis_v4.sql` on first run
- Expose MySQL on host port 3306 for external tools
- Use development PHP/nginx configs with enhanced logging
- Create persistent composer cache volume

## Database Configuration

For Docker usage, copy the sample configuration files:

```bash
# Copy Docker-specific database configuration
cp common/config/main-local.php.docker-example common/config/main-local.php
cp common/config/env.php.docker-example common/config/env.php
```

Database settings:
- Host: `db` (service name in docker-compose)
- Port: `3306`
- Database: `ildis_v4`
- User: `dev` / Password: `dev`
- Root password: `root`

## Manual Database Import

If you need to import the database manually:

```bash
# copy dump into container
docker cp DATABASE/ildis_v4.sql $(docker-compose ps -q db):/tmp/ildis_v4.sql
# exec into mysql and import
docker exec -it $(docker-compose ps -q db) sh -c 'mysql -u dev -pdev ildis_v4 < /tmp/ildis_v4.sql'
```

## Development Tools

### Connect to MySQL from host
With development setup, MySQL is exposed on `localhost:3306`:
```bash
mysql -h localhost -u dev -pdev ildis_v4
```

### VS Code xdebug
Add to your `.vscode/launch.json`:
```json
{
    "name": "Listen for Xdebug (Docker)",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/var/www/html": "${workspaceFolder}"
    }
}
```

## Files Structure

Production files:
- `docker/Dockerfile` - PHP 7.4 FPM production image
- `docker/php.ini` - Production PHP config
- `docker/nginx.conf` - Production nginx config
- `docker-compose.yml` - Base services (php, nginx, db)

Development files:
- `docker/Dockerfile.dev` - Development image with xdebug
- `docker/php.dev.ini` - Development PHP config (no opcache, enhanced logging)
- `docker/nginx.dev.conf` - Development nginx config (debug logging, longer timeouts)
- `docker-compose.override.yml` - Development overrides (auto-runs with docker-compose)

Configuration examples:
- `common/config/main-local.php.docker-example` - Database config for Docker
- `common/config/env.php.docker-example` - Environment variables for Docker
