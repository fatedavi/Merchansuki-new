<?php

function env($key, $default = null)
{
    return $_ENV[$key] ?? getenv($key) ?? $default;
}
