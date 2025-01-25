<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Center (CenterController)
 * Center Class to control all center related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Center extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Center_model','center_model');
        $this->load->model('Sed_School_model','sed_school_model');
        $this->load->model('Pef_School_model','pef_school_model');
		  $this->isLoggedIn();   
    }
    public function editCenter($centerId)
    { 
        if ($this->isAdmin() == FALSE || $this->isCEO() == FALSE) {
            if ($centerId == null) {
                 $this->loadThis();
                 return;
                // redirect('center/centerListing');
            }

            $data['centerInfo'] = $this->center_model->getCenterInfoById($centerId);
            if (empty($data['centerInfo'])) {
                show_error('Center not found', 404);
            } 
            $data['districts'] = $this->sed_school_model->getAllDistricts();
            $districtId = $data['centerInfo']->cdistrict_id;
            $teshilId = $data['centerInfo']->cteshil_id;
            $schoolId = $data['centerInfo']->csedschool_id;
            $data['tehsils'] = $this->sed_school_model->getTehsilsByDistrict($districtId);
				
            $data['schools'] = $this->sed_school_model->getSchoolsByTehsilEdit($teshilId,$data['centerInfo']->csedschool_id);
            $data['schoolInfo'] = $this->sed_school_model->getSchoolsById($schoolId);

            $selectedPefSchoolsIds = $this->center_model->getCenterPefSchoolIdsInfoById($centerId);
				//print_r($selectedPefSchoolsIds); die;
				$data['pefschools'] = $this->pef_school_model->getPefSchoolsByTehsilEdit($teshilId,$selectedPefSchoolsIds['dpefschool_ids']);
				
            $centerInfoSchoolDetails = $this->center_model->getCenterDetailInfoById($centerId);
            // print_r($centerInfoSchoolDetails);die;
            $data['centerInfoSchoolDetails'] = $centerInfoSchoolDetails;
            
            $this->global['pageTitle'] = 'Edit Center';
            $this->loadViews("editCenterInfo", $this->global, $data, NULL);
        } else {
            $this->loadThis();
        }
    }

    public function deleteCenter($cid)
    {
		 $this->db->delete('tbl_staff', array('staff_cid' => $cid));
		 $this->db->delete('tbl_examcenter_details', array('dcenter_id' => $cid));
		 $this->db->delete('tbl_examcenter', array('cid' => $cid));
		 $this->session->set_flashdata('success', 'Exam center deleted successfully.');
		 redirect('center/centerListing'); 	 
	 }
        public function get_total_selected(){
             $data = $this->pef_school_model->get_total_selected( $this->input->post('school_id'));
                echo json_encode($data);
        }  
    
   public function updateCenter($centerId)
	{
		 $this->load->library('form_validation');
		 $this->form_validation->set_rules('school_district_id', 'District', 'required');
		 $this->form_validation->set_rules('school_tehsil_id', 'Tehsil', 'required');
		 $this->form_validation->set_rules('school_id', 'School', 'required');
		 $this->form_validation->set_rules('total_students', 'Total Students', 'required');
	
		 if ($this->form_validation->run() == FALSE) 
			  {
				  $data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('error', $data['errors']);
					redirect('Center/editCenter/'.$centerId);
			  } else {
			  $district_id = $this->input->post('school_district_id');
			  $tehsil_id = $this->input->post('school_tehsil_id');
			  $school_id = $this->input->post('school_id');
			  $total_students = $this->input->post('total_students');
			  $pefschools = $this->input->post('pefschools');
	
			  // Collect student counts for PEF schools
			  $students = [];
			  if (!empty($pefschools)) {
					foreach ($pefschools as $key => $school) {
						 $students[$key] = $this->input->post("students_$key");
					}
			  }
	
			  // Count total PEF schools
				$total_pefschools = !empty($pefschools) ? count(array_filter($pefschools)) : 0;
			  // Prepare exam center data
			  $examCenterData = [
					'cdistrict_id' => $district_id,
					'cteshil_id' => $tehsil_id,
					'csedschool_id' => $school_id,
					'cpef_students_selected' => $total_students,
					'cpefschools_total' => $total_pefschools,
					'cupdated' => date('Y-m-d H:i:s'),
					'cupdatedby' => $this->session->userdata('userId'),
			  ];
			  // Update exam center
			  $this->db->where('cid', $centerId);
			  if (!$this->db->update('tbl_examcenter', $examCenterData)) {
					$this->session->set_flashdata('error', 'Failed to update exam center.');
					redirect('center/centerListing');
			  }
	
			  // Update exam center details
			  $this->db->where('dcenter_id', $centerId);
			  if (!$this->db->delete('tbl_examcenter_details')) {
					$this->session->set_flashdata('error', 'Failed to update exam center details.');
					redirect('center/centerListing');
			  }
	
			  $examCenterDetailsData = [];
			  foreach ($pefschools as $key => $school_id) {
					if (!empty($school_id)) {
						 $examCenterDetailsData[] = [
							  'dcenter_id' => $centerId,
							  'dpefschool_id' => $school_id,
							  // 'total_selected' => isset($students[$key]) ? $students[$key] : 0,
						 ];
					}
			  }
	
			  if (!empty($examCenterDetailsData) && !$this->db->insert_batch('tbl_examcenter_details', $examCenterDetailsData)) {
					$this->session->set_flashdata('error', 'Failed to insert exam center details.');
					redirect('center/centerListing');
			  }
			  $this->db->delete('tbl_staff', array('staff_cid' => $centerId));
			  $this->session->set_flashdata('success', 'Exam center updated successfully.');
			  redirect('center/centerListing');
		 }
	}


    public function addNewCenter(){

            // $data=$this->input->post();

            // echo'<pre>';
            // print_r($data);
            // die('here');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('school_district_id', 'District', 'required');
        $this->form_validation->set_rules('school_tehsil_id', 'Tehsil', 'required');
        $this->form_validation->set_rules('school_id', 'School', 'required');
        $this->form_validation->set_rules('username', 'School Code');
        $this->form_validation->set_rules('total_students', 'total_students','required',);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('centers');
        } else {
            $district_id = $this->input->post('school_district_id');
            $tehsil_id = $this->input->post('school_tehsil_id');
            $school_id = $this->input->post('school_id');
            $school_code = $this->input->post('username');
            $total_students = $this->input->post('total_students');
            $pefschools = $this->input->post('pefschools'); 

            // Count total PEF schools
        $total_pefschools = !empty($pefschools) ? count(array_filter($pefschools)) : 0;

            $examCenterData = [
                'cdistrict_id' => $district_id,
                'cteshil_id' => $tehsil_id,
                'csedschool_id' => $school_id,
                'ccode' =>$school_code,
                'cpef_students_selected' =>$total_students,
                'cpefschools_total' => $total_pefschools,
                'cstatus' => 1,
                'ccreated' => date('Y-m-d H:i:s'),
                'ccreatedby' => $this->session->userdata('userId'),
            ];

            // echo'<pre>';
            // print_r($examCenterData);
            // die('here');
            
            $this->db->insert('tbl_examcenter', $examCenterData);
            $center_id = $this->db->insert_id();

            if (!empty($center_id) && !empty($pefschools)) {
                foreach ($pefschools as $pefschool_id) {
                    if (!empty($pefschool_id)) { 
                        $examCenterDetailsData[] = [
                            'dcenter_id' => $center_id,
                            'dpefschool_id' => $pefschool_id,
                        ];
                    }
                }
                // Batch insert into tbl_examcenter_details
                if (!empty($examCenterDetailsData)) {
                    $this->db->insert_batch('tbl_examcenter_details', $examCenterDetailsData);
                }
            }
            // Redirect with success message
            $this->session->set_flashdata('success', 'Exam center created successfully.');
            redirect('center/centerListing');
        }
    }

    
    /**
     * This function used to load the first screen of the Center
     */
    public function index()
    {
        $this->global['pageTitle'] = 'PEC : Dashboard';
			$this->load->model('school_model');
			$data=[];
			//updateNulls
			$this->school_model->updateNulls();	
		
			if($this->isAdmin() == FALSE)
			{
				$schoolStats = $this->school_model->getStatisticsSchools();	
				$data['districtStats'] = $this->school_model->getStatisticsDistricts();
			}
			else
			{
				$schoolStats = $this->school_model->getStatisticsSchoolsCEO();	
			}
			$data['stats'] = $schoolStats;		
         $this->loadViews("dashboard", $this->global, $data, NULL);
    }
    
	
	 public function getPefSchoolsByTehsil()
	 {
		 $tehsilId = $this->input->get('tehsil_id'); 
		 if ($tehsilId) {
			  $this->load->model('pef_school_model'); 
			  $schools = $this->pef_school_model->getPefSchoolsByTehsil($tehsilId); 
			 
			  echo json_encode($schools);
		 } else {
			  echo json_encode([]);
		 }
	}
	
	public function getPefSchoolsByTehsilEdit()
	 {
		 $tehsilId = $this->input->get('tehsil_id');
		 $centerId = $this->input->get('centerId');
		 $selectedPefSchoolsIds = $this->center_model->getCenterPefSchoolIdsInfoById($centerId); 
		 if ($tehsilId) {
			  $this->load->model('pef_school_model'); 
			  $schools = $this->pef_school_model->getPefSchoolsByTehsilEdit($tehsilId,$selectedPefSchoolsIds['dpefschool_ids']); 
			 
			  echo json_encode($schools);
		 } else {
			  echo json_encode([]);
		 }
	}
	
    /**
     * This function is used to load the Center list
     */
	function centerListing()
	{
		if($this->isAdmin() === TRUE || $this->isCEO() === TRUE)        
		{  
			$searchText = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;            
			$this->load->library('pagination');            
			$count = $this->center_model->centerListingCount($searchText);            
			$returns = $this->paginationCompress ( "centerListing/", $count, 10 ); 
			//print '<pre>'; print_r($returns); die;
			$data['centerRecords'] = $this->center_model->centerListing($searchText, $returns["page"], $returns["segment"]);
			$this->global['pageTitle'] = 'PEC : Center Listing';            
			$this->loadViews("centers", $this->global, $data, NULL);
		}
		else
		{
			$this->loadThis();
		}
	  
	}
  
    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() === TRUE || $this->isCEO() === TRUE)
        {
            $this->load->model('center_model');
            $data['roles'] = $this->center_model->getCenterRoles();
			
			 $data['districts'] = $this->center_model->getCenterDistricts();
            
            $this->global['pageTitle'] = 'PEC : Add New Center';
            $this->loadViews("addExamCenter", $this->global, $data, NULL);
        }
		else {
            $this->loadThis();
        }
    }
    
    
    /**
     * This function is used load center edit information
     * @param number $centerId : Optional : This is center id
     */
    function editOld($centerId = NULL)
    {
        if($this->isAdmin() == TRUE || $centerId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($centerId == null)
            {
                redirect('centerListing');
            }
            
            $data['roles'] = $this->center_model->getCenterRoles();
            $data['centerInfo'] = $this->center_model->getCenterInfo($centerId);
			$data['districts'] = $this->center_model->getCenterDistricts();
            
            $this->global['pageTitle'] = 'PEC : Edit Center';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the center information
     */
   
   
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'PEC : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
   
   
}
?>