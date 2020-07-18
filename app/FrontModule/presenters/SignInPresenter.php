<?php

namespace App\FrontModule;

use Nette\Application\UI\Form;
use App\Common\Models\Authenticator;
use Nette;
use App\Common\Models\Account;

class SignInPresenter extends BasePresenter
{

	protected $account;

	public function injectAccount(Account $account)
	{
		$this->account = $account;
	}

	protected function createComponentLogin()
	{
		$form = new Form();

		$form->addText('username', $this->trans('messages.forms.username'))
			->setRequired($this->trans('messages.forms.need_username'));
		$form->addPassword('password', $this->trans('messages.forms.password'))
			->setRequired($this->trans('messages.forms.need_password'));
		$form->addSubmit('send', $this->trans('messages.forms.login.send'));

		$form->onSuccess[] = $this->performLogin;

		return $form;
	}

	public function performLogin(Form $form)
	{
		$vals = $form->getValues();

		try {
			$authenticator = new Authenticator($this->account);
			$this->user->setAuthenticator($authenticator);
			$this->user->login($vals->username, $vals->password);
			$this->flashMessage("Přihlášen", "success");
			$this->redirect('Home:default');
		} catch (Nette\Security\AuthenticationException $e) {
			$this->flashMessage($this->trans('messages.common.exception') . ' : ' . $this->trans($e->getMessage()), 'danger');
		}
	}

}
