<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session extends CI_Session {

    public function setForm($arr = array(), $newData = ''){
        $this->set_userdata($arr);
    }
}

?>