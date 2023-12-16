<?php 

declare(strict_types = 1);

namespace KaffirFold\Router;

interface RouterInterface 
{
    /**
     * Simply adds route to the routing table
     * 
     * @param string $route
     * @param array $params
     * @return void
     */

    public function add(string $route, array $params):void;
   
    /**
     * Dispatches the route and create controller object, execute any default
     * method. 
     * in that controller object.
     * @param string $url
     * @return void
     */

    public function dispatch(string $url):void;
}