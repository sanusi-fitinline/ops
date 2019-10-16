<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Subd_m extends CI_Model {
 
    var $table = 'tb_subdistrict'; //nama tabel dari database
    var $column_order = array(null, 'SUBD_NAME','CITY_NAME','STATE_NAME', 'CNTR_NAME'); //field yang ada di table user
    var $column_search = array('SUBD_NAME','CITY_NAME','STATE_NAME', 'CNTR_NAME'); //field yang diizin untuk pencarian 
    var $order = array('SUBD_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select('tb_subdistrict.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_subdistrict.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_subdistrict.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_subdistrict.CITY_ID', 'left');

        $i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getSubdistrict($CITY_ID = null) {
        $this->db->select('*');
        $this->db->from('tb_subdistrict');
        if($CITY_ID != null) {
            $this->db->where('CITY_ID', $CITY_ID);
        }
        $this->db->order_by('SUBD_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function getAreaSubd($SUBD_ID = null) {
        $this->db->select('tb_subdistrict.*, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME');
        $this->db->from('tb_subdistrict');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_subdistrict.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_subdistrict.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_subdistrict.CITY_ID', 'left');
        if($SUBD_ID != null) {
            $this->db->where('SUBD_ID', $SUBD_ID);
        }
        $this->db->order_by('SUBD_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function insertSubd(){
        $dataInsert = array(
            'CNTR_ID'       => $this->input->post('CNTR_ID', TRUE),
            'STATE_ID'      => $this->input->post('STATE_ID', TRUE),
            'CITY_ID'       => $this->input->post('CITY_ID', TRUE),
            'SUBD_NAME'     => $this->input->post('SUBD_NAME', TRUE),
        );
        $this->db->insert('tb_subdistrict', $this->db->escape_str($dataInsert));
    }

    public function updateSubd($SUBD_ID){
        $dataUpdate = array(
            'CNTR_ID'       => $this->input->post('CNTR_ID', TRUE),
            'STATE_ID'      => $this->input->post('STATE_ID', TRUE),
            'CITY_ID'       => $this->input->post('CITY_ID', TRUE),
            'SUBD_NAME'     => $this->input->post('SUBD_NAME', TRUE),
        );
        $this->db->where('SUBD_ID', $SUBD_ID)->update('tb_subdistrict', $this->db->escape_str($dataUpdate));
    }

    public function deleteSubd($SUBD_ID){
        $this->db->where('SUBD_ID', $SUBD_ID);
        $this->db->delete('tb_subdistrict');
    } 
}