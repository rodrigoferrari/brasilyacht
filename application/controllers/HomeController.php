<?php
/**
 * HomeController - The default controller class
 * 
 * @author Enrico Zimuel (enrico@zimuel.it)
 * @version 0.2
 */
require_once 'Zend/Controller/Action.php';
class HomeController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $options = $bootstrap->getOptions();
        $this->view->auth = $options['auth']['active'];
    }
    /**
     * logout
     */
    public function logoutAction ()
    {
        if (Zend_Session::sessionExists()) {
            Zend_Session::destroy(true, true);
            $this->_redirect('/index/login');
        }
    }
}
