<?php

// Docker environment variables
// These values match the docker-compose.yml database service

defined('DB_HOST') or define('DB_HOST', getenv('DB_HOST') ?: 'db');
defined('DB_DATABASE_PORT') or define('DB_DATABASE_PORT', getenv('DB_PORT') ?: '3306');
defined('DB_DATABASE') or define('DB_DATABASE', getenv('DB_NAME') ?: 'ildis_v4');
defined('DB_USER') or define('DB_USER', getenv('DB_USER') ?: 'dev');
defined('DB_PASSWORD') or define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'dev');

// Cookie validation keys - auto-generated if not set
defined('COOKIE_VALIDATION_KEY_FE') or define('COOKIE_VALIDATION_KEY_FE', getenv('COOKIE_VALIDATION_KEY_FE') ?: '');
defined('COOKIE_VALIDATION_KEY_BE') or define('COOKIE_VALIDATION_KEY_BE', getenv('COOKIE_VALIDATION_KEY_BE') ?: '');
