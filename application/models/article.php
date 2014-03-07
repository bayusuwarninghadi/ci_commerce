<?php
class Article extends CI_Model
{

    private $table;
    private $id;
    private $key;
    private $page;
    private $pageLength;

    function __construct()
    {
        $this->table = 't_article';
    }

    function setId($id){
        $this->id = $id;
    }

    function setKey($key){
        $this->key = $key;
    }

    function setPage($page){
        $this->page = $page;
    }
    function setPageLength($pageLength){
        $this->pageLength = $pageLength;
    }

    function doSearch($order = 'pk_i_id')
    {
        $sqlpush = array();
        if ($this->id){
            array_push($sqlpush, sprintf("pk_i_id = %d",$this->id));
        }
        if ($this->key){
            array_push($sqlpush, sprintf("MATCH(s_name, s_body) AGAINST ('%s' IN BOOLEAN MODE)",$this->key));
        }

        $sqlpush = $sqlpush ? 'WHERE '.implode(' AND ', $sqlpush): '';

        if (!is_numeric($this->pageLength)) $this->pageLength = 10;
        if (!is_numeric($this->page) || is_numeric($this->page) < 1){
            $this->page = 1;
        }
        $this->page = ($this->page - 1) * $this->pageLength;

        $sql = sprintf("SELECT * FROM %s %s ORDER BY %s DESC LIMIT %d,%d", $this->table, $sqlpush, $order, $this->page, $this->pageLength);
        $query = $this->db->query($sql);
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