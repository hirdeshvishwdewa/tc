<?php

define("__ACCESS__", 1);

require 'api/base/base.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'controllers.php';

$app =  $DEBUG_MODE ? new \Slim\App($DEBUG_ARR) : new \Slim\App;

/********************************USER****************************************/

/*Register a user, insert a new row in users table*/

$app->post('/user/', function (Request $request, Response $response){
    $user = array();
    $user = $request->getParsedBody();
    $response->getBody()->write(registerUser($user, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

$app->put('/user/address/{id}', function (Request $request, Response $response){
    $addressDetails = array();
    $addressDetails = $request->getParsedBody();
    $id = $request->getAttribute('id');
    $response->getBody()->write(updateUserAddress($id, $addressDetails));
    return $response;
});

$app->put('/user/details/{id}', function ($request, $response, $args){
    $userDetails = array();
    $userDetails = $request->getParsedBody();
    $id = $request->getAttribute('id');
    $response->getBody()->write(updateUserDetails($id, $userDetails, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

// $app->put('/user/password/{id}', function (Request $request, Response $response){
//     $userDetails = array();
//     $userDetails = $request->getParsedBody();
//     $id = $request->getAttribute('id');
//     $response->getBody()->write(updateUserDetails($id, $userDetails));
//     return $response;
// });

$app->get('/user/{options}', function (Request $request, Response $response){
    $options = $request->getAttribute('options');
    $response->getBody()->write(getUser($options, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

/********************************TC*********************************************************/
$app->post('/tc/', function (Request $request, Response $response){
    $TCData = array();
    $TCData = $request->getParsedBody();
    $response->getBody()->write(resgisterTC($TCData, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

$app->get('/tc/{options}', function (Request $request, Response $response){
    $options = $request->getAttribute('options');
    $response->getBody()->write(getTC($options, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

/********************************Reviews****************************************************/

$app->post('/review/', function (Request $request, Response $response){
    $reviewData = array();
    $reviewData = $request->getParsedBody();
    $response->getBody()->write(addReview($reviewData, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

/**********************************AREA****************************************************/

$app->post('/area/', function (Request $request, Response $response){
    $areaData = array();
    $areaData = $request->getParsedBody();
    $response->getBody()->write(addArea($areaData, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

/**********************************TC PLANS****************************************************/

$app->post('/plan/', function (Request $request, Response $response){
    $areaData = array();
    $areaData = $request->getParsedBody();
    $response->getBody()->write(addPlan($areaData, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

/**********************************USER WALLET****************************************************/

$app->post('/wallet/', function (Request $request, Response $response){
    $walletData = array();
    $walletData = $request->getParsedBody();
    $response->getBody()->write(addPlan($walletData, $request->getHeaders()['HTTP_DEBUG'][0]));
    return $response;
});

/******************************************************************************************/
$app->run();

