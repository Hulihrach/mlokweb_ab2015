<?php

namespace App;

use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
		$router[] = new Route('[<locale=cs [a-z]{2}>/]<module=Front>/<presenter=Home>/<action=default>[/<id>]', []);
		return $router;
	}

}
