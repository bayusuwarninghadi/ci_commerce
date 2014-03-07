<?php
class Slider extends CI_Model
{
    private $table;

    function __construct()
    {
        $this->table = 't_slider';
    }

    function listAll()
    {
        $query = $this->db->query(sprintf("SELECT * FROM %s", $this->table));
        return $query->result();
    }

    function createNew($data = array())
    {
        $query = $this->db->query(sprintf("
            insert into %s (s_name, s_link)
            values ('%s','%s')",
            $this->table, $data['s_name'], $data['s_link']));
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
            UPDATE %s SET s_name='%s', s_link='%s' WHERE pk_i_id='%s'",
            $this->table, $data['s_name'], $data['s_link'], $data['pk_i_id']
        ));
        return $query;
    }

    function updateImageById($data = array())
    {
        $query = $this->db->query(sprintf("
            UPDATE %s SET s_image= '%s' WHERE pk_i_id='%s'",
            $this->table, $data['s_image'], $data['pk_i_id']
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