<?php 

declare(strict_types = 1);

namespace KaffirFold\Router;

use Exception;
use KaffirFold\Router\RouterInterface;

class Router implements RouterInterface
{
    /**
     * Return an array of routes from our routing table
     * @var array
     */
    protected array $routes = [];

    /**
     * Return an array of route parameters
     * @var array
     */
    protected array $params = [];

    /**
     * Add a suffix in the controller name
     * @var array
     */
    protected string $controllerSuffix = 'controller';

    /* == IMPLEMENT THE ROUTER INTERFACE METHODS == */

    /**
     * @inheritDoc 
     */

    public function add(string $route, array $params):void
    {
        $this->routes[$route] = $params; 
    }

    /**
     * @inheritDoc 
     * @param string $url
     * @return void
     * @method match(); transformToPascalCase(); getNamespace()
     */

    public function dispatch(string $url):void
    {
        // use the match() helper function 
        if($this->match($url))
        // then - start extaxting those parameters to build controller objects & action methods
        {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformToPascalCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);

            if(class_exists($controllerString))
            {
                // Instantiate the class (create object)
                $controllerObject = new $controllerString();
                // Extract action from the params
                $action = $this->params['action'];
                // Convert to camelCase
                $action = $this->transformToCamelCase($action);

                if(\is_callable([$controllerObject,$action]))
                {
                    // Execute the method
                    $controllerObject->$action();
                } else 
                {
                    throw new Exception(); // one of standard PHP Exceptions
                }
            } else 
            {
                throw new Exception();
            }
        } else 
        {
            throw new Exception();
        }
    }

    /**
     * Helper Function that transforms the $action to a camelCase as per
     * the modern PHP standards
     * @param string $string
     * @return string
     */

    public function transformToPascalCase(string $string):string 
    {
        return \lcfirst($this->transformToPascalCase($string));
    }

    /**
     * Helper Function that transforms the $controllerString to a PascalCase as per
     * the modern PHP standards
     * @param string $string
     * @return string
     */

    public function transformToCamelCase(string $string):string 
    {
        return str_replace(' ','',ucwords(str_replace('-',' ',$string)));
    }

    /**
     * Helper Function that matches routes from the request url with the routes in * the routing table, then sets the '$this->params' property if the route is
     * found.
     * @param string $url
     * @return bool
     */

    public function match(string $url):bool 
    {
        foreach($this->routes as $route => $params)
        {
            if(preg_match($route,$url, $matches))
            {
                foreach($matches as $key => $param)
                {
                    // force $params as string
                    if((is_string($key)))
                    {
                        $params[$key] = $param;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Helper Function that gets the namespace for the controller class, which
     * namespace is defined within the route parameters, only if it was added
     * @param string $string
     * @return string
     */

     public function getNamespace(string $string):string 
     {
        $namespace = 'App\Controller\\';
        if(array_key_exists('namespace',$this->params))
        {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
     }



} 