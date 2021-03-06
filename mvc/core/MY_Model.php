<?php

class MY_Model extends CI_Model{
    
    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = '';
    protected $_rules = array();
    protected $_timestamps = FALSE;
    

    public function __construct() {
        parent::__construct();
    }
    
   
    public function get($id = NULL, $single = FALSE){
        if($id != NULL ){
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
                   
        }elseif($single == TRUE){
            $method = 'row';
            
        }else {
            $method = 'result';
        }
        
        if(!count( $this->db->ar_orderby)){
             $this->db->order_by($this->_order_by);
        }
        
       
        return $this->db->get($this->_table_name)->$method();
        
    }
    
    
    public function get_by($where, $single= FALSE)
    {
        $this->db->where($where);
        return $this->get(NULL,$single);
        
    }
    public function save($data, $id= NULl)
    {
        
        if($this->_timestamps == TRUE){
            $now = date('Y-m-d H:i-s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }
        
        //INSERT
        if($id==NULL)
        {
            $this->db->insert($data);
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = null;
            $this->db->insert($data);
            $id = $this->db->insert_id();
            
            
        }
        //UPDATE
        else{
            $filter = $this->_primary_filter;
            $id = $filter($data[$this->_primary_key]);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
            
        }
        
        return $id;
    }
    public function delete($id)
    {
        $filter = $this->_primary_filter;
        $id = $filter($id);
        
        if(!$id){
            return FALSE;
        }
        $this->db->where($this->_primary_key, $id);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

