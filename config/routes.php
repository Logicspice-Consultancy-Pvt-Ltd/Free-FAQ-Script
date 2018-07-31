<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

// Admin routing
Router::prefix('admin', function ($routes) {
    // All routes here will be prefixed with `/admin`
    // And have the prefix => admin route element added.
    $routes->connect('/', ['controller' => 'admins', 'action' => 'login']);
    $routes->connect('/admins', ['controller' => 'admins', 'action' => 'login']);
    $routes->fallbacks('DashedRoute');
});

// Front end routing
Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'homes', 'action' => 'index']);
    //$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    //$routes->connect('/termsAndCondition', ['controller' => 'Pages', 'action' => 'termsAndCondition']);
    $routes->fallbacks('DashedRoute');
});
Router::connect('/privacy_policy', array('controller' => 'pages', 'action' => 'privacyPolicy'));
Router::connect('/terms_and_conditions', array('controller' => 'pages', 'action' => 'termsAndConditions'));
Router::connect('/broker', array('controller' => 'users', 'action' => 'brokerregister'));
Router::connect('/tenant', array('controller' => 'users', 'action' => 'tenantregister'));
Router::connect('/friend', array('controller' => 'users', 'action' => 'friendregister'));
Router::connect('/thankyou', array('controller' => 'users', 'action' => 'thankyou'));
Plugin::routes();
