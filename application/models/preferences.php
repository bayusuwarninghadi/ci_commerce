<?php
class Preferences extends CI_Model
{
    private $table;

    function __construct()
    {
        $this->table = 't_preferences';
    }

    function listAll()
    {
        $query = $this->db->query(sprintf("SELECT * FROM %s", $this->table));
        return $query->result();
    }
    function updateByName($name, $string)
    {
        $query = $this->db->query(sprintf("
            UPDATE %s SET s_string='%s' WHERE s_name='%s'",
            $this->table, $string, $name
        ));
        return $query;
    }


}

?>