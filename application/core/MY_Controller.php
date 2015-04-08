<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = "Top Secret Government Site";    // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    function render() {
        $this->data['menubar'] = $this->parser->parse('_menubar', $this->makemenu(),true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->data['sessionid'] = session_id();
        
        // finally, build the browser page!
        $this->data['data'] = &$this->data;        
        $this->parser->parse('_template', $this->data);
    }
    
    function makemenu()
    {
        $userRole = $this->session->userdata('userRole');
        //add menu depending on what authorization the user has
        $this->menu = array( array('name' => "Alpha", 'link' => '/alpha') );
        
        if ($userRole == ROLE_USER || $userRole == ROLE_ADMIN ) {
            array_push($this->menu, array('name' => "Beta", 'link' => '/beta') );
        }
            
        if ($userRole == ROLE_ADMIN ) {
            array_push($this->menu, array('name' => "Gamma", 'link' => '/gamma') );
        }            
        
        //add menu depending on if the user is logged in or not
        if ($userRole == null) {
            array_push($this->menu, array('name' => "Login", 'link' => '/auth') );
        }
            
        if ($userRole != null) {
            array_push($this->menu, array('name' => "Logout", 'link' => '/auth/logout') );
        }            
        
        //return the menu array to the render function
        $this->something = array('menudata' => $this->menu);
        return $this->something;
    }

    function restrict($roleNeeded = null) {
    $userRole = $this->session->userdata('userRole');
    if ($roleNeeded != null) {
      if (is_array($roleNeeded)) {
        if (!in_array($userRole, $roleNeeded)) {
          redirect("/");
          return;
        }
      } else if ($userRole != $roleNeeded) {
        redirect("/");
        return;
      }
  }
}
}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */