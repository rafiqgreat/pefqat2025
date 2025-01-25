<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Center (CenterController)
 * Center Class to control all center related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Staff extends BaseController
{
    public function __construct()
    {
		parent::__construct();
		$this->load->model('Staff_model');
		$this->load->model('Pef_School_model');
		$this->load->model('Sed_School_model');
		$this->isLoggedIn();   
    }
    public function check_teacher_assignment()
	{
		$personal_no = $this->input->post('personal_no');
		$this->db->where('staff_personalno', $personal_no);
		$query = $this->db->get('tbl_staff');
		$is_assigned = $query->num_rows();

		if ($is_assigned > 0) {
			echo json_encode(['assigned' => true, 'message' => 'Personal number is already assigned.']);
			return;
		}

		echo json_encode(['assigned' => false, 'message' => 'Personal number is available.']);
	}

	/*public function staff_add($cid)
	{
		 if ($this->input->post('submit')) {
			  $this->load->library('form_validation');
			  $this->form_validation->set_rules('staff_personalno', 'Personal Number', 'required');
			  $this->form_validation->set_rules('staff_cnic', 'CNIC', 'required');
			  $this->form_validation->set_rules('staff_name', 'Name', 'required');
	
			  if ($this->form_validation->run() == FALSE) {
					$data = array(
						 'errors' => validation_errors()
					);
					$this->session->set_flashdata('error', $data['errors']);
					redirect('staff/staff_add/' . $cid);
			  } else {
					// Start a transaction
					$this->db->trans_start();
	
					// Check for existing assignment for RI
					$existingRi = $this->db->get_where('tbl_staff', [
						 'staff_cnic' => $this->input->post('staff_cnic'),
						 'staff_cid' => $cid
					])->row();
	
					if ($existingRi) {
						 $this->session->set_flashdata('error', 'This teacher is already assigned a duty at this center.');
						 redirect('staff/staff_add/' . $cid);
					}
	
					// RI data
					$riData = array(
						 'staff_cid' => $cid,
						 'staff_role' => $this->input->post('staff_role'),
						 'staff_personalno' => $this->input->post('staff_personalno'),
						 'staff_cnic' => $this->input->post('staff_cnic'),
						 'staff_name' => $this->input->post('staff_name'),
						 'staff_fathername' => $this->input->post('staff_fathername'),
						 'staff_gender' => $this->input->post('staff_gender'),
						 'staff_dob' => $this->input->post('staff_dob'),
						 'staff_email' => $this->input->post('staff_email'),
						 'staff_mobile' => $this->input->post('staff_mobile')
					);
					$this->db->insert('tbl_staff', $riData);
	
					// Check for existing assignment for Supervisor
					$existingSup = $this->db->get_where('tbl_staff', [
						 'staff_cnic' => $this->input->post('sup_staff_cnic'),
						 'staff_cid' => $cid
					])->row();
	
					if ($existingSup) {
						 $this->session->set_flashdata('error', 'This supervisor is already assigned a duty at this center.');
						 redirect('staff/staff_add/' . $cid);
					}
	
					// Supervisor data
					$supData = array(
						 'staff_cid' => $cid,
						 'staff_role' => $this->input->post('sup_staff_role'),
						 'staff_personalno' => $this->input->post('sup_staff_personalno'),
						 'staff_cnic' => $this->input->post('sup_staff_cnic'),
						 'staff_name' => $this->input->post('sup_staff_name'),
						 'staff_fathername' => $this->input->post('sup_staff_fathername'),
						 'staff_gender' => $this->input->post('sup_staff_gender'),
						 'staff_dob' => $this->input->post('sup_staff_dob'),
						 'staff_email' => $this->input->post('sup_staff_email'),
						 'staff_mobile' => $this->input->post('sup_staff_mobile')
					);
					$this->db->insert('tbl_staff', $supData);
	
					// Check for existing assignment for Invigilators
					$numberOfInvigilator = $this->input->post('numberOfInvigilator');
					if ($numberOfInvigilator != 0 && $numberOfInvigilator != '') {
						 for ($i = 1; $i <= $numberOfInvigilator; $i++) {
							  $invCnic = $this->input->post('inv' . $i . '_staff_cnic');
							  $existingInv = $this->db->get_where('tbl_staff', [
									'staff_cnic' => $invCnic,
									'staff_cid' => $cid
							  ])->row();
	
							  if ($existingInv) {
									$this->session->set_flashdata('error', "The invigilator with CNIC {$invCnic} is already assigned a duty at this center.");
									redirect('staff/staff_add/' . $cid);
							  }
	
							  $invData = array(
									'staff_cid' => $cid,
									'staff_role' => $this->input->post('inv' . $i . '_staff_role'),
									'staff_personalno' => $this->input->post('inv' . $i . '_staff_personalno'),
									'staff_cnic' => $invCnic,
									'staff_name' => $this->input->post('inv' . $i . '_staff_name'),
									'staff_fathername' => $this->input->post('inv' . $i . '_staff_fathername'),
									'staff_gender' => $this->input->post('inv' . $i . '_staff_gender'),
									'staff_dob' => $this->input->post('inv' . $i . '_staff_dob'),
									'staff_email' => $this->input->post('inv' . $i . '_staff_email'),
									'staff_mobile' => $this->input->post('inv' . $i . '_staff_mobile')
							  );
							  $this->db->insert('tbl_staff', $invData);
						 }
					}
	
					// Commit the transaction
					$this->db->trans_complete();
	
					if ($this->db->trans_status() === FALSE) {
						 $this->session->set_flashdata('error', 'Failed to add exam center staff. Please try again.');
						 redirect('staff/staff_add/' . $cid);
					} else {
						 $this->session->set_flashdata('success', 'Exam center staff added successfully.');
						 redirect('center/centerListing');
					}
			  }
		 } else {
			  $data['centerInfo'] = $this->Staff_model->getCenterInfoById($cid);
			  $this->global['pageTitle'] = 'EXAM CENTER : Add Staff';
			  $this->loadViews("staff/staff_add", $this->global, $data, NULL);
		 }
	}*/

    public function staff_add($cid)
	 {
		if($this->input->post('submit'))
		{
        $this->load->library('form_validation');
        $this->form_validation->set_rules('staff_personalno[]', 'Personal Number', 'required');
        $this->form_validation->set_rules('staff_cnic[]', 'CNIC', 'required');
        $this->form_validation->set_rules('staff_name[]', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) 
		  {
			  $data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('error', $data['errors']);
            redirect('staff/staff_add/'.$cid);
        } 
		  else 
		  {
			  $this->db->trans_start();
			  $staff_personalno = $this->input->post('staff_personalno');
			  $transok = true;
			  $flag = false;
			  $stafflist = array();
        	  $staffindex = 0;
			  foreach ($staff_personalno as $key => $value) 
			  {
				 $staff_personalno = $this->input->post('staff_personalno');
				 $staff_role = $this->input->post('staff_role');
				 $staff_cnic = $this->input->post('staff_cnic');
				 $staff_name = $this->input->post('staff_name');
				 $staff_fathername = $this->input->post('staff_fathername');
				 $staff_gender = $this->input->post('staff_gender');
				 $staff_dob = $this->input->post('staff_dob');
				 $staff_email = $this->input->post('staff_email');
				 $staff_mobile = $this->input->post('staff_mobile');

				 $data = array(
				 	  'staff_cid' => $cid,
					  'staff_personalno' => $staff_personalno[$key],
					  'staff_role' => $staff_role[$key],
					  'staff_cnic' => $staff_cnic[$key],
					  'staff_name' => $staff_name[$key],
					  'staff_fathername' => $staff_fathername[$key],
					  'staff_gender' => $staff_gender[$key],
					  'staff_dob' => $staff_dob[$key],
					  'staff_email' => $staff_email[$key],
					  'staff_mobile' => $staff_mobile[$key]
				 );
				 $flag = true;
				 $stafflist[$staffindex] = $data;
				 $staffindex++;
            }
				
				if ($flag) 
				{
					$this->db->insert_batch('tbl_staff', $stafflist);
	
			  } 
			  else 
			  {
					$this->session->set_flashdata('error', 'Exam center staff was not added.');
					$transok = false;
			  }	
			  if ($transok) 
			  {
					$this->db->trans_complete();
					$this->session->set_flashdata('success', 'Exam center staff added successfully.');
            	redirect('center/centerListing');
			  } 
			  else 
			  {
					$this->db->trans_rollback();
					$this->session->set_flashdata('error', 'Exam center staff was not added.');
					redirect('center/centerListing');
			  }            
        }
		}
		else
		{
			$data['centerInfo'] = $this->Staff_model->getCenterInfoById($cid);
			$this->global['pageTitle'] = 'EXAM CENTER : Add Staff';
			$this->loadViews("staff/staff_add", $this->global, $data, NULL);
		}
    }
	 
	 public function staff_edit($cid)
    {
		if($this->input->post('submit'))
		{
        $this->load->library('form_validation');
        $this->form_validation->set_rules('staff_personalno[]', 'Personal Number', 'required');
        $this->form_validation->set_rules('staff_cnic[]', 'CNIC', 'required');
        $this->form_validation->set_rules('staff_name[]', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) 
		  {
			  $data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('error', $data['errors']);
            redirect('staff/staff_edit/'.$cid);
        } 
		  else 
		  {
			  $this->db->trans_start();
			  $this->db->delete('tbl_staff', array('staff_cid' => $cid));
			  $staff_personalno = $this->input->post('staff_personalno');
			  $transok = true;
			  $flag = false;
			  $stafflist = array();
        	  $staffindex = 0;
			  foreach ($staff_personalno as $key => $value) 
			  {
				 $staff_personalno = $this->input->post('staff_personalno');
				 $staff_role = $this->input->post('staff_role');
				 $staff_cnic = $this->input->post('staff_cnic');
				 $staff_name = $this->input->post('staff_name');
				 $staff_fathername = $this->input->post('staff_fathername');
				 $staff_gender = $this->input->post('staff_gender');
				 $staff_dob = $this->input->post('staff_dob');
				 $staff_email = $this->input->post('staff_email');
				 $staff_mobile = $this->input->post('staff_mobile');

				 $data = array(
				 	  'staff_cid' => $cid,
					  'staff_personalno' => $staff_personalno[$key],
					  'staff_role' => $staff_role[$key],
					  'staff_cnic' => $staff_cnic[$key],
					  'staff_name' => $staff_name[$key],
					  'staff_fathername' => $staff_fathername[$key],
					  'staff_gender' => $staff_gender[$key],
					  'staff_dob' => $staff_dob[$key],
					  'staff_email' => $staff_email[$key],
					  'staff_mobile' => $staff_mobile[$key]
				 );
				 $flag = true;
				 $stafflist[$staffindex] = $data;
				 $staffindex++;
            }
				
				if ($flag) 
				{
					$this->db->insert_batch('tbl_staff', $stafflist);
	
			  } 
			  else 
			  {
					$this->session->set_flashdata('error', 'Exam center staff did not update.');
					$transok = false;
			  }	
			  if ($transok) 
			  {
					$this->db->trans_complete();
					$this->session->set_flashdata('success', 'Exam center staff updated successfully.');
            	redirect('center/centerListing');
			  } 
			  else 
			  {
					$this->db->trans_rollback();
					$this->session->set_flashdata('error', 'Exam center staff did not update.');
					redirect('center/centerListing');
			  }            
        }
		}
		else
		{
			$data['centerInfo'] = $this->Staff_model->getCenterInfoById($cid);
			$data['staffDetails'] = $this->Staff_model->getStaffInfoById($cid);
			$this->global['pageTitle'] = 'EXAM CENTER : Edit Staff';
			$this->loadViews("staff/staff_edit", $this->global, $data, NULL);
		}
    }
	 
	 public function staff_view($cid)
    {		
		$data['centerInfo'] = $this->Staff_model->getCenterInfoById($cid);
		$data['staffDetails'] = $this->Staff_model->getStaffInfoById($cid);
		$this->global['pageTitle'] = 'EXAM CENTER : View Staff';
		$this->loadViews("staff/staff_view", $this->global, $data, NULL);
    }
	 
	 public function staff_delete($cid)
    {
		 $this->db->delete('tbl_staff', array('staff_cid' => $cid));
		 $this->session->set_flashdata('success', 'Exam center staff deleted successfully.');
		 redirect('center/centerListing'); 
	 }
	 public function check_duplicate_personalno() 
	 {
		 // Get the personal number from POST data
		 $personalno = $this->input->post('personalno');
	
		 // Load the model to query the database
		 $this->load->model('Staff_model'); 
	
		 // Call the model method to check if personal number exists
		 $is_duplicate = $this->Staff_model->check_personalno_exists($personalno);
	
		 // Prepare the response
		 if ($is_duplicate) {
			  // If the personal number already exists
			  echo json_encode(array('status' => 'duplicate'));
		 } else {
			  // If it's unique
			  echo json_encode(array('status' => 'unique'));
		 }
	}
	
	 public function check_duplicate_personalno_on_edit() 
	 {
		 // Get the personal number from POST data
		 $personalno = $this->input->post('personalno');
		 $staff_cid = $this->input->post('staff_cid');
	
		 // Load the model to query the database
		 $this->load->model('Staff_model'); 
	
		 // Call the model method to check if personal number exists
		 $is_duplicate = $this->Staff_model->check_personalno_exists_on_edit($personalno,$staff_cid);
	
		 // Prepare the response
		 if ($is_duplicate) {
			  // If the personal number already exists
			  echo json_encode(array('status' => 'duplicate'));
		 } else {
			  // If it's unique
			  echo json_encode(array('status' => 'unique'));
		 }
	}   
}
?>