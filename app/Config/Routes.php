<?php

namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// ===== МАРШРУТЫ =====
$routes->get('/', 'Home::index');

// API для логина (ИСПРАВЛЕНО: изменен метод на post + добавлен options)
$routes->post('api/login', 'AuthController::login');
$routes->options('api/login', 'AuthController::login');

// API для рейтинга
$routes->get('api/ratings', 'RatingApi::index');
$routes->options('api/ratings', 'RatingApi::index');

$routes->post('api/ratings', 'RatingApi::store');
$routes->options('api/ratings', 'RatingApi::store');