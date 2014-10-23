<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Ajax extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();

            return TRUE;
        }

        public function get_application($appname)
        {
            $result = FALSE;

            $appdb = $this->load->database("default", TRUE);

            $q_eventCode = "SELECT * FROM applications WHERE application_name=? and email=?";

            $r_eventCode = $appdb->query($q_eventCode, array($appname, $this->session->userdata('email')));
            $row         = $r_eventCode->row();

            echo json_encode($row);
        }

        public function get_event_code($appname, $eventname)
        {
            $result = FALSE;

            $appdb = $this->load->database("default", TRUE);

            $q_eventCode = "SELECT applications.application_id,applications.application_name,appevents.* FROM applications "
                . "LEFT JOIN appevents ON applications.application_id = appevents.application_id "
                . "WHERE applications.application_name = ? "
                . "AND appevents.stasis_event=? "
                . "ORDER BY applications.application_name ASC, appevents.stasis_event ASC";

            $r_eventCode = $appdb->query($q_eventCode, array($appname, $eventname));
            $row         = $r_eventCode->row();

            echo json_encode($row);

        }

        public function generate_app($appname)
        {

            $result = FALSE;

            $header = file_get_contents("../html/blocks/stasis_header.txt");
            $footer = file_get_contents("../html/blocks/stasis_footer.txt");

            $appdb = $this->load->database("default", TRUE);

            $q_events = "SELECT applications.application_id,applications.application_name,appevents.* FROM applications "
                . "LEFT JOIN appevents ON applications.application_id = appevents.application_id "
                . "WHERE applications.application_name = ? "
                . "ORDER BY applications.application_name ASC, appevents.stasis_event ASC";
            $r_events = $appdb->query($q_events, array($appname));

            $eventsCode = "";

            foreach ($r_events->result() as $eventData) {
                $eventsCode .= "\n\n/** EVENT: " . $eventData->stasis_event . " **/\n\n";
                $eventsCode .= "\$this->stasisEvents->on(\"$eventData->stasis_event\", function (\$event) {\n";
                $eventsCode .= $eventData->sourcecode . "\n";
                $eventsCode .= "});\n";
            }

            $orignalOutput = $header . "\n" . $eventsCode . "\n" . $footer;

            $output = str_replace("%PHP_TAG%", "<?php", $orignalOutput);
            $output = str_replace("%APPNAME_TEMPLATE%", $appname, $output);

            file_put_contents("../html/generated/" . $appname . ".php", $output);

            echo json_encode(array('sourcecode' => $output));

        }

        function exec_app($appname)
        {
            exec("cd C:\\xampp\\htdocs\\phpari-sandbox\\www\\html\\generated");
            exec("C:\\xampp\\php\\php C:\\xampp\\htdocs\\phpari-sandbox\\www\\html\\generated\\" . $appname . ".php");
        }

        function update_event()
        {
            $appdb = $this->load->database("default", TRUE);

            $sourceCode = $this->input->post('sourcecode', TRUE);
            $appid      = $this->input->post('appid', TRUE);
            $eventname  = $this->input->post('event', TRUE);

            $q_eventCode = "UPDATE appevents set sourcecode = ? where stasis_event = ? and application_id = ?";

            $r_eventCode = $appdb->query($q_eventCode, array($sourceCode, $eventname, $appid));

            echo json_encode(array("message" => "Updated"));
        }
    }

