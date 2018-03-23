<?php //-->
/**
 * This file is part of a Custom Project
 * (c) 2017-2019 Acme Inc
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 namespace Cradle\Package\Role;

 use Cradle\Package\System\Schema;
 use Cradle\Module\System\Utility\Validator as UtilityValidator;

/**
 * Validator layer
 *
 * @vendor   Acme
 * @package  role
 * @author   John Doe <john@acme.com>
 * @standard PSR-2
 */
class Validator
{
    /**
     * Returns Role Auth Errors
     *
     * @param *array $data
     * @param array  $errors
     *
     * @return array
     */
    public static function getAccessErrors(array $data, array $errors = [])
    {
        $schema = Schema::i('role');

        if (!isset($data['role']['auth_id']) || empty($data['role']['auth_id'])) {
            $errors['auth_id'] = 'Auth Id is required';
        } else {
            $exists = $schema->model()->service('sql')->getResource()
                ->search('role_auth')
                ->addFilter('auth_id = %s', $data['role']['auth_id'])
                ->getRow();

            if($exists) {
                $errors['auth_id'] = 'Auth Exists';
            }
        }

        if (!isset($data['role']['role_id']) || empty($data['role']['role_id'])) {
            $errors['role_id'] = 'Role Id is required';
        }

        return $errors;
    }

    /**
     * Returns Optional Errors
     *
     * @param *array $data
     * @param array  $errors
     *
     * @return array
     */
    public static function getOptionalErrors(array $data, array $errors = [])
    {
        //validations

        return $errors;
    }
}
