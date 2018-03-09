<?php

namespace App\Presenters;

use Nette;
use Tracy\Debugger;
USE Nette\Database\Context;


class HomepagePresenter extends Nette\Application\UI\Presenter
{

	private $database;

	public function __construct(Context $database)
	{
		$this->database = $database;
	}

	public function renderDefault() {
		$query = parse_url("https://www.youtube.com/watch?v=zHdeRU8Zu_E")['query'];
		parse_str($query, $output);
		Debugger::dump($output);
		$posts = $this->database->table('posts');
		$this->template->posts = $posts;
	}

	public function actionLikePost($postId) {
		$like = $this->database->table('posts_likes')
			->where('post_id = ? AND user_id = ?', $postId, $this->getUser()->getId())
			->fetch();
		if ($like) {
			$this->flashMessage('Tohle jsi už lajknul');
		}
		else {
			$this->database->table('posts_likes')
				->insert(['post_id' => $postId, 'user_id' => $this->getUser()->getId()]);
		}
		$this->redirect('Homepage:default');
	}
}
