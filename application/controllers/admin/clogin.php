<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CLogin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	public function index()
	{
		if ($this->session->userdata('isAdminLogin')) {
			header("Location: /admin");
		}
		$post_ = $this->input->post();
		if ($post_) {
			$email = $this->input->post('s_email');
			$password = $this->input->post('s_password');

			$this->load->model('user');
			$user = (Array)$this->user->findAdminByEmailAndPassword($email, md5($password));

			if ($user) {
				$this->load->library('session');
				$sessionData = array(
					'isAdminLogin' => $user[0]->s_level,
					'loginAdminName' => $user[0]->s_username,
					'loginAdminEmail' => $user[0]->s_email,
					'adminMessage' => 'Welcome Admin ' . $user[0]->s_username
				);
				$this->session->set_userdata($sessionData);
				header("Location: /admin");
			} else {
				$this->session->set_userdata('adminMessage', 'invalid combination email and password');
			}
		}
		$data['title'] = 'Flowlace Admin';
		$this->doView('login', $data);
	}

	public function doView($file = '404', $data = array())
	{
		$this->load->model('preferences');
		foreach ((array)$this->preferences->listAll() as $set) {
			$preferences[$set->s_name] = $set->s_string;
		}
		$this->session->set_userdata('setting', $preferences);
		$data['setting'] = $this->session->userdata('setting');

		$data['isAdminLogin'] = $this->session->userdata('isAdminLogin');
		$data['loginAdminName'] = $this->session->userdata('loginAdminName');
		$data['loginAdminEmail'] = $this->session->userdata('loginAdminEmail');

		$data['flash_message'] = $this->session->userdata('adminMessage');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/' . $file, $data);
		$this->load->view('admin/footer', $data);
	}
}

?>