<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::test');

// 비인증 api
$routes->group('api/bebecare/noauth', static function ($routes) {
    $routes->add('login', 'Api/User::login');
});

// 인증 api
$routes->group('api/bebecare/service', static function ($routes) {
    $routes->add('user/check', 'Api/User::checkUser');
    $routes->add('user/info', 'Api/User::getUserInfo');
    $routes->add('user/modify', 'Api/User::modifyUser');
    $routes->add('user/delete', 'Api/User::deleteUser');

    $routes->add('parents/disconnect', 'Api/User::disconnectUser');

    $routes->add('children/info', 'Api/Children::getChildrenInfo');
    $routes->add('children/insert', 'Api/Children::insertChildren');
    $routes->add('children/modify', 'Api/Children::modifyChildren');
    $routes->add('children/delete', 'Api/Children::deleteChildren');

    $routes->add('items/list', 'Api/Items::getItemList');
    $routes->add('items/insert', 'Api/Items::insertItem');
    $routes->add('items/complete', 'Api/Items::completeItem');
    $routes->add('items/modify', 'Api/Items::modifyItem');
    $routes->add('items/delete', 'Api/Items::deleteItem');

    $routes->add('invite/make', 'Api/Invite::makeInviteCode');
    $routes->add('invite/join', 'Api/Invite::joinInviteCode');
});


/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
