<?php
/**
 * IndexController - The default controller class
 * 
 * @author Enrico Zimuel (enrico@zimuel.it)
 * @version 0.3
 */
require_once 'Zend/Controller/Action.php';
class IndexController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // Redirect all'homepage
        $this->_redirect('/home');
    }
    /**
     * Login
     */
    public function loginAction ()
    {
        $flash = $this->_helper->getHelper('flashMessenger');
        if ($flash->hasMessages()) {
            $this->view->message = $flash->getMessages();
        }
        $options= $this->getInvokeArg('bootstrap')->getOptions();
        $opt= array (
    			'custom' => array (
    				'timeout' => $options['auth']['timeout']
 				)   	
    	);
        $this->view->form = new App_Form_Login($opt);
        $this->render('login');
    }
    /**
     * Submit 
     */
    public function submitAction ()
    {
        $session = Zend_Registry::get('session');
        $options= $this->getInvokeArg('bootstrap')->getOptions();
        $opt= array (
    			'custom' => array (
    				'timeout' => $options['auth']['timeout']
 				)   	
    	);
        $form = new App_Form_Login($opt);
        $request = $this->getRequest();
        if (!$form->isValid($request->getPost())) {
            if (count($form->getErrors('token')) > 0) {
                return $this->_forward('csrf-forbidden', 'error');
            }    
            $this->view->form = $form;
            return $this->render('login');
        }
        $username = $form->getValue('username');
        $password = $form->getValue('password');
        $db = $this->getInvokeArg('bootstrap')->getResource('db');
        $salt= $options['password']['salt'];
        $authAdapter = new Zend_Auth_Adapter_DbTable(
                                $db,
                                'users',
                                'username',
                                'password', "MD5(CONCAT('$salt',?)) AND active=1");
        $authAdapter->setIdentity($username)->setCredential($password);
        $result = $authAdapter->authenticate();
        Zend_Session::regenerateId();
        if (!$result->isValid()) {
            $this->_helper->flashMessenger->addMessage("Authentication error.");
            $this->_redirect('/index/login');
        } else {
            $session->username = $result->getIdentity();
            $users = new App_Model_Users();
            $data = array('last_access' => date('Y-m-d H:i:s'));
            $where = $users->getAdapter()->quoteInto('username = ?', $session->username);
            if (! $users->update($data, $where)) {
                throw new Zend_Exception('Error on update last_access');
            }
            $this->_redirect('/home');
        }
    }
}