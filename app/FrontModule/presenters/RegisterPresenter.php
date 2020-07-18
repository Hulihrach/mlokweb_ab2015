<?php

namespace App\FrontModule;

use Nette\Application\UI\Form;
use App\Common\Entities\AccountEntity;
use Kdyby\Doctrine as KD;

class RegisterPresenter extends BasePresenter
{

	protected function createComponentRegister()
	{
		$form = new Form();

		$form->addText('username', $this->trans('messages.forms.username'))
			->setRequired($this->trans('messages.forms.need_username'));
		$form->addPassword('password', $this->trans('messages.forms.password'))
			->setRequired($this->trans('messages.forms.need_password'));
		$form->addPassword('passwordCheck', $this->trans('messages.forms.register.password_check'))
			->setRequired($this->trans('messages.forms.register.need_password_check'))
			->addRule(Form::EQUAL, 'Hesla se neschodují', $form['password']);
		$form->addSubmit('send', $this->trans('messages.forms.register.send'));

		$form->onSuccess[] = $this->performRegister;

		return $form;
	}

	public function performRegister(Form $form)
	{
		$values = $form->getValues(true);
		$accountEntity = new AccountEntity();
		$accountEntity->setUsername($values['username']);
		$accountEntity->setPassword(password_hash($values['password'], PASSWORD_BCRYPT));
		$accountEntity->setRegistered(new \DateTime());

		try {
			$this->account->save($accountEntity);
			$this->flashMessage($this->trans('messages.forms.register.completed'), 'success');
		} catch (KD\DuplicateEntryException $e) {
			$this->flashMessage($this->trans('messages.forms.register.user_already_exists'), 'danger');
		}

		$this->redirect(':Front:SignIn:default');
	}
}
