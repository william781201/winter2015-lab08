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
        $menuinfo = array('menudata' => $this->makemenu());
        $this->data['menubar'] = $this->parser->parse('_menubar', $menuinfo, true);
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        
        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->data['sessionid'] = session_id();
        $this->parser->parse('_template', $this->data);
    }
    
    function makemenu() {
        // Get role and name from session
        $name = $this->session->userdata('userName');
        $role = $this->session->userdata('userRole');        
        if (strcmp($role, "admin") == 0) {
            $menu = array(
                    array('name' => "Alpha", 'link' => '/alpha'),
                    array('name' => "Beta", 'link' => '/beta'),
                    array('name' => "Gamma", 'link' => '/gamma'),
                    array('name' => "Logout", 'link' => '/auth/logout'), );
        }else if (strcmp($role, "user") == 0) {
            $menu = array(
                    array('name' => "Alpha", 'link' => '/alpha'),
                    array('name' => "Beta", 'link' => '/beta'),
                    array('name' => "Logout", 'link' => '/auth/logout'), );
        }else {
            $menu = array(
                    array('name' => "Alpha", 'link' => '/alpha'),
                    array('name' => "Login", 'link' => '/auth'), );
        }                
        return $menu;
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