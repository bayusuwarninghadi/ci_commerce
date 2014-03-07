<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('preferences');
        $this->load->model('pages');
    }

    public function doView($file = '404', $data = null)
    {
        if ($file == '404') {
            $data['title'] = 'page not found';
        }
        $data['isLogin'] = $this->session->userdata('isLogin');
        $data['loggedUser'] = $this->session->userdata('user');

        foreach ((array) $this->preferences->listAll() as $set) {
            $preferences[$set->s_name] = $set->s_string;
        }
        $this->session->set_userdata('setting',$preferences);
        $data['setting'] = $this->session->userdata('setting');

        $this->load->model('category');
        $data['categories'] = $this->category->getCategories();

        $data['flash_message'] = $this->session->userdata('message');
        $this->session->set_userdata('message', '');

        $page = (Array)$this->pages->findByid('39');
        $data['store'] = $page[0];

        $this->load->view('catalog/header', $data);
        $this->load->view('catalog/' . $file, $data);
        $this->load->view('catalog/footer', $data);
    }

    public function send_mail($to_email = '', $email_slug = '', $data = array())
    {
        $this->load->library('email');

        $config['protocol'] = 'mail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->load->model('email', 'mEmail');

        $this->email->initialize($config);

        if (!isEmail($to_email)) {
            return 1;
        }
        $this->email->clear();
        $this->email->from('flowlace@gmail.com', 'flowlace');
        $this->email->to($to_email);

        $content = $this->mEmail->findBySlug($email_slug);
        if (!$content) {
            return 2;
        }
        $content = $content[0];

        $this->email->subject($content->s_name);

        $body = $content->s_body;

        $setting = $this->session->userdata('setting');
        foreach ($setting as $key => $val) {
            $data[$key] = $val;
        }
        $data['base_url'] = base_url();

        if ($data){
            $body = mail_replace_data($body, $data);
        }

        $signature = $this->mEmail->findBySlug('signature');
        $signature = $signature[0]->s_body;

        $body = mail_beauty($body, $signature);
        $this->email->message($body);

        if (!$this->email->send())
        {
            return 3;
        }
        return true;
    }


}

?>