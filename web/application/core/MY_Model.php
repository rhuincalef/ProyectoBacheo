<?php
class MY_Model extends CI_Model
{
    public $table_name;
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fetch a single record based on the primary key. Returns an object.
     */
    public function get($id)
    {
        $query = $this->db->get_where($this->table_name, array('id' => $id));
        if (empty($query->result()))
        {
            throw new MY_BdExcepcion('Sin resultados');
        }
        return $query->result()[0];
    }

    /**
     * Fetch an array of records.
     */
    public function get_all()
    {
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    /**
     * Fetch a single record based on the array $datos.
     * $datos array as $column => $value
     */
    public function get_by($datos)
    {
        foreach ($datos as $column => $value) {
            $this->db->like("LOWER($column)", strtolower($value));
        }
        $query = $this->db->get($this->table_name);
        if (empty($query->result())) {
            throw new MY_BdExcepcion('Sin resultados');
        }
        return $query->result()[0];
    }

}