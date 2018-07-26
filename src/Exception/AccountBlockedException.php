<?php
/**
 * Created by PhpStorm.
 * User: M4rk0
 * Date: 7/26/2018
 * Time: 5:56 PM
 */

namespace App\Exception;


use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountBlockedException extends AccountStatusException
{

}