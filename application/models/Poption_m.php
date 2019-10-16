<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poption_m extends CI_Model {
	var $table = 'tb_poption'; //nama tabel dari database
    var $column_order = array(null, 'PRO_NAME','POPT_NAME','POPT_PICTURE'); //field yang ada di table
    var $column_search = array('PRO_NAME','POPT_NAME'); //field yang diizin untuk pencarian 
    var $order = array('POPT_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($PRO_ID = null){
        $this->db->select('tb_product.PRO_NAME, tb_poption.*');
        $this->db->from($this->table);
        $this->db->join('tb_product', 'tb_product.PRO_ID=tb_poption.PRO_ID', 'left');
        if ($PRO_ID !=null) {
            $this->db->where('tb_poption.PRO_ID', $PRO_ID);
        }

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

    function get_datatables($PRO_ID = null){
        $this->_get_datatables_query($PRO_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($PRO_ID = null){
        $this->_get_datatables_query($PRO_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($PRO_ID = null){
        $this->_get_datatables_query($PRO_ID);
        return $this->db->count_all_results();
    }

	public function get_by_product($PRO_ID = null) {
		$this->db->select('tb_poption.POPT_ID, tb_poption.POPT_NAME, tb_product.PRO_NAME');
		$this->db->join('tb_product', 'tb_product.PRO_ID=tb_poption.PRO_ID', 'left');
		$this->db->from('tb_poption');
		if($PRO_ID != null) {
			$this->db->where('tb_poption.PRO_ID', $PRO_ID);
		}
		$this->db->order_by('POPT_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function getDetailOption($POPT_ID = null) {
		$this->db->select('tb_poption.*, tb_product.PRO_NAME');
		$this->db->from('tb_poption');
		$this->db->join('tb_product', 'tb_product.PRO_ID=tb_poption.PRO_ID', 'left');
		if($POPT_ID != null) {
			$this->db->where('tb_poption.POPT_ID', $POPT_ID);
		}
		$this->db->order_by('POPT_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function insertOption(){
		$config['upload_path']          = './assets/images/product/option/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

        if (!$this->upload->do_upload('POPT_PICTURE'))
        {
            $gambar = '';
        } else {
            $gambar = $this->upload->data('file_name', TRUE);
        }
		$dataInsert = array(
			'POPT_NAME'				=> $this->input->post('POPT_NAME', TRUE),
			'POPT_PICTURE'			=> $gambar,
			'PRO_ID'				=> $this->input->post('PRO_ID', TRUE),
		);
		$this->db->insert('tb_poption', $this->db->escape_str($dataInsert));
	}

	public function updateOption($POPT_ID){
		$config['upload_path']          = './assets/images/product/option/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('POPT_PICTURE')) {
	    	$gambar = $this->input->post('OLD_PICTURE', TRUE);
        } else {
    		$query = $this->db->get_where('tb_poption',['POPT_ID' => $POPT_ID])->row();
	        unlink("assets/images/product/option/".$query->POPT_PICTURE);
	        $gambar = $this->upload->data('file_name', TRUE);
		}
		$dataUpdate = array(
			'POPT_NAME'				=> $this->input->post('POPT_NAME', TRUE),
			'POPT_PICTURE'			=> $gambar,
			'PRO_ID'				=> $this->input->post('PRO_ID', TRUE),
		);
		$this->db->where('POPT_ID', $POPT_ID)->update('tb_poption', $this->db->escape_str($dataUpdate));
	}

	public function deleteOption($POPT_ID) {
		$opt = $this->db->get_where('tb_poption',['POPT_ID' => $POPT_ID])->row();
        $query = $this->db->delete('tb_poption',['POPT_ID'=>$POPT_ID]);
        if($query){
            if($opt->POPT_PICTURE !=null) {
                unlink("assets/images/product/option/".$opt->POPT_PICTURE);
            }
        }
	}

}