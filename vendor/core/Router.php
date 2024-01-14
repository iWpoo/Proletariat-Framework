<?php

namespace Core;
	
class Router	
{
	public function getTrack($routes, $uri, $method)
    {
        foreach ($routes as $route) {
            if ($route->getMethod() == $method) {
                $pattern = $this->createPattern($route->path);

                if (preg_match($pattern, $uri, $params)) {
                    $params = $this->clearParams($params);
                    return new Track($route->controller, $route->action, $params);
                }
            }
        }

        return new Track('error', 'notFound');
    }
		
	private function createPattern($path)
	{
		return '#^' . preg_replace('#/:([^/]+)#', '/(?<$1>[^/]+)', $path) . '/?$#';
	}
	
	private function clearParams($params)
	{
		$result = [];
		
		foreach ($params as $key => $param) {
			if (!is_int($key)) {
				$result[$key] = $param;
			}
		}
			
		return $result;
	}	
}