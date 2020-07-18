<?php

namespace App\FrontModule;

class HomePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->articles = $this->article->getArticleList(0, $this->locale, 2);
		$this->template->latestComments = $this->comment->findBy(["display" => 1], ["created_at" => "desc"], 2);
	}

	public function actionLogout()
	{
		$this->getUser()->logout(true);
		$this->flashMessage($this->trans('messages.homepage.logged_out'));
		$this->redirect('Home:default');
	}

}
