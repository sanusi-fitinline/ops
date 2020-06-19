<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_m extends CI_Model {
	var $table = 'tb_product'; //nama tabel dari database
    var $column_order = array(null, 'PRO_NAME'); //field yang ada di table user
    var $column_search = array('PRO_NAME'); //field yang diizin untuk pencarian 
    var $order = array('PRO_NAME' => 'ASC'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        
        $this->db->select('tb_product.*, umea_a.UMEA_NAME AS PRO_UMEA, umea_b.UMEA_NAME AS PRO_VOL_UMEA');
        $this->db->from($this->table);
        $this->db->join('tb_unit_measure AS umea_a', 'umea_a.UMEA_ID=tb_product.PRO_UNIT', 'left');
        $this->db->join('tb_unit_measure AS umea_b', 'umea_b.UMEA_ID=tb_product.PRO_VOL_UNIT', 'left');

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

	public function get($PRO_ID = null) {
		$this->db->select('tb_product.*, umea_a.UMEA_NAME AS UMEA_NAME_A, umea_b.UMEA_NAME AS UMEA_NAME_B, umea_c.UMEA_NAME AS UMEA_NAME_C, tb_vendor.VEND_NAME, tb_currency.CURR_NAME, tb_city.CITY_NAME, tb_type.TYPE_NAME, user_created.USER_NAME AS CREATED_NAME, user_edited.USER_NAME AS EDITED_NAME');
		$this->db->from('tb_product');
		$this->db->join('tb_unit_measure AS umea_a', 'umea_a.UMEA_ID=tb_product.PRO_UNIT', 'left');
		$this->db->join('tb_unit_measure AS umea_b', 'umea_b.UMEA_ID=tb_product.PRO_VOL_UNIT', 'left');
		$this->db->join('tb_unit_measure AS umea_c', 'umea_c.UMEA_ID=tb_product.PRO_TOTAL_UNIT', 'left');
		$this->db->join('tb_vendor', 'tb_vendor.VEND_ID=tb_product.VEND_ID', 'left');
		$this->db->join('tb_currency', 'tb_currency.CURR_ID=tb_product.CURR_ID', 'left');
		$this->db->join('tb_city', 'tb_city.CITY_ID=tb_product.CITY_ID', 'left');
		$this->db->join('tb_type', 'tb_type.TYPE_ID=tb_product.TYPE_ID', 'left');
		$this->db->join('tb_user AS user_created', 'user_created.USER_ID=tb_product.PRO_CREATEDBY', 'left');
		$this->db->join('tb_user AS user_edited', 'user_edited.USER_ID=tb_product.PRO_EDITEDBY', 'left');
		if($PRO_ID != null) {
			$this->db->where('tb_product.PRO_ID', $PRO_ID);
		}
		$this->db->order_by('tb_product.PRO_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_by_subtype($PRO_ID = null) {
		$this->db->select('tb_product.STYPE_ID, tb_subtype.STYPE_NAME');
		$this->db->from('tb_product');
		$this->db->join('tb_subtype', 'tb_subtype.STYPE_ID=tb_product.STYPE_ID', 'left');
		if ($PRO_ID != null) {
			$this->db->where('tb_product.PRO_ID', $PRO_ID);
		}
		$this->db->order_by('tb_subtype.STYPE_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_umea($PRO_ID) {
        $this->db->select('tb_product.PRO_ID, a.UMEA_ID AS UNIT_ID, a.UMEA_NAME AS UNIT_NAME, b.UMEA_ID AS VOL_ID,  b.UMEA_NAME AS VOL_NAME, c.UMEA_ID AS TOTAL_ID, c.UMEA_NAME AS TOTAL_NAME');
        $this->db->from('tb_product');
        $this->db->join('tb_unit_measure AS a', 'a.UMEA_ID=tb_product.PRO_UNIT', 'left');
        $this->db->join('tb_unit_measure AS b', 'b.UMEA_ID=tb_product.PRO_VOL_UNIT', 'left');
        $this->db->join('tb_unit_measure AS c', 'c.UMEA_ID=tb_product.PRO_TOTAL_UNIT', 'left');
        $this->db->where('tb_product.PRO_ID', $PRO_ID);
        $this->db->order_by('a.UMEA_NAME', 'ASC');
        $this->db->order_by('b.UMEA_NAME', 'ASC');
        $this->db->order_by('c.UMEA_NAME', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function get_subtype_price_list() {
    	$TYPE_ID  = $this->input->post('TYPE_ID', TRUE);
    	$STYPE_ID = $this->input->post('STYPE_ID', TRUE);
    	$SUBTYPE = array();
    	if ($STYPE_ID != null) {
	    	foreach($STYPE_ID as $i => $val){
				$SUBTYPE[] = $STYPE_ID[$i];
			}
    	}

    	$this->db->select('tb_product.STYPE_ID, tb_subtype.STYPE_NAME');
		$this->db->from('tb_product');
		$this->db->join('tb_subtype', 'tb_subtype.STYPE_ID=tb_product.STYPE_ID', 'inner');
		$this->db->where('tb_product.TYPE_ID', $TYPE_ID);
		if ($STYPE_ID != null) {
			$this->db->where_in('tb_product.STYPE_ID', $SUBTYPE);
		}
		$this->db->order_by('tb_subtype.STYPE_NAME', 'ASC');
		$this->db->group_by('tb_product.STYPE_ID');
		$query = $this->db->get();
		return $query;
    }

    public function get_price_list() {
    	$TYPE_ID  = $this->input->post('TYPE_ID', TRUE);
    	$STYPE_ID = $this->input->post('STYPE_ID', TRUE);
    	$SUBTYPE = array();
    	if ($STYPE_ID != null) {
	    	foreach($STYPE_ID as $i => $val){
				$SUBTYPE[] = $STYPE_ID[$i];
			}
		}

    	$this->db->select('tb_product.*, umea_a.UMEA_NAME AS UMEA_NAME_A, umea_b.UMEA_NAME AS UMEA_NAME_B, umea_c.UMEA_NAME AS UMEA_NAME_C, tb_type.TYPE_NAME, tb_subtype.STYPE_NAME');
		$this->db->from('tb_product');
		$this->db->join('tb_unit_measure AS umea_a', 'umea_a.UMEA_ID=tb_product.PRO_UNIT', 'left');
		$this->db->join('tb_unit_measure AS umea_b', 'umea_b.UMEA_ID=tb_product.PRO_VOL_UNIT', 'left');
		$this->db->join('tb_unit_measure AS umea_c', 'umea_c.UMEA_ID=tb_product.PRO_TOTAL_UNIT', 'left');
		$this->db->join('tb_type', 'tb_type.TYPE_ID=tb_product.TYPE_ID', 'left');
		$this->db->join('tb_subtype', 'tb_subtype.STYPE_ID=tb_product.STYPE_ID', 'inner');
		$this->db->where('tb_product.TYPE_ID', $TYPE_ID);
		if ($STYPE_ID != null) {
			$this->db->where_in('tb_product.STYPE_ID', $SUBTYPE);
		}
		$this->db->order_by('tb_subtype.STYPE_NAME', 'ASC');
		$this->db->order_by('tb_product.PRO_NAME', 'ASC');
		$query = $this->db->get();
		return $query;
    }

	public function insert(){
		date_default_timezone_set('Asia/Jakarta');
		$config['upload_path']          = './assets/images/product/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('PRO_PICTURE'))
        {
            // $error = array('error' => $this->upload->display_errors());
            // $this->template->load('template', 'product/product_data', $error);
            $gambar = '';
        } else {
        	$gambar = $this->upload->data('file_name', TRUE);
        }

		$dataInsert = array(
			'PRO_NAME'				=> $this->input->post('PRO_NAME', TRUE),
			'PRO_DESC'				=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRO_DESC', TRUE)),
			'PRO_WEIGHT'			=> $this->input->post('PRO_WEIGHT', TRUE),
			'PRO_PICTURE'			=> $gambar,
			'PRO_STATUS'			=> $this->input->post('PRO_STATUS', TRUE),
			'PRO_AVAIL'				=> $this->input->post('PRO_AVAIL', TRUE),
			'PRO_PRICE'				=> str_replace(".", "", $this->input->post('PRO_PRICE', TRUE)),
			'PRO_UNIT'				=> $this->input->post('PRO_UNIT', TRUE),
			'PRO_VOL_PRICE'			=> str_replace(".", "", $this->input->post('PRO_VOL_PRICE', TRUE)),
			'PRO_VOL_UNIT'			=> $this->input->post('PRO_VOL_UNIT', TRUE),
			'PRO_PRICE_VENDOR'		=> str_replace(".", "", $this->input->post('PRO_PRICE_VENDOR', TRUE)),
			'PRO_VOL_PRICE_VENDOR' 	=> str_replace(".", "", $this->input->post('PRO_VOLPRICE_VENDOR', TRUE)),
			'PRO_TOTAL_COUNT'		=> $this->input->post('PRO_TOTAL_COUNT', TRUE),
			'PRO_TOTAL_UNIT'		=> $this->input->post('PRO_TOTAL_UNIT', TRUE),
			'PRO_TOTAL_WEIGHT'		=> $this->input->post('PRO_TOTAL_WEIGHT', TRUE),
			'VEND_ID'				=> $this->input->post('VEND_ID', TRUE),
			'CURR_ID'				=> $this->input->post('CURR_ID', TRUE),
			'CITY_ID'				=> $this->input->post('CITY_ID', TRUE),
			'TYPE_ID'				=> $this->input->post('TYPE_ID', TRUE),
			'STYPE_ID'				=> $this->input->post('STYPE_ID', TRUE),
			'PRO_CREATEDON'			=> date('Y-m-d H:i:s'),
			'PRO_CREATEDBY'			=> $this->session->USER_SESSION,

		);
		$this->db->insert('tb_product', $this->db->escape_str($dataInsert));
		
	}

	public function update($PRO_ID){
		date_default_timezone_set('Asia/Jakarta');
		$config['upload_path']          = './assets/images/product/';
	    $config['allowed_types']        = 'jpg|jpeg|png';
	    $config['encrypt_name'] 		= FALSE;
	    $config['remove_spaces'] 		= TRUE;
	    $config['overwrite']			= FALSE;
	    $config['max_size']             = 3024; // 3MB
	    $config['max_width']            = 5000;
	    $config['max_height']           = 5000;
	    $this->load->library('upload');
	    $this->upload->initialize($config);

	    if (!$this->upload->do_upload('PRO_PICTURE'))
        {
        	$gambar = $this->input->post('OLD_PICTURE', TRUE);
        } else {
	        $query = $this->db->get_where('tb_product',['PRO_ID' => $PRO_ID])->row();
	        if($query->PRO_PICTURE != null || $query->PRO_PICTURE != ''){
	        	if(file_exists("./assets/images/product/".$query->PRO_PICTURE)) {
			        unlink("./assets/images/product/".$query->PRO_PICTURE);
	        	}
        	}
		    $gambar = $this->upload->data('file_name', TRUE);
		}
		$dataUpdate = array(
			'PRO_NAME'				=> $this->input->post('PRO_NAME', TRUE),
			'PRO_DESC'				=> str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRO_DESC', TRUE)),
			'PRO_WEIGHT'			=> $this->input->post('PRO_WEIGHT', TRUE),
			'PRO_PICTURE'			=> $gambar,
			'PRO_STATUS'			=> $this->input->post('PRO_STATUS', TRUE),
			'PRO_AVAIL'				=> $this->input->post('PRO_AVAIL', TRUE),
			'PRO_PRICE'				=> str_replace(".", "", $this->input->post('PRO_PRICE', TRUE)),
			'PRO_UNIT'				=> $this->input->post('PRO_UNIT', TRUE),
			'PRO_VOL_PRICE'			=> str_replace(".", "", $this->input->post('PRO_VOL_PRICE', TRUE)),
			'PRO_VOL_UNIT'			=> $this->input->post('PRO_VOL_UNIT', TRUE),
			'PRO_PRICE_VENDOR'		=> str_replace(".", "", $this->input->post('PRO_PRICE_VENDOR', TRUE)),
			'PRO_VOL_PRICE_VENDOR'	=> str_replace(".", "", $this->input->post('PRO_VOLPRICE_VENDOR', TRUE)),
			'PRO_TOTAL_COUNT'		=> $this->input->post('PRO_TOTAL_COUNT', TRUE),
			'PRO_TOTAL_UNIT'		=> $this->input->post('PRO_TOTAL_UNIT', TRUE),
			'PRO_TOTAL_WEIGHT'		=> $this->input->post('PRO_TOTAL_WEIGHT', TRUE),
			'VEND_ID'				=> $this->input->post('VEND_ID', TRUE),
			'CURR_ID'				=> $this->input->post('CURR_ID', TRUE),
			'CITY_ID'				=> $this->input->post('CITY_ID', TRUE),
			'TYPE_ID'				=> $this->input->post('TYPE_ID', TRUE),
			'STYPE_ID'				=> $this->input->post('STYPE_ID', TRUE),
			'PRO_EDITEDON'			=> date('Y-m-d H:i:s'),
			'PRO_EDITEDBY'			=> $this->session->USER_SESSION,
		);
		$this->db->where('PRO_ID', $PRO_ID)->update('tb_product', $this->db->escape_str($dataUpdate));
	}

	public function delete($PRO_ID) {
		$opt = $this->db->get_where('tb_poption',['PRO_ID' => $PRO_ID])->result();
        $query1 = $this->db->delete('tb_poption',['PRO_ID'=>$PRO_ID]);
        foreach($opt as $row) {
	        if($query1){
	        	if($row->POPT_PICTURE !=null || $row->POPT_PICTURE != '') {
	        		if(file_exists("./assets/images/product/option/".$row->POPT_PICTURE)) {
	            		unlink("./assets/images/product/option/".$row->POPT_PICTURE);
	            	}
				}
	        }
        }

		$pro = $this->db->get_where('tb_product',['PRO_ID' => $PRO_ID])->row();
        $query2 = $this->db->delete('tb_product',['PRO_ID'=>$PRO_ID]);
        if($query2){
        	if($pro->PRO_PICTURE != null || $pro->PRO_PICTURE != ''){
	        	if(file_exists("./assets/images/product/".$pro->PRO_PICTURE)) {
			        unlink("./assets/images/product/".$pro->PRO_PICTURE);
	        	}
        	}
        }
	}

}