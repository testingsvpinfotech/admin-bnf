<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website_manager_controller extends CI_Controller {

    
        public function __construct(){
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('session');
         }

         public function index(){
            $this->load->view('vendor/include/header');
            $this->load->view('vendor/home');
            $this->load->view('vendor/include/footer');
         }

        
}         