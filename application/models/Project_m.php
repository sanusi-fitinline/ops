<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_m extends CI_Model {
	var $table = 'tb_project'; //nama tabel dari database
    var $column_search = array('tb_project.PRJ_ID','tb_customer.CUST_NAME', 'tb_user.USER_NAME'); //field yang diizin untuk pencarian

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($STATUS_FILTER = null) {
        $this->load->model('access_m');
        $modul = "Project";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $this->db->select('tb_project.*, tb_customer.CUST_NAME, tb_user.USER_NAME');
        $this->db->from($this->table);
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
			if (!($viewall)) { // filter sesuai hak akses
				$this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
			}
	    }

		if ($STATUS_FILTER != null) { // filter by status
			$this->db->group_start();
            if ($STATUS_FILTER == 0) { // filter status pre-order
                $this->db->where('tb_project.PRJ_STATUS', 0);
            } elseif ($STATUS_FILTER == 1) { // filter status offered
				$this->db->where('tb_project.PRJ_STATUS', 1);
			} elseif ($STATUS_FILTER == 2) { // filter status invoiced
				$this->db->where('tb_project.PRJ_STATUS', 2);
			} elseif ($STATUS_FILTER == 3) { // filter status confirmed
				$this->db->where('tb_project.PRJ_STATUS', 3);
			} elseif ($STATUS_FILTER == 4) { // filter status in progress
				$this->db->where('tb_project.PRJ_STATUS', 4);
            } elseif ($STATUS_FILTER == 5) { // filter status half paid
                $this->db->where('tb_project.PRJ_STATUS', 5);
            } elseif ($STATUS_FILTER == 6) { // filter status paid
                $this->db->where('tb_project.PRJ_STATUS', 6);
            } elseif ($STATUS_FILTER == 7) { // filter status half delivered
                $this->db->where('tb_project.PRJ_STATUS', 7);
            } elseif ($STATUS_FILTER == 8) { // filter status delivered
                $this->db->where('tb_project.PRJ_STATUS', 8);
			} else { // filter status cancel
				$this->db->where('tb_project.PRJ_STATUS', 9);
			}
			$this->db->group_end();
		} 

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
        
        $this->db->order_by('tb_project.PRJ_DATE', 'DESC');
    }

    function get_datatables($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($STATUS_FILTER = null) {
        $this->_get_datatables_query($STATUS_FILTER);
        return $this->db->count_all_results();
    }

    public function get($PRJ_ID = null) {
        $this->load->model('access_m');
        $modul = "Project";
        $modul2 = "Follow Up (VR)";
        $view = 1;
        $viewall =  $this->access_m->isViewAll($modul, $view)->row();
        $viewall2 =  $this->access_m->isViewAll($modul2, $view)->row();
        $this->db->select('tb_project.*, tb_project_type.PRJT_NAME, tb_customer.CUST_NAME, tb_customer.CUST_EMAIL, tb_customer.CUST_ADDRESS, tb_customer.CUST_PHONE, tb_customer.CNTR_ID, tb_customer.STATE_ID, tb_customer.CITY_ID, tb_customer.SUBD_ID, tb_country.CNTR_NAME, tb_state.STATE_NAME, tb_city.CITY_NAME, tb_subdistrict.SUBD_NAME, tb_bank.BANK_NAME, tb_channel.CHA_NAME, tb_user.USER_NAME, tb_courier.COURIER_NAME');
        $this->db->from('tb_project');
        $this->db->join('tb_user', 'tb_user.USER_ID=tb_project.USER_ID', 'left');
        $this->db->join('tb_customer', 'tb_customer.CUST_ID=tb_project.CUST_ID', 'left');
        $this->db->join('tb_country', 'tb_country.CNTR_ID=tb_customer.CNTR_ID', 'left');
        $this->db->join('tb_state', 'tb_state.STATE_ID=tb_customer.STATE_ID', 'left');
        $this->db->join('tb_city', 'tb_city.CITY_ID=tb_customer.CITY_ID', 'left');
        $this->db->join('tb_subdistrict', 'tb_subdistrict.SUBD_ID=tb_customer.SUBD_ID', 'left');
        $this->db->join('tb_bank', 'tb_bank.BANK_ID=tb_project.BANK_ID', 'left');
        $this->db->join('tb_channel', 'tb_channel.CHA_ID=tb_project.CHA_ID', 'left');
        $this->db->join('tb_project_type', 'tb_project_type.PRJT_ID=tb_project.PRJT_ID', 'left');
        $this->db->join('tb_courier', 'tb_courier.COURIER_ID=tb_project.COURIER_ID', 'left');
        if ($this->session->GRP_SESSION !=3) {
            if (!($viewall || $viewall2)) { // filter sesuai hak akses
                $this->db->where('tb_project.USER_ID', $this->session->USER_SESSION);
            }
        }
        if($this->uri->segment(2) == "cancel_detail" || $this->uri->segment(2) == "cancel_detail_view") {
            $this->db->where('tb_project.PRJ_STATUS', 9);
        } else if($this->uri->segment(2) == "detail" || $this->uri->segment(2) == "detail_view") {
            $this->db->where('tb_project.PRJ_STATUS !=', 9);
        }
        if($PRJ_ID != null) {
            $this->db->where('tb_project.PRJ_ID', $PRJ_ID);
        }
        $this->db->order_by('PRJ_ID', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function insert() {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d', strtotime($this->input->post('PRJ_DATE', TRUE)));
        $time = date('H:i:s');
        $params['CUST_ID']  = $this->input->post('CUST_ID', TRUE);
        $params['PRJ_DATE'] = $date.' '.$time;
        if (!empty($this->input->post('PRJ_NOTES'))) {
            $params['PRJ_NOTES'] = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n")," ",$this->input->post('PRJ_NOTES', TRUE));
        }
        $params['PRJ_STATUS'] = 0;
        if (!empty($this->input->post('PRJ_DURATION_EXP'))) {
            $params['PRJ_DURATION_EXP'] = $this->input->post('PRJ_DURATION_EXP', TRUE);
        }
        $params['USER_ID'] = $this->session->USER_SESSION;
        $params['CHA_ID']  = $this->input->post('CHA_ID', TRUE);
        $params['PRJT_ID'] = $this->input->post('PRJT_ID', TRUE);
        
        $insert = $this->db->insert('tb_project', $this->db->escape_str($params));
    }

    public function update($PRJ_ID) {
        $PRJ_PAYMENT_METHOD = $this->input->post('PRJ_PAYMENT_METHOD', TRUE);
        $PRJ_DURATION_EST   = $this->input->post('PRJ_DURATION_EST', TRUE);
        $COURIER_ID         = $this->input->post('COURIER_ID', TRUE);
        $PRJ_SERVICE_TYPE   = $this->input->post('PRJ_SERVICE_TYPE', TRUE);
        $PRJ_ETD            = $this->input->post('PRJ_ETD', TRUE);
        $PRJ_SUBTOTAL       = str_replace(".", "", $this->input->post('PRJ_SUBTOTAL', TRUE));
        $PRJ_DISCOUNT       = str_replace(".", "", $this->input->post('PRJ_DISCOUNT', TRUE));
        $PRJ_DEPOSIT        = str_replace(".", "", $this->input->post('PRJ_DEPOSIT', TRUE));
        $PRJ_ADDCOST        = str_replace(".", "", $this->input->post('PRJ_ADDCOST', TRUE));
        $PRJ_TAX            = str_replace(".", "", $this->input->post('PRJ_TAX', TRUE));
        $PRJ_TOTAL          = str_replace(".", "", $this->input->post('PRJ_TOTAL', TRUE));
        $PRJ_SHIPCOST       = str_replace(".", "", $this->input->post('PRJ_SHIPCOST', TRUE));
        $PRJ_GRAND_TOTAL    = str_replace(".", "", $this->input->post('PRJ_GRAND_TOTAL', TRUE));
        $TANPA_DEPOSIT      = (($PRJ_SUBTOTAL - $PRJ_DISCOUNT) + $PRJ_SHIPCOST + $PRJ_ADDCOST + $PRJ_TAX);

        $PRJD_ID            = $this->input->post('PRJD_ID', TRUE);
        $PRJD_SHIPCOST      = $this->input->post('PRJD_SHIPCOST', TRUE);
        $PRJD_ETD           = $this->input->post('PRJD_ETD', TRUE);

        $PRJDQ_ID           = $this->input->post('PRJDQ_ID', TRUE);
        $PRJDQ_QTY          = $this->input->post('PRJDQ_QTY', TRUE);

        // update total tb_project
        if(!empty($PRJ_DEPOSIT)) {
            if($PRJ_DEPOSIT > $TANPA_DEPOSIT) {
                $DEPOSIT = $TANPA_DEPOSIT;
            } else {
                $DEPOSIT = $PRJ_DEPOSIT;
            }
        } else {
            $DEPOSIT = Null;
        }

        $update_project['PRJ_SUBTOTAL']       = $PRJ_SUBTOTAL;
        $update_project['PRJ_DISCOUNT']       = $PRJ_DISCOUNT;
        $update_project['PRJ_DEPOSIT']        = $DEPOSIT;
        $update_project['PRJ_ADDCOST']        = $PRJ_ADDCOST;
        $update_project['PRJ_TAX']            = $PRJ_TAX;
        $update_project['PRJ_TOTAL']          = $PRJ_TOTAL;
        $update_project['PRJ_SHIPCOST']       = $PRJ_SHIPCOST;
        $update_project['PRJ_GRAND_TOTAL']    = $PRJ_GRAND_TOTAL;
        $update_project['PRJ_PAYMENT_METHOD'] = $PRJ_PAYMENT_METHOD;
        $update_project['PRJ_DURATION_EST']   = ( !empty( $PRJ_DURATION_EST ) ) ? $PRJ_DURATION_EST : Null;
        $update_project['COURIER_ID']         = ( !empty( $COURIER_ID ) ) ? $COURIER_ID : Null;
        $update_project['PRJ_SERVICE_TYPE']   = ( !empty( $PRJ_SERVICE_TYPE ) ) ? $PRJ_SERVICE_TYPE : Null;
        $update_project['PRJ_ETD']            = ( !empty( $PRJ_ETD ) ) ? $PRJ_ETD : Null;
        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update_project);
        //

        if( !empty( $COURIER_ID ) ) {
            // update shipcost tb_project_detail
            $update_detail_shipcost = array();
            foreach($PRJD_ID as $n => $key) {
                $update_detail_shipcost = array(
                    'PRJD_SHIPCOST' => $PRJD_SHIPCOST[$n],
                    'PRJD_ETD'      => $PRJD_ETD[$n],
                );
                $this->db->where('PRJD_ID', $PRJD_ID[$n]);
                $this->db->update('tb_project_detail', $this->db->escape_str($update_detail_shipcost));
            }
        }
        //

        if ($PRJ_PAYMENT_METHOD != null) {
            $payment = $this->db->get_where('tb_project_payment',['PRJ_ID' => $PRJ_ID, 'PRJP_PAYMENT_DATE' => "0000-00-00"]);
            if ($payment->num_rows() > 0) {
                $this->db->delete('tb_project_payment',['PRJ_ID' => $PRJ_ID]);
            }

            if ($PRJ_PAYMENT_METHOD != 1) {
                $params['PRJ_ID']      = $this->input->post('PRJ_ID', TRUE);
                $params['PRJP_NO']     = 1;
                $params['PRJP_PCNT']   = 100;
                $params['PRJP_AMOUNT'] = $PRJ_GRAND_TOTAL;
                $this->db->insert('tb_project_payment', $this->db->escape_str($params));
            }

        }
    }

    public function get_user_id($CUST_ID) {
        $this->db->select('USER_ID');
        $this->db->from('tb_customer');
        $this->db->where('CUST_ID', $CUST_ID);
        $query = $this->db->get();
        return $query;
    }

    public function update_payment($PRJ_ID) {
        $CUST_ID            = $this->input->post('CUST_ID', TRUE);
        $PRJ_STATUS         = $this->input->post('PRJ_STATUS', TRUE);
        $PRJ_DURATION_EST   = $this->input->post('PRJ_DURATION_EST', TRUE);
        $PRJ_TOTAL          = str_replace(".", "", $this->input->post('PRJ_TOTAL', TRUE));
        $PRJ_DISCOUNT       = str_replace(".", "", $this->input->post('PRJ_DISCOUNT', TRUE));
        $PRJ_DEPOSIT        = str_replace(".", "", $this->input->post('PRJ_DEPOSIT', TRUE));
        $ALL_DEPOSIT        = str_replace(".", "", $this->input->post('ALL_DEPOSIT', TRUE));
        $PRJ_SHIPCOST       = str_replace(".", "", $this->input->post('PRJ_SHIPCOST', TRUE));
        $PRJ_ADDCOST        = str_replace(".", "", $this->input->post('PRJ_ADDCOST', TRUE));
        $PRJ_TAX            = str_replace(".", "", $this->input->post('PRJ_TAX', TRUE));
        $PRJ_GRAND_TOTAL    = str_replace(".", "", $this->input->post('PRJ_GRAND_TOTAL', TRUE));
        $TANPA_DEPOSIT      = (($PRJ_TOTAL - $PRJ_DISCOUNT) + $PRJ_SHIPCOST + $PRJ_ADDCOST + $PRJ_TAX);
        $PRJ_PAYMENT_METHOD = $this->input->post('PRJ_PAYMENT_METHOD', TRUE);
        $BANK_ID            = $this->input->post('BANK_ID', TRUE);
        $PAYMENT_DATE       = $this->input->post('PRJ_PAYMENT_DATE', TRUE);
        $PRJ_PAYMENT_DATE   = date('Y-m-d', strtotime($PAYMENT_DATE));

        // update payment tb_project
        // if($PRJ_PAYMENT_METHOD != '') {
        //     $update['PRJ_STATUS'] = ($PRJ_PAYMENT_METHOD != 1) ? '6' : '3';
        // }
        $update['PRJ_PAYMENT_METHOD'] = $PRJ_PAYMENT_METHOD;
        $update['BANK_ID'] = (!empty($BANK_ID)) ? $BANK_ID : Null;
        $update['PRJ_PAYMENT_DATE'] = (!empty($PAYMENT_DATE)) ? $PRJ_PAYMENT_DATE : Null;
        $update['PRJ_DURATION_EST'] = (!empty($PRJ_DURATION_EST)) ? $PRJ_DURATION_EST : Null;
        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $update);
        //
        // mencatat sisa deposit jika ada
        if ($PRJ_STATUS < 3) {
            if ($PRJ_PAYMENT_METHOD != 1) {
                if($this->db->affected_rows() > 0) {
                    if(!empty($PRJ_DEPOSIT)) {
                        // check customer deposit yang masih open
                        $this->load->model('custdeposit_m');
                        $check = $this->custdeposit_m->check_deposit($CUST_ID);
                        if($check->num_rows() > 0) {
                            // update deposit status pada tb_customer_deposit
                            $update_status['CUSTD_DEPOSIT_STATUS'] = 2;
                            $this->db->where('CUST_ID', $CUST_ID);
                            $this->db->where('CUSTD_DEPOSIT_STATUS', 0);
                            $this->db->update('tb_customer_deposit', $this->db->escape_str($update_status));
                        }

                        // insert sisa deposit jika deposit > grand total
                        if($ALL_DEPOSIT > $TANPA_DEPOSIT) {
                            $get_user     = $this->get_user_id($CUST_ID)->row();
                            $USER_ID      = $get_user->USER_ID;
                            $SISA_DEPOSIT = $ALL_DEPOSIT - $TANPA_DEPOSIT;
                            $deposit_baru['CUSTD_DATE']           = date('Y-m-d H:i:s');
                            $deposit_baru['CUSTD_DEPOSIT']        = $SISA_DEPOSIT;
                            $deposit_baru['CUSTD_DEPOSIT_STATUS'] = 0;
                            $deposit_baru['CUST_ID']              = $CUST_ID;
                            $deposit_baru['USER_ID']              = $USER_ID;
                            $this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit_baru));
                        }
                    }
                }
            }
        }
        //
    }

    public function cancel_project($PRJ_ID) {
        $field = $this->db->get_where('tb_project',['PRJ_ID' => $PRJ_ID])->row();
        $CUST_ID            = $field->CUST_ID;
        $PRJ_STATUS         = $field->PRJ_STATUS;
        $PRJ_PAYMENT_METHOD = $field->PRJ_PAYMENT_METHOD;
        $PRJ_GRAND_TOTAL    = $field->PRJ_GRAND_TOTAL;
        $TANPA_DEPOSIT      = (($field->PRJ_SUBTOTAL - $field->PRJ_DISCOUNT) + $field->PRJ_SHIPCOST + $field->PRJ_ADDCOST + $field->PRJ_TAX);

        $cancel_project = array(
            'PRJ_STATUS' => 9,
        );
        $this->db->where('PRJ_ID', $PRJ_ID)->update('tb_project', $this->db->escape_str($cancel_project));

        // if($PRJ_STATUS >= 3 && $PRJ_STATUS <= 6) {
        //     if($PRJ_PAYMENT_METHOD != 1) {
        //         if($PRJ_GRAND_TOTAL !=0){
        //             $TOTAL_DEPOSIT = $PRJ_GRAND_TOTAL;
        //         } else {
        //             $TOTAL_DEPOSIT = $TANPA_DEPOSIT;
        //         }
        //     } else {
        //         $row = $this->db->select('SUM(PRJP_AMOUNT) AS TOTAL_AMOUNT')->where('PRJ_ID', $PRJ_ID)->where('BANK_ID IS NOT NULL', null, false)->get('tb_project_payment')->row();
        //         $TOTAL_DEPOSIT = $row->TOTAL_AMOUNT;
        //     }
        //     $get_user = $this->get_user_id($CUST_ID)->row();
        //     $USER_ID  = $get_user->USER_ID;
        //     $deposit['CUSTD_DATE']           = date('Y-m-d H:i:s');
        //     $deposit['ORDER_ID']             = $PRJ_ID;
        //     $deposit['CUSTD_DEPOSIT']        = $TOTAL_DEPOSIT;
        //     $deposit['CUSTD_DEPOSIT_STATUS'] = 0;
        //     $deposit['CUST_ID']              = $CUST_ID;
        //     $deposit['USER_ID']              = $USER_ID;
        //     $deposit['CUSTD_NOTES']          = "Order Custom : ".$PRJ_ID;
        //     $this->db->insert('tb_customer_deposit', $this->db->escape_str($deposit));
        // }
    }

    public function delete($PRJ_ID) {
        // check project detail
        $check_detail = $this->db->get_where('tb_project_detail',['PRJ_ID' => $PRJ_ID]);
        if($check_detail->num_rows() > 0) {
            // get detail
            $detail     = $check_detail->result();

            foreach ($detail as $key) {
                // delete tb_project_review
                $check_review = $this->db->get_where('tb_project_review',['PRJD_ID'=>$key->PRJD_ID]);
                if($check_review->num_rows() > 0) {
                    $this->db->delete('tb_project_review',['PRJD_ID'=>$key->PRJD_ID]);
                }

                // delete tb_project_progress
                $check_progress = $this->db->get_where('tb_project_progress',['PRJD_ID'=>$key->PRJD_ID]);
                if($check_progress->num_rows() > 0) {
                    $progress = $check_progress->result();
                    $del_progress = $this->db->delete('tb_project_detail_model',['PRJD_ID'=>$key->PRJD_ID]);
                    if($del_progress){
                        foreach ($progress as $_field) {
                            if($_field->PRJPG_IMG != null || $_field->PRJPG_IMG != '') {
                                if(file_exists("./assets/images/project/progress/".$_field->PRJDM_IMG)) {
                                    unlink("./assets/images/project/progress/".$_field->PRJPG_IMG);
                                }
                            }
                        }
                    }
                }

                // delete tb_project_producer
                $check_project_producer = $this->db->get_where('tb_project_producer',['PRJD_ID'=>$key->PRJD_ID]);
                if($check_project_producer->num_rows() > 0) {
                    $pro_produc = $check_project_producer->result();
                    $del_pro_produc = $this->db->delete('tb_project_producer',['PRJD_ID'=>$key->PRJD_ID]);
                    if($del_pro_produc) {
                        foreach ($pro_produc as $_data) {
                            if($_data->PRJPR_IMG != null || $_data->PRJPR_IMG != ''){
                                if(file_exists("./assets/images/project/offer/".$_data->PRJPR_IMG)) {
                                    unlink("./assets/images/project/offer/".$_data->PRJPR_IMG);
                                }
                            }
                            // delete tb_project_producer_detail
                            $this->db->delete('tb_project_producer_detail',['PRJPR_ID'=>$_data->PRJPR_ID]);
                        }

                    }
                }

                // delete tb_project_detail_model
                $check_model = $this->db->get_where('tb_project_detail_model',['PRJD_ID'=>$key->PRJD_ID]);
                if($check_model->num_rows() > 0) {
                    $model = $check_model->result();
                    $del_model = $this->db->delete('tb_project_detail_model',['PRJD_ID'=>$key->PRJD_ID]);
                    if($del_model){
                        foreach ($model as $field) {
                            if($field->PRJDM_IMG != null || $field->PRJDM_IMG != ''){
                                if(file_exists("./assets/images/project/detail/model/".$field->PRJDM_IMG)) {
                                    unlink("./assets/images/project/detail/model/".$field->PRJDM_IMG);
                                }
                            }
                        }
                    }
                }

                // delete tb_project_detail_quantity
                $check_qty  = $this->db->get_where('tb_project_detail_quantity',['PRJD_ID'=>$key->PRJD_ID]);
                if($check_qty->num_rows() > 0) {
                   $this->db->delete('tb_project_detail_quantity',['PRJD_ID'=>$key->PRJD_ID]);
                }

                // delete gambar project detail
                if($key->PRJD_IMG != null || $key->PRJD_IMG != '') {
                    $img = explode(", ",$key->PRJD_IMG);
                    foreach ($img as $i => $value) {
                        $image[$i] = $img[$i];
                        if(file_exists("./assets/images/project/detail/".$image[$i])) {
                            unlink("./assets/images/project/detail/".$image[$i]);
                        }
                    }
                }

                // delete payment to producer
                $check_payment = $this->db->get_where('tb_project_payment_to_producer',['PRJD_ID'=>$key->PRJD_ID]);
                if($check_payment->num_rows() > 0) {
                    $this->db->delete('tb_project_payment_to_producer',['PRJD_ID'=>$key->PRJD_ID]);
                }

                // delete shipment to customer
                $check_shipment = $this->db->get_where('tb_project_shipment',['PRJD_ID'=>$key->PRJD_ID]);
                if($check_shipment->num_rows() > 0) {
                    $this->db->delete('tb_project_shipment',['PRJD_ID'=>$key->PRJD_ID]);
                }
            }

            // delete tb_project_detail
            $del_detail = $this->db->delete('tb_project_detail',['PRJ_ID'=>$PRJ_ID]);
        }

        // check installment
        $check_installment = $this->db->get_where('tb_project_payment',['PRJ_ID' => $PRJ_ID]);
        if($check_installment->num_rows() > 0) {
            // delete tb_project_payment
            $this->db->delete('tb_project_payment',['PRJ_ID'=>$PRJ_ID]);
        }

        // delete tb_project
        $this->db->delete('tb_project',['PRJ_ID'=>$PRJ_ID]);
    }
}