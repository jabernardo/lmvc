<?php

namespace App\Controller\Core;

use \Lollipop\Config;
use \Lollipop\Cookie;
use \Lollipop\CsrfToken;
use \Lollipop\Log;
use \Lollipop\Page;
use \Lollipop\HTTP\Response;
use \Lollipop\Url;

/**
 * Base Controller
 * 
 * @package Lollipop for MVC
 * @author  John Aldrich Bernardo
 * @version 1.1
 * 
 */
class Base
{
    /**
     * Class Construct
     * 
     */
    function __construct() {
        /**
         * @var     \stdClass    View variable holder
         * 
         */
        $this->view = new \stdClass();
        
        /**
         * @var     array   Cookies
         * 
         */
        $this->cookies = [];
        
        /**
         * @var     array   Headers
         * 
         */
        $this->headers = [];
        
        // Set all default view variables on class constuct
        $this->_setDefaultView();
    }
    
    /**
     * Set default view variables
     * 
     * @access  private
     * @return  void
     * 
     */
    private function _setDefaultView() {
        /**
         * @var string  Title
         * 
         */
        $this->view->title = Config::get('app')->name;
        
        /**
         * @var string  Page
         * 
         */
        $this->view->page = 'home';
        
        /**
         * @var array   JS Files
         * 
         */
        $this->view->js = [];
        
        /**
         * @var array   CSS Files
         * 
         * 
         */
        $this->view->css = [];

        /**
         * @var string  Domain name
         * 
         */
        $this->view->domain = Url::base();
        
        /**
         * @var string  Request URI
         * 
         */
        $this->view->request_uri = Url::here();
        
        /**
         * @var string  Csrf Token
         * 
         */
        $this->view->form = (object) [
            'anti_csrf_input' => CsrfToken::getFormInput()
        ];
    }
    
    /**
     * Generate data
     * 
     * @access  private
     * @return  array
     * 
     */
    private function _getViewData() {
        $d = [];
        
        // Build-up data
        foreach (get_object_vars($this->view) as $var => $val) {
            $d[$var] = $val;
        }
        
        return $d;
    }
    
    /**
     * Process response
     * 
     * @access  private
     * @
     * 
     */
    private function _createResponse($page) {
        // Render view
        $rendered = Page::render(APP_CORE_VIEW . $page . '.php', $this->_getViewData());
        
        // Create response
        $response = new Response($rendered);
        
        // Set response cookies
        $response->cookies($this->cookies);
        
        // Set response headers
        $response->header($this->headers);

        return $response;
    }
    
    /**
     * Render structure
     * 
     * @access  public
     * @param   string   $struct
     * @return  string
     * 
     */
    public function render($page) {
        return $this->_createResponse($page);
    }
}