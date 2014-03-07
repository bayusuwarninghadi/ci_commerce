<?php
class Checkout extends CI_Model
{

    private $table;
    private $tableAttr;
    private $tableUser;
    private $tableProduct;
    private $page;
    private $pageLength;

    private $id;
    private $key;
    private $status;
    private $userId;

    function __construct()
    {
        $this->table = 't_checkout';
        $this->tableAttr = 't_checkout_attr';
        $this->tableUser = 't_user';
        $this->tableProduct = 't_product';
        $this->tableConfirm = 't_confirm';
    }

    function setPage($page){
        $this->page = $page;
    }

    function setPageLength($pageLength){
        $this->pageLength = $pageLength;
    }


    function setUserId($userId)
    {
        $this->userId = $userId;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setKey($key)
    {
        $this->key = $key;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }

    function doSearch($order = 'dt_transaction')
    {

        if (!is_numeric($this->pageLength)) $this->pageLength = 10;
        if (!is_numeric($this->page) || is_numeric($this->page) < 1){
            $this->page = 1;
        }
        $this->page = ($this->page - 1) * $this->pageLength;
        $sqlpush = array();

        if ($this->userId) {
            array_push($sqlpush, sprintf("a.fk_i_user_id = %d", $this->userId));
        }
        if ($this->id) {
            array_push($sqlpush, sprintf("a.pk_i_Id = %d", $this->id));
        }
        if ($this->status) {
            array_push($sqlpush, sprintf("a.s_status = '%s'", $this->status));
        }
        if ($this->key) {
            array_push($sqlpush, sprintf("(c.s_name like '%%%s%%' OR c.s_email like '%%%s%%' OR a.s_address like '%%%s%%' )", $this->key, $this->key, $this->key));
        }

        $sqlpush = $sqlpush ? 'WHERE ' . implode(' AND ', $sqlpush) : '';

        $sql = sprintf("
            SELECT
              a.*,
              b.*,
              c.s_name, c.s_email,
              d.s_name s_product_name, d.s_image,
              e.i_ammount i_transfer_ammount, e.s_bank s_transfer_bank, e.i_rek i_transfer_rek, e.s_bank_name s_transfer_bank_name, e.dt_transfer
            FROM %s a
            LEFT JOIN %s b ON a.pk_i_id = b.fk_i_checkout_id
            LEFT JOIN %s c ON a.fk_i_user_id = c.pk_i_id
            LEFT JOIN %s d ON b.fk_i_product_id = d.pk_i_id
            LEFT JOIN %s e ON a.pk_i_id = e.fk_i_checkout_id
            %s
            ORDER BY %s DESC
            LIMIT %d,%d",
            $this->table,
            $this->tableAttr,
            $this->tableUser,
            $this->tableProduct,
            $this->tableConfirm,
            $sqlpush,
            $order,
            $this->page,
            $this->pageLength
        );
        $query = $this->db->query($sql);
        $return = $this->rearrange($query->result());
        return $return;
    }

    private function rearrange($object){
        $return = array();

        foreach((array)$object as $obj){
//            transaction
            if (empty($return[$obj->pk_i_id])){
                $trx = array(
                    'pk_i_id' => $obj->pk_i_id,
                    'fk_i_user_id' => $obj->fk_i_user_id,
                    's_name' => $obj->s_name,
                    's_email' => $obj->s_email,
                    's_address' => $obj->s_address,
                    'i_grand_total' => $obj->i_grand_total,
                    'dt_transaction' => $obj->dt_transaction,
                    'dt_confirm' => $obj->dt_confirm,
                    'i_transfer_ammount' => $obj->i_transfer_ammount,
                    's_transfer_bank' => $obj->s_transfer_bank,
                    'i_transfer_rek' => $obj->i_transfer_rek,
                    's_transfer_bank_name' => $obj->s_transfer_bank_name,
                    'dt_transfer' => $obj->dt_transfer,
                    's_optional_notes' => $obj->s_optional_notes,
                    's_status' => $obj->s_status
                );
                $return[$obj->pk_i_id] = $trx;
            }

//            attibute
            $attr = array(
                'fk_i_product_id' => $obj->fk_i_product_id,
                's_product_name' => $obj->s_product_name,
                's_image' => $obj->s_image,
                'i_price' => $obj->i_price,
                'i_sale' => $obj->i_sale,
                'i_count' => $obj->i_count,
                's_color' => $obj->s_color,
                's_size' => $obj->s_size,
                'i_total' => $obj->i_total
            );
            $return[$obj->pk_i_id]['product'][$obj->fk_i_product_id] = $attr   ;

        }
        return $return;

    }

    function createNew($data = array())
    {
        if (!isset($data['dt_transaction'])) {
            $data['dt_transaction'] = date('Y-m-d H:i:s');
        }
        $sql = sprintf("
            insert into %s (
                dt_transaction,
                fk_i_user_id,
                s_address
            )
            values ('%s', %d, '%s')",
            $this->table,
            $data['dt_transaction'],
            $data['fk_i_user_id'],
            $data['s_address']
        );
        $query = $this->db->query($sql);
        return $query;
    }


    function createNewAttr($data = array())
    {
        $sql = sprintf("
            insert into %s (
                fk_i_checkout_id,
                fk_i_product_id,
                i_price,
                i_sale,
                i_count,
                i_total,
                s_color,
                s_size
            )
            values (%d, %d, %d, %d, %d, %d, '%s', '%s')",
            $this->tableAttr,
            $data['fk_i_checkout_id'],
            $data['fk_i_product_id'],
            $data['i_price'],
            $data['i_sale'],
            $data['i_count'],
            $data['i_total'],
            $data['s_color'],
            $data['s_size']
        );
        $query = $this->db->query($sql);
        return $query;
    }

    function updateTotal($data = array())
    {
        $query = $this->db->query(sprintf("
            UPDATE %s SET i_grand_total=%d WHERE pk_i_id=%d",
            $this->table, $data['i_grand_total'], $data['pk_i_id']
        ));
        return $query;
    }

    function deleteByid($id)
    {
        $query = $this->db->query(sprintf("DELETE FROM %s WHERE fk_i_checkout_id=%d", $this->tableAttr, $id));
        $query = $this->db->query(sprintf("DELETE FROM %s WHERE pk_i_id='%s'", $this->table, $id));
        return $query;
    }

    function transactionConfirmByid($data)
    {
        $sql = sprintf("
            insert into %s (
                fk_i_checkout_id,
                fk_i_user_id,
                i_ammount,
                s_bank,
                i_rek,
                s_bank_name,
                dt_transfer
            )
            values (%d, %d, %d, '%s', '%s', '%s', '%s')",
            $this->tableConfirm,
            $data['fk_i_checkout_id'],
            $this->userId,
            $data['i_ammount'],
            $data['s_bank'],
            $data['i_rek'],
            $data['s_bank_name'],
            $data['dt_transfer']
        );
        $query = $this->db->query($sql);
        return $query;
    }

    function confirmByid($data)
    {
        $query = $this->db->query(sprintf("
            UPDATE %s SET dt_confirm='%s', s_status='approved' WHERE pk_i_id=%d",
            $this->table, date('Y-m-d H:i:s'), $data['pk_i_id']
        ));
        if ($query) {
            foreach ($data['product'] as $p){
                $stock = $this->db->query(sprintf("
                    SELECT i_stok FROM %s WHERE pk_i_id = %d",
                    $this->tableProduct, $p['fk_i_product_id']
                ));
                if ($stock){
                    $stock = $stock->result();
                    $stock = $stock[0]->i_stok;
                    $this->db->query(sprintf("
                        UPDATE %s SET i_stok = %d WHERE pk_i_id=%d",
                        $this->tableProduct, $stock - $p['i_count'], $p['fk_i_product_id']
                    ));
                }
            }
        }

        return $query;
    }

    function rejectByid($data)
    {
        $sql = sprintf("
            UPDATE %s SET dt_confirm='%s', s_status='rejected', s_optional_notes='%s' WHERE pk_i_id=%d",
            $this->table, date('Y-m-d H:i:s'), $data['s_optional_notes'], $data['pk_i_id']
        );
        $query = $this->db->query($sql);
        return $query;
    }

}

?>