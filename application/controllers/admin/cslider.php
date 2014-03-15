<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'cadmin.php';

class Cslider extends CAdmin
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('slider', 'pages');
        $config = array(
            'path' => 'images/slider'
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
                        $redirect = '/admin/slider/edit?id=' . $data['pk_i_id'];
                        if ($_FILES['s_image'] && $data['pk_i_id']) {
                            $upload = $this->fupload->do_upload($data['pk_i_id'], 's_image', 1000, 1000);
                            if ($upload) {
                                $data['s_image'] = $upload['file_name'];
                                $data['dt_modified'] = date('Y-m-d H:i:s');
                                $exec = $this->pages->updateImageById($data);
                                if ($exec != 1) {
                                    $msg = 'data is invalid';
                                    $redirect = '/admin/slider/new';
                                }
                            }
                        }
                    } else {
                        $msg = 'data is invalid';
                        $redirect = '/admin/slider/new';
                    }
                    $this->session->set_userdata(array('adminMessage' => $msg));
                    header("Location: " . $redirect);
                }

                $data['title'] = 'Add New slider';
                $this->doView('slider', $data);
                break;
            case 'edit':
                $data['pk_i_id'] = $this->input->get('id');
                $post_ = $this->input->post();
                if ($post_) {
                    $post_ = $this->prepareData($post_);
                    $data = array_merge($data, $post_);
                    if ($_FILES['s_image']) {
	                    // image_name, image_folder, file_param
                        $upload = $this->fupload->do_upload($data['pk_i_id'], 's_image', 1000, 500);

	                    if ($upload) {
                            $data['s_image'] = $upload['file_name'];
                            $exec = $this->pages->updateImageById($data);
                            if ($exec != 1) {
                                $msg = 'error uploading image';
                            }
                        }
                    }
                    $exec = $this->pages->updateById($data);
                    if ($exec == 1) {
                        $msg = 'success';
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

                $this->doView('slider', $data);
                break;
            case 'delete':
                $data['pk_i_id'] = $this->input->get('id');
                if ($data['pk_i_id'] == '') return false;
                $page = (Array)$this->pages->findByid($data['pk_i_id']);
                if (!$page) {
                    $this->session->set_userdata(array('adminMessage' => 'item not found'));
                    header("Location: /admin/slider");
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
                header("Location: /admin/slider");
                break;
            default:
                $data['pages'] = (Array)$this->pages->listAll();
                $data['list'] = 'slider';
                if (IS_AJAX) {
                    $this->load->view('admin/list', $data);
                } else {
                    $data['title'] = 'slider';
                    $this->doView('slider', $data);
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
        $data['s_link'] = $this->input->post('s_link');
        return $data;
    }
}

?>