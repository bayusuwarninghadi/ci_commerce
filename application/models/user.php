<?php
class User extends CI_Model
{

      private $table;
      private $adminTable;
      private $page;
      private $pageLength;
      private $id;
      private $key;
      private $keySearch;
      private $email;
      private $username;
      private $active;
      private $order = 'dt_created';

      function __construct()
      {
            $this->table = 't_user';
            $this->adminTable = 't_admin';
      }

      public function setPage($page)
      {
            $this->page = $page;
      }

      public function setPageLength($pageLength)
      {
            $this->pageLength = $pageLength;
      }

      public function setActive($active)
      {
            $this->active = $active;
      }

      public function setId($id)
      {
            $this->id = $id;
      }

      public function setEmail($email)
      {
            $this->email = $email;
      }

      public function setUsername($username)
      {
            $this->username = $username;
      }

      public function setKey($key)
      {
            $this->key = $key;
      }

      public function setKeySearch($keySearch)
      {
            $this->keySearch = $keySearch;
      }

      function doSearch()
      {
            $sqlpush = array();
            if ($this->id) {
                  array_push($sqlpush, sprintf("pk_i_id = %d", $this->id));
            }

            if ($this->key) {
                  array_push($sqlpush, sprintf("s_key = '%s'", $this->key));
            }

            if ($this->active) {
                  array_push($sqlpush, sprintf("s_active = %d", $this->active));
            }

            if ($this->keySearch) {
                  array_push($sqlpush, sprintf("MATCH(s_name, s_email) AGAINST ('%s' IN BOOLEAN MODE)", $this->keySearch));
            }


            if ($this->email) {
                  array_push($sqlpush, sprintf("s_email = '%s'", $this->email));
            }

            if ($this->username) {
                  array_push($sqlpush, sprintf("s_username = '%s'", $this->username));
            }

            if (!is_numeric($this->pageLength)) $this->pageLength = 10;
            if (!is_numeric($this->page) || is_numeric($this->page) < 1) {
                  $this->page = 1;
            }
            $this->page = ($this->page - 1) * $this->pageLength;

            $sqlpush = $sqlpush ? 'WHERE ' . implode(' AND ', $sqlpush) : '';

            $sql = sprintf("
            SELECT * FROM %s %s
            ORDER BY %s DESC
            LIMIT %d,%d",
                  $this->table, $sqlpush, $this->order, $this->page, $this->pageLength);
            $query = $this->db->query($sql);
            return $query->result();
      }

      function doAdminSearch()
      {
            $sqlpush = array();
            if ($this->id) {
                  array_push($sqlpush, sprintf("pk_i_id = %d", $this->id));
            }

            if ($this->email) {
                  array_push($sqlpush, sprintf("s_email = '%s'", $this->email));
            }

            if ($this->keySearch) {
                  array_push($sqlpush, sprintf("MATCH(s_username, s_email) AGAINST ('%s' IN BOOLEAN MODE)", $this->keySearch));
            }

            if ($this->username) {
                  array_push($sqlpush, sprintf("s_username = '%s'", $this->username));
            }

            if (!is_numeric($this->pageLength)) $this->pageLength = 10;
            if (!is_numeric($this->page) || is_numeric($this->page) < 1) {
                  $this->page = 1;
            }
            $this->page = ($this->page - 1) * $this->pageLength;

            $sqlpush = $sqlpush ? 'WHERE ' . implode(' AND ', $sqlpush) : '';

            $sql = sprintf("
            SELECT * FROM %s %s
            LIMIT %d,%d",
                  $this->adminTable, $sqlpush, $this->page, $this->pageLength);
            $query = $this->db->query($sql);
            return $query->result();
      }

      function findById($id)
      {
            $query = $this->db->query(sprintf("SELECT * FROM %s WHERE pk_i_id='%s'", $this->table, $id));
            return $query->result();
      }

      function findAdminById($id)
      {
            $query = $this->db->query(sprintf("SELECT * FROM %s WHERE pk_i_id='%s'", $this->adminTable, $id));
            return $query->result();
      }

      function findByIdAndKey($id, $key)
      {
            $query = $this->db->query(sprintf("SELECT * FROM %s WHERE pk_i_id='%s' AND s_key='%s' ", $this->table, $id, $key));
            return $query->result();
      }

      function findByUsername($username)
      {
            $query = $this->db->query(sprintf("SELECT * FROM %s WHERE s_username='%s'", $this->table, $username));
            return $query->result();
      }

      function findByEmail($email)
      {
            $query = $this->db->query(sprintf("SELECT * FROM %s WHERE s_email='%s'", $this->table, $email));
            return $query->result();
      }

      function findByEmailAndPassword($email, $password)
      {
            $query = $this->db->query(sprintf("SELECT * FROM %s WHERE s_email='%s' AND s_password='%s'", $this->table, $email, $password));
            return $query->result();
      }

