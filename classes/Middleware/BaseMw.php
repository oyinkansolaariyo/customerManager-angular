<?php

/**
 * Created by PhpStorm.
 * User: itunu.babalola
 * Date: 1/31/17
 * Time: 10:10 AM
 */
namespace Middleware;
use \Interop\Container\ContainerInterface;

 abstract  class BaseMw
{
     protected $container;

     public  function __construct( ContainerInterface $c)
     {
         $this->container =$c;
     }
}