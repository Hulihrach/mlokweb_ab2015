<?php

namespace App\AdminModule;

use App\Presenters\GlobalPresenter;

class BasePresenter extends GlobalPresenter
{

	public function startup()
	{
		parent::startup();
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect(':Front:Home:default');
		}
		if (!$this->getUser()->isInRole('mod')) {
			$this->redirect(':Front:Home:default');
		}
	}
}