<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require 'general.php';
class CCheckout extends General
{

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

		$this->load->model('checkout');
		$this->load->model('cart');
		$this->user = $this->session->userdata('user');
	}

	private function redirect_($msg = '', $url = '/cart')
	{
		if (IS_AJAX) {
			echo $msg;
		} else {
			$this->session->set_userdata('message', $msg);
			header("Location: " . $url);
		}
		die;
	}

	public function pages($act = '')
	{
		$data['act'] = $act;
		switch ($data['act']) {
			case 'add' :
				$this->cart->setUserId($this->user->pk_i_id);
				$this->checkout->setUserId($this->user->pk_i_id);
				$data['cart'] = (Array)$this->cart->doSearch();
				if ($data['cart']) {
					$data['fk_i_user_id'] = $this->user->pk_i_id;
					$data['s_address'] = $this->user->s_address;
					$data['dt_transaction'] = date('Y-m-d H:i:s');
					$this->checkout->createNew($data);
					$total = 0;
					$cart['fk_i_checkout_id'] = mysql_insert_id();

					foreach ($data['cart'] as $c) {
						$cart['fk_i_product_id'] = $c->pk_i_id;
						$cart['i_count'] = $c->i_count;
						$cart['s_size'] = $c->order_size;
						$cart['s_color'] = $c->order_color;
						$cart['i_price'] = $c->i_price;
						$cart['i_sale'] = $c->i_sale;
						$cart['i_total'] = (100 - $c->i_sale) / 100 * $c->i_price * $c->i_count;
						$total += $cart['i_total'];
						$this->checkout->createNewAttr($cart);
						$this->cart->deleteByid($c->pk_i_cart_id);
					}

					$update['i_grand_total'] = $total;
					$update['pk_i_id'] = $cart['fk_i_checkout_id'];
					$this->checkout->updateTotal($update);

					$data['invoice_detail'] = '';
					$total = 0;
					foreach ($data['cart'] as $c) {

						$data['invoice_detail'] .= '
                            <div style="margin:10px; padding:10px; border:1px solid #bbb; background:#f5f5f5;">
                                <img src="http://' . base_url() . 'images/product/thumbs/' . $c->s_image . '" style="float: right;" width="50"/>
                                <div style="text-transform: uppercase; font-size: 20px; line-height: 150%">' . $c->s_name . '</div>
                                <div>Quantity: <b>' . $c->i_count . '</b></div>';

						$gross = $c->i_price * $c->i_count;
						$price = (100 - $c->i_sale) / 100 * $gross;
						$total += $price;

						$data['invoice_detail'] .= '<div>@ ' . format_money($c->i_price) . '</div>';

						if ($c->i_sale > 0) {
							$data['invoice_detail'] .= '<div Style="text-decoration:line-through;">' . format_money($gross) . '</div>';
							$data['invoice_detail'] .= '<div>Diskon: ' . $c->i_sale . '%</div>';
							$data['invoice_detail'] .= '<div>Price: ' . format_money($price) . '%</div>';
						} else {
							$data['invoice_detail'] .= '<div>Price: ' . format_money($gross) . '%</div>';
						}
						$data['invoice_detail'] .= '
                                <div style="clear: both;"></div>
                            </div>';
					}
					$data['invoice_detail'] .= '<div>GRAND TOTAL = ' . format_money($total) . '</div>';
					$data['cart'] = '';
					$data['s_name'] = $this->user->s_name;
					$data['s_email'] = $this->user->s_email;
					$data['fk_i_checkout_id'] = $cart['fk_i_checkout_id'];
					$email = $this->send_mail($this->user->s_email, 'checkout_success', $data);
					if ($email != 1) {
						$msg = 'Email protocol not work, :(';
					} else {
						$this->send_mail($this->setting['admin_email'], 'checkout_success_admin', $data);
						#forward to admin
						$msg = 'Thanks your request will approval by admin';
					}
				} else {
					$msg = 'You dont have an items on your cart';
				}

				$this->session->set_userdata('message', $msg);
				header("Location: /");

				break;
			default:
				$data['title'] = 'Shopping Cart';
				$data['cart'] = (Array)$this->cart->doSearch();
				if ($data['cart']) {
					$data['list'] = 'checkout';
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