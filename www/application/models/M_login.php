<?php
/**
 * Created by PhpStorm.
 * User: nirsi_000
 * Date: 10/22/2014
 * Time: 8:22 PM
 */

    class M_login extends CI_Model {

        public function __construct()
        {
            // Call the CI_Model constructor
            parent::__construct();
        }

        public function authenticate($username = null, $password = null)
        {
            return true;
        }


    }