<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'general.php';
class CCart extends General {

    private $user;

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('isLogin') == false) {
            $this->session->set_userdata('message', 'you must login to see this page');
            header("Location: /login");
            exit;
        }

        $this->user = $this->session->userdata('user');
        $this->load->model('cart');

    }

    private function redirect_( $msg = '', $url = '/cart'){
        if (IS_AJAX){
            echo $msg;
        } else {
            $this->session->set_userdata('message', $msg);
            header("Location: ".$url);
        }
        die;
    }

    public function pages($act = '')
    {
        $data['act'] = $act;
        switch ($data['act']) {
            case 'add' :
                $data['fk_i_item_id'] = $this->input->get('id');
                $data['s_color'] = $this->input->get('c');
                $data['s_size'] = $this->input->get('s');
                $data['i_count'] = $this->input->post('i_count') ? $this->input->post('i_count') : 1;
                $data['fk_i_user_id'] = $this->user->pk_i_id;

                if (!$data['fk_i_item_id']) {
                    $this->redirect_('no spesific item found');
                }

                $this->load->model('product');
                $data['item'] = (Array)$this->product->findByid($data['fk_i_item_id']);

                if (!$data['item']) {
                    $this->redirect_('item not found');
                }

                $data['item'] = $data['item'][0];

                if ($data['item']->i_stok <= 0) {
                    $this->redirect_('Sorry, empty stock for this item');
                }

                if ($data['item']->i_stok < $data['i_count']) {
                    $this->redirect_('Sorry, quantity not valid');
                }
                if ($data['s_color'] == '') {
                    $color = explode(',', $data['item']->s_color);
                    $data['s_color'] = $color[0];
                }
                if ($data['s_size'] == '') {
                    $size = explode(',', $data['item']->s_size);
                    $data['s_size'] = $size[0];
                }

                $this->cart->setUserId($this->user->pk_i_id);
                $this->cart->setItemId($data['fk_i_item_id']);
                $this->cart->setColor($data['s_color']);
                $this->cart->setSize($data['s_size']);
                $findCart = (Array)$this->cart->doSearch();
                if ($findCart){
                    $data['pk_i_id'] = $findCart[0]->pk_i_cart_id;
                    $exec = $this->cart->updateById($data);
                }else {
                    $exec = $this->cart->createNew($data);
                }

                if ($exec == 1) {
                    $this->redirect_('item successfully added to your cart');
                } else {
                    $this->redirect_('item failed to added');
                }
                break;
            case 'delete' :
                $data['id'] = $this->input->get('id');
                $this->load->model('product');
                if ($data['id']) {
                    $exec = $this->cart->deleteById($data['id']);
                    if ($exec) $this->redirect_('item successfully delete from your cart');
                }
                $this->redirect_('item not found');
                break;
            default:
                $this->cart->setUserId($this->user->pk_i_id);
                $data['cart'] = (Array)$this->cart->doSearch();
                if ($data['cart']) {
                    $data['list'] = 'cart';
                    $data['title'] = 'Shopping Cart';
                    $this->doView('cart', $data);
                } else {
                    $this->session->set_userdata('message', 'You dont have an items on your cart');
                    header("Location: /");
                }

                break;
        }
    }

}
?>