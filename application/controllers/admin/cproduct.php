<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'cadmin.php';

class CProduct extends CAdmin
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('product');
		$this->load->library('session');
	}

	public function pages($act = '')
	{
		$data['act'] = $act;
		switch ($data['act']) {
			case 'new':
				$post_ = $this->input->post();
				$this->load->model('category');
				$data['categories'] = $this->category->getCategories();
				if ($post_) {
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);
					$exec = $this->product->createNew($data);
					if ($exec == 1) {
						$data['pk_i_id'] = mysql_insert_id();
						$msg = 'Item successfully posted';
						$redirect = '/admin/product/edit?id=' . $data['pk_i_id'];

						$data['dt_modified'] = date('Y-m-d H:i:s');

						$upload = false;
						$config = array(
							'path' => 'images/product'
						);
						$this->load->model('fupload', '', false, $config);

						if ($_FILES['s_image']['error'] == 0) {
							$upload = $this->fupload->do_upload($data['pk_i_id'] . '_1', 's_image');
							$data['s_image']['s_image'] = $upload['file_name'];
						}
						if ($_FILES['s_image2']['error'] == 0) {
							$upload = $this->fupload->do_upload($data['pk_i_id'] . '_2', 's_image2');
							$data['s_image']['s_image2'] = $upload['file_name'];
						}
						if ($_FILES['s_image3']['error'] == 0) {
							$upload = $this->fupload->do_upload($data['pk_i_id'] . '_3', 's_image3');
							$data['s_image']['s_image3'] = $upload['file_name'];
						}
						if ($_FILES['s_image4']['error'] == 0) {
							$upload = $this->fupload->do_upload($data['pk_i_id'] . '_4', 's_image4');
							$data['s_image']['s_image4'] = $upload['file_name'];
						}
						if ($upload) {
							$exec = $this->product->updateImageById($data);
							if ($exec != 1) {
								$msg = 'data is invalid';
								$redirect = '/admin/product/new';
							}
						}
					} else {
						$msg = 'data is invalid';
						$redirect = '/admin/product/new';
					}
					$this->session->set_userdata(array('adminMessage' => $msg));
					header("Location: " . $redirect);
				}
				$data['fk_i_cat_id'] = '';
				$data['s_color'] = array();
				$data['s_size'] = array();
				$data['title'] = 'Add New product';
				$this->doView('product', $data, true);
				break;
			case 'edit':
				$data['pk_i_id'] = $this->input->get('id');
				$post_ = $this->input->post();
				$this->load->model('category');
				$data['categories'] = $this->category->getCategories();
				if ($post_) {
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);

					$data['dt_modified'] = date('Y-m-d H:i:s');
					$upload = false;
					$config = array(
						'path' => 'images/product'
					);

					if ($_FILES['s_image']['error'] == 0) {
						$this->load->model('fupload', '', false, $config);
						$upload = $this->fupload->do_upload($data['pk_i_id'] . '_1', 's_image');
						$data['s_image']['s_image'] = $upload['file_name'];
					}
					if ($_FILES['s_image2']['error'] == 0) {
						$this->load->model('fupload', '', false, $config);
						$upload = $this->fupload->do_upload($data['pk_i_id'] . '_2', 's_image2');
						$data['s_image']['s_image2'] = $upload['file_name'];
					}
					if ($_FILES['s_image3']['error'] == 0) {
						$this->load->model('fupload', '', false, $config);
						$upload = $this->fupload->do_upload($data['pk_i_id'] . '_3', 's_image3');
						$data['s_image']['s_image3'] = $upload['file_name'];
					}
					if ($_FILES['s_image4']['error'] == 0) {
						$this->load->model('fupload', '', false, $config);
						$upload = $this->fupload->do_upload($data['pk_i_id'] . '_4', 's_image4');
						$data['s_image']['s_image4'] = $upload['file_name'];
					}
					if ($upload) {
						$exec = $this->product->updateImageById($data);
						if ($exec != 1) {
							$msg = 'data is invalid';
							$redirect = '/admin/product/new';
						}
					}

					$exec = $this->product->updateById($data);

					if ($exec == 1) {
						$msg = 'success';
					} else {
						$msg = 'error updating field';
					}
					$this->session->set_userdata(array('adminMessage' => $msg));
				}
				$this->product->setId($data['pk_i_id']);
				$page = (Array)$this->product->doSearch($data['pk_i_id']);
				if (!$page) {
					$this->doView('404');
					return;
				}
				$data['page'] = $page[0];
				$data['fk_i_cat_id'] = $data['page']->fk_i_cat_id;
				$data['title'] = $page[0]->s_name;
				$data['s_color'] = (array)explode(',', $data['page']->s_color);
				$data['s_size'] = (array)explode(',', $data['page']->s_size);

				$this->doView('product', $data, true);
				break;
			case 'delete':
				$data['pk_i_id'] = $this->input->get('id');
				if ($data['pk_i_id'] == '') return false;

				$this->product->setId($data['pk_i_id']);
				$page = (Array)$this->product->doSearch($data['pk_i_id']);

				if (!$page) {
					$this->session->set_userdata(array('adminMessage' => 'item not found'));
					header("Location: /admin/product");
				}
				$config = array(
					'path' => 'images/product'
				);
				$this->load->model('fupload', '', false, $config);

				if ($page[0]->s_image) {
					$this->fupload->delete_file($page[0]->s_image);
				}
				if ($page[0]->s_image2) {
					$this->fupload->delete_file($page[0]->s_image2);
				}
				if ($page[0]->s_image3) {
					$this->fupload->delete_file($page[0]->s_image3);
				}
				if ($page[0]->s_image4) {
					$this->fupload->delete_file($page[0]->s_image4);
				}

				$page = $this->product->deleteByid($data['pk_i_id']);
				if ($page == 1) {
					$msg = 'deleted success';
				} else {
					$msg = 'error during delete the data';
				}
				$this->session->set_userdata(array('adminMessage' => $msg));
				header("Location: /admin/product");
				break;
			default:
				$data['s_color'] = (array)$this->input->post('s_color');
				$this->load->model('category');
				$data['categories'] = $this->category->getCategories();

				$data['page'] = $this->input->post('page');
				if (!is_numeric($data['page']) || $data['page'] == '' || $data['page'] < 1) $data['page'] = 1;
				$this->product->setPage($data['page']);

				if ($data['s_color']) {
					$this->product->setColor($data['s_color']);
				}

				$data['fk_i_cat_id'] = $this->input->post('fk_i_cat_id');
				if ($data['fk_i_cat_id']) {
					$this->product->setCat($data['fk_i_cat_id']);
				}

				$data['s_size'] = (array)$this->input->post('s_size');
				if (isset($data['s_size'])) {
					$this->product->setSize($data['s_size']);
				}

				$data['s_key'] = $this->input->post('s_key');
				if ($data['s_key'] != '') {
					$this->product->setKey($data['s_key']);
				}
				$data['pages'] = (Array)$this->product->doSearch();
				$data['list'] = 'product';
				if (IS_AJAX) {
					$this->load->view('admin/list', $data);
				} else {
					$data['title'] = 'product';
					$this->doView('product', $data);
				}
				break;
		}
	}

	private function prepareData($data)
	{
		if ($this->input->post('pk_i_id')) {
			$data['pk_i_id'] = $this->input->post('pk_i_id');
		}
		$data['s_color'] = $this->input->post('s_color');
		if ($data['s_color']) {
			$data['s_color'] = implode(',', $data['s_color']);
		}
		$data['s_size'] = $this->input->post('s_size');
		if ($data['s_size']) {
			$data['s_size'] = implode(',', $data['s_size']);
		}
		$data['s_name'] = $this->input->post('s_name');
		$data['i_price'] = $this->input->post('i_price');
		$data['i_sale'] = $this->input->post('i_sale');
		$data['i_size'] = $this->input->post('i_size');
		$data['s_slug'] = htmlentities(str_replace(' ', '_', strtolower($data['s_name'])));
		$data['s_body'] = $this->input->post('s_body');
		$data['fk_i_cat_id'] = $this->input->post('fk_i_cat_id');
		return $data;
	}
}

?>