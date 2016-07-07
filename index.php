<?php

define("__ACCESS__", 1);

$DEBUG_MODE = true;

if($DEBUG_MODE){
    error_reporting();
}else {
    error_reporting(0);
}

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$DEBUG_ARR = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

$app =  $DEBUG_MODE ? new \Slim\App($DEBUG_ARR) : new \Slim\App;

require 'controllers.php';

/********************************USER****************************************/

/*Register a user, insert a new row in users table*/

$app->post('/user/', function (Request $request, Response $response){
    $user = array();
    $user = $request->getParsedBody();
    $response->getBody()->write(registerUser($user));
    return $response;
});

// $app->put('/user/address/{id}', function (Request $request, Response $response){
//     $addressDetails = array();
//     $addressDetails = $request->getParsedBody();
//     $id = $request->getAttribute('id');
//     $response->getBody()->write(updateUserAddress($id, $addressDetails));
//     return $response;
// });

$app->put('/user/details/{id}', function ($request, $response, $args){
    $userDetails = array();
    $userDetails = $request->getParsedBody();
    $id = $request->getAttribute('id');
    $response->getBody()->write(updateUserDetails($id, $userDetails));
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
    $response->getBody()->write(getUser($options));
    return $response;
});

/********************************TC*********************************************************/
$app->post('/tc/', function (Request $request, Response $response){
    $TCData = array();
    $TCData = $request->getParsedBody();
    $response->getBody()->write(resgisterTC($TCData));
    return $response;
});

$app->get('/tc/{options}', function (Request $request, Response $response){
    $options = $request->getAttribute('options');
    $response->getBody()->write(getTC($options));
    return $response;
});

/********************************Reviews****************************************************/

$app->post('/review/', function (Request $request, Response $response){
    $reviewData = array();
    $reviewData = $request->getParsedBody();
    $response->getBody()->write(addReview($reviewData));
    return $response;
});

/**********************************AREA****************************************************/

$app->post('/area/', function (Request $request, Response $response){
    $areaData = array();
    $areaData = $request->getParsedBody();
    $response->getBody()->write(addArea($areaData));
    return $response;
});

/**********************************TC PLANS****************************************************/

$app->post('/plan/', function (Request $request, Response $response){
    $areaData = array();
    $areaData = $request->getParsedBody();
    $response->getBody()->write(addPlan($areaData));
    return $response;
});

/**********************************USER WALLET****************************************************/

$app->post('/wallet/', function (Request $request, Response $response){
    $walletData = array();
    $walletData = $request->getParsedBody();
    $response->getBody()->write(addPlan($walletData));
    return $response;
});

/******************************************************************************************/
$app->run();

