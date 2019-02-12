<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

return function ($request, $response) {
    //this happens on an error
    $this->error(function ($request, $response, $error) {
        // if an exception was thrown from the role package
        if (!($error instanceof \Cradle\Package\Role\Exception)) {
            return;
        }

        $global = $this->package('global');
        $config = $global->config('settings');

        // set default redirect
        $redirect = '/';

        // if config home url is set
        if (isset($config['home'])) {
            // get the home url
            $redirect = $config['home'];
        }

        // let them know
        $global->flash($error->getMessage(), 'error');

        // redirect
        return $global->redirect($redirect);
    });
};
