<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Class : School (SchoolController)
 * School Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Pef_School extends BaseController
{
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Pef_School_model','pef_school_model');		
            $this->isLoggedIn();   
        }
        public function addSchoolForm()
        {
            if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {
            $data['districts'] = $this->pef_school_model->getAllDistricts();
            // By default, load tehsils for the first district (optional)
            $firstDistrictId = !empty($data['districts']) ? $data['districts'][0]->district_id : null;
            $data['tehsils'] = $firstDistrictId ? $this->pef_school_model->getTehsilsByDistrict($firstDistrictId) : [];
                $this->global['pageTitle'] = 'PEF : Add School';
                $this->loadViews("addSchool", $this->global, $data, NULL);
            } else {
                $this->loadThis();
            }
        }
       public function addSchool()
        {
        // Check if the user has admin privileges
        if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {
            $this->load->library('form_validation');
            
            // Set form validation rules
            $this->form_validation->set_rules('s_program', 'School Program', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('s_phase', 'Phase', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('s_school_code', 'School Code', 'trim|required|numeric');
            $this->form_validation->set_rules('s_name', 'School Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('s_address', 'School Address', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('s_district_id', 'District ID', 'trim|required|numeric');
            $this->form_validation->set_rules('s_tehsil_id', 'Tehsil ID', 'trim|required|numeric');
            $this->form_validation->set_rules('s_level', 'School Level', 'trim|required|max_length[25]');
            $this->form_validation->set_rules('s_status', 'Status', 'trim|required|numeric');
            $this->form_validation->set_rules('s_owner_name', 'Owner Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('s_owner_cell', 'Owner Cell', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('s_email', 'Email', 'trim|valid_email|max_length[255]');
            $this->form_validation->set_rules('username', 'Username', 'trim|max_length[255]');
            $this->form_validation->set_rules('password', 'Password', 'trim|max_length[255]');
            $this->form_validation->set_rules('s_department', 'Department', 'trim|max_length[100]');
            $this->form_validation->set_rules('s_type', 'Type', 'trim|max_length[100]');
            $this->form_validation->set_rules('s_gender', 'Gender', 'trim|max_length[100]');
            $this->form_validation->set_rules('s_lat', 'Latitude', 'trim|required|decimal');
            $this->form_validation->set_rules('s_long', 'Longitude', 'trim|required|decimal');
            if ($this->form_validation->run() === FALSE) {
                    $data['districts'] = $this->pef_school_model->getAllDistricts();
                // By default, load tehsils for the first district (optional)
                $firstDistrictId = !empty($data['districts']) ? $data['districts'][0]->district_id : null;
                $data['tehsils'] = $firstDistrictId ? $this->pef_school_model->getTehsilsByDistrict($firstDistrictId) : [];
                $this->global['pageTitle'] = 'PEF : Add School';
                $this->loadViews("addSchool", $this->global, $data, NULL);
                } 
                else {
                // Prepare data for insertion
                $schoolData = array(
                    // General School Details
                    's_program'     => $this->input->post('s_program'),
                    's_phase'       => $this->input->post('s_phase'),
                    's_school_code' => $this->input->post('s_school_code'),
                    's_name'        => $this->input->post('s_name'),
                    's_address'     => $this->input->post('s_address'),
                    's_district_id' => $this->input->post('s_district_id'),
                    's_tehsil_id'   => $this->input->post('s_tehsil_id'),
                    's_level'       => $this->input->post('s_level'),
                    's_status'      => $this->input->post('s_status'),
                    // Owner Information
                    's_owner_name'  => $this->input->post('s_owner_name'),
                    's_owner_cell'  => $this->input->post('s_owner_cell'),
                    's_email'       => $this->input->post('s_email'),
                    // User Credentials
                    'username'      => $this->input->post('username'),
                    'password'      => $this->input->post('password'),
                    // Additional Information
                    's_department'  => $this->input->post('s_department'),
                    's_type'        => $this->input->post('s_type'),
                    's_gender'      => $this->input->post('s_gender'),
                    // Location Data
                    's_lat'         => $this->input->post('s_lat'),
                    's_long'        => $this->input->post('s_long'),
                );
                // Save data to the database
                $result = $this->pef_school_model->insertSchool($schoolData);
                // Flash message based on the result
                if ($result) {
                    $this->session->set_flashdata('success', 'School added successfully.');
                } 
                else {
                    $this->session->set_flashdata('error', 'Failed to add school.');
                }
                // Redirect to the school listing page
                redirect('Pef_School/PefschoolListing');
                    }
                } 
            else {
            // If the user does not have access, load the "no access" page
            $this->loadThis();
            }
    }
 
    /**
     * This function is used to load the user list
     */
	function PefschoolListing()
	{
		if($this->isAdmin() == FALSE)
		{
			$searchText = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;
			
			$this->load->library('pagination');
			
			$count = $this->pef_school_model->PefschoolListingCount($searchText);
			$returns = $this->paginationCompress ( "PefschoolListing/", $count, 10 );
			
			$data['schoolRecords'] = $this->pef_school_model->PefschoolListing($searchText, $returns["page"], $returns["segment"]);
			// Get the total number of records
			$total_schools = $this->pef_school_model->count_records();
			
			$data['total_records'] = $total_schools[0]->totalschools;
			
			$this->global['pageTitle'] = 'PEC : Pef Schools Listing';
			$this->loadViews("Pefschools", $this->global, $data, NULL);
		}
		else if ($this->isCEO() == FALSE)
		{
			$total_schools = $this->pef_school_model->PefschoolListingCountCEO();
			$data['total_records'] = $total_schools;  
			$searchText = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;
			
			$this->load->library('pagination');
			
			$count = $this->pef_school_model->PefschoolListingCountCEO($searchText);
			$returns = $this->paginationCompress ( "PefschoolListing/", $count, 10 );
			
			$data['schoolRecords'] = $this->pef_school_model->PefschoolListingCEO($searchText, $returns["page"], $returns["segment"]);
			$this->global['pageTitle'] = 'PEF : Schools Listing';
			
			$this->loadViews("Pefschools", $this->global, $data, NULL);
        }
        else
        {        
			 $this->loadThis();
			
        }
    }
        public function deletePefSchool($schoolId)
        {
            // Check if the user has admin privileges
            if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {
                // Attempt to delete the school
                $result = $this->pef_school_model->deleteSchoolById($schoolId);
                
                // Set flash message based on the result
                if ($result) {
                    $this->session->set_flashdata('success', 'School deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete the school. Please try again.');
                }
                
                // Redirect to the school listing page
                redirect('Pef_School/PefschoolListing');
            } else {
                // If the user does not have access, load the "no access" page
                $this->loadThis();
            }
        }
  
     /**
     * This function is used to check whether email already exist or not
     */
    function checkTeacherExists()
    {
        $cnicTA = $this->input->post("CNIC");
        if(empty($nameTA)){
            $result = $this->pef_school_model->checkTeacherExists($cnicTA);
        } 
        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editPefSchool__($schoolId = NULL)
    {
        if($this->isAdmin() == FALSE )
         {
            if($schoolId == null)
            {
                redirect('PefschoolListing');
            }
            $data['schoolInfo'] = $this->pef_school_model->getPefSchoolInfo($schoolId);
            $this->global['pageTitle'] = 'PEF : Edit School';
            $this->loadViews("editPefSchoolInfo", $this->global, $data, NULL);
        }
		else if ($this->isCEO() == FALSE)
		{
            if($schoolId == null)
            {
                redirect('PefschoolListing');
            }
            $data['schoolInfo'] = $this->pef_school_model->getPefSchoolInfoCEO($schoolId);
            $this->global['pageTitle'] = 'PEF : Edit School ';
            $this->loadViews("editPefSchoolInfo", $this->global, $data, NULL);
        }
        else
        {
            $this->loadThis();
        }
    }
    public function editPefSchool($schoolId = NULL)
    {
        if ($this->isAdmin() == FALSE ||$this->isCEO() == FALSE) {
            if ($schoolId == null) {
                redirect('PefschoolListing');
            }
            // Get school info along with district and tehsil names
            $data['schoolInfo'] = $this->pef_school_model->getPefSchoolInfo($schoolId);
            
            // Pass district and tehsil data to view
            $data['districts'] = $this->pef_school_model->getAllDistricts();
            $data['tehsils'] = $this->pef_school_model->getTehsilsByDistrict($data['schoolInfo']->s_district_id);
            $this->global['pageTitle'] = 'PEF : Edit School';
            $this->loadViews("editPefSchoolInfo", $this->global, $data, NULL);
        } else {
            $this->loadThis();
        }
    }
        public function getTehsilsByDistrict($districtId)
        {
            $tehsils = $this->pef_school_model->getTehsilsByDistrict($districtId);
            echo json_encode($tehsils);
        }
    
    /**
     * This function is used to edit the user information
     */
    
    function updateSchool()
        {
            // Check if the user has admin or CEO privileges
            if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {
                $this->load->library('form_validation');
                
                // Get school ID
                $schoolId = $this->input->post('s_id');
                
                // Set form validation rules
                $this->form_validation->set_rules('s_program', 'School Program', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('s_phase', 'Phase', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('s_school_code', 'School Code', 'trim|required');
                $this->form_validation->set_rules('s_name', 'School Name', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('s_address', 'School Address', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('s_district_id', 'District ID', 'trim|required|numeric');
                $this->form_validation->set_rules('s_tehsil_id', 'Tehsil ID', 'trim|required|numeric');
                $this->form_validation->set_rules('s_level', 'School Level', 'trim|required|max_length[25]');
                $this->form_validation->set_rules('s_status', 'Status', 'trim|required|numeric');
                $this->form_validation->set_rules('s_owner_name', 'Owner Name', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('s_owner_cell', 'Owner Cell', 'trim|required|max_length[20]');
                $this->form_validation->set_rules('s_email', 'Email', 'trim|valid_email|max_length[255]');
                $this->form_validation->set_rules('username', 'Username', 'trim|max_length[255]');
                $this->form_validation->set_rules('password', 'Password', 'trim|max_length[255]');
                $this->form_validation->set_rules('s_department', 'Department', 'trim|max_length[100]');
                $this->form_validation->set_rules('s_type', 'Type', 'trim|max_length[100]');
                $this->form_validation->set_rules('s_gender', 'Gender', 'trim|max_length[100]');
                $this->form_validation->set_rules('s_lat', 'Latitude', 'trim|decimal');
                $this->form_validation->set_rules('s_long', 'Longitude', 'trim|decimal');
                
                // If validation fails, reload the edit view
                if ($this->form_validation->run() === FALSE) {
                    // $this->editSchool($schoolId);
                    echo validation_errors();
                } else {
                    // Prepare data for updating
                    $schoolInfo = array(
                        // General School Details
                    's_program'     => $this->input->post('s_program'),
                    's_phase'       => $this->input->post('s_phase'),
                    's_school_code' => $this->input->post('s_school_code'),
                    's_name'        => $this->input->post('s_name'),
                    's_address'     => $this->input->post('s_address'),
                    's_district_id' => $this->input->post('s_district_id'),
                    's_tehsil_id'   => $this->input->post('s_tehsil_id'),
                    's_level'       => $this->input->post('s_level'),
                    's_status'      => $this->input->post('s_status'),
                    // Owner Information
                    's_owner_name'  => $this->input->post('s_owner_name'),
                    's_owner_cell'  => $this->input->post('s_owner_cell'),
                    's_email'       => $this->input->post('s_email'),
                    // User Credentials
                    'username'      => $this->input->post('username'),
                    'password'      => $this->input->post('password'),
                    // Additional Information
                    's_department'  => $this->input->post('s_department'),
                    's_type'        => $this->input->post('s_type'),
                    's_gender'      => $this->input->post('s_gender'),
                    // Location Data
                    's_lat'         => $this->input->post('s_lat'),
                    's_long'        => $this->input->post('s_long'),
                        // 'school_updatedby' => $this->vendorId,
                    );
                    
                    // Update school information in the database
                    $result = $this->pef_school_model->updateSchool($schoolInfo, $schoolId);
                    
                    // Set flash messages based on the update result
                    if ($result) {
                        $this->session->set_flashdata('success', 'School updated successfully');
                    } else {
                        $this->session->set_flashdata('error', 'School update failed');
                    }
                    
                    // Redirect to the school listing page
                    redirect('Pef_School/PefschoolListing');
                }
            } else {
                // If the user does not have access, load the "no access" page
                $this->loadThis();
            }
        }
        
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'PEF : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    } 
	
	public function export_pef_school_csv(){ 
		$filename = 'schools_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		
		if($this->session->userdata('userId')==1){
			$school_data= $this->pef_school_model->get_pef_schools_csv_export();
		}		
		else{
			$District_Training_Centr = $this->session->userdata('district');	
			$school_data= $this->pef_school_model->get_pef_ae_schools_csv_export($District_Training_Centr);
		}
		
		//$school_data= $this->school_model->get_schools_csv_export();
		
		$file = fopen('php://output', 'w');
		$header = array("s_id", "s_program","s_school_code","s_phase","s_name","s_address","s_district_id","s_tehsil_id","s_owner_name","s_owner_cell","s_level","s_lat","s_long","s_status"); 
                                                                                                                                                                                                
		fputcsv($file, $header);
		foreach ($school_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
   
}
?>