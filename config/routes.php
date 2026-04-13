<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;


return function (RouteBuilder $routes): void {

    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
        
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/otp-test', ['controller' => 'OtpTest', 'action' => 'index']);
$builder->connect('/otp-test/send', ['controller' => 'OtpTest', 'action' => 'sendManual']);
        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        //$routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);

        $builder->fallbacks();
    });

    $routes->connect(
        '/register/getDistrictsByState/:stateId',
        ['controller' => 'Register', 'action' => 'getDistrictsByState']
    )->setPass(['stateId']);
};
