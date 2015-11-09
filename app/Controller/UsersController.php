<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('registration');
    }

    
    public function registration() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Konto zostało utworzone'));
                return $this->redirect(array('action' => 'login'));
            }
            $this->Session->setFlash(
                __('Nie udało się utworzyć konta. Spróbuj ponownie')
            );
        }
    }
    public function login() {
    if ($this->request->is('post')) {
        if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->Session->setFlash(__('Niepoprawny login i/lub hasło'));
    }
}
    public function logout() {
        $this->Auth->logout();
         $this->Session->setFlash(__('Zostałeś poprawnie wylogowany'));
        return $this->redirect(array('action' => 'login'));
}
	public function edit() {
	   // form posted
		if ($this->request->is('post')) {
			// create
			$this->User->create();
            $data=$this->request->data;
            $data['User']['id']=$this->Session->read('Auth.User.id');
			// attempt to save
			if ($this->User->save($data)) {
				$this->Session->setFlash('Your message has been submitted');
				$this->redirect(array('action' => 'edit'));
			}
            
		}
	}
       
       

}
