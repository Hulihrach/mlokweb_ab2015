<?php

namespace App\Presenters;

use Nette;
use App\Common\Models\Account;
use App\Common\Models\Authenticator;
use App\Common\Models\Article;
use App\Common\Models\Comment;
use App\Common\Models\Language;
use App\Common\Models\Page;
use App\Common\Models\PageTranslation;
use App\Common\Models\File;
use Nette\Database\Context;


/**
 * Base presenter for all application presenters.
 */
abstract class GlobalPresenter extends Nette\Application\UI\Presenter {

	/** @persistent */
	public $locale;

	/** @var \Kdyby\Translation\Translator */
	protected $translator;

    /** @var Account  */
    protected $account;

    /** @var Article */
    protected $article;

    /** @var Authenticator */
	protected $authenticator;

    /** @var Context */
	protected $database;

    /** @var Comment */
    protected $comment;
	
	/** @var Language */
	protected $language;
	
	/** @var Page */
	protected $page;
	
	/** @var PageTranslation */
	protected $pageTranslation;
	
	/** @var File */
	protected $file;

    /**
     * Method for inject Translator. 
     * @param    \Kdyby\Translation\Translator    $translator
     */
	public function injectTranslator(\Kdyby\Translation\Translator $translator) {
		$this->translator = $translator;
	}

    /**
     * Method for inject Account. 
     * @param    Account    $account
     */
    public function injectAccount(Account $account) {
        $this->account = $account;
    }

    /**
     * Method for inject Authenticator
     * @param    Authenticator    $authenticator
     */
    public function injectAuthenticator(Authenticator $authenticator) {
    	$this->authenticator = $authenticator;
    }

    /**
     * Method for inject Database.
     * @param    Nette\Database\Context    $database
     */
    public function injectDatabase(Context $database) {
    	$this->database = $database;
    }
    
    /**
     * Method for inject Article. 
     * @param    Article    $article
     */
    public function injectArticle(Article $article) {
        $this->article = $article;
    }

    /**
     * Method for inject Comment
     * @param   Comment    $comment
     */
    public function injectComment(Comment $comment) {
        $this->comment = $comment;
    }
	
	/**
	 * Method for inject Language
	 * @param Language $language
	 */
	public function injectLanguage(Language $language) {
		$this->language = $language;
	}
	
	/**
	 * @param Page $page
	 */
	public function injectPage(Page $page) {
		$this->page = $page;
	}
	
	/**
	 * @param PageTranslation $pageTranslation
	 */
	public function injectPageTranslation(PageTranslation $pageTranslation) {
		$this->pageTranslation = $pageTranslation;
	}
	
	/**
	 * @param File $file
	 */
	public function injectFile(File $file) {
		$this->file = $file;
	}
	
	protected function trans($message, $count = NULL, array $parameters = array(), $domain = NULL, $locale = NULL) {
		return $this->translator->translate($message, $count, $parameters, $domain, $locale);
	}

	protected function createTemplate($class = NULL) {
		$template = parent::createTemplate($class);
		$template->getLatte()->addFilter('loader', $this->translator->createTemplateHelpers());

		return $template;
	}

    public function startup() {
        parent::startup();
    }
}
