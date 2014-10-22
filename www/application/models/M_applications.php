<?php
    /**
     * Created by PhpStorm.
     * User: nirsi_000
     * Date: 10/22/2014
     * Time: 8:22 PM
     */

    class M_applications extends CI_Model {

        public function __construct()
        {
            // Call the CI_Model constructor
            parent::__construct();
        }

        public function get_applications($username = null)
        {
            $result = false;

            $appdb = $this->load->database("default", TRUE);

            $q_applications = "SELECT * FROM applications where email=?";
            $r_applications = $appdb->query($q_applications, array($this->session->userdata('email')));

            $result = $r_applications->result();

            return $result;
        }

        public function create_application($appname = null, $appserver = null, $appport = 8088, $appendpoint = "/ari", $apptransport = "ws")
        {
            $result = false;

            return $result;
        }
    }