<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require 'general.php';
class CSession extends General
{
      function __construct()
      {
            parent::__construct();
            $this->load->library('session');
      }

      public function pages($case)
      {
            switch ($case) {
                  case 'set' :
                        $key = $this->input->get('key');
                        $value = $this->input->get('value');
                        $this->session->set_userdata($key, $value);
                        echo 'ok';
                        break;
                  case 'get' :
                        $key = $this->input->post('key');
                        echo $this->session->userdata($key);
                        break;
                  default:
                        echo json_encode($this->session->userdata());
                        break;

            }
      }

}

?>