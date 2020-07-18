<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends GlobalPresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
		echo $this->translator->translate('messages.homepage.hello');
	}

}
