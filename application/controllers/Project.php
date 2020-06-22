<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	function __construct() {
		parent::__construct();
		check_not_login();
		$this->load->model('access_m');
		$this->load->model('bank_m');
		$this->load->model('customer_m');
		$this->load->model('channel_m');
		$this->load->model('producer_m');
		$this->load->model('producer_product_m');
		$this->load->model('project_m');
		$this->load->model('project_detail_m');
		$this->load->model('project_model_m');
		$this->load->model('project_quantity_m');
		$this->load->model('project_type_m');
		$this->load->model('project_payment_m');
		$this->load->model('project_producer_m');
		$this->load->model('project_activity_m');
		$this->load->model('project_progress_m');
		$this->load->model('project_criteria_m');
		$this->load->model('project_review_m');
		$this->load->model('size_group_m');
		$this->load->model('size_m');
		$this->load->model('size_value_m');
		$this->load->model('custdeposit_m');
		$this->load->model('courier_m');
		$this->load->model('coutariff_m');
		$this->load->model('orderletter_m');
		$this->load->model('city_m');
		$this->load->library('pdf');
		$this->load->library('rajaongkir');
		$this->load->library('form_validation');
	}

	public function index() {
		$modul  = "Order Custom";
		$access = $this->access_m->isAccess($this->session->GRP_SESSION, $modul)->row();
		if ((!$access) && ($this->session->GRP_SESSION !=3)) {
			echo "<script>alert('Anda tidak punya akses ke $modul.')</script>";
			echo "<script>window.location='".site_url('dashboard')."'</script>";
		} else {
			$this->template->load('template', 'project/project_data');
		}
	}

	public function project_json() {
		$STATUS_FILTER  = $this->input->post('STATUS_FILTER', TRUE);
		$url 	   		= $this->config->base_url();
		$list      		= $this->project_m->get_datatables($STATUS_FILTER);
		$data 			= array();
		$no 			= $_POST['start'];
		foreach ($list as $field) {
			if ($field->PRJ_NOTES!=null) {
				$PRJ_NOTES = $field->PRJ_NOTES;
			} else {$PRJ_NOTES = "<div align='center'>-</div>";}

			if ($field->PRJ_STATUS == 0) { // Pre-Order
				$PRJ_STATUS = "<div class='btn btn-light btn-sm' style='font-size: 12px; color: #6c757d; background-color:#f8f9fa; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-exclamation-circle'></i><span><b> Pre Order</b></span></div>";
			} else if ($field->PRJ_STATUS == 1) { // Offered
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#795548; border-color:#795548; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-user-check'></i><span><b> Offered</b></span></div>";
			} else if ($field->PRJ_STATUS == 2) { // Invoiced
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6f7948; border-color:#6f7948; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-print'></i><span><b> Invoiced</b></span></div>";
			} else if ($field->PRJ_STATUS == 3) { // Confirmed
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6c757d; border-color:#6c757d; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-bell'></i><span><b> Confirmed</b></span></div>";
			} else if ($field->PRJ_STATUS == 4) { // In Progress
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#6f42c1; border-color:#6f42c1; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fas fa-drafting-compass'></i><span><b> In Progress</b></span></div>";			
			} else if ($field->PRJ_STATUS == 5) { // Half Paid
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:orange; border-color:orange; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-hourglass-half'></i><span><b> Half Paid</b></span></div>";
			} else if ($field->PRJ_STATUS == 6) { // Paid
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#20c997; border-color:#20c997; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-minus-circle'></i><span><b> Paid</b></span></div>";		
			} else if ($field->PRJ_STATUS == 7) { // Half Delivered
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#4269c1; border-color:#4269c1; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-truck'></i><span><b> Half Delivered</b></span></div>";
			} else if ($field->PRJ_STATUS == 8) { // Delivered
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#17a2b8; border-color:#17a2b8; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-check-circle'></i><span><b> Delivered</b></span></div>";
			} else {
				$PRJ_STATUS = "<div class='btn btn-default btn-sm' style='font-size: 12px; color: #fff; background-color:#e83e8c; border-color:#e83e8c; border-radius: 6px; padding: 2px 5px 5px 3px; width:100px;'><i class='fa fa-ban'></i><span><b> Cancel</b></span></div>";
			}

			$row   = array();
			$row[] = "<div align='center'>$PRJ_STATUS</div>";
			$row[] = "<div align='center'>$field->PRJ_ID</div>";
			$row[] = "<div align='center'>".date('d-m-Y / H:i:s', strtotime($field->PRJ_DATE))."</div>";
			$row[] = stripslashes($field->CUST_NAME);
			$row[] = stripslashes($PRJ_NOTES);
			$row[] = stripslashes($field->USER_NAME);
			
			if($field->PRJ_STATUS == 9) {
				$detail = "cancel_detail";
			} else {
				$detail = "detail";
			}

			if((!$this->access_m->isDelete('Order Custom', 1)->row()) && ($this->session->GRP_SESSION !=3))
			{
				$row[] = '<div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'project/'.$detail.'/'.$field->PRJ_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a></div>';
			} else {
				$row[] = '<form action="'.$url.'project/del_project" method="post"><div style="vertical-align: middle; text-align: center;">
					<a href="'.$url.'project/'.$detail.'/'.$field->PRJ_ID.'" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-search-plus"></i></a>
					<input type="hidden" name="PRJ_ID" value="'.$field->PRJ_ID.'">
					<button onclick="'."return confirm('Hapus data?')".'" type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
					</div></form>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->project_m->count_all($STATUS_FILTER),
			"recordsFiltered" => $this->project_m->count_filtered($STATUS_FILTER),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	public function add() {
		$data['customer'] 	= $this->customer_m->get()->result();
		$data['channel']  	= $this->channel_m->getCha()->result();
		$data['producer']  	= $this->producer_m->get()->result();
		$data['type']  		= $this->project_type_m->get()->result();
		$this->template->load('template', 'project/project_form_add', $data);
	}

	public function add_process() {
		$data['row'] =	$this->project_m->insert();
		if($data) {
            echo "<script>window.location='".site_url('project/add_detail/'.$this->db->insert_id())."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('project')."'</script>";
        }	
	}

	public function add_detail() {
		$data['product'] 	= $this->producer_product_m->get()->result();
		$data['size_group'] = $this->size_group_m->get()->result();
		$this->template->load('template', 'project/project_form_add_detail', $data);
	}

	public function add_detail_process() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID');
		$data['row'] = $this->project_detail_m->insert();
        if(isset($_POST['new'])) {
			if($data){
				echo "<script>alert('Data berhasil ditambah.')</script>";
				echo "<script>window.location='".site_url('project/add_detail/'.$PRJ_ID)."'</script>";
			}
		} else {
			if($data) {
	            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
	        } else {
	            echo "<script>alert('Data gagal ditambah.')</script>";
	            echo "<script>window.location='".site_url('project')."'</script>";
	        }
		}	
	}

	public function detail($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		 = $query->row();
			$data['bank'] 		 = $this->bank_m->getBank()->result();
			$data['_detail'] 	 = $this->project_detail_m->get($PRJ_ID, null)->result();
			$data['quantity'] 	 = $this->project_quantity_m->get()->result();
			$data['installment'] = $this->project_payment_m->check_installment($PRJ_ID);
			$data['courier'] 	 = $this->courier_m->getCourier()->result();
			$data['payment'] 	 = $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'project/project_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function detail_view($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model'] 		= $this->project_model_m->get($PRJD_ID, null)->result();
			$data['size_group'] = $this->size_group_m->get()->result();
			$this->template->load('template', 'project/project_detail_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function cancel_detail($PRJ_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['_detail'] 	= $this->project_detail_m->get($PRJ_ID)->result();
			$data['quantity'] 	= $this->project_quantity_m->get()->result();
			$data['model'] 		= $this->project_model_m->get()->result();
			$data['payment'] 	= $this->project_payment_m->get($PRJ_ID)->result_array();
			$this->template->load('template', 'project/project_cancel_detail', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function cancel_detail_view($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['model'] 		= $this->project_model_m->get($PRJD_ID, null)->result();
			$this->template->load('template', 'project/project_cancel_detail_view', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function cancel_project($PRJ_ID) {
		$check = $this->project_detail_m->get($PRJ_ID, null);
		if($check->num_rows() > 0){
			echo "<script>alert('Tambah detail dibatalkan.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
		} else {
			$data['row'] =	$this->project_m->delete($PRJ_ID);
			if($data) {
				echo "<script>alert('Project dibatalkan.')</script>";
				echo "<script>window.location='".site_url('project')."'</script>";
			} else {
				echo "<script>alert('Project gagal dibatalkan.')</script>";
				echo "<script>window.location='".site_url('project')."'</script>";
			}
		}
	}

	public function edit_project() {
		$PRJ_ID = $this->input->post('PRJ_ID', true);
		if(isset($_POST['CANCEL'])) {
			$cancel['data'] = $this->project_m->cancel_project($PRJ_ID);
			if($cancel) {
				echo "<script>alert('Order dicancel.')</script>";
				echo "<script>window.location='".site_url('project/cancel_detail/'.$PRJ_ID)."'</script>";
			} else {
				echo "<script>alert('Cancel order gagal.')</script>";
				echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
			}
		} else if(isset($_POST['UPDATE_PAYMENT'])) {
			$update['update'] = $this->project_m->update_payment($PRJ_ID);
			if($update) {
				echo "<script>alert('Data berhasil diubah.')</script>";
				echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
			} else {
				echo "<script>alert('Tidak ada perubahan data.')</script>";
				echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
			}
		} else if(isset($_POST['UPDATE_DETAIL'])) {
			$PRJD_ID = $this->input->post('PRJD_ID');
			$query['update'] = $this->project_detail_m->update($PRJ_ID);
			if($query) {
				echo "<script>alert('Data berhasil diubah.')</script>";
				echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
			} else {
				echo "<script>alert('Tidak ada perubahan data.')</script>";
				echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
			}
		} else {
			$update['update'] = $this->project_m->update($PRJ_ID);
			if($update) {
	            echo "<script>alert('Data berhasil diubah.')</script>";
	            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
	        } else {
	            echo "<script>alert('Data gagal diubah.')</script>";
	            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
	        }
		}
	}

	public function del_project() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$data['row'] =	$this->project_m->delete($PRJ_ID);
		if($data) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function add_installment() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$data['row'] =	$this->project_payment_m->insert();
		if($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
        }	
	}

	public function edit_installment() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$data['row'] =	$this->project_payment_m->update();
		if($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
        } else {
            echo "<script>alert('Tidak ada perubahan data.')</script>";
            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
        }	
	}

	public function add_quantity() {
		$PRJ_ID 	 = $this->input->post('PRJ_ID', TRUE);
		$data['row'] =	$this->project_quantity_m->insert();
		if($data) {
            echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
        }	
	}

	public function del_quantity($PRJ_ID, $PRJDQ_ID) {
		$this->project_quantity_m->delete($PRJ_ID, $PRJDQ_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project/detail/'.$PRJ_ID)."'</script>";
		}
	}

	public function add_model() {
		$PRJ_ID  	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$data['row'] =	$this->project_model_m->insert();
		if($data) {
            echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        }	
	}

	public function edit_model() {
		$PRJ_ID   = $this->input->post('PRJ_ID', TRUE, TRUE);
		$PRJD_ID  = $this->input->post('PRJD_ID', TRUE, TRUE);
		$PRJDM_ID = $this->input->post('PRJDM_ID', TRUE, TRUE);
		$this->project_model_m->update($PRJDM_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_model($PRJ_ID, $PRJD_ID, $PRJDM_ID) {
		$this->project_model_m->delete($PRJDM_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project/detail_view/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function progress($PRJD_ID) {
		$query = $this->project_detail_m->get(null, $PRJD_ID);
		if ($query->num_rows() > 0) {
			$data['detail'] 	= $query->row();
			$PRJ_ID 			= $query->row()->PRJ_ID;
			$data['row'] 		= $this->project_m->get($PRJ_ID)->row();
			$data['activity'] 	= $this->project_activity_m->get()->result();
			$data['progress'] 	= $this->project_progress_m->get($PRJD_ID)->result();
			$this->template->load('template', 'project/project_progress', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function review($PRJ_ID, $PRJD_ID) {
		$query = $this->project_m->get($PRJ_ID);
		if ($query->num_rows() > 0) {
			$data['row'] 		= $query->row();
			$data['detail'] 	= $this->project_detail_m->get(null, $PRJD_ID)->row();
			$data['progress'] 	= $this->project_progress_m->get($PRJD_ID)->result();
			$data['review'] 	= $this->project_review_m->get(null, $PRJD_ID)->result();
			$data['criteria'] 	= $this->project_criteria_m->get()->result();
			$this->template->load('template', 'project/project_review', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan.')</script>";
			echo "<script>window.location='".site_url('project')."'</script>";
		}
	}

	public function add_review() {
		$PRJ_ID  	 = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID 	 = $this->input->post('PRJD_ID', TRUE);
		$data['row'] =	$this->project_review_m->insert();
		if($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
            echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        } else {
            echo "<script>alert('Data gagal ditambah.')</script>";
            echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
        }	
	}

	public function edit_review() {
		$PRJ_ID  = $this->input->post('PRJ_ID', TRUE);
		$PRJD_ID = $this->input->post('PRJD_ID', TRUE);
		$PRJR_ID = $this->input->post('PRJR_ID', TRUE);
		$this->project_review_m->update($PRJR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function del_review($PRJ_ID, $PRJD_ID, $PRJR_ID) {
		$this->project_review_m->delete($PRJR_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		} else {
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project/review/'.$PRJ_ID.'/'.$PRJD_ID)."'</script>";
		}
	}

	public function size_group($PRJ_ID) {
		$this->template->load('template', 'project/size-data/size-group/size_group_data');
	}

	public function add_size_group($PRJ_ID) {
		$data['row'] =	$this->size_group_m->insert();
		$SIZG_ID = $this->db->insert_id();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project/size/'.$PRJ_ID.'/'.$SIZG_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project/size_group/'.$PRJ_ID)."'</script>";
		}
	}

	public function size($PRJ_ID, $SIZG_ID) {
		$data['row']   = $this->size_group_m->get($SIZG_ID)->row();
		$data['size']  = $this->size_m->get_by_group($SIZG_ID)->result();
		$data['group'] = $this->size_group_m->get()->result();
		$this->template->load('template', 'project/size-data/size/size_data', $data);
	}

	public function add_size($PRJ_ID, $SIZG_ID) {
		$data['row'] = $this->size_m->insert();
		if ($data) {
			echo "<script>alert('Data berhasil ditambah.')</script>";
			echo "<script>window.location='".site_url('project/size/'.$PRJ_ID.'/'.$SIZG_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal ditambah.')</script>";
			echo "<script>window.location='".site_url('project/size/'.$PRJ_ID.'/'.$SIZG_ID)."'</script>";
		}
	}

	public function edit_size($PRJ_ID, $SIZG_ID, $SIZE_ID) {
		$data['row'] = $this->size_m->update($SIZE_ID);
		if ($data) {
			echo "<script>alert('Data berhasil diubah.')</script>";
			echo "<script>window.location='".site_url('project/size/'.$PRJ_ID.'/'.$SIZG_ID)."'</script>";
		} else{
			echo "<script>alert('Tidak ada perubahan data.')</script>";
			echo "<script>window.location='".site_url('project/size/'.$PRJ_ID.'/'.$SIZG_ID)."'</script>";
		}
	}

	public function del_size($PRJ_ID, $SIZG_ID, $SIZE_ID) {
		$this->size_m->delete($SIZE_ID);
		if($this->db->affected_rows() > 0) {
			echo "<script>alert('Data berhasil dihapus.')</script>";
			echo "<script>window.location='".site_url('project/size/'.$PRJ_ID.'/'.$SIZG_ID)."'</script>";
		} else{
			echo "<script>alert('Data gagal dihapus.')</script>";
			echo "<script>window.location='".site_url('project/size/'.$PRJ_ID.'/'.$SIZG_ID)."'</script>";
		}
	}

	public function datacal(){
		$PRDU_ID 		= $this->input->post('PRDU_ID', TRUE);
		$CUST_ID 		= $this->input->post('CUST_ID', TRUE);
		$COURIER_ID 	= $this->input->post('COURIER_ID', TRUE);
		$COURIER_NAME 	= $this->input->post('COURIER_NAME', TRUE);
		$WEIGHT 		= $this->input->post('WEIGHT', TRUE);
		$customer 		= $this->customer_m->get($CUST_ID)->row();
		$origin 	    = $this->city_m->getAreaCity(269)->row();
		$apinol  		= $this->coutariff_m->getTariff2($COURIER_ID, $origin->CNTR_ID, $origin->STATE_ID, $origin->CITY_ID, 0, $customer->CNTR_ID, $customer->STATE_ID, $customer->CITY_ID, $customer->SUBD_ID)->result();
		$key 			= $this->courier_m->getCourier($COURIER_ID)->row();
		if($customer->CITY_ID!=0){
		    if($key->COURIER_API == 1){
		    	$WEIGHT_RO = $WEIGHT*1000;
				$lists = "";
				$etd = "";
		    	if($customer->SUBD_ID!=0){
		    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->SUBD_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'subdistrict');
		    	} else{
		    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->CITY_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'city');
		    	}
				$detailCost = json_decode($dataCost, true);
				$status = $detailCost['rajaongkir']['status']['code'];
				if ($status == 200) {
					for ($i=0; $i < count($detailCost['rajaongkir']['results']); $i++) {
						for ($j=0; $j < count($detailCost['rajaongkir']['results'][$i]['costs']); $j++) {
							$service = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['service'];
							$lists .= "<option value='$service'>$service</option>";
						}
					}
				}
			}
			else{
				if(!$apinol){
						$lists = 0;
						$etd = "";
						$status = "<p style='font-size:14px;color:red;'><small>* </small>Tarif tidak ditemukan, ganti kurir lain atau input manual.</p>";
				} else{
					foreach($apinol as $k) {
				    	if($k->RULE_ID == 1) {
							if (round($WEIGHT) <= $k->COUTAR_MIN_KG) {
								$tarif = ($k->COUTAR_MIN_KG * $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
							} else if (round($WEIGHT) > $k->COUTAR_MIN_KG) {
								$tarif = (round($WEIGHT) * $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
							}
						}else if($k->RULE_ID == 2){
							if (round($WEIGHT) <= $k->COUTAR_MIN_KG) {
								$tarif = ($k->COUTAR_KG_FIRST + $k->COUTAR_ADMIN_FEE);
							} else if (round($WEIGHT) > $k->COUTAR_MIN_KG) {
								$tarif = (((round($WEIGHT) - $k->COUTAR_MIN_KG) * $k->COUTAR_KG_NEXT) + $k->COUTAR_KG_FIRST) + $k->COUTAR_ADMIN_FEE;
							}
						}
						
						$lists = number_format($tarif,0,',','.');
						$etd = $k->COUTAR_ETD;
						$status = "";
						
					}
				}
			}
			$callback = array('list_courier'=>$lists, 'list_status'=>$status, 'list_estimasi'=>$etd); 
		    echo json_encode($callback);
		} else {
			echo "Alamat customer belum lengkap.";
		}
	}

	public function service(){
		$PRDU_ID 		= $this->input->post('PRDU_ID', TRUE);
		$CUST_ID 		= $this->input->post('CUST_ID', TRUE);
		$COURIER_ID 	= $this->input->post('COURIER_ID', TRUE);
		$COURIER_NAME 	= $this->input->post('COURIER_NAME', TRUE);
		$WEIGHT 		= $this->input->post('WEIGHT', TRUE);
		$customer 		= $this->customer_m->get($CUST_ID)->row();
		$origin 	    = $this->city_m->getAreaCity(269)->row();
		$apinol  		= $this->coutariff_m->getTariff2($COURIER_ID, $origin->CNTR_ID, $origin->STATE_ID, $origin->CITY_ID, 0, $customer->CNTR_ID, $customer->STATE_ID, $customer->CITY_ID, $customer->SUBD_ID)->result();
		$key 			= $this->courier_m->getCourier($COURIER_ID)->row();
		$SERVICE_TYPE 	= $this->input->post('SERVICE');

    	$WEIGHT_RO = $WEIGHT*1000;
		$lists 	  = "";
		$estimasi = "";
    	if($customer->SUBD_ID!=0){
    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->SUBD_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'subdistrict');
    	} else{
    		$dataCost = $this->rajaongkir->cost($origin->RO_CITY_ID, $customer->CITY_ID, $WEIGHT_RO, strtolower($key->COURIER_NAME), 'city');
    	}
		$detailCost = json_decode($dataCost, true);
		$status = $detailCost['rajaongkir']['status']['code'];
		if ($status == 200) {
			for ($i=0; $i < count($detailCost['rajaongkir']['results']); $i++) {
				for ($j=0; $j < count($detailCost['rajaongkir']['results'][$i]['costs']); $j++) {
					$service = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['service'];
					$tarif = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'];
					$etd = $detailCost['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd']." Hari";

					if($SERVICE_TYPE == $service){
						$lists .= $tarif;
						$estimasi .= $etd;
					}
				}
			}
		}

		$callback = array('list_tarif'=>$lists, 'list_estimasi'=>$estimasi); 
		    echo json_encode($callback);
	}

	public function quotation($PRJ_ID) {
		$ORDL_TYPE 				= 1;
		$ORDL_DOC 				= 3;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
    	$this->template->load('template', 'letter/project_quotation', $data);
    }

    public function invoice($PRJ_ID) {
		$ORDL_TYPE 				= 2;
		$ORDL_DOC 				= 3;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
    	$this->template->load('template', 'letter/project_invoice', $data);
    }

    public function receipt($PRJ_ID) {
		$ORDL_TYPE 				= 3;
		$ORDL_DOC 				= 3;
		$data['check'] 			= $this->orderletter_m->check($PRJ_ID, $ORDL_TYPE, $ORDL_DOC);
		$data['pernah_dicetak'] = $this->orderletter_m->get_pernah_dicetak($PRJ_ID, $ORDL_TYPE, $ORDL_DOC)->row();
		$data['row'] 			= $this->orderletter_m->get()->row();
		$data['project'] 		= $this->project_m->get($PRJ_ID)->row();
		$data['payment'] 		= $this->project_payment_m->get($PRJ_ID)->result();
    	$this->template->load('template', 'letter/project_receipt', $data);
    }
}