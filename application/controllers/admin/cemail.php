<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'cadmin.php';

class CEmail extends CAdmin
{

      function __construct()
      {
            parent::__construct();
            $this->load->library('session');
            $this->load->model('email', 'emails');
            $this->load->model('contact', 'inbox');

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
                              $exec = $this->emails->createNew($data);
                              if ($exec == 1) {
                                    $data['pk_i_id'] = mysql_insert_id();
                                    $msg = 'Item successfully posted';
                                    $redirect = '/admin/email/edit?id=' . $data['pk_i_id'];
                              } else {
                                    $msg = 'data is invalid';
                                    $redirect = '/admin/email/new';
                              }
                              $this->session->set_userdata(array('adminMessage' => $msg));
                              header("Location: " . $redirect);
                        }

                        $data['title'] = 'Add New email';
                        $this->doView('email', $data, true);
                        break;
                  case 'edit':
                        $data['pk_i_id'] = $this->input->get('id');
                        $post_ = $this->input->post();
                        if ($post_) {
                              $post_ = $this->prepareData($post_);
                              $data = array_merge($data, $post_);
                              $exec = $this->emails->updateById($data);
                              if ($exec == 1) {
                                    $msg = 'success';
                              } else {
                                    $msg = 'error updating field';
                              }
                              $this->session->set_userdata(array('adminMessage' => $msg));
                        }
                        $page = (Array)$this->emails->findByid($data['pk_i_id']);
                        if (!$page) {
                              $this->doView('404');
                              return;
                        }
                        $data['page'] = $page[0];
                        $data['title'] = $page[0]->s_name;

                        $this->doView('email', $data, true);
                        break;
                  case 'delete':
                        $data['pk_i_id'] = $this->input->get('id');
                        if ($data['pk_i_id'] == '') return false;
                        $page = (Array)$this->emails->findByid($data['pk_i_id']);
                        if (!$page) {
                              $this->session->set_userdata(array('adminMessage' => 'item not found'));
                              header("Location: /admin/email");
                        }

                        $page = $this->emails->deleteByid($data['pk_i_id']);
                        if ($page == 1) {
                              $msg = 'deleted success';
                        } else {
                              $msg = 'error during delete the data';
                        }
                        $this->session->set_userdata(array('adminMessage' => $msg));
                        header("Location: /admin/email");
                        break;
                  case 'open':
                        $data['pk_i_id'] = $this->input->get('id');
                        $page = (Array)$this->inbox->findByid($data['pk_i_id']);
                        if (!$page) {
                              $this->doView('404');
                              return;
                        }
                        $data['page'] = $page[0];
                        $data['title'] = $page[0]->s_name;
                        $this->doView('email', $data, true);
                        break;
                  case 'send':
                        $data['title'] = "Send Email";
                        if ($this->input->post()) {
                              $data['to'] = $this->input->post('users');
                              $data['subject'] = $this->input->post('subject');
                              $data['message'] = $this->input->post('message');


                              if ($data['to'] == 'all') {
                                    $this->load->model('subscribe','users');
                              } else {
                                    $this->load->model('user','users');
                              }

                              $users = (array)$this->users->doSearch();

                              foreach ($users as $user) {
                                    $this->send_mail($user->s_email, 'send_mail', $data);
                              }

                        }
                        $this->doView('email', $data, true);

                        break;
                  case 'reply':
                        $data['pk_i_id'] = $this->input->post('id');
                        $data['message'] = $this->input->post('message');
                        $page = (Array)$this->inbox->findByid($data['pk_i_id']);
                        if (!$page) {
                              $this->doView('404');
                              return;
                        }
                        $data['page'] = $page[0];
                        $data['title'] = $page[0]->s_name;
                        $data['body'] = "<h3>In Reply:</h3>";
                        $data['body'] .= "<div Style='background:#f5f5f5; padding:10px; margin-bottom:10px; color:gray; border:1px solid #bbb;'>" . $page[0]->s_message . "</div>";
                        $data['body'] .= "<h3>Reply:</h3>";
                        $data['body'] .= $data['message'];
                        $data['subject'] = 'No Reply';
                        $email = $this->send_mail($page[0]->s_email, '', $data);
                        if ($email == 1) {
                              $msg = "Reply send";
                        } else {
                              $msg = "Error Occurred";
                        }
                        $this->session->set_userdata(array('adminMessage' => $msg));
                        header("Location: /admin/email/open?id=" . $data['pk_i_id']);
                        break;
                  case 'inbox-delete':
                        $data['pk_i_id'] = $this->input->get('id');
                        if ($data['pk_i_id'] == '') return false;
                        $page = (Array)$this->inbox->findByid($data['pk_i_id']);
                        if (!$page) {
                              $this->session->set_userdata(array('adminMessage' => 'item not found'));
                              header("Location: /admin/inbox");
                        }

                        $page = $this->inbox->deleteByid($data['pk_i_id']);
                        if ($page == 1) {
                              $msg = 'deleted success';
                        } else {
                              $msg = 'error during delete the data';
                        }
                        $this->session->set_userdata(array('adminMessage' => $msg));
                        header("Location: /admin/email");
                        break;
                  default:
                        $data['emails'] = (Array)$this->emails->listAll();

                        $data['page'] = $this->input->post('page');
                        if (!is_numeric($data['page']) || $data['page'] == '' || $data['page'] < 1) $data['page'] = 1;
                        $this->inbox->setPage($data['page']);

                        $data['s_key'] = $this->input->post('s_key');
                        if ($data['s_key'] != '') {
                              $this->inbox->setKey($data['s_key']);
                        }

                        $data['inbox'] = (Array)$this->inbox->doSearch();

                        $data['list'] = 'inbox';
                        if (IS_AJAX) {
                              $this->load->view('admin/list', $data);
                        } else {
                              $data['title'] = 'Mail list';
                              $this->doView('email', $data);
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
            $data['s_slug'] = str_replace((' '), '_', $data['s_name']);
            $data['s_body'] = $this->input->post('s_body');
            return $data;
      }
}

?>