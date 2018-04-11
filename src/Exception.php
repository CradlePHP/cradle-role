<?php //-->
/**
 * This file is part of a package designed for the CradlePHP Project.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Package\Role;

use Exception as BaseException;

/**
 * Resolver exceptions
 *
 * @package  Cradle
 * @category Resolver
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class Exception extends BaseException
{
    /**
     * @const string ERROR_NOT_PERMITTED Error template
     */
    const ERROR_NOT_PERMITTED = 'Request not Permitted';

    /**
     * Create a new exception for permissions error
     *
     * @return Exception
     */
    public static function forNotPermitted(): Exception
    {
        return new static(static::ERROR_NOT_PERMITTED);
    }
}
