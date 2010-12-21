<?php
/**
 * App_Plugin_SessionCheck
 * 
 * @author Enrico Zimuel (enrico@zimuel.it)
 * @version 0.2
 */
class App_Plugin_SessionCheck extends Zend_Controller_Plugin_Abstract
{
    /**
     * preDispatch
     */
    public function preDispatch (Zend_Controller_Request_Abstract $request)
    {
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $options = $bootstrap->getOptions();
        $controller = $this->getRequest()->getControllerName();
        if (($controller != 'index') && ($controller != 'error')) {
            if ($options['auth']['active']) {
                $this->checkSession();
            }
        }
    }
    /**
     * checkSession
     */
    public function checkSession ()
    {
        $session = Zend_Registry::get('session');
        if (empty($session->username)) {
            $this->getResponse()->setRedirect('/index/login')->sendResponse();
            exit;
        }
    }
}
