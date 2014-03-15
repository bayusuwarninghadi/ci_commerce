<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'cadmin.php';

class CUser extends CAdmin
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('user', 'pages');
		$config = array(
			'path' => 'images/user'
		);
		$this->load->model('fupload', '', false, $config);
		$this->load->library('session');
	}

	private function beforePost($data)
	{
		$msg = '';
		$user = (Array)$this->pages->findByEmail($data['s_email']);
		if ($user) {
			$msg = '<div>email is already in use<div>';
		}

		$user = (Array)$this->pages->findByUsername($data['s_username']);
		if ($user) {
			$msg .= '<div>username is already in use</div>';
		}

		if ($msg != '') {
			$this->session->set_userdata('message', $msg);
			header("Location: /admin/user/new");
			exit();
		}

	}

	public function admin($act = '')
	{
		$data['act'] = $act;
		switch ($data['act']) {
			case 'new':
				$post_ = $this->input->post();
				if ($post_) {
					$data['i_user_type'] = 1;
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);
					$exec = $this->pages->createNewAdmin($data);
					if ($exec == 1) {
						$data['pk_i_id'] = mysql_insert_id();
						$msg = 'Success';
						$redirect = '/admin/admin/edit?id=' . $data['pk_i_id'];

					} else {
						$msg = 'data is invalid';
						$redirect = '/admin/admin/new';
					}
					$this->session->set_userdata(array('adminMessage' => $msg));
					header("Location: " . $redirect);
				}

				$data['title'] = 'Add New Admin';
				$this->doView('admin', $data, true);
				break;
			case 'edit':
				$data['pk_i_id'] = $this->input->get('id');
				$post_ = $this->input->post();
				if ($post_) {
					$data['i_user_type'] = 1;
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);
					$exec = $this->pages->updateAdminById($data);
					if ($exec == 1) {
						$msg = 'success';
					} else {
						$msg = 'error updating field';
					}
					$this->session->set_userdata(array('adminMessage' => $msg));
				}
				$page = (Array)$this->pages->findAdminByid($data['pk_i_id']);
				if (!$page) {
					$this->doView('404');
					return;
				}
				$data['page'] = $page[0];
				$data['title'] = $page[0]->s_username;

				$this->doView('admin', $data, true);
				break;
			case 'change_password':
				$data['pk_i_id'] = $this->input->get('id');

				$this->load->model('user', 'users');
				$find_user = (Array)$this->users->findAdminByid($data['pk_i_id']);

				if (!$find_user) {
					$this->doView('404');
					return;
				}

				$find_user = $find_user[0];
				$data['page'] = $find_user;

				$data['title'] = "Change Password";

				$data['password'] = $this->input->post('password');

				if ($this->input->post('password')) {
					$updatePass = $this->users->updateAdminPasswordById($find_user->pk_i_id, md5($data['password']));
					$this->session->set_userdata(array('adminMessage' => $updatePass ? "Change Password Success" : "failed save password"));
					header("Location: /admin/admin/edit?id=" . $find_user->pk_i_id);
					exit;
				}

				$this->doView('change_admin_password', $data);

				break;
			case 'delete':
				$data['pk_i_id'] = $this->input->get('id');
				if ($data['pk_i_id'] == '') return false;
				$page = (Array)$this->pages->findByid($data['pk_i_id']);
				if (!$page) {
					$this->session->set_userdata(array('adminMessage' => 'item not found'));
					header("Location: /admin/user");
				}
				if ($page[0]->s_image) {
					$this->fupload->delete_file($page[0]->s_image);
				}

				$page = $this->pages->deleteAdminByid($data['pk_i_id']);
				if ($page == 1) {
					$msg = 'deleted success';
				} else {
					$msg = 'error during delete the data';
				}
				$this->session->set_userdata(array('adminMessage' => $msg));
				header("Location: /admin/admin");
				break;
			default:
				$data['page'] = $this->input->post('page');
				if (!is_numeric($data['page']) || $data['page'] == '' || $data['page'] < 1) $data['page'] = 1;
				$this->pages->setPage($data['page']);

				$data['s_key'] = $this->input->post('s_key');
				if ($data['s_key'] != '') {
					$this->pages->setKeySearch($data['s_key']);
				}

				$data['pages'] = (Array)$this->pages->doAdminSearch();
				$data['list'] = 'admin';
				if (IS_AJAX) {
					$this->load->view('admin/list', $data);
				} else {
					$data['title'] = 'User';
					$this->doView('admin', $data);
				}
				break;
		}
	}

	public function pages($act = '')
	{
		$data['act'] = $act;
		switch ($data['act']) {
			case 'new':
				$post_ = $this->input->post();
				if ($post_) {
					$data['i_user_type'] = 1;
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);
					$data['s_key'] = randomPassword();
					$data['s_active'] = 1;
					$this->beforePost($data);
					$exec = $this->pages->createNew($data);
					if ($exec == 1) {
						$data['pk_i_id'] = mysql_insert_id();
						$msg = 'Item successfully posted';
						$redirect = '/admin/user/edit?id=' . $data['pk_i_id'];
						if ($_FILES['s_image'] && $data['pk_i_id']) {
							$upload = $this->fupload->do_upload($data['pk_i_id'], 's_image');
							if ($upload) {
								$data['s_image'] = $upload['file_name'];
								$data['dt_modified'] = date('Y-m-d H:i:s');
								$exec = $this->pages->updateImageById($data);
								if ($exec != 1) {
									$msg = 'data is invalid';
									$redirect = '/admin/user/new';
								}
							}
						}
					} else {
						$msg = 'data is invalid';
						$redirect = '/admin/user/new';
					}
					$this->session->set_userdata(array('adminMessage' => $msg));
					header("Location: " . $redirect);
				}

				$data['title'] = 'Add New User';
				$this->doView('user', $data, true);
				break;
			case 'change_password':
				$data['pk_i_id'] = $this->input->get('id');

				$this->load->model('user', 'users');
				$find_user = (Array)$this->users->findByid($data['pk_i_id']);
				if (!$find_user) {
					$this->doView('404');
					return;
				}
				$find_user = $find_user[0];
				$data['page'] = $find_user;

				$data['title'] = "Change Password";

				$data['password'] = $this->input->post('password');

				if ($this->input->post('password')) {
					$updatePass = $this->users->updateUserPasswordByIdAndPass($find_user->pk_i_id, $find_user->s_password, md5($data['password']));
					$this->session->set_userdata(array('adminMessage' => $updatePass ? "Change Password Success" : "failed save password"));
					header("Location: /admin/user/edit?id=" . $find_user->pk_i_id);
					exit;
				}

				$this->doView('change_password', $data);

				break;
			case 'edit':
				$data['pk_i_id'] = $this->input->get('id');
				$post_ = $this->input->post();
				if ($post_) {
					$data['i_user_type'] = 1;
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);
					if ($_FILES['s_image']) {
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
					$data['dt_modified'] = date('Y-m-d H:i:s');
					$exec = $this->pages->updateById($data);
					if ($exec == 1) {
						$msg = 'successss';
					} else {
						$msg = 'error updating field';
					}
					$this->session->set_userdata(array('adminMessage' => $msg));
				}
				$page = (Array)$this->pages->findByid($data['pk_i_id']);
				if (!$page) {
					$this->doView('404');
					return;
				}
				$data['page'] = $page[0];
				$data['title'] = $page[0]->s_name;

				$this->doView('user', $data, true);
				break;
			case 'activate':
				$data['pk_i_id'] = $this->input->get('id');
				$data['s_key'] = $this->input->get('key');
				$exec = $this->pages->activatedByIdAndKey($data['pk_i_id'], $data['s_key']);
				if ($exec == 1) {
					$msg = 'success, User active';
				} else {
					$msg = 'error updating field';
				}
				$this->session->set_userdata(array('adminMessage' => $msg));
				header("Location: /admin/user");
				break;

			case 'deactivate':
				$data['pk_i_id'] = $this->input->get('id');
				$data['s_key'] = $this->input->get('key');
				$exec = $this->pages->deactivatedByIdAndKey($data['pk_i_id'], $data['s_key']);
				if ($exec == 1) {
					$msg = 'success, User deactivate';
				} else {
					$msg = 'error updating field';
				}
				$this->session->set_userdata(array('adminMessage' => $msg));
				header("Location: /admin/user");
				break;

			case 'delete':
				$data['pk_i_id'] = $this->input->get('id');
				if ($data['pk_i_id'] == '') return false;
				$page = (Array)$this->pages->findByid($data['pk_i_id']);
				if (!$page) {
					$this->session->set_userdata(array('adminMessage' => 'item not found'));
					header("Location: /admin/user");
				}
				if ($page[0]->s_image) {
					$this->fupload->delete_file($page[0]->s_image);
				}

				$page = $this->pages->deleteByid($data['pk_i_id']);
				if ($page == 1) {
					$msg = 'deleted success';
				} else {
					$msg = 'error during delete the data';
				}
				$this->session->set_userdata(array('adminMessage' => $msg));
				header("Location: /admin/user");
				break;
			default:
				$data['page'] = $this->input->post('page');
				if (!is_numeric($data['page']) || $data['page'] == '' || $data['page'] < 1) $data['page'] = 1;
				$this->pages->setPage($data['page']);

				$data['s_key'] = $this->input->post('s_key');
				if ($data['s_key'] != '') {
					$this->pages->setKeySearch($data['s_key']);
				}

				$data['pages'] = (Array)$this->pages->doSearch();
				$data['list'] = 'user';
				if (IS_AJAX) {
					$this->load->view('admin/list', $data);
				} else {
					$data['title'] = 'User';
					$this->doView('user', $data);
				}
				break;
		}
	}

	private function prepareData($data)
	{
		if ($this->input->post('pk_i_id')) {
			$data['pk_i_id'] = $this->input->post('pk_i_id');
		}
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

		return $data;
	}

	public function setting()
	{
		if ($this->input->post()) {
			foreach ($this->input->post() as $k => $v) {
				$this->preferences->updateByName($k, nl2br($v));
			}
		}
		$data['title'] = 'Setting';
		$this->doView('setting', $data, true);
	}
}

?>