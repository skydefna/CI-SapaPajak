<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ================= DEFAULT =================
$routes->setDefaultController('Tamu');
$routes->setDefaultMethod('index');
$routes->set404Override();
$routes->setTranslateURIDashes(false);


// ================= PUBLIC (TANPA LOGIN) =================
$routes->get('/', 'Tamu::index');

$routes->get('/tamu/personal', 'Tamu::personal');
$routes->post('/tamu/personal', 'Tamu::personal');

$routes->get('/tamu/organisasi', 'Tamu::organisasi');
$routes->post('/tamu/organisasi', 'Tamu::organisasi');

$routes->get('tamu/buku_tamu', 'Tamu::buku_tamu');
$routes->get('tamu/buku_tamu/(:num)', 'Tamu::buku_tamu/$1');

$routes->get('tamu/download/(:num)', 'Tamu::downloadPdf/$1');

$routes->get('/login', 'Login::index');
$routes->post('/login/process', 'Login::loginProcess');
$routes->get('/logout', 'Login::logout');
$routes->get('/login/blocked', 'Login::blocked');   


// ================= PROTECTED (WAJIB LOGIN) =================

$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/dashboard/hapus/(:num)', 'Dashboard::hapus/$1');

    $routes->get('/dashboard/kunjungan', 'Dashboard::chart');
    $routes->get('/dashboard/testimoni', 'Dashboard::testimoniChart');

    // DATA TAMU
    $routes->get('/bukutamu/data', 'BukuTamu::data');

    // EDIT
    $routes->match(['get','post'], '/bukutamu/edit/(:num)', 'BukuTamu::editDataTamu/$1');

    // HAPUS DAN CETAK
    $routes->post('/bukutamu/delete/(:num)', 'BukuTamu::hapusDataTamu/$1');
    $routes->get('/bukutamu/cetak', 'BukuTamu::cetak');

    $routes->match(['get','post'], '/bukutamu/rekam', 'BukuTamu::rekam');
    $routes->post('/bukutamu/upload', 'BukuTamu::upload');
    $routes->post('/bukutamu/unrekam', 'BukuTamu::unRekam');

    // ADMIN - KELOLA MENU
    $routes->get('/administrator/menu', 'Administrator::menu');    
    $routes->post('/administrator/menu/edit/(:num)', 'Administrator::editMenu/$1');
    $routes->post('/administrator/menu/delete/(:num)', 'Administrator::deleteMenu/$1');

    // ADMIN
    $routes->get('/administrator/akses', 'Administrator::role');    
    $routes->post('/administrator/akses/add', 'Administrator::addRole');
    $routes->get('/administrator/akses/getMenu/(:num)', 'Administrator::getMenu/$1');
    $routes->post('/administrator/akses/edit/(:num)', 'Administrator::edit/$1');
    $routes->get('/administrator/akses/delete/(:num)', 'Administrator::delete/$1');

    //SOCIAL MEDIA
    $routes->get('/settings/social-media', 'Settings::social');
    $routes->post('/settings/social-media/update', 'Settings::saveSocial');
    $routes->get('/settings/social-media/delete/(:num)', 'Settings::deleteSocial/$1');

    // settings akun dan website
    $routes->get('/settings/account', 'Settings::account');
    $routes->post('/settings/account/update', 'Settings::updateAccount');    
    $routes->post('/settings/changePassword', 'Settings::changePassword');
    $routes->post('/settings/gantiFotoProfile', 'Settings::gantiFotoProfile');
    $routes->get('/settings/website', 'Settings::website');
    $routes->post('/settings/website/update', 'Settings::updateWebsite');    

    // USERS
    $routes->match(['get','post'], '/administrator/users', 'Administrator::users');

    $routes->post('/administrator/users/edit/(:num)', 'Administrator::editUser/$1');
    $routes->get('/administrator/users/edit/(:num)', 'Administrator::editUser/$1');

    $routes->get('/administrator/users/delete/(:num)', 'Administrator::deleteUser/$1');

    // AJAX
    $routes->post('/administrator/cekUsername', 'Administrator::cekUsername');
    $routes->get('/administrator/users/unblock/(:num)', 'Administrator::unblock/$1');
    $routes->get('/administrator/users/reset/(:num)', 'Administrator::resetPassword/$1');
});