<?php
require '../app/controllers/ProductController.php';
require '../app/controllers/AuthController.php';

function route($uri, $method) {

    // AUTH
    if ($uri === '/api/login' && $method === 'POST') {
        (new AuthController)->login();
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

    elseif ($uri === '/api/products' && $method === 'DELETE') {
        (new ProductController)->delete();
    }

    // UI
    elseif ($uri === '/products') {
        (new ProductController)->view();
    }

    else {
        http_response_code(404);
        echo "404 Not Found";
    }
}