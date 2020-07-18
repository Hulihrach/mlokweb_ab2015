<?php

namespace App\FrontModule;

use App\Common\Entities\CommentEntity;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class ArticlePresenter extends BasePresenter
{

	public function renderDefault($id)
	{
		$parameters = $this->request->getParameters();
		$limit = isset($parameters['limit']) ? $parameters['limit'] : 5;
		$this->template->articles = $this->article->getArticleList($id, $this->locale, $limit);
		$this->template->actualId = $id;
		$this->template->id = $this->article->getContentAutoIncrement() + 1;
		$this->template->limit = $limit;
		$this->template->prev = (($id + $limit) < ($this->article->getContentAutoIncrement()) - 5) ? ($id + $limit) : ((($this->article->getContentAutoIncrement() - $limit) > 0) ? ($this->article->getContentAutoIncrement() - $limit) : 0);
		$this->template->next = (($id - $limit) > 0) ? ($id - $limit) : 0;
	}

	public function renderDetail($id)
	{
		$article = $this->article->findArticleById($id);
		$this->template->article = $article;
		$this->template->comments = $this->comment->findCommentsByArticle($article);
	}

	public function createComponentAddComment()
	{
		$form = new Form();

		$form->addText('regnum', $this->trans('messages.common.regnum'));
		$form->addTextarea('content', $this->trans('messages.forms.comment.content'))
			->setRequired($this->trans('messages.forms.comment.need_content'));
		$form->addHidden('articleId');
		$form->addSubmit('send', $this->trans('messages.forms.comment.send'));

		$form->onSuccess[] = $this->performAddComment;

		return $form;
	}

	public function performAddComment(Form $form)
	{
		$vals = $form->getValues();

		$res = ArrayHash::from(json_decode(file_get_contents('http://oris.orientacnisporty.cz/API/?format=json&method=getUser&rgnum=' . $vals->regnum), TRUE));
		if (!isset($res->Data->ID) && !$this->getUser()->isLoggedIn()) {
			$this->flashMessage("Registrační číslo nenalezeno v ORISu", "danger");
			$this->redirect('this');
		} else {
			$ce = new CommentEntity;
			$ce->setArticle($this->article->findArticleByContentId($vals->articleId));
			if ($this->getUser()->isLoggedIn()) {
				$ce->setAccount($this->account->getAccountById($this->getUser()->getId()));
			}
			$author = $this->getUser()->isLoggedIn() ? $this->account->getAccountById($this->getUser()->getId())->getUsername() : $vals->regnum;
			$ce->setAuthor($author);
			$ce->setContent($vals->content);
			$ce->setCreated_at(new \DateTime());
			$ce->setDisplay(1);
			$this->comment->save($ce);
			$this->flashMessage("Komentář úspěšně přidán", "success");
		}
	}

}
