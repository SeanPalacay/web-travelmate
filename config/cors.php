<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'images/*', '*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],  // For development. In production, specify your domains
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];