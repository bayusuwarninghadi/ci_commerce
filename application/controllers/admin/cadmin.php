<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CAdmin extends CI_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('preferences');

        if ($this->session->userdata('isAdminLogin') == false){
            header("Location: /admin/login");
        }
    }

    public function index()
    {
        $data['title'] = 'dashboard';

        $this->load->model('checkout');
        $this->checkout->setPageLength(5);
        $data['checkout'] = (Array)$this->checkout->doSearch();

        $this->load->model('contact');
        $this->contact->setPageLength(5);
        $data['inbox'] = (Array)$this->contact->doSearch();

        $this->load->model('product');
        $this->product->setPageLength(5);
        $data['product'] = (Array)$this->product->doSearch();

        $this->doView('dashboard', $data);
    }

    public function adminLogin(){
        $email = $this->input->post('s_email');
        $password = $this->input->post('s_password');

        $this->load->model('user');
        $user = (Array)$this->user->findAdminByEmailAndPassword($email, md5($password));

        if ($user) {
            $this->load->library('session');

            $sessionData = array(
                'isAdminLogin' => $user[0]->s_level,
                'loginAdminName' => $user[0]->s_name,
                'loginAdminEmail' => $user[0]->s_email,
                'adminMessage' => 'Welcome Admin '.$user[0]->s_name
            );
            $this->session->set_userdata($sessionData);
        } else {
            $this->session->set_userdata('adminMessage', 'invalid combination email and password');
        }

        header("Location: /admin");
    }

    public function adminLogout(){
        $this->load->library('session');
        $sessionData = array('isAdminLogin' => 0,'loginAdminName' => '','loginAdminEmail' => '');
        $this->session->set_userdata($sessionData);
        header("Location: /admin");
                
    }

    public function doView($file = '404', $data = array(), $loadCkeditor = false){

        foreach ((array) $this->preferences->listAll() as $set) {
            $preferences[$set->s_name] = $set->s_string;
        }
        $this->session->set_userdata('setting',$preferences);
        $data['title'] = isset($data['title']) ? $data['title'] : '';
        $data['setting'] = $this->session->userdata('setting');
        $data['isAdminLogin'] = $this->session->userdata('isAdminLogin');
        $data['loginAdminName'] = $this->session->userdata('loginAdminName');
        $data['loginAdminEmail'] = $this->session->userdata('loginAdminEmail');

        $data['flash_message'] = $this->session->userdata('adminMessage');
        $this->session->set_userdata('adminMessage', '');

        $this->load->view('admin/header', $data);
        if ($loadCkeditor) {
            $this->load->view('ckeditor');
        }
        $this->load->view('admin/'.$file, $data);
        $this->load->view('admin/footer', $data);
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

        $setting = $this->session->userdata('setting');
        foreach ($setting as $key => $val) {
            $data[$key] = $val;
        }
        $data['base_url'] = base_url();

        if ($email_slug) {
            $content = $this->mEmail->findBySlug($email_slug);
            if (!$content) {
                return 2;
            }
            $content = $content[0];
            $this->email->subject($content->s_name);
            $body = $content->s_body;
            if ($data){
                $body = mail_replace_data($body, $data);
            }
        } else {
            $body = $data['body'];
            $this->email->subject($data['subject']);
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