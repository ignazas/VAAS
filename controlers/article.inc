<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/article.inc';

class ArticleControler extends BaseControler {
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
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/article/edit.php';

    $results = array(
      'pageTitle' => "Edit Article",
      'formAction' => "editArticle",
    );

    if (empty($_GET['articleId']) && !empty($_GET['id'])) $_GET['articleId'] = $_GET['id'];
    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if (!$article = Article::getById( (int)$_POST['articleId'])) {
        Messages::set_message("Pranešimas nerastas.", 'errors');
        return $this->AdminItemList();
      }

      $article->storeFormValues( $_POST );
      $article->update();

      //log it
      log_event("Admin", "ArticleEdited", $_POST['articleId']);

      Messages::set_message("Pakeitimai išsaugoti.");
      $this->Transfer(NULL, 'AdminItemList');
      //return $this->AdminItemList();
    }
    elseif (isset($_POST['cancel'] ) ) {
      // User has cancelled their edits: return to the article list
      $this->Transfer(NULL, 'AdminItemList');
      //return $this->AdminItemList();
    }
    else if (!empty($_GET['articleId'])) {
      // User has not posted the article edit form yet: display the form
      $results['article'] = Article::getById((int)$_GET['articleId']);

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function NewItem() {
    if (!$this->HasPermission())
      $this->Transfer();

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
      $this->Transfer(NULL, 'AdminItemList');
      //return $this->AdminItemList();
    }
    elseif (isset($_POST['cancel'] ) ) {
      // User has cancelled their edits: return to the article list
      $this->Transfer(NULL, 'AdminItemList');
      //return $this->AdminItemList();
    }
    else {
      // User has not posted the article edit form yet: display the form
      $results['article'] = new Article;

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (!$this->HasPermission())
      $this->Transfer();

    if (empty($_GET['articleId']) && !empty($_GET['id'])) $_GET['articleId'] = $_GET['id'];
    if (empty($_GET['articleId']) || !($article = Article::getById((int)$_GET['articleId']))) {
      Messages::set_message("Pranešimas nerastas.", 'errors');
    }
    else {
      $article->delete();
      log_event("Admin", "ArticleDeleted", $_GET['articleId']);

      Messages::set_message("Pranešimas pašalintas.");
    }
    $this->Transfer(NULL, 'AdminItemList');
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/article/view.php';

    if (empty($_GET['articleId']) && !empty($_GET['id'])) $_GET['articleId'] = $_GET['id'];
    if (isset($_GET["articleId"])) {
      $results = array('article' => Article::getById((int)$_GET["articleId"]));
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function Notify() {
    $article = Article::getById((int)(empty($_GET['articleId']) && !empty($_GET['id']) ? $_GET['id'] : $_GET['articleId']));
    if (empty($article))
      $this->Transfer(NULL, 'AdminItemList');

    $receivers = array();
    $r = isset($_GET['receivers']) ? $_GET['receivers'] : 'me';
    switch($_GET['receivers']) {
      case 'all':
        require_once dirname(__FILE__) . '/../models/user.inc';
        $data = User::getList();
        foreach ($data['results'] as $user) {
          $receivers[] = !empty($user->email_to) ? $user->email_to : $user->email;
        }
        break;
      case 'flying_today':
        require_once dirname(__FILE__) . '/../models/calendar_event.inc';
        $data = CalendarEvent::getByDate(time());
        foreach ($data['results'] as $event) {
          if (!empty($event->user))
            $receivers[] = !empty($event->user->email_to) ? $event->user->email_to : $event->user->email;
        }
        break;
      case 'flying_tomorrow':
        require_once dirname(__FILE__) . '/../models/calendar_event.inc';
        $data = CalendarEvent::getByDate(time()+86400); /*1 Day = 24*60*60 = 86400*/
        foreach ($data['results'] as $event) {
          if (!empty($event->user))
            $receivers[] = !empty($event->user->email_to) ? $event->user->email_to : $event->user->email;
        }
        break;
      case 'me':
      default:
        require_once dirname(__FILE__) . '/../helpers/user.inc';
        $uid = UserHelper::get_id();
        if (!empty($uid)) {
          require_once dirname(__FILE__) . '/../models/user.inc';
          $user = User::Get($uid);
          $receivers[] = !empty($user->email_to) ? $user->email_to : $user->email;
        }
          break;
    }

    $url = '/index.php?action=article&amp;view=View&amp;id=' . $article->id;
    if (!empty($_SERVER['HTTP_HOST'])) {
      $base = 'http://' . $_SERVER['HTTP_HOST'];
      if (!empty($url) && $url[0] == '?')
        $base .= $_SERVER['PHP_SELF'];
      else
        $base .= dirname($_SERVER['PHP_SELF']);
      $url = $base . $url;
    }

    send_mail($receivers, $article->title, "Sveiki,<br />Buvo paskelbtas VAK pranešimas adresu: $url<br /><br />" . $article->content);

    $this->Transfer(NULL, 'View', array('id' => $article->id));
  }
}
