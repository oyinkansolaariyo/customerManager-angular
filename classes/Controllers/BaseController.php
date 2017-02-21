<?php
/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/30/17
 * Time: 4:59 PM
 */

namespace Controllers;

use \Interop\Container\ContainerInterface;
use Utils\Utility;

abstract  class BaseController
{
     protected $container;
     protected $user;

     public  function __construct( ContainerInterface $c)
     {
         $this->container = $c;
         if(Utility::isLoggedIn()) {
             $this->user = Utility::setSession('user');
         }
     }

 }