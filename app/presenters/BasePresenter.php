<?php

namespace App\Presenters;

use Nette;
use Tracy\Debugger;
USE Nette\Database\Context;


class BasePresenter extends Nette\Application\UI\Presenter
{

	private $database;

	public function __construct(Context $database)
	{
		$this->database = $database;
	}

	public function startup()
	{
		parent::startup();
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
			die();
		}
	}
}
