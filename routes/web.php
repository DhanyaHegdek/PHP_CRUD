<?php

require __DIR__ . '/../app/controllers/ProductController.php';
require __DIR__ . '/../app/controllers/AuthController.php';

function route($uri, $method) {

    // AUTH
    if ($uri === '/api/login' && $method === 'POST') {
        (new AuthController)->login();
    }

    elseif ($uri === '/login' && $method === 'GET') {
        (new AuthController)->loginView();
    }

    // PRODUCTS API
    elseif ($uri === '/api/products' && $method === 'GET') {
        (new ProductController)->index();
    }

    elseif ($uri === '/api/products' && $method === 'POST') {
        (new ProductController)->store();
    }

    elseif ($uri === '/api/products' && $method === 'PATCH') {
        (new ProductController)->update();
    }

    elseif (preg_match('#^/api/products/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
        (new ProductController)->delete($matches[1]);
    }

    // UI
    elseif ($uri === '/products' && $method === 'GET') {
        (new ProductController)->view();
    }

    else {
        http_response_code(404);
        echo "404 Not Found";
    }
}