<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'cadmin.php';

class CArticle extends CAdmin
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('article', 'pages');
        $config = array(
            'path' => 'images/article'
        );
        $this->load->model('fupload', '', false, $config);
        $this->load->library('session');
    }

    public function pages($act = '')
    {
        $data['act'] = $act;
        switch ($data['act']) {
            case 'new':
                $post_ = $this->input->post();
                if ($post_) {
                    $post_ = $this->prepareData($post_);
                    $data = array_merge($data, $post_);
                    $exec = $this->pages->createNew($data);
                    if ($exec == 1) {
                        $data['pk_i_id'] = mysql_insert_id();
                        $msg = 'Item successfully posted';
                        $redirect = '/admin/article/edit?id=' . $data['pk_i_id'];
                        if ($_FILES['s_image'] && $data['pk_i_id']) {
                            $upload = $this->fupload->do_upload($data['pk_i_id'], 's_image');
                            if ($upload) {
                                $data['s_image'] = $upload['file_name'];
                                $data['dt_modified'] = date('Y-m-d H:i:s');
                                $exec = $this->pages->updateImageById($data);
                                if ($exec != 1) {
                                    $msg = 'data is invalid';
                                    $redirect = '/admin/article/new';
                                }
                            }
                        }
                    } else {
                        $msg = 'data is invalid';
                        $redirect = '/admin/article/new';
                    }
                    $this->session->set_userdata(array('adminMessage' => $msg));
                    header("Location: " . $redirect);
                }

                $data['title'] = 'Add New Article';
                $this->doView('article', $data, true);
                break;
            case 'edit':
                $data['pk_i_id'] = $this->input->get('id');
                $post_ = $this->input->post();
                if ($post_) {
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
                        $msg = 'success';
                    } else {
                        $msg = 'error updating field';
                    }
                    $this->session->set_userdata(array('adminMessage' => $msg));
                }
                $this->pages->setId($data['pk_i_id']);
                $page = (Array)$this->pages->doSearch();
                if (!$page) {
                    $this->doView('404');
                    return;
                }
                $data['page'] = $page[0];
                $data['title'] = $page[0]->s_name;

                $this->doView('article', $data, true);
                break;
	        case 'delete-image':
		        $data['pk_i_id'] = $this->input->get('id');
		        $data['image_id'] = $this->input->get('image-id');

		        $config = array(
			        'path' => 'images/article'
		        );

		        $this->pages->deleteImage($data);

		        $this->load->model('fupload', '', false, $config);
		        $this->fupload->delete_file($data['image_id']);

		        break;
	        case 'delete':
                $data['pk_i_id'] = $this->input->get('id');
                if ($data['pk_i_id'] == '') return false;
                $this->pages->setId($data['pk_i_id']);
                $page = (Array)$this->pages->doSearch();

                if (!$page) {
                    $this->session->set_userdata(array('adminMessage' => 'item not found'));
                    header("Location: /admin/article");
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
                header("Location: /admin/article");
                break;
            default:
                $data['page'] = $this->input->post('page');
                if (!is_numeric($data['page']) || $data['page'] == '' || $data['page'] < 1) $data['page'] = 1;
                $this->pages->setPage($data['page']);

                $data['s_key'] = $this->input->post('s_key');
                if ($data['s_key'] != '') {
                    $this->pages->setKey($data['s_key']);
                }

                $data['pages'] = (Array)$this->pages->doSearch();
                $data['list'] = 'article';
                if (IS_AJAX) {
                    $this->load->view('admin/list', $data);
                } else {
                    $data['title'] = 'Article';
                    $this->doView('article', $data);
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
        $data['s_slug'] = htmlentities(strtolower($data['s_name']));
        $data['s_body'] = $this->input->post('s_body');
        return $data;
    }
}

?>