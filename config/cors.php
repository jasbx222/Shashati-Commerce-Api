<?php

return [
    'paths' => ['api/*', 'v1/*', '*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173','https://admin.shashatyapp.com'], 
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
