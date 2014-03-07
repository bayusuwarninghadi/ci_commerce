<?php
class Pages extends CI_Model
{

    private $table;

    function __construct()
    {
        $this->table = 't_pages';
    }

    function listAll($order = 'pk_i_id')
    {
        $query = $this->db->query(sprintf("SELECT * FROM %s ORDER BY '%s' DESC", $this->table, $order));
        return $query->result();
    }

    function createNew($data = array())
    {
        $query = $this->db->query(sprintf("
            insert into %s (s_name, s_body, dt_created, dt_modified, i_type)
            values ('%s','%s','%s','%s','1')",
                                          $this->table, $data['s_name'], $data['s_body'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')));
        return $query;
    }

    function findByid($id)
    {
        $query = $this->db->query(sprintf("SELECT * FROM %s WHERE pk_i_id='%s'", $this->table, $id));
        return $query->result();
    }

    function updateById($data = array())
    {
        $query = $this->db->query(sprintf("
            UPDATE %s SET s_name='%s', s_body='%s' , dt_modified= '%s'  WHERE pk_i_id='%s'",
                                          $this->table, $data['s_name'], $data['s_body'], date('Y-m-d H:i:s'), $data['pk_i_id']
                                  ));
        return $query;
    }

    function updateImageById($data = array())
    {
        $query = $this->db->query(sprintf("
            UPDATE %s SET s_image= '%s', dt_modified= '%s'  WHERE pk_i_id='%s'",
                                          $this->table, $data['s_image'], date('Y-m-d H:i:s'), $data['pk_i_id']
                                  ));
        return $query;
    }

    function deleteByid($id)
    {
        $query = $this->db->query(sprintf("DELETE FROM %s WHERE pk_i_id='%s'", $this->table, $id));
        return $query;
    }

}

?>