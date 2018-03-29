<?php //-->
/**
 * This file is part of a Custom Package.
 */
require_once __DIR__ . '/package/events.php';
require_once __DIR__ . '/src/events.php';
require_once __DIR__ . '/src/controller.php';
require_once __DIR__ . '/package/helpers.php';

use Cradle\Event\EventHandler;
use Cradle\Http\Router;
use Cradle\Package\Role\Exception;

$this->preprocess(function ($request, $response) {
    // get default auth id
    $authId = $request->getSession('me', 'auth_id');

    // get default role permissions
    $permissions[] = [
        'path' => '(?!/admin)/**',
        'label' => 'Guest Access',
        'method' => 'all'
    ];

    // if session role permission override
    if($request->getSession('me', 'role_permissions')) {
        $permissions = array_merge(
            $permissions,
            $request->getSession('me', 'role_permissions')
        );
    }

    // if role permission override
    if ($request->hasStage('role_permissions')) {
        // get role permissions
        $permissions = array_merge(
            $permissions,
            $request->getStage('role_permissions')
        );
    }

    // allow auth id 1
    if($authId && $authId == 1) {
        // skip permission check
        return true;
    }

    //  path
    $home = $this->package('global')->config('settings', 'home');
    if ($request->getPath('string') === $home) {
        return true;
    }

    // initialize router
    $router = new Router;

    // iterate on each permissions
    foreach($permissions as $permission) {
        // validate route
        $router->route(
            $permission['method'],
            $permission['path'],
            function($request, $response) {
            //if good, let's end checking
            return false;
        });
    }

    // process router
    $router->process($request, $response, 1);

    //let's interpret the results
    if($router->getEventHandler()->getMeta() ===  EventHandler::STATUS_INCOMPLETE) {
        //the role passes
        return true;
    }

    $this->response->setFlash(Exception::ERROR_NOT_PERMITTED, 'error');

    throw Exception::forNotPermitted();
});
