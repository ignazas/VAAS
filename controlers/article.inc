<?php

require_once dirname(__FILE__) . '/../models/article.inc';
require_once dirname(__FILE__) . '/../helpers/messages.inc';

class ArticleControler {
  private $article_model;
  private $view;

  public function ArticleControler() {
    $this->view = dirname(__FILE__) . '/../templates/article.php';
    $this->article_model = new Article();
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/article/item-list.php';

    $data = Article::getList();
    $results = array('articles' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function AdminItemList() {
    $this->view = dirname(__FILE__) . '/../views/article/admin-item-list.php';

    $data = Article::getList();
    $results = array('articles' => $data['results'], 'totalRows' => $data['totalRows'], 'pageTitle' => "All Articles");

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Edit() {
    $this->view = dirname(__FILE__) . '/../views/article/edit.php';

    $results = array(
      'pageTitle' => "Edit Article",
      'formAction' => "editArticle",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if ( !$article = Article::getById( (int)$_POST['articleId'])) {
        Messages::set_message("Pranešimas nerastas.", 'errors');
        return $this->AdminItemList();
      }

      $article->storeFormValues( $_POST );
      $article->update();

      //log it
      log_event("Admin", "ArticleEdited", $_POST['articleId']);

      Messages::set_message("Pakeitimai išsaugoti.");
      return $this->AdminItemList();
    }
    elseif (isset($_POST['cancel'] ) ) {
      // User has cancelled their edits: return to the article list
      return $this->AdminItemList();
    }
    else if (!empty($_GET['articleId'])) {
      // User has not posted the article edit form yet: display the form
      $results['article'] = Article::getById((int)$_GET['articleId']);

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function NewItem() {
    $this->view = dirname(__FILE__) . '/../views/article/edit.php';

    $results = array(
      'pageTitle' => "New Article",
      'formAction' => "newArticle",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the new article
      $article = new Article;

      $article->storeFormValues( $_POST );
      $article->insert();

      log_event("Admin", "ArticleCreated", $article->id);

      Messages::set_message("Pakeitimai išsaugoti.");
      return $this->AdminItemList();
    }
    elseif (isset($_POST['cancel'] ) ) {
      // User has cancelled their edits: return to the article list
      return $this->AdminItemList();
    }
    else {
      // User has not posted the article edit form yet: display the form
      $results['article'] = new Article;

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (empty($_GET['articleId']) || !($article = Article::getById((int)$_GET['articleId']))) {
      Messages::set_message("Pranešimas nerastas.", 'errors');
    }
    else {
	$article->delete();
	log_event("Admin", "ArticleDeleted", $_GET['articleId']);

	Messages::set_message("Pranešimas pašalintas.");
    }
    return $this->AdminItemList();
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/article/view.php';

    if (isset($_GET["articleId"])) {
      $results = array('article' => Article::getById((int)$_GET["articleId"]));
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
