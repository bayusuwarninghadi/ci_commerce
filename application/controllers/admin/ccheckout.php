<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'cadmin.php';

class CCheckout extends CAdmin
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('checkout');
    }

    public function pages($act = '')
    {
        $data['act'] = $act;
        switch ($data['act']) {
            case 'delete':
                if ($this->session->userdata('isAdminLogin') != 1){
                    $this->session->set_userdata(array('adminMessage' => 'access not granted'));
                    header("Location: /admin");
                }

                $data['pk_i_id'] = $this->input->get('id');
                $this->checkout->setId($data['pk_i_id']);
                $data['checkout'] = (Array)$this->checkout->doSearch();

                if (!$data['checkout']) {
                    $this->session->set_userdata(array('adminMessage' => 'item not found'));
                    header("Location: /admin/checkout");
                }

                $page = $this->checkout->deleteByid($data['pk_i_id']);
                if ($page == 1) {
                    $msg = 'deleted success';
                } else {
                    $msg = 'error during delete the data';
                }
                $this->session->set_userdata(array('adminMessage' => $msg));
                header("Location: /admin/checkout");
                break;
            case 'confirm':
                if ($this->session->userdata('isAdminLogin') != 1){
                    $this->session->set_userdata(array('adminMessage' => 'access not granted'));
                    header("Location: /admin");
                }

                $data['pk_i_id'] = $this->input->get('id');
                $this->checkout->setId($data['pk_i_id']);
                $data['checkout'] = (Array)$this->checkout->doSearch();
                if (!$data['checkout']) {
                    $this->session->set_userdata(array('adminMessage' => 'item not found'));
                    header("Location: /admin/checkout");
                }

                $page = $this->checkout->confirmById($data['checkout'][$data['pk_i_id']]);

                if ($page == 1) {
                    $data = $data['checkout'][$data['pk_i_id']];
                    $data['i_transfer_ammount'] = format_money($data['i_transfer_ammount']);
                    $data['dt_transfer'] = format_date($data['dt_transfer']);
                    $email = $this->send_mail($data['s_email'], 'checkout_confirm', $data);
                    if ($email != 1) {
                        $msg = 'Email protocol not work, :(';
                    } else {
                        $msg = 'Confirm success';
                    }
                } else {
                    $msg = 'error during confirm the data';
                }
                $this->session->set_userdata(array('adminMessage' => $msg));
                header("Location: /admin/checkout");
                break;

            case 'reject':
                if ($this->session->userdata('isAdminLogin') != 1){
                    $this->session->set_userdata(array('adminMessage' => 'access not granted'));
                    header("Location: /admin");
                }

                $data['pk_i_id'] = $this->input->post('id');
                $data['s_optional_notes'] = $this->input->post('reason');
                $this->checkout->setId($data['pk_i_id']);
                $data['checkout'] = (Array)$this->checkout->doSearch();

                if (!$data['checkout']) {
                    $this->session->set_userdata(array('adminMessage' => 'item not found'));
                    header("Location: /admin/checkout");
                }

                $page = $this->checkout->rejectById($data);

                if ($page == 1) {
                    $data = $data['checkout'][$data['pk_i_id']];
                    $data['i_transfer_ammount'] = format_money($data['i_transfer_ammount']);
                    $data['dt_transfer'] = format_date($data['dt_transfer']);
                    $data['s_optional_notes'] = $this->input->post('reason');

                    $email = $this->send_mail($data['s_email'], 'checkout_reject', $data);
                    if ($email != 1) {
                        $msg = 'Email protocol not work, :(';
                    } else {
                        $msg = 'Reject success';
                    }
                } else {
                    $msg = 'error during reject the data';
                }
                $this->session->set_userdata(array('adminMessage' => $msg));
                header("Location: /admin/checkout");
                break;

            default:
                $data['page'] = $this->input->post('page');
                if (!is_numeric($data['page']) || $data['page'] == '' || $data['page'] < 1) $data['page'] = 1;
                $this->checkout->setPage($data['page']);

                $data['title'] = 'Shopping Cart';

                $data['s_key'] = $this->input->post('s_key');
                if ($data['s_key'] != '') {
                    $this->checkout->setKey($data['s_key']);
                }

                $data['status'] = $this->input->post('status');
                $this->checkout->setStatus($data['status']);

                $data['checkout'] = (Array)$this->checkout->doSearch();
                $data['list'] = 'checkout';
                if (IS_AJAX) {
                    $data['isAdminLogin'] = $this->session->userdata('isAdminLogin');
                    $data['loginAdminName'] = $this->session->userdata('loginAdminName');
                    $data['loginAdminEmail'] = $this->session->userdata('loginAdminEmail');

                    $this->load->view('admin/list', $data);
                    return;
                }
                if ($data['checkout']) {
                    $this->doView('checkout', $data);
                } else {
                    $this->session->set_userdata('message', 'You dont have an items on your cart');
                    header("Location: /");
                }
                break;
        }
    }
}

?>