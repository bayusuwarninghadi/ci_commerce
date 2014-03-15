<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'cadmin.php';

class CCategory extends CAdmin
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('category');

	}

	public function pages($act = '')
	{
		$data['act'] = $act;
		switch ($data['act']) {
			case 'new':
				$data['title'] = 'Add New Category';
				$post_ = $this->input->post();
				if ($post_) {
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);
					$this->category->createNew($data);
					header("Location: /admin/category");
				} else {
					$data['categories'] = $this->category->getCategories();
					$data['fk_i_cat_id'] = '';
					$this->doView('category', $data);
				}

				break;
			case 'edit':
				$data['id'] = $this->input->get('id');
				$post_ = $this->input->post();
				if ($post_) {
					$post_ = $this->prepareData($post_);
					$data = array_merge($data, $post_);


					header("Location: /admin/category");
				} else {
					$cat = (Array)$this->category->findByid($data['id']);
					if (!$cat) {
						$this->doView('404');
						return;
					}
					$data['categories'] = $this->category->getCategories();
					$data['page'] = $cat[0];
					$data['title'] = $cat[0]->s_name;
					$data['fk_i_cat_id'] = $cat[0]->i_parent_id;
					$this->doView('category', $data);
				}
				break;
			case 'delete':
				$data['id'] = $this->input->get('id');
				if ($data['id'] == '') return false;
				$article = (Array)$this->category->deleteByid($data['id']);
				if (!$article) {
					echo 'Category not found';
					return;
				}
				header("Location: /admin/category");
				break;
			default:
				$data['categories'] = $this->category->getCategories();
				$data['title'] = 'Category';
				$this->doView('category', $data);
				break;
		}
	}

	private function prepareData($data)
	{
		$data['pk_i_id'] = $this->input->post('pk_i_id');
		$data['s_name'] = $this->input->post('s_name');
		$data['i_parent_id'] = $this->input->post('i_parent_id');

		$data['s_slug'] = str_replace(' ', '_', strtolower($data['s_name']));
		$data['s_url'] = '/' . $data['s_slug'];

		if ($data['i_parent_id'] != 0) {
			$parent = (Array)$this->category->findByid($data['i_parent_id']);
			$parent = $parent[0];
			$data['s_url'] = $parent->s_url . $data['s_url'];
		}
		return $data;
	}
}

?>