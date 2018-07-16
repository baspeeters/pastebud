<?php

include_once 'vendor/symfony/dotenv/Dotenv.php';

function reset_db() {
    exec(sprintf('php "%s/../bin/console" doctrine:schema:drop --force --full-database', __DIR__));
    exec(sprintf('php "%s/../bin/console" doctrine:migrations:migrate --no-interaction', __DIR__));
}

if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
    // executes the "php bin/console cache:clear" command
    passthru(sprintf(
        'php "%s/../bin/console" cache:clear --env=%s --no-warmup',
        __DIR__,
        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
    ));
}

if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Symfony\Component\Dotenv\Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Symfony\Component\Dotenv\Dotenv())->load(__DIR__.'/../.env');
}

require __DIR__.'/../vendor/autoload.php';
