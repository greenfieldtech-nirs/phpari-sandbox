<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Login extends CI_Controller {

        public function index()
        {

            /*
            echo "<pre>";
            print_r($_SERVER);
            echo "</pre>";
            */

            $this->session->set_userdata('BASEPATH', $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);
            $this->load->view('v_login');
        }

        public function authenticate()
        {
            $this->load->model('m_login');

            $result = $this->m_login->authenticate($this->input->post('email', TRUE), $this->input->post('key', TRUE));

            /**
             * TODO: add proper checkups in here
             */
            $this->session->set_userdata(array('loggedin'=>1, 'email'=>$this->input->post('email')));

            redirect( $this->session->userdata('BASEPATH') . '/welcome', 'refresh', 302);
        }

        public function logout()
        {
            $this->session->set_userdata(array('loggedin'=>0));

            redirect($this->session->userdata('BASEPATH'), 'refresh', 302);
        }
    }

    /* End of file welcome.php */
    /* Location: ./application/controllers/Welcome.php */