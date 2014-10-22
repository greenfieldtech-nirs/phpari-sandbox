<?php
    /**
     * Created by PhpStorm.
     * User: nirsi_000
     * Date: 10/22/2014
     * Time: 8:22 PM
     */

    class M_events extends CI_Model {

        public function __construct()
        {
            // Call the CI_Model constructor
            parent::__construct();
        }

        public function get_events($username = null)
        {
            $result = false;

            $appdb = $this->load->database("default", TRUE);

            $q_events = "SELECT applications.application_id,applications.application_name,appevents.* FROM applications "
                        ."LEFT JOIN appevents ON applications.application_id = appevents.application_id "
                        ."WHERE applications.email = ? "
                        ."ORDER BY applications.application_name ASC, appevents.stasis_event ASC";

            $r_events = $appdb->query($q_events, array($username));

            $result = array();

            foreach ($r_events->result() as $row) {

                $result[$row->application_name][] = $row->stasis_event;

            }

            return $result;
        }

        public function create_application($appname = null, $appserver = null, $appport = 8088, $appendpoint = "/ari", $apptransport = "ws")
        {
            $result = false;

            return $result;
        }
    }