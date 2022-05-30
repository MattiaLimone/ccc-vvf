<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
//LOGIN LOGOUT ROUTE
$routes->match(['get', 'post'], 'admin/login', 'Admin\Login::index', ['filter' => 'adminNoAuth']);
$routes->get('admin/logout', 'Admin/Logout::index');
//DASHBOARD ROUTE
$routes->get('admin/dashboard', 'Admin\Dashboard::index', ['filter' => 'adminAuth']);
//ADD PAGE AND METHOD ROUTE
$routes->get('admin/dashboard/add', 'Admin\Dashboard\Add::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/add/getComuni', 'Admin\Dashboard\Add::getComuni',['filter' => 'adminAuth']);
$routes->get('admin/dashboard/add/getComuni', 'Admin\Dashboard\Add::index',['filter' => 'adminAuth']);
$routes->post('admin/dashboard/add/newEntry', 'Admin\Dashboard\Add::newEntry',['filter' => 'adminAuth']);
$routes->get('admin/dashboard/add/newEntry', 'Admin\Dashboard\Add::index',['filter' => 'adminAuth']);
//SEARCH PAGE AND METHOD ROUTE
$routes->get('admin/dashboard/search', 'Admin\Dashboard\Search::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/search/filter', 'Admin\Dashboard\Search::index',['filter' => 'adminAuth']);
$routes->post('admin/dashboard/search/filter', 'Admin\Dashboard\Search::filter',['filter' => 'adminAuth']);
//IMPORT PAGE AND METHOD ROUTE
$routes->get('admin/dashboard/import', 'Admin\Dashboard\Import::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/import/upload', 'Admin\Dashboard\Import::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/import/upload', 'Admin\Dashboard\Import::do_upload', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/import/import', 'Admin\Dashboard\Import::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/import/import', 'Admin\Dashboard\Import::import', ['filter' => 'adminAuth']);
//UPDATE PAGE AND METHOD ROUTE
$routes->get('admin/dashboard/update', 'Admin\Dashboard\Update::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/update/getComuni', 'Admin\Dashboard\Update::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/update/getComuni', 'Admin\Dashboard\Update::getComuni', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/update/getData', 'Admin\Dashboard\Update::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/update/getData', 'Admin\Dashboard\Update::getData', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/update/update', 'Admin\Dashboard\Update::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/update/update', 'Admin\Dashboard\Update::update', ['filter' => 'adminAuth']);
//PERMISSION PAGE AND METHOD ROUTE
$routes->get('admin/dashboard/permissions', 'Admin\Dashboard\Permissions::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/permissions/update', 'Admin\Dashboard\Permissions::update',['filter' => 'adminAuth']);
$routes->get('admin/dashboard/permissions/update', 'Admin\Dashboard\Permissions::index',['filter' => 'adminAuth']);
//FORMATION
$routes->get('admin/dashboard/formation', 'Admin\Dashboard\Formation::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/formation/getData', 'Admin\Dashboard\Formation::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/formation/getData', 'Admin\Dashboard\Formation::getData', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/formation/add', 'Admin\Dashboard\Formation::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/formation/add', 'Admin\Dashboard\Formation::addSpecs', ['filter' => 'adminAuth']);
//CALENDAR
$routes->get('admin/dashboard/calendar', 'Admin\Dashboard\Calendar::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/calendar/getData', 'Admin\Dashboard\Calendar::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/calendar/getData', 'Admin\Dashboard\Calendar::getData', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/calendar/getCalendarEvents', 'Admin\Dashboard\Calendar::getCalendarEvents', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/calendar/getCalendarEvents', 'Admin\Dashboard\Calendar::getCalendarEvents', ['filter' => 'adminAuth']);
//FONOGRAMMA
$routes->get('admin/dashboard/fonogramma', 'Admin\Dashboard\Fonogramma::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/fonogramma/getData', 'Admin\Dashboard\Fonogramma::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/fonogramma/getData', 'Admin\Dashboard\Fonogramma::getData', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/fonogramma/newEntry', 'Admin\Dashboard\Fonogramma::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/fonogramma/newEntry', 'Admin\Dashboard\Fonogramma::newEntry', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/fonogramma/all', 'Admin\Dashboard\Fonogramma::getAll', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/fonogramma/all', 'Admin\Dashboard\Fonogramma::getAll', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/fonogramma/getPdf', 'Admin\Dashboard\Fonogramma::getAll', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/fonogramma/getPdf', 'Admin\Dashboard\Fonogramma::getPdf', ['filter' => 'adminAuth']);
//INSERISCI FERIE
$routes->get('admin/dashboard/addferie', 'Admin\Dashboard\AddFerie::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/addferie/insert', 'Admin\Dashboard\AddFerie::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/addferie/insert', 'Admin\Dashboard\AddFerie::insert', ['filter' => 'adminAuth']);
//INSERISCI MALATTIA
$routes->get('admin/dashboard/addmalattia', 'Admin\Dashboard\AddMalattia::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/addmalattia/insert', 'Admin\Dashboard\AddMalattia::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/addmalattia/insert', 'Admin\Dashboard\AddMalattia::insert', ['filter' => 'adminAuth']);
//MODIFICA QUALIFICA
$routes->get('admin/dashboard/updatequalifica', 'Admin\Dashboard\UpdateQualifica::index', ['filter' => 'adminAuth']);
$routes->get('admin/dashboard/updatequalifica/insert', 'Admin\Dashboard\UpdateQualifica::index', ['filter' => 'adminAuth']);
$routes->post('admin/dashboard/updatequalifica/insert', 'Admin\Dashboard\UpdateQualifica::insert', ['filter' => 'adminAuth']);