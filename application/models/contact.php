<?php
class Contact extends CI_Model
{

    private $table;
    private $page;
    private $pageLength;
    private $id;
    private $key;

    function __construct()
    {
        $this->table = 't_contact';
    }

    function setId($id){
        $this->id = $id;
    }

    function setPage($page){
        $this->page = $page;
    }

    function setKey($key){
        $this->key= $key;
    }

    function setPageLength($pageLength){
        $this->pageLength = $pageLength;
    }


    function doSearch()
    {
        $sqlpush = array();

        if ($this->id){
            array_push($sqlpush, sprintf("pk_i_id = %d", $this->id));
        }

        if ($this->key){
            array_push($sqlpush, sprintf("MATCH(s_name, s_email, s_message) AGAINST ('%s' IN BOOLEAN MODE)",$this->key));
        }

        $sqlpush = $sqlpush ? 'WHERE '.implode(' AND ', $sqlpush): '';

        if (!is_numeric($this->pageLength)) $this->pageLength = 10;
        if (!is_numeric($this->page) || is_numeric($this->page) < 1){
            $this->page = 1;
        }
        $this->page = ($this->page - 1) * $this->pageLength;


        $sql = sprintf("
            SELECT * FROM %s %s ORDER BY pk_i_id DESC LIMIT %d,%d",
            $this->table, $sqlpush, $this->page, $this->pageLength
        );
        $query = $this->db->query($sql);
        return $query->result();
    }

    function createNew($data = array())
    {
        $query = $this->db->query(sprintf("
            insert into %s (s_name, s_email, s_message, dt_created)
            values ('%s','%s','%s','%s')",
            $this->table, $data['s_name'], $data['s_email'], $data['s_message'], date('Y-m-d H:i:s')));
        return $query;
    }

    function findByid($id)
    {
        $query = $this->db->query(sprintf("SELECT * FROM %s WHERE pk_i_id='%s'", $this->table, $id));
        return $query->result();
    }

    function findContact($string)
    {
        $query = $this->db->query(sprintf("
            SELECT * FROM %s WHERE
                s_name like '%%s%' OR
                s_email like '%%s%' OR
                s_message like '%%s%'",
            $this->table, $string, $string, $string));
        return $query->result();
    }
}

?>