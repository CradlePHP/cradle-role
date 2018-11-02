<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
require_once __DIR__ . '/package/events.php';
require_once __DIR__ . '/package/helpers.php';
require_once __DIR__ . '/src/controller.php';
require_once __DIR__ . '/src/events.php';

//bootstrap
$this
    ->preprocess(include __DIR__ . '/src/bootstrap/errors.php')
    ->preprocess(include __DIR__ . '/src/bootstrap/schema.php')
    ->preprocess(include __DIR__ . '/src/bootstrap/permitted.php')
    ->preprocess(include __DIR__ . '/src/bootstrap/session.php');
