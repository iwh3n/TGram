<?php

function config_path(string $path = ''): string
{
    $base = (realpath(__DIR__ . '/../config'));

    if ($path === '') {
        return $base;
    }

    return "$base/" . ltrim($path, '/');
}
