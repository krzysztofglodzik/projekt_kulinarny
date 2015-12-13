<?php
App::uses('AppController', 'Controller');
/**
 * Recipes Controller
 *
 * @property Recipe $Recipe
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RecipesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('all', 'view'); //nazwy metod dostepne bez zalogownaia
    }
    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Recipe->recursive = 0;
        $this->paginate = array('conditions' => array('user_id' => $this->Session->read
                    ('Auth.User.id'))); //warunek gwarantujacy widok tylko przepisow obecnie zalogowanego użytkownika
        $this->set('recipes', $this->Paginator->paginate());
        $levels = $this->Recipe->Level->find('list');
        $this->set(compact('levels'));
    }

    /**
     * 
     */
    public function all($category = null)
    {
        $this->loadModel('Category');
        $categories = $this->Category->find('all'); // przeszukuje wszystkie kategorie w bazie
        $name = ''; // zmienna pomocnicza pola wyszukiwarki do zapamietwania

        $conditions = array(); // tablica na warunki wyszukiwania
        if ($category != null) {
            $conditions = array('Recipe.category_id' => $category);
        }
        if (isset($this->params['url']['name'])) { //jezeli istnieje parametr name w adresie url to->
            $name = $this->params['url']['name']; // przypisanie do pomocniczej zmiennej name
            $conditions = array('Recipe.name LIKE' => '%' . $name . '%'); //ustalamy warunki wyszukiwania
        }
        $this->loadModel('Recipe'); // laduje model przepisy
        $recipes = $this->Recipe->find('all', array('conditions' => $conditions)); //przekazuje wszystkie przepisy w bazie
        $TopComment =  $this->Recipe->find('all', array('limit'=>5, 'order' => array('Recipe.CommentsCount DESC'),'conditions' => $conditions));// znajduje przpeisy dodatkowo je sortuje. gdy nie ma numerka to bierze dla wszystkich kategorii
        // pozostawia wyszukiwana fraze w wyszukiwarce po przeladowaniu strony
        //debug($TopComment);
        $this->set(compact('categories', 'recipes', 'name','TopComment')); // przekazuje zmienna categories do widoku
        // przekazuje zmienna recipes do pliku widoku
        
        
    }


    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Recipe->exists($id)) {
            throw new NotFoundException(__('Nieprawidłowy przepis.'));
        }
        if ($this->request->data) {
            $this->loadModel('Comment');
            $this->Comment->save($this->request->data);
        }


        $options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey =>
                    $id));
        $this->set('recipe', $this->Recipe->find('first', $options));
        $categories = $this->Recipe->Category->find('list');
        $levels = $this->Recipe->Level->find('list');
        $this->set(compact('categories', 'levels'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Recipe->create();
            if ($this->Recipe->save($this->request->data)) {
                $this->Session->setFlash(__('Przepis został zapisany.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Nie można zapisać przepisu. Proszę spróbować ponownie.'));
            }
        }
        $categories = $this->Recipe->Category->find('list');
        $levels = $this->Recipe->Level->find('list');
        $this->set(compact('categories', 'levels'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Recipe->exists($id)) {
            throw new NotFoundException(__('Nieprawidłowy przepis.'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Recipe->save($this->request->data)) {
                $this->Session->setFlash(__('Przepis został zapisany.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Nie można zapisać przepisu. Proszę spróbować ponownie.'));
            }
        } else {
            $options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey =>
                        $id));
            $this->request->data = $this->Recipe->find('first', $options);
        }
        $categories = $this->Recipe->Category->find('list');
        $levels = $this->Recipe->Level->find('list');
        $this->set(compact('categories', 'levels'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->Recipe->id = $id;
        if (!$this->Recipe->exists()) {
            throw new NotFoundException(__('Nieprawidłowy przepis.'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Recipe->delete()) {
            $this->Session->setFlash(__('Przepis został usunięty.'));
        } else {
            $this->Session->setFlash(__('Przepis nie może zostać usunięty. Proszę spróbować ponownie.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function deleteComment($id)
    {
        $this->loadModel('Comment'); //zaladowanie tabeli z komentarzami
        $this->Comment->id = $id; // ustawienie identyfikatora obrabianego komentarza
        if (!$this->Comment->exists()) { //sprawdzanie czy komentarz istnieje
            throw new NotFoundException(__('Nie znaleziono takiego komentarza.'));
        }
        $recipe = $this->Comment->field('recipe_id'); // pobieramy id przepisu do ktorego nalezy komentarz
        if ($this->Session->check('Auth.User.id') && $this->Session->read('Auth.User.id') ==
            $this->Comment->field('user_id')) { // sprawdzanie czy uzytkownik jest zalogowany i czy komentarz nalezy do niego
            if ($this->Comment->delete()) { //usuwanie komentarza
                $this->Session->setFlash(__('Komentarz został usunięty.'));
            } else {
                $this->Session->setFlash(__('Komentarz nie może zostać usunięty. Proszę spróbować ponownie.'));
            }
        } else {
            $this->Session->setFlash(__('Nie możesz usunąć tego komentarza.'));
        }

        return $this->redirect(array('controller' => 'recipes','action' => 'view',$recipe));//  przekierowanie na strone przepisu
    }
}