      function findAdminByEmailAndPassword($email, $password)
      {
            $query = $this->db->query(sprintf("SELECT * FROM %s WHERE s_email='%s' AND s_password='%s'", $this->adminTable, $email, $password));
            return $query->result();
      }

      function createNew($data = array())
      {
            $query = $this->db->query(sprintf("
            INSERT INTO %s (
                s_name,
                s_email,
                i_user_type,
                s_password,
                dt_created,
                dt_modified,
                s_phone,
                s_address,
                s_website,
                s_username,
                s_key,
                i_ktp,
                i_rek,
                s_bank,
                s_active,
                s_bank_name
            )
            VALUES ('%s', '%s', %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, %d, '%s', %d, '%s')",
                  $this->table,
                  $data['s_name'],
                  $data['s_email'],
                  $data['i_user_type'],
                  md5($data['s_password']),
                  date('Y-m-d H:i:s'),
                  date('Y-m-d H:i:s'),
                  $data['s_phone'],
                  $data['s_address'],
                  $data['s_website'],
                  $data['s_username'],
                  $data['s_key'],
                  $data['i_ktp'],
                  $data['i_rek'],
                  $data['s_bank'],
                  $data['s_active'] ? 1 : 0,
                  $data['s_bank_name']
            ));
            return $query;
      }

      function createNewAdmin($data = array())
      {
            $query = $this->db->query(sprintf("
            INSERT INTO %s (
                s_username,
                s_email,
                s_password,
                s_level
            )
            VALUES ('%s', '%s', '%s', '%s')",
                  $this->adminTable,
                  $data['s_username'],
                  $data['s_email'],
                  md5($data['s_password']),
                  $data['s_level']
            ));
            return $query;
      }

      function updateById($data = array())
      {
            $sql = sprintf("
            UPDATE %s SET
                s_name='%s',
                s_email='%s',
                i_user_type=%d,
                s_phone='%s',
                dt_modified= '%s',
                s_address='%s',
                s_website='%s',
                s_username='%s',
                i_ktp='%s',
                i_rek='%s',
                s_bank='%s',
                s_bank_name='%s'
            WHERE pk_i_id=%d",
                  $this->table,
                  $data['s_name'],
                  $data['s_email'],
                  $data['i_user_type'],
                  $data['s_phone'],
                  date('Y-m-d H:i:s'),
                  $data['s_address'],
                  $data['s_website'],
                  $data['s_username'],
                  $data['i_ktp'],
                  $data['i_rek'],
                  $data['s_bank'],
                  $data['s_bank_name'],
                  $data['pk_i_id']
            );

            $query = $this->db->query($sql);
            return $query;
      }

      function updateAdminById($data = array())
      {
            $sql = sprintf("
            UPDATE %s SET
                s_username='%s',
                s_email='%s',
                s_level='%s'
            WHERE pk_i_id=%d",
                  $this->adminTable,
                  $data['s_username'],
                  $data['s_email'],
                  $data['s_level'],
                  $data['pk_i_id']
            );

            $query = $this->db->query($sql);
            return $query;
      }

      function updateEmailById($data = array())
      {
            $query = $this->db->query(sprintf("
             UPDATE %s SET dt_modified= '%s', s_email='%s' WHERE pk_i_id='%s'",
                  $this->table, date('Y-m-d H:i:s'), $data['s_email'], $data['pk_i_id']
            ));
            return $query;
      }

      function activatedByIdAndKey($id, $key)
      {
            $sql = sprintf("
             UPDATE %s SET dt_modified= '%s', s_active=1 WHERE pk_i_id=%d AND s_key='%s'",
                  $this->table, date('Y-m-d H:i:s'), $id, $key
            );
            $query = $this->db->query($sql);
            return $query;
      }

      function deactivatedByIdAndKey($id, $key)
      {
            $sql = sprintf("
             UPDATE %s SET dt_modified= '%s', s_active=0 WHERE pk_i_id=%d AND s_key='%s'",
                  $this->table, date('Y-m-d H:i:s'), $id, $key
            );
            $query = $this->db->query($sql);
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

      function updateUserPasswordByIdAndPass($id, $old_password, $new_pass)
      {
            $query = $this->db->query(sprintf("UPDATE %s SET s_password='%s' WHERE pk_i_id='%s' AND s_password='%s'", $this->table, $new_pass, $id, $old_password));
            return $query;
      }

      function updateAdminPasswordById($id, $new_pass)
      {
            $sql = sprintf("UPDATE %s SET s_password='%s' WHERE pk_i_id='%s'", $this->adminTable, $new_pass, $id);
            $query = $this->db->query($sql);
            return $query;
      }

      function deleteByid($id)
      {
            $query = $this->db->query(sprintf("DELETE FROM %s WHERE pk_i_id='%s'", $this->table, $id));
            return $query;
      }

      function deleteAdminByid($id)
      {
            $query = $this->db->query(sprintf("DELETE FROM %s WHERE pk_i_id='%s'", $this->adminTable, $id));
            return $query;
      }
}

?>
