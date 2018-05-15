<?php

require_once dirname(__FILE__) . '/base.inc';
require_once dirname(__FILE__) . '/../models/category.inc';

class CategoryControler extends BaseControler {
  private $model;
  private $view;

  public function CategoryControler() {
    $this->view = dirname(__FILE__) . '/../templates/category.php';
    $this->model = new Category();
  }

  private function Validate() {
    if (empty($_POST['title'])) {
      Messages::form_error('title', "Pavadinimas negali būti tuščias.");
    }

    $messages = Messages::get_messages('errors', false);
    return empty($messages);
  }

  private function updateDefaultValues($category) {
        $category->name = $category->title;
        $category->section = 'com_contxtd_details';
        $category->published = true;
        if (!isset($category->parent_id)) $category->parent_id = 0;
        $category->editor = UserHelper::get_id();
        $category->access = date();
        if (!isset($category->count)) $category->count = 0;
        if (!isset($category->params)) $category->params = '';
  }

  public function NewItem() {
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/category/edit.php';

    $results = array(
      'pageTitle' => "Nauja kategorija",
      'formAction' => "NewItem",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      $category = new Category();
      $results['category'] = $category;

      if ($this->Validate()) {
        $category->storeFormValues($_POST);
        $this->updateDefaultValues($category);
        $category->id = empty($category->id) ? NULL : $category->id;
        if ($category->insert()) {
          //log it
          log_event("Admin", "CategoryCreated", $category->id);
          Messages::set_message("Pakeitimai išsaugoti.");

          $this->Transfer(NULL, 'ItemList');
        }
        else {
          Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
        }
      }
      include dirname(__FILE__) . '/../views/_layout.php';
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the category list
      $this->Transfer(NULL, 'ItemList');
    }
    else {
      // User has not posted the category edit form yet: display the form
      $results['category'] = new Category();

      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Delete() {
    if (!$this->HasPermission())
      $this->Transfer();

    if (empty($_GET['id']) || !($category = Category::getById($_GET['id']))) {
      Messages::set_message("Kategorija nerasta.", 'errors');
    }
    else {
      $category->delete();
      log_event("Admin", "CategoryDeleted", $_GET['id']);

      Messages::set_message("Kategorija pašalinta.");
    }
	  $this->Transfer(NULL, 'ItemList');
  }

  public function Edit() {
    if (!$this->HasPermission())
      $this->Transfer();

    $this->view = dirname(__FILE__) . '/../views/category/edit.php';

    $results = array(
      'pageTitle' => "Kategorijos redagavimas",
      'formAction' => "Edit",
    );

    if (isset($_POST['saveChanges'])) {
      // User has posted the article edit form: save the article changes
      if (!($category = Category::getById($_POST['id']))) {
        Messages::set_message("Kategorija $_POST[id] nerasta.", 'errors');

        include dirname(__FILE__) . '/../views/_layout.php';
      }
      else {
        $results['category'] = $category;
        if ($this->Validate()) {
          $category->storeFormValues($_POST);
          $this->updateDefaultValues($category);
          if ($category->update()) {
            //log it
            log_event("Admin", "CategoryEdited", $_POST['id']);
            Messages::set_message("Pakeitimai išsaugoti.");

            $this->Transfer(NULL, 'ItemList');
          }
          else {
            Messages::set_message("Klaida išsaugant reikšmes.", 'errors');
          }
        }
        include dirname(__FILE__) . '/../views/_layout.php';
      }
    }
    elseif (isset($_POST['cancel'])) {
      // User has cancelled their edits: return to the category list
      $this->Transfer(NULL, 'ItemList');
    }
    else if (!empty($_GET['id'])) {
      // User has not posted the category edit form yet: display the form
      $results['category'] = Category::getById($_GET['id']);
      include dirname(__FILE__) . '/../views/_layout.php';
    }
  }

  public function Index() {
    return $this->ItemList();
  }

  public function View() {
    $this->view = dirname(__FILE__) . '/../views/category/view.php';

    if (isset($_GET["id"])) {
      $results = array('category' => Category::getById($_GET["id"]));
    }

    include dirname(__FILE__) . '/../views/_layout.php';
  }

  public function ItemList() {
    $this->view = dirname(__FILE__) . '/../views/category/item-list.php';

    $filters = array();
    if (!empty($_GET['search'])) {
      $escaped = DB::escape('%' . $_GET['search'] . '%');
      $filters[] = "(name LIKE $escaped OR title LIKE $escaped)";
    }

    $data = Category::getList(1000000, "ordering", implode(' AND ', $filters));
    $results = array('categorys' => $data['results'], 'totalRows' => $data['totalRows']);

    include dirname(__FILE__) . '/../views/_layout.php';
  }
}
