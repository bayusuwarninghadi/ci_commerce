<?php
class Cart extends CI_Model
{

    private $table;
    private $userId;
    private $itemId;
    private $color;
    private $size;

    function __construct()
    {
        $this->table = 't_cart';
    }

    function setUserId($userId)
    {
        $this->userId = $userId;
    }

    function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }
    function setColor($color)
    {
        $this->color = $color;
    }
    function setSize($size)
    {
        $this->size = $size;
    }

    function doSearch($order = 'pk_i_id')
    {
        $sqlpush = array();
        if ($this->userId) {
            array_push($sqlpush, sprintf("a.fk_i_user_id = %d", $this->userId));
        }
        if ($this->itemId) {
            array_push($sqlpush, sprintf("a.fk_i_item_id = %d", $this->itemId));
        }
        if ($this->color) {
            array_push($sqlpush, sprintf("a.s_color = '%s'", $this->color));
        }
        if ($this->size) {
            array_push($sqlpush, sprintf("a.s_size= '%s'", $this->size));
        }

        $sqlpush = $sqlpush ? 'WHERE ' . implode(' AND ', $sqlpush) : '';

        $sql = sprintf("
            SELECT a.pk_i_id pk_i_cart_id, a.s_size order_size, a.s_color order_color, a.i_count, b.s_name,b.s_email,c.* FROM %s a
            JOIN %s b ON a.fk_i_user_id = b.pk_i_id
            JOIN %s c ON a.fk_i_item_id = c.pk_i_id
            %s
            ORDER BY %s DESC",
            $this->table, 't_user','t_product',$sqlpush, $order
        );
        $query = $this->db->query($sql);
        return $query->result();
    }

    function createNew($data = array())
    {
        $query = $this->db->query(sprintf("
            insert into %s (fk_i_user_id, fk_i_item_id, i_count, s_color, s_size)
            values (%d, %d, %d, '%s', '%s')",
            $this->table, $data['fk_i_user_id'], $data['fk_i_item_id'], $data['i_count'], $data['s_color'], $data['s_size']));
        return $query;
    }

    function updateById($data = array())
    {
        $query = $this->db->query(sprintf("
            UPDATE %s SET i_count=%d WHERE pk_i_id=%d",
                $this->table, $data['i_count'], $data['pk_i_id']
            ));
        return $query;
    }


    function deleteByid($id)
    {
        $sql = sprintf("DELETE FROM %s WHERE pk_i_id='%s'", $this->table, $id);
        $query = $this->db->query($sql);
        return $query;
    }

}

?>