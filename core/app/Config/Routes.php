<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->group("api", function ($routes) {
    // Manajemen User
    $routes->post("Login", "Login::create");
    $routes->post("Register", "User::create",);
    $routes->get("TampilPengguna", "User::index", ['filter' => 'authFilter']);
    $routes->get("TampilDetailPengguna/(:any)", "User::show/$1", ['filter' => 'authFilter']);
    $routes->put("GantiPassword/(:num)", "User::gantiPassword/$1", ['filter' => 'authFilter']);
    $routes->delete("HapusUser/(:num)", "User::delete/$1", ['filter' => 'authFilter']);
    // Manajemen Keluhan
    $routes->post("Keluhan", "Keluhan::create");
    $routes->put("ResponKeluhan/(:any)", "Keluhan::responKeluhan/$1", ['filter' => 'authFilter']);
    $routes->put("EditKeluhan/(:any)", "Keluhan::edit/$1", ['filter' => 'authFilter']);
    $routes->post("PermohonanTukang", "Keluhan::permohonanTukang", ['filter' => 'authFilter']);
    $routes->get("TampilKeluhan", "Keluhan::index", ['filter' => 'authFilter']);
    $routes->get("TampilDetailKeluhan/(:any)", "Keluhan::show/$1", ['filter' => 'authFilter']);
    $routes->delete("HapusKeluhan/(:any)", "Keluhan::delete/$1", ['filter' => 'authFilter']);
    // Manajemen Permohonan
    $routes->post("Permohonan", "Permohonan::create");
    $routes->put("ValidasiPermohonan/(:any)", "Permohonan::validasiPermohonan/$1", ['filter' => 'authFilter']);
    $routes->get("TampilPermohonan", "Permohonan::index", ['filter' => 'authFilter']);
    $routes->get("TampilDetailPermohonan/(:any)", "Permohonan::show/$1", ['filter' => 'authFilter']);
    $routes->get("TampilDetailPermohonanByNomorTelepon/(:any)", "Permohonan::tampilByNomorTelepon/$1", ['filter' => 'authFilter']);
    $routes->delete("HapusPermohonan/(:any)", "Permohonan::delete/$1", ['filter' => 'authFilter']);
    // Manajemen Notifikasi
    $routes->get("TampilNotifikasi", "Notifikasi::index", ['filter' => 'authFilter']);
    // Manajemen Artikel
    $routes->post("Artikel", "Artikel::create", ['filter' => 'authFilter']);
    $routes->get("TampilArtikel", "Artikel::index", ['filter' => 'authFilter']);
    $routes->get("TampilArtikelDetail/(:any)", "Artikel::show/$1", ['filter' => 'authFilter']);
    $routes->delete("DeleteArtikel/(:any)", "Artikel::delete/$1", ['filter' => 'authFilter']);
    $routes->put("EditArtikel/(:any)", "Artikel::edit/$1", ['filter' => 'authFilter']);
    // Manajemen Pembayaran
    $routes->get("TampilPembayaranDetail/(:any)", "Pembayaran::show/$1", ['filter' => 'authFilter']);
    $routes->put("ValidasiPembayaran/(:any)", "Pembayaran::validasiPembayaran/$1", ['filter' => 'authFilter']);
    // Manajemen Master permohonan
    $routes->post("MasterPermohonan", "MasterPermohonan::create", ['filter' => 'authFilter']);
    $routes->get("TampilMasterPermohonan", "MasterPermohonan::index", ['filter' => 'authFilter']);
    $routes->delete("HapusMasterPermohonan/(:any)", "MasterPermohonan::delete/$1", ['filter' => 'authFilter']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
