<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coutariff_m extends CI_Model {
	var $table = 'tb_courier_tariff'; //nama tabel dari database
    var $column_search = array('COURIER_NAME', 'OCNTR.CNTR_NAME', 'OSTATE.STATE_NAME', 'OCITY.CITY_NAME', 'OSUBD.SUBD_NAME', 'DCNTR.CNTR_NAME', 'DSTATE.STATE_NAME', 'DCITY.CITY_NAME', 'DSUBD.SUBD_NAME'); //field yang diizin untuk pencarian 
    var $order = array('COURIER_NAME' => 'ASC'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($COURIER_ID) {
        $this->db->select('tb_courier_tariff.*, tb_courier.COURIER_NAME, OCNTR.CNTR_NAME AS O_CNTR_NAME, OSTATE.STATE_NAME AS O_STATE_NAME, OCITY.CITY_NAME AS O_CITY_NAME, OSUBD.SUBD_NAME AS O_SUBD_NAME, DCNTR.CNTR_NAME AS D_CNTR_NAME, DSTATE.STATE_NAME AS D_STATE_NAME, DCITY.CITY_NAME AS D_CITY_NAME, DSUBD.SUBD_NAME AS D_SUBD_NAME');
		$this->db->from($this->table);    
		$this->db->join('tb_courier', 'tb_courier_tariff.COURIER_ID=tb_courier.COURIER_ID', 'left');
		$this->db->join('tb_country AS OCNTR', 'OCNTR.CNTR_ID=tb_courier_tariff.O_CNTR_ID', 'left');
		$this->db->join('tb_state AS OSTATE', 'OSTATE.STATE_ID=tb_courier_tariff.O_STATE_ID', 'left');
		$this->db->join('tb_city AS OCITY', 'OCITY.CITY_ID=tb_courier_tariff.O_CITY_ID', 'left');
		$this->db->join('tb_subdistrict AS OSUBD', 'OSUBD.SUBD_ID=tb_courier_tariff.O_SUBD_ID', 'left');
		$this->db->join('tb_country AS DCNTR', 'DCNTR.CNTR_ID=tb_courier_tariff.D_CNTR_ID', 'left');
		$this->db->join('tb_state AS DSTATE', 'DSTATE.STATE_ID=tb_courier_tariff.D_STATE_ID', 'left');
		$this->db->join('tb_city AS DCITY', 'DCITY.CITY_ID=tb_courier_tariff.D_CITY_ID', 'left');
		$this->db->join('tb_subdistrict AS DSUBD', 'DSUBD.SUBD_ID=tb_courier_tariff.D_SUBD_ID', 'left');
		$this->db->where('tb_courier_tariff.COURIER_ID', $COURIER_ID);

        $i = 0;
    
        foreach ($this->column_search as $item) { // loop column 
            if($_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
       	if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($COURIER_ID) {
        $this->_get_datatables_query($COURIER_ID);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($COURIER_ID) {
        $this->_get_datatables_query($COURIER_ID);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($COURIER_ID) {
        $this->_get_datatables_query($COURIER_ID);
        return $this->db->count_all_results();
    }
	
	public function getTariff($COURIER_ID = null) {
		
		$this->db->select('tb_courier_tariff.*, tb_courier.COURIER_NAME, OCNTR.CNTR_NAME AS O_CNTR_NAME, OSTATE.STATE_NAME AS O_STATE_NAME, OCITY.CITY_NAME AS O_CITY_NAME, OSUBD.SUBD_NAME AS O_SUBD_NAME, DCNTR.CNTR_NAME AS D_CNTR_NAME, DSTATE.STATE_NAME AS D_STATE_NAME, DCITY.CITY_NAME AS D_CITY_NAME, DSUBD.SUBD_NAME AS D_SUBD_NAME');
		$this->db->from('tb_courier_tariff');
		$this->db->join('tb_courier', 'tb_courier_tariff.COURIER_ID=tb_courier.COURIER_ID', 'left');
		$this->db->join('tb_country AS OCNTR', 'OCNTR.CNTR_ID=tb_courier_tariff.O_CNTR_ID', 'left');
		$this->db->join('tb_state AS OSTATE', 'OSTATE.STATE_ID=tb_courier_tariff.O_STATE_ID', 'left');
		$this->db->join('tb_city AS OCITY', 'OCITY.CITY_ID=tb_courier_tariff.O_CITY_ID', 'left');
		$this->db->join('tb_subdistrict AS OSUBD', 'OSUBD.SUBD_ID=tb_courier_tariff.O_SUBD_ID', 'left');
		$this->db->join('tb_country AS DCNTR', 'DCNTR.CNTR_ID=tb_courier_tariff.D_CNTR_ID', 'left');
		$this->db->join('tb_state AS DSTATE', 'DSTATE.STATE_ID=tb_courier_tariff.D_STATE_ID', 'left');
		$this->db->join('tb_city AS DCITY', 'DCITY.CITY_ID=tb_courier_tariff.D_CITY_ID', 'left');
		$this->db->join('tb_subdistrict AS DSUBD', 'DSUBD.SUBD_ID=tb_courier_tariff.D_SUBD_ID', 'left');
		if($COURIER_ID != null) {
			$this->db->where('tb_courier_tariff.COURIER_ID', $COURIER_ID);
		}
		$this->db->order_by('COURIER_NAME', 'ASC');
		$query = $this->db->get();
		return $query;	
	}

	public function getTariff2($COURIER_ID, $O_CNTR_ID, $O_STATE_ID, $O_CITY_ID, $O_SUBD_ID, $D_CNTR_ID, $D_STATE_ID, $D_CITY_ID, $D_SUBD_ID) {
		
		$query = $this->db->query("SELECT tb_courier_tariff.*, tb_courier.COURIER_NAME, tb_courier.COURIER_API
			FROM tb_courier_tariff
			INNER JOIN tb_courier ON tb_courier_tariff.COURIER_ID=tb_courier.COURIER_ID
			WHERE (tb_courier_tariff.COURIER_ID='$COURIER_ID') AND (tb_courier.COURIER_API=0) AND ((O_CNTR_ID='$O_CNTR_ID' AND O_STATE_ID='$O_STATE_ID' AND O_CITY_ID='$O_CITY_ID' AND O_SUBD_ID='$O_SUBD_ID')
			OR (O_CNTR_ID='$O_CNTR_ID' AND O_STATE_ID='$O_STATE_ID' AND O_CITY_ID='$O_CITY_ID' AND O_SUBD_ID=0)
			OR (O_CNTR_ID='$O_CNTR_ID' AND O_STATE_ID='$O_STATE_ID' AND O_CITY_ID=0 AND O_SUBD_ID=0)
			OR (O_CNTR_ID='$O_CNTR_ID' AND O_STATE_ID=0 AND O_CITY_ID=0 AND O_SUBD_ID=0))
			AND ((D_CNTR_ID='$D_CNTR_ID' AND D_STATE_ID='$D_STATE_ID' AND D_CITY_ID='$D_CITY_ID' AND D_SUBD_ID='$D_SUBD_ID') 
			OR (D_CNTR_ID='$D_CNTR_ID' AND D_STATE_ID='$D_STATE_ID' AND D_CITY_ID='$D_CITY_ID' AND D_SUBD_ID=0)
			OR (D_CNTR_ID='$D_CNTR_ID' AND D_STATE_ID='$D_STATE_ID' AND D_CITY_ID=0 AND D_SUBD_ID=0)
			OR (D_CNTR_ID='$D_CNTR_ID' AND D_STATE_ID=0 AND D_CITY_ID=0 AND D_SUBD_ID=0))
			ORDER BY O_CNTR_ID DESC, O_STATE_ID DESC, O_CITY_ID DESC, O_SUBD_ID DESC,
			D_CNTR_ID DESC, D_STATE_ID DESC, D_CITY_ID DESC, D_SUBD_ID DESC LIMIT 1");

		return $query;	
	}

	public function getDetailTariff($COUTAR_ID = null) {
		
		$this->db->select('tb_courier_tariff.*, tb_courier.COURIER_NAME, OCNTR.CNTR_NAME AS O_CNTR_NAME, OSTATE.STATE_NAME AS O_STATE_NAME, OCITY.CITY_NAME AS O_CITY_NAME, OSUBD.SUBD_NAME AS O_SUBD_NAME, DCNTR.CNTR_NAME AS D_CNTR_NAME, DSTATE.STATE_NAME AS D_STATE_NAME, DCITY.CITY_NAME AS D_CITY_NAME, DSUBD.SUBD_NAME AS D_SUBD_NAME');
		$this->db->from('tb_courier_tariff');
		$this->db->join('tb_courier', 'tb_courier_tariff.COURIER_ID=tb_courier.COURIER_ID', 'left');
		$this->db->join('tb_country AS OCNTR', 'OCNTR.CNTR_ID=tb_courier_tariff.O_CNTR_ID', 'left');
		$this->db->join('tb_state AS OSTATE', 'OSTATE.STATE_ID=tb_courier_tariff.O_STATE_ID', 'left');
		$this->db->join('tb_city AS OCITY', 'OCITY.CITY_ID=tb_courier_tariff.O_CITY_ID', 'left');
		$this->db->join('tb_subdistrict AS OSUBD', 'OSUBD.SUBD_ID=tb_courier_tariff.O_SUBD_ID', 'left');
		$this->db->join('tb_country AS DCNTR', 'DCNTR.CNTR_ID=tb_courier_tariff.D_CNTR_ID', 'left');
		$this->db->join('tb_state AS DSTATE', 'DSTATE.STATE_ID=tb_courier_tariff.D_STATE_ID', 'left');
		$this->db->join('tb_city AS DCITY', 'DCITY.CITY_ID=tb_courier_tariff.D_CITY_ID', 'left');
		$this->db->join('tb_subdistrict AS DSUBD', 'DSUBD.SUBD_ID=tb_courier_tariff.D_SUBD_ID', 'left');
		if($COUTAR_ID != null) {
			$this->db->where('tb_courier_tariff.COUTAR_ID', $COUTAR_ID);
		}
		$this->db->order_by('COURIER_NAME', 'ASC');
		$query = $this->db->get();
		return $query;	
	}

	public function insertTariff() {
		$dataInsert = array(
			'O_CNTR_ID'			=> $this->input->post('O_CNTR_ID', TRUE),
			'O_STATE_ID'		=> $this->input->post('O_STATE_ID', TRUE),
			'O_CITY_ID'			=> $this->input->post('O_CITY_ID', TRUE),
			'O_SUBD_ID'			=> $this->input->post('O_SUBD_ID', TRUE),
			'D_CNTR_ID'			=> $this->input->post('D_CNTR_ID', TRUE),
			'D_STATE_ID'		=> $this->input->post('D_STATE_ID', TRUE),
			'D_CITY_ID'			=> $this->input->post('D_CITY_ID', TRUE),
			'D_SUBD_ID'			=> $this->input->post('D_SUBD_ID', TRUE),
			'RULE_ID'			=> $this->input->post('RULE_ID', TRUE),
			'COUTAR_MIN_KG'		=> $this->input->post('COUTAR_MIN_KG', TRUE),
			'COUTAR_ADMIN_FEE'	=> str_replace(".", "", $this->input->post('COUTAR_ADMIN_FEE', TRUE)),
			'COUTAR_KG_FIRST'	=> str_replace(".", "", $this->input->post('COUTAR_KG_FIRST', TRUE)),
			'COUTAR_KG_NEXT'	=> str_replace(".", "", $this->input->post('COUTAR_KG_NEXT', TRUE)),
			'COUTAR_ETD'		=> $this->input->post('COUTAR_ETD', TRUE),
			'COUTAR_NOTE'		=> $this->input->post('COUTAR_NOTE', TRUE),
			'COURIER_ID'		=> $this->input->post('COURIER_ID', TRUE),
		);
		$this->db->insert('tb_courier_tariff', $this->db->escape_str($dataInsert));
	}

	public function updateTariff($COUTAR_ID) {
		$dataUpdate = array(
			'O_CNTR_ID'			=> $this->input->post('O_CNTR_ID', TRUE),
			'O_STATE_ID'		=> $this->input->post('O_STATE_ID', TRUE),
			'O_CITY_ID'			=> $this->input->post('O_CITY_ID', TRUE),
			'O_SUBD_ID'			=> $this->input->post('O_SUBD_ID', TRUE),
			'D_CNTR_ID'			=> $this->input->post('D_CNTR_ID', TRUE),
			'D_STATE_ID'		=> $this->input->post('D_STATE_ID', TRUE),
			'D_CITY_ID'			=> $this->input->post('D_CITY_ID', TRUE),
			'D_SUBD_ID'			=> $this->input->post('D_SUBD_ID', TRUE),
			'RULE_ID'			=> $this->input->post('RULE_ID', TRUE),
			'COUTAR_MIN_KG'		=> $this->input->post('COUTAR_MIN_KG', TRUE),
			'COUTAR_ADMIN_FEE'	=> str_replace(".", "", $this->input->post('COUTAR_ADMIN_FEE', TRUE)),
			'COUTAR_KG_FIRST'	=> str_replace(".", "", $this->input->post('COUTAR_KG_FIRST', TRUE)),
			'COUTAR_KG_NEXT'	=> str_replace(".", "", $this->input->post('COUTAR_KG_NEXT', TRUE)),
			'COUTAR_ETD'		=> $this->input->post('COUTAR_ETD', TRUE),
			'COUTAR_NOTE'		=> $this->input->post('COUTAR_NOTE', TRUE),
		);
		$this->db->where('COUTAR_ID', $COUTAR_ID)->update('tb_courier_tariff', $this->db->escape_str($dataUpdate));
	}

	public function deleteTariff($COUTAR_ID) {
		$this->db->where('COUTAR_ID', $COUTAR_ID);
		$this->db->delete('tb_courier_tariff');
	}

}