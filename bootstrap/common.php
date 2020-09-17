<?php declare(strict_types=1);

if (! function_exists('appEnv')) {
    /**
     * Get setting from the application environment.
     *
     * @param   string      $key        setting key.
     * @param   mixed|null  $default    OPTIONAL: default value to return if setting does not exist.
     * @return  mixed|null
     */
    function appEnv(string $key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}
