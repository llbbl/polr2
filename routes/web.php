<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', ['as' => 'index', 'uses' => 'IndexController@showIndexPage']);

$router->get('/logout', ['as' => 'logout', 'uses' => 'UserController@performLogoutUser']);
$router->get('/login', ['as' => 'login', 'uses' => 'UserController@displayLoginPage']);
$router->get('/about-polr', ['as' => 'about', 'uses' => 'StaticPageController@displayAbout']);

$router->get('/lost_password', ['as' => 'lost_password', 'uses' => 'UserController@displayLostPasswordPage']);
$router->get('/activate/{username}/{recovery_key}', ['as' => 'activate', 'uses' => 'UserController@performActivation']);
$router->get('/reset_password/{username}/{recovery_key}', ['as' => 'reset_password', 'uses' => 'UserController@performPasswordReset']);

$router->get('/admin', ['as' => 'admin', 'uses' => 'AdminController@displayAdminPage']);

$router->get('/setup', ['as' => 'setup', 'uses' => 'SetupController@displaySetupPage']);
$router->post('/setup', ['as' => 'psetup', 'uses' => 'SetupController@performSetup']);
$router->get('/setup/finish', ['as' => 'setup_finish', 'uses' => 'SetupController@finishSetup']);

$router->get('/{short_url}', ['uses' => 'LinkController@performRedirect']);
$router->get('/{short_url}/{secret_key}', ['uses' => 'LinkController@performRedirect']);

$router->get('/admin/stats/{short_url}', ['uses' => 'StatsController@displayStats']);

/* POST endpoints */

$router->post('/login', ['as' => 'plogin', 'uses' => 'UserController@performLogin']);
$router->post('/shorten', ['as' => 'pshorten', 'uses' => 'LinkController@performShorten']);
$router->post('/lost_password', ['as' => 'plost_password', 'uses' => 'UserController@performSendPasswordResetCode']);
$router->post('/reset_password/{username}/{recovery_key}', ['as' => 'preset_password', 'uses' => 'UserController@performPasswordReset']);

$router->post('/admin/action/change_password', ['as' => 'change_password', 'uses' => 'AdminController@changePassword']);

$router->group(['prefix' => '/api/v2', 'namespace' => 'App\Http\Controllers'], function ($router) {
    /* API internal endpoints */
    $router->post('link_avail_check', ['as' => 'api_link_check', 'uses' => 'AjaxController@checkLinkAvailability']);
    $router->post('admin/toggle_api_active', ['as' => 'api_toggle_api_active', 'uses' => 'AjaxController@toggleAPIActive']);
    $router->post('admin/generate_new_api_key', ['as' => 'api_generate_new_api_key', 'uses' => 'AjaxController@generateNewAPIKey']);
    $router->post('admin/edit_api_quota', ['as' => 'api_edit_quota', 'uses' => 'AjaxController@editAPIQuota']);
    $router->post('admin/toggle_user_active', ['as' => 'api_toggle_user_active', 'uses' => 'AjaxController@toggleUserActive']);
    $router->post('admin/change_user_role', ['as' => 'api_change_user_role', 'uses' => 'AjaxController@changeUserRole']);
    $router->post('admin/add_new_user', ['as' => 'api_add_new_user', 'uses' => 'AjaxController@addNewUser']);
    $router->post('admin/delete_user', ['as' => 'api_delete_user', 'uses' => 'AjaxController@deleteUser']);
    $router->post('admin/toggle_link', ['as' => 'api_toggle_link', 'uses' => 'AjaxController@toggleLink']);
    $router->post('admin/delete_link', ['as' => 'api_delete_link', 'uses' => 'AjaxController@deleteLink']);
    $router->post('admin/edit_link_long_url', ['as' => 'api_edit_link_long_url', 'uses' => 'AjaxController@editLinkLongUrl']);

    $router->get('admin/get_admin_users', ['as' => 'api_get_admin_users', 'uses' => 'AdminPaginationController@paginateAdminUsers']);
    $router->get('admin/get_admin_links', ['as' => 'api_get_admin_links', 'uses' => 'AdminPaginationController@paginateAdminLinks']);
    $router->get('admin/get_user_links', ['as' => 'api_get_user_links', 'uses' => 'AdminPaginationController@paginateUserLinks']);
});

$router->group(['prefix' => '/api/v2', 'namespace' => 'App\Http\Controllers\Api', 'middleware' => 'api'], function ($router) {
    /* API shorten endpoints */
    $router->post('action/shorten', ['as' => 'api_shorten_url', 'uses' => 'ApiLinkController@shortenLink']);
    $router->get('action/shorten', ['as' => 'api_shorten_url', 'uses' => 'ApiLinkController@shortenLink']);
    $router->post('action/shorten_bulk', ['as' => 'api_shorten_url_bulk', 'uses' => 'ApiLinkController@shortenLinksBulk']);

    /* API lookup endpoints */
    $router->post('action/lookup', ['as' => 'api_lookup_url', 'uses' => 'ApiLinkController@lookupLink']);
    $router->get('action/lookup', ['as' => 'api_lookup_url', 'uses' => 'ApiLinkController@lookupLink']);

    /* API data endpoints */
    $router->get('data/link', ['as' => 'api_link_analytics', 'uses' => 'ApiAnalyticsController@lookupLinkStats']);
    $router->post('data/link', ['as' => 'api_link_analytics', 'uses' => 'ApiAnalyticsController@lookupLinkStats']);
});


