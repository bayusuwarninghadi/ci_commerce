<?php
class Product extends CI_Model
{

	private $table;

	private $cat;
	private $key;
	private $color;
	private $size;
	private $b_sale;
	private $order = 'dt_modified';
	private $page;
	private $pageLength;
	private $id;

	public function __construct()
	{
		$this->table = 't_product';
	}

	public function setCat($cat)
	{
		$this->cat = $cat;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageLength($pageLength)
	{
		$this->pageLength = $pageLength;
	}

	public function setKey($key)
	{
		$this->key = $key;
	}

	public function setColor($color)
	{
		$this->color = $color;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	private function getAllowedOrder()
	{
		return array("dt_modified", "i_price", "i_sale", "s_name");
	}

	public function setOrder($order)
	{
		$this->order = $order;
	}

	function setB_sale($b_sale = false)
	{
		if ($b_sale) {
			$this->b_sale = $b_sale;
		}
	}

	//1= active, 2 = deactive
	function listAll($page = 0, $order = 'pk_i_id', $by = 'DESC')
	{
		$display_page = 10;
		$page = $page * $display_page;
		$sql = sprintf("SELECT * FROM %s ORDER BY %s %s LIMIT %d,%d", $this->table, $order, $by, $page, $display_page);
		$query = $this->db->query($sql);
		return $query->result();
	}

	function listAllbyCat($cat = '', $page = 0, $order = 'dt_modified')
	{
		$page = $page * 10;
		$query = $this->db->query(sprintf("SELECT * FROM %s WHERE fk_i_cat_id like '%s%%' AND i_type='2' ORDER BY %s DESC LIMIT %d,10", $this->table, $cat, $order, $page));
		return $query->result();
	}

	function doSearch()
	{
		$sqlpush = array();

		if ($this->cat) {
			if (is_array($this->cat)) {
				$this->cat = implode(',', $this->cat);
			}
			array_push($sqlpush, sprintf("fk_i_cat_id IN (%s)", $this->cat));
		}
		if ($this->id) {
			array_push($sqlpush, sprintf("pk_i_id = %d", $this->id));
		}
		if ($this->key) {
			array_push($sqlpush, sprintf("MATCH(s_name, s_body) AGAINST ('%s' IN BOOLEAN MODE)", $this->key));
		}
		if ($this->b_sale) {
			array_push($sqlpush, "i_sale <> 0");
		}
		if ($this->color) {
			$color_ = array();
			foreach ($this->color as $color) {
				if ($color != '') {
					array_push($color_, sprintf("s_color like '%%%s%%'", $color));
				}
			}
			if (!empty($color_)) {
				$color_ = '(' . implode(' OR ', $color_) . ')';
				array_push($sqlpush, $color_);
			}
		}

		if ($this->size) {
			$size_ = array();
			foreach ($this->size as $size) {
				if ($size != '') {
					array_push($size_, sprintf("s_size like '%%%s%%'", $size));
				}
			}
			if (!empty($size_)) {
				$size_ = '(' . implode(' OR ', $size_) . ')';
				array_push($sqlpush, $size_);
			}
		}

		if (!is_numeric($this->pageLength)) $this->pageLength = 10;
		if (!is_numeric($this->page) || is_numeric($this->page) < 1) {
			$this->page = 1;
		}
		$this->page = ($this->page - 1) * $this->pageLength;

		$sqlpush = $sqlpush ? 'WHERE ' . implode(' AND ', $sqlpush) : '';

		$sql = sprintf("
            SELECT * FROM %s %s ORDER BY %s DESC LIMIT %d,%d",
			$this->table, $sqlpush, $this->order, $this->page, $this->pageLength
		);
		$query = $this->db->query($sql);
		return $query->result();
	}

	function updateById($data = array())
	{
		$query = $this->db->query(sprintf("
            UPDATE %s SET s_name='%s', s_slug='%s', s_body='%s', i_price=%d, i_sale=%d, s_color = '%s', s_size = '%s', i_stok=%d, dt_modified= '%s', fk_i_cat_id='%s'  WHERE pk_i_id='%s'",
			$this->table, $data['s_name'], $data['s_slug'], $data['s_body'], $data['i_price'], $data['i_sale'], $data['s_color'], $data['s_size'], $data['i_stok'], $data['dt_modified'], $data['fk_i_cat_id'], $data['pk_i_id']
		));
		return $query;
	}

	function updateImageById($data = array())
	{
		$sqlpush = array();
		foreach ($data['s_image'] as $key => $value) {
			array_push($sqlpush, sprintf("%s = '%s'", $key, $value));
		}

		array_push($sqlpush, sprintf("dt_modified = '%s'", date('Y-m-d H:i:s')));

		$sqlpush = implode(', ', $sqlpush);

		$query = $this->db->query(sprintf("
            UPDATE %s SET %s WHERE pk_i_id='%s'",
			$this->table, $sqlpush, $data['pk_i_id']
		));
		return $query;
	}

	function createNew($data = array())
	{
		$query = $this->db->query(sprintf("
            insert into %s (
                s_name,
                s_slug,
                s_body,
                dt_created,
                dt_modified,
                i_type,
                fk_i_cat_id,
                i_price,
                s_size,
                s_color,
                i_stok,
                i_sale
            )
            values ('%s','%s','%s','%s','%s','2', '%s', %d, '%s', '%s', %d, %d)",
			$this->table,
			$data['s_name'],
			$data['s_slug'],
			$data['s_body'],
			date('Y-m-d H:i:s'),
			date('Y-m-d H:i:s'),
			$data['fk_i_cat_id'],
			$data['i_price'],
			$data['s_size'],
			$data['s_color'],
			$data['i_stok'],
			$data['i_sale']));
		return $query;
	}

//    no longer used
	function findByid($id)
	{
		$query = $this->db->query(sprintf("SELECT * FROM %s WHERE pk_i_id='%s'", $this->table, $id));
		return $query->result();
	}

	function findBySlug($slug)
	{
		$query = $this->db->query(sprintf("SELECT * FROM %s WHERE s_slug='%s'", $this->table, $slug));
		return $query->result();
	}

	function deleteByid($id)
	{
		$query = $this->db->query(sprintf("DELETE FROM %s WHERE pk_i_id='%s'", $this->table, $id));
		return $query;
	}
	function deleteImage($data){
		$sql= sprintf('UPDATE %s SET %s = NULL WHERE pk_i_id = %d', $this->table, $data['field'], $data['pk_i_id']);
		$query = $this->db->query($sql);
		return $query;
	}

}

?>
