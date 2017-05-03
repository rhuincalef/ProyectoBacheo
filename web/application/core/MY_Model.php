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
            // $this->db->like("$column", strtolower($value));
        }
        $query = $this->db->get($this->table_name);
        if (empty($query->result())) {
            throw new MY_BdExcepcion('Sin resultados');
        }
        return $query->result()[0];
    }


/**
     * Fetch an array of records based on an arbitrary WHERE call.
     */
    public function get_many_by()
    {
        require_once('CustomLogger.php');
        $where = func_get_args();
        CustomLogger::log('los atributos del where son');
        CustomLogger::log($where);
        
        $this->_set_where($where);

        return $this->get_all();
    }

      /**
     * Set WHERE parameters, cleverly
     */
    protected function _set_where($params)
    {
        if (count($params) == 1 && is_array($params[0]))
        {
            foreach ($params[0] as $field => $filter)
            {
                if (is_array($filter))
                {
                    $this->_database->where_in($field, $filter);
                }
                else
                {
                    if (is_int($field))
                    {
                        $this->_database->where($filter);
                    }
                    else
                    {
                        $this->_database->where($field, $filter);
                    }
                }
            }
        } 
        else if (count($params) == 1)
        {
            $this->_database->where($params[0]);
        }
        else if(count($params) == 2)
        {
            if (is_array($params[1]))
            {
                $this->_database->where_in($params[0], $params[1]);    
            }
            else
            {
                $this->_database->where($params[0], $params[1]);
            }
        }
        else if(count($params) == 3)
        {
            $this->_database->where($params[0], $params[1], $params[2]);
        }
        else
        {
            if (is_array($params[1]))
            {
                $this->_database->where_in($params[0], $params[1]);    
            }
            else
            {
                $this->_database->where($params[0], $params[1]);
            }
        }
    }


}