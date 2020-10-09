<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
|
| You will define all of the routes for your application in the routes/web.php file. 
| The most basic Lumen routes simply accept a URI and a Closure
|
*/

/* MAIN API */
// user sign up
$router->post('users/signup', 'UsersController@create');

$router->post('users/update', 'UsersController@updateProfile');
// user login
// $router->get('users/login/{username}/{password}', 'UsersController@login');
$router->post('users/login', 'UsersController@login');
// get image
$router->get('users/image/{file_name}','UsersController@get_avatar');
// get profile
$router->get('users/getprofile/{user_id}','UsersController@get_profile');
// create event
$router->post('event/create', 'EventController@create');
//list ranking woman
$router->get('ranking/list-woman', 'RankingController@getAllRankingWoman');
$router->get('ranking/list-man', 'RankingController@getAllRankingMan');

// list event
$router->get('event/list', 'EventController@list_event');
// event poster
$router->get('event/image/{file_name}','EventController@get_poster');
// create invitation
$router->post('play/create/sparing', 'PlayController@createsparing');
// create invitation
$router->post('play/create/coaching', 'PlayController@createcoaching');

// list invitation coaching
$router->get('play/invitation/coaching', 'PlayController@coaching');
// list invitation sparing
$router->get('play/invitation/sparing', 'PlayController@sparing');
// list detail sparing
$router->get('play/detailinvitation/{play_type}/{play_id}', 'PlayController@detailinvitation');

// list request sparing
$router->get('play/listrequest/sparing/{play_id}', 'PlayController@listrequstsparing');

// list request coaching
$router->get('play/listrequest/coaching/{user_id}', 'PlayController@listrequstcoaching');

// create request sparing
$router->post('play/request/sparing', 'PlayPartnerController@request');
// create request coaching
$router->post('play/request/coaching', 'PlayPartnerController@request');

// approval request play sparing
$router->post('play/approval/sparing', 'PlayPartnerController@approval');
// approval request play coaching
$router->post('play/approval/coaching', 'PlayPartnerController@approval');

$router->get('play/allstatus/request/{user_id}', 'PlayPartnerController@allStatusRequest');

$router->get('play/allstatuscoaching/request/{user_id}', 'PlayPartnerController@allStatusRequestCoaching');

// list detail invitation
$router->get('play/detailinvitation/{play_type}/{play_id}', 'PlayController@detailinvitation');


// play sparing history 
$router->get('play/sparing/history/{user_id}', 'PlayController@historysparing');

// play coaching history 
$router->get('play/coaching/history/{user_id}', 'PlayController@historycoaching');

// contact
$router->get('users/contact/{user_id}', 'UsersController@contact');

// ads
$router->get('ads/get-all', 'UsersController@ads');

$router->get('informasi/getInformasiUmum', 'InformasiController@getInformasiUmum');
$router->get('informasi/getKebijakanPrivasi', 'InformasiController@getKebijakanPrivasi');

// certificte
$router->post('users/certificate', 'CertificateController@certificate');
$router->get('users/certificate/{file_name}','CertificateController@get_certificate');
