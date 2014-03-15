<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require 'general.php';

class CUserNonSecure extends General
{

	function __construct()
	{
		parent::__construct();
	}

	public function subscribe()
	{
		$this->load->helper('form');
		$this->load->helper('url');
		$data['s_email'] = $this->input->post('s_email');
		if (!$data['s_email']) {
			$this->session->set_userdata('message', 'Email is empty, please provide your email, thank you.');
		}
		$this->load->model('subscriber');
		$this->subscriber->setEmail($data['s_email']);
		$exist = (array)$this->subscriber->doSearch();

		if (count($exist) > 0) {
			$this->session->set_userdata('message', 'Your Email already subscriber.');
			header("Location: /");
			exit;
		}


		$this->subscriber->createNew($data['s_email']);
		$this->session->set_userdata('message', 'Thank you. you will receive newsletter from us');

		header("Location: /");
		exit;
	}


	public function register()
	{
		$this->load->helper('form');
		$this->load->helper('url');

		if ($this->session->userdata('isLogin') == true) {
			header("Location: /account");
			exit;
		} else {

			$data['title'] = 'Register';

			$data['s_name'] = $this->input->post('s_name');
			$data['s_email'] = $this->input->post('s_email');
			$data['s_password'] = $this->input->post('s_password');
			$data['s_phone'] = $this->input->post('s_phone');
			$data['s_address'] = $this->input->post('s_address');
			$data['s_website'] = $this->input->post('s_website');
			$data['s_username'] = $this->input->post('s_username');
			$data['i_ktp'] = $this->input->post('i_ktp');
			$data['i_rek'] = $this->input->post('i_rek');
			$data['s_bank'] = $this->input->post('s_bank');
			$data['s_bank_name'] = $this->input->post('s_bank_name');
			$data['agreement'] = $this->input->post('agreement');
			$data['s_active'] = 0;
			# prepare data

			if ($this->input->post()) {

				$data['i_user_type'] = 1;

				$msg = '';
				if ($data['agreement'] != 1) {
					$msg = ('<div>You must accept our agreement</div>');
				}
				if (filter_var($data['s_email'], FILTER_VALIDATE_EMAIL) == false) {
					$msg .= ('<div>invalid email address</div>');
				}
				if (!$data['s_password']) {
					$msg .= ('<div>Password required</div>');
				}

				$this->load->model('user');
				$user = (Array)$this->user->findByEmail($data['s_email']);

				if ($user) {
					$msg .= ('<div>email is already in use</div>');
				}

				if ($msg != '') {
					$this->session->set_userdata('message', $msg);
					$this->doView('register', $data);
					return;
				}

				$data['s_key'] = randomPassword();
				$res = $this->user->createNew($data);
				if ($res) {
					$user = (array)$this->user->findById(mysql_insert_id());
					$email = $this->send_mail($data['s_email'], 'registration_success', (array)$user[0]);
					if ($_FILES && $_FILES['s_image']) {
						$config = array(
							'path' => 'images/user'
						);

						$this->load->model('fupload', '', false, $config);
						// image_name, image_folder, file_param
						$upload = $this->fupload->do_upload($data['pk_i_id'], 's_image');
						if ($upload) {
							$data['s_image'] = $upload['file_name'];
							$exec = $this->pages->updateImageById($data);
							if ($exec != 1) {
								$msg = 'error uploading image';
							}
						}
					}

					$this->load->model('subscriber');
					$this->subscriber->createNew($data['s_email']);
					if ($email) {
						$this->session->set_userdata("message", "registration success, check the following link on your email");
					}
					header("Location: /");
					exit;
				}

			} else {
				$this->doView('register', $data);
			}
		}
	}

	public function activated($userId = '', $key = '')
	{
		if ($userId == '' || $key == '') {
			$this->session->set_userdata("message", "invalid key");
			header("Location: /");
		}
		$this->load->model('user');

		$exec = $this->user->activatedByIdAndKey($userId, $key);
		if ($exec) {
			$user = (Array)$this->user->findById($userId);
			$this->load->library('session');
			$sessionData = array(
				'isLogin' => 1,
				'user' => $user[0],
				'message' => 'Welcome ' . $user[0]->s_name
			);
			$this->session->set_userdata($sessionData);
			$this->session->set_userdata("message", "Succes, user active and happy shopping " . $user[0]->s_name);
			header("Location: /");
		}
	}

	public function change_email($key = null)
	{
		if ($key == null) {
			$this->session->set_userdata("message", "invalid key");
			header("Location: /");
		}

		$key = explode(',', $key = base64_decode(str_replace('d3V1l', '=', $key)));

		$data['pk_i_id'] = $key[0];
		$data['s_key'] = $key[1];
		$data['s_email'] = $key[2];

		$this->load->model('user', 'pages');
		$page = (Array)$this->pages->findByIdAndKey($data['pk_i_id'], $data['s_key']);

		if (!$page) {
			$this->session->set_userdata("message", "invalid key combination");
			header("Location: /");
		}

		$exec = $this->pages->updateEmailById($data);
		if ($exec == 1) {
			$msg = 'Thank you, your profile has been update';
		} else {
			$msg = 'error updating email';
		}

		$this->session->set_userdata(array('message' => $msg));

		$data['page'] = $page[0];
		$data['title'] = $page[0]->s_name;

		header("Location: /");
	}


	public function login()
	{
		if ($this->session->userdata('isLogin') == true) {
			header("Location: /account");
			exit;
		} else {
			$post_ = $this->input->post();
			$data['title'] = 'Login';
			if ($post_) {
				$this->load->helper('form');
				$this->load->helper('url');
				$email = $this->input->post('s_email');
				$password = $this->input->post('s_password');
				if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
					$this->session->set_userdata('message', 'invalid email address');
					header("Location: /login");
					exit;
				}

				$this->load->model('user');
				$user = (Array)$this->user->findByEmailAndPassword($email, md5($password));
				if ($user && $user[0]->s_active == 0) {
					$this->session->set_userdata('message', 'please activate your account first');
					header("Location: /login");
					exit;
				}

				if ($user) {
					$this->load->library('session');
					$sessionData = array(
						'isLogin' => 1,
						'user' => $user[0],
						'message' => 'Welcome ' . $user[0]->s_name
					);
					$this->session->set_userdata($sessionData);
					header("Location: /account");
					exit;
				} else {
					$this->session->set_userdata('message', 'invalid combination email and password');
					header("Location: /login");
					exit;
				}
			} else {
				$this->doView('login', $data);
			}
		}
	}

	public function contact()
	{
		$data['title'] = 'Contact';
		$post_ = $this->input->post();
		if ($post_) {
			$data = array_merge($data, $post_);
			$this->load->model('contact');
			$exec = $this->contact->createNew($data);
			if ($exec == 1) {
				$msg = 'thanks for supporting Us';
			} else {
				$msg = 'data is invalid';
			}

			$this->session->set_userdata(array('message' => $msg));
		}

		$this->doView('contact', $data);
	}

}

?>