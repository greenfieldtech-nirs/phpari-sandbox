<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('ini');
    }

	public function index()
	{
        $this->load->model('m_applications', 'applications');
        $this->load->model('m_events', 'events');

        $applications = $this->applications->get_applications($this->session->userdata('email'));
        $events = $this->events->get_events($this->session->userdata('email'));

		$this->load->view('v_main', array('applications'=>$applications, 'events'=>$events));
	}

    public function applications()
    {
        $this->load->model('m_applications', 'applications');
        $this->load->model('m_events', 'events');

        $applications = $this->applications->get_applications($this->session->userdata('email'));
        $events = $this->events->get_events($this->session->userdata('email'));

        $this->load->view('v_applications', array('applications'=>$applications, 'events'=>$events));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/Welcome.php */