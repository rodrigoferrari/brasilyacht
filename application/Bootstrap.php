<?php
/**
 * Bootstrap
 * 
 * @author Enrico Zimuel (enrico@zimuel.it)
 * @version 0.2
 *
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initModuleAutoloader ()
    {
        $al = new Zend_Application_Module_Autoloader(array('namespace' => 'App' , 'basePath' => dirname(__FILE__)));
    }
    protected function _initView ()
    {
        // Initialize view
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('ZF Secure Login');
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }
    
    protected function _initSession ()
    {
        $options = $this->getOptions();
        $session = new Zend_Session_Namespace($options['resources']['session']['namespace']);
        Zend_Registry::set('session', $session);
    }
	
}

