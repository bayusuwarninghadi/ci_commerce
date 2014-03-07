<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CEmail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->load->model('email', 'mEmail');

        $this->email->initialize($config);
    }

    public function send_mail($to_email = '', $email_slug = '', $data = array())
    {
        if (!isEmail($to_email)) {
            return 1;
        }
        $this->email->clear();
        $this->email->from('contact@happytradingfx.com', 'milly and charlote');
        $this->email->to($to_email);

        $content = $this->mEmail->findBySlug($email_slug);
        if (!$content) {
            return 2;
        }
        $content = $content[0];

        $this->email->subject($content->s_name);

        $body = $content->s_body;
        if (isset($data)){
            $body = $this->replace_data($body, $data);
        }
        $body = $this->create_body($body);
        $this->email->message($body);

        if (!$this->email->send())
        {
            return 3;
        }
        return true;
    }
    private function replace_data($content, $replace = array()){
        foreach ($replace as $key => $data) {
            $content = str_replace('{#'.$key.'}',$data,$content);
        }
        return $content;
    }

    private function create_body($content)
    {
        $return =
            "<div>
                <div style='padding: 10px; background: #00aeef; color: #fff; font-size: 14px; font-weight: bold;'>milly and charlote</div>
                <div style='margin: 10px'>";

        $return .= $content;

        $signature = $this->mEmail->findBySlug('signature');
        if ($signature) {
            $return .= $signature[0]->s_body;
        }

        $return .=
            "</div>
                <div style='padding: 10px; background: #00aeef; color: #fff'>Copyrigh flowlace 2013 - present</div>
            </div>";
        return $return;
    }
}

?>