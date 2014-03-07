<?php
class Subscriber extends CI_Model
{

      private $table;
      private $email;

      function __construct()
      {
            $this->table = 't_subscriber';
      }

      function setEmail($email) {
            $this->email = $email;
      }


      function doSearch()
      {
            $sqlpush = array();
            
              if ($this->email){
                  array_push($sqlpush, sprintf("s_email = '%s'",$this->email));
              }
                 $sqlpush = $sqlpush ? 'WHERE '.implode(' AND ', $sqlpush): '';

            
            $query = $this->db->query(sprintf("SELECT * FROM %s %s", $this->table,  $sqlpush));
            return $query->result();
      }

      function createNew($email)
      {
            $query = $this->db->query(sprintf(" insert into %s (s_email) values ('%s')", $this->table, $email));
            return $query;
      }

      function deleteByEmail($email)
      {
            $query = $this->db->query(sprintf("DELETE FROM %s WHERE s_email='%s'", $this->table, $email));
            return $query;
      }


}

?>