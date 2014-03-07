<?php
class Email extends CI_Model
{

    private $table;

    function __construct()
    {
        $this->table = 't_email';
    }

    function listAll($order = 'pk_i_id')
    {
        $query = $this->db->query(sprintf("SELECT * FROM %s ORDER BY %s DESC", $this->table, $order));
        return $query->result();
    }

    function createNew($data = array())
    {
        $query = $this->db->query(sprintf("
            insert into %s (s_name, s_slug, s_body)
            values ('%s','%s','%s')",
            $this->table, $data['s_name'], $data['s_slug'], $data['s_body']));
        return $query;
    }

    function findBySlug($slug)
    {
        $query = $this->db->query(sprintf("SELECT * FROM %s WHERE s_slug='%s'", $this->table, $slug));
        return $query->result();
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

}

?>