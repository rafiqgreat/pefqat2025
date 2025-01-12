<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Class : School (SchoolController)
 * School Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Sed_School extends BaseController
{
    /**
     * This is default constructor of the class
     */
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Sed_School_model','sed_school_model');
            $this->load->model('Pef_School_model','pef_school_model');
            $this->isLoggedIn();   
        }
        // public function ImportSchool(){
        //      if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {

        //             $this->global['pageTitle'] = 'Import School';
        //             $this->loadViews("ImportSchool", $this->global, $data, NULL);
        //         } else {
        //             $this->loadThis();
        //         }
            
        // }
        public function ExamCenterManagement(){
            if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {
                $data['districts'] = $this->sed_school_model->getAllDistricts();

                // By default, load tehsils for the first district (optional)
                $firstDistrictId = !empty($data['districts']) ? $data['districts'][0]->district_id : null;
                $data['tehsils'] = $firstDistrictId ? $this->sed_school_model->getTehsilsByDistrict($firstDistrictId) : [];
                    $this->global['pageTitle'] = 'Add Exam Center';
                    $this->loadViews("addExamCenter", $this->global, $data, NULL);
                } else {
                    $this->loadThis();
                }
            }
        public function getSchoolsByTehsil()
            {
                $tehsilId = $this->input->get('tehsil_id'); 
                if ($tehsilId) {
                    $this->load->model('sed_school_model'); 
                    $schools = $this->sed_school_model->getSchoolsByTehsil($tehsilId); 

                    // echo '<pre>';
                    // print_r($schools);
                    // die('lllllllllllll');
                    echo json_encode($schools);
                } else {
                    echo json_encode([]);
                }
            }
        public function getSchoolsById()
            {
                $schoolId = $this->input->get('school_id'); 
                if ($schoolId) {
                    $this->load->model('sed_school_model'); 
                    $schools = $this->sed_school_model->getSchoolsById($schoolId); 

                    // echo '<pre>';
                    // print_r($schools);
                    // die('lllllllllllll');
                    echo json_encode($schools);
                } else {
                    echo json_encode([]);
                }
            }    
             
     
    /**
     * This function is used to load the user list
     */
	    function SedschoolListing()
    {
         if($this->isAdmin() == FALSE)
        {
			$searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->sed_school_model->SedschoolListingCount($searchText);
			$returns = $this->paginationCompress ( "SedschoolListing/", $count, 10 );
            
            $data['schoolRecords'] = $this->sed_school_model->SedschoolListing($searchText, $returns["page"], $returns["segment"]);
				// Get the total number of records
    		 $total_schools = $this->sed_school_model->count_records();
			
			 $data['total_records'] = $total_schools[0]->totalschools;
			
            $this->global['pageTitle'] = 'PEC : SED Schools Listing';
            $this->loadViews("Sedschools", $this->global, $data, NULL);
		}
		else if ($this->isCEO() == FALSE)
		{
        
			$total_schools = $this->sed_school_model->SedschoolListingCountCEO();
			$data['total_records'] = $total_schools;  
			$searchText = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->sed_school_model->SedschoolListingCountCEO($searchText);
			$returns = $this->paginationCompress ( "SedschoolListing/", $count, 10 );
            
            $data['schoolRecords'] = $this->sed_school_model->SedschoolListingCEO($searchText, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'SED : Schools Listing';
            
            $this->loadViews("Sedschools", $this->global, $data, NULL);
        }
        else
        {        
			 $this->loadThis();
			
        }
    }
         public function addSchoolForm()
            {

                if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {
                $data['loggedInUserId'] = $this->session->userdata('userId');
                $data['districts'] = $this->sed_school_model->getAllDistricts();

                // By default, load tehsils for the first district (optional)
                $firstDistrictId = !empty($data['districts']) ? $data['districts'][0]->district_id : null;
                $data['tehsils'] = $firstDistrictId ? $this->sed_school_model->getTehsilsByDistrict($firstDistrictId) : [];
                    $this->global['pageTitle'] = 'SED : Add School';
                    $this->loadViews("addSedSchool", $this->global, $data, NULL);
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
            $this->form_validation->set_rules('emiscode', 'School EMIS Code', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('school_department', 'School Department', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('school_type', 'School Type', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('school_name', 'School Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('school_address', 'School Address', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('school_district_id', 'District ID', 'trim|required|numeric');
            $this->form_validation->set_rules('school_tehsil_id', 'Tehsil ID', 'trim|required|numeric');
            $this->form_validation->set_rules('school_markaz', 'Markaz', 'trim|max_length[255]');
            $this->form_validation->set_rules('school_level', 'School Level', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('school_gender', 'School Gender', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('school_email', 'School Email', 'trim|required|valid_email|max_length[255]');
            $this->form_validation->set_rules('school_phone', 'School Phone', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('school_contact_name', 'Contact Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('school_contact_mobile', 'Contact Mobile', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('school_lat', 'Latitude', 'trim|required|decimal');
            $this->form_validation->set_rules('school_lon', 'Longitude', 'trim|required|decimal');
            
            if ($this->form_validation->run() === FALSE) {
                    $data['districts'] = $this->sed_school_model->getAllDistricts();

                // By default, load tehsils for the first district (optional)
                $firstDistrictId = !empty($data['districts']) ? $data['districts'][0]->district_id : null;
                $data['tehsils'] = $firstDistrictId ? $this->sed_school_model->getTehsilsByDistrict($firstDistrictId) : [];
                $this->global['pageTitle'] = 'SED : Add School';
                $data['loggedInUserId'] = $this->session->userdata('userId');
                
                $this->loadViews("addSedSchool", $this->global, $data, NULL);
                } 
                else {
                // Prepare data for insertion
                $schoolData = array(
                    // General School Details
                    'username'           => $this->input->post('username'),
                    'password'           => $this->input->post('password'),
                    'school_department'  => $this->input->post('school_department'),
                    'school_type'        => $this->input->post('school_type'),
                    'school_name'        => $this->input->post('school_name'),
                    'school_address'     => $this->input->post('school_address'),
                    'school_district_id' => $this->input->post('school_district_id'),
                    'school_tehsil_id'   => $this->input->post('school_tehsil_id'),
                    'school_level'       => $this->input->post('school_level'),
                    'school_contact_name' => $this->input->post('school_contact_name'),
                    'school_contact_mobile' => $this->input->post('school_contact_mobile'),
                    'school_email'       => $this->input->post('school_email'),
                    'school_gender'       => $this->input->post('school_gender'),
                    'school_phone'       => $this->input->post('school_phone'),
                    'school_markaz'      => $this->input->post('school_markaz'),
                    'school_gender'      => $this->input->post('school_gender'),
                    'school_status'      => $this->input->post('school_status') ?? 1,
                    'school_createdby'      => $this->input->post('school_createdby') ?? $data['loggedInUserId'],
                    'school_lat'         => $this->input->post('school_lat'),
                    'school_lon'         => $this->input->post('school_lon'),
                );

                // Save data to the database
                $result = $this->sed_school_model->insertSchool($schoolData);

                // Flash message based on the result
                if ($result) {
                    $this->session->set_flashdata('success', 'School added successfully.');
                } 
                else {
                    $this->session->set_flashdata('error', 'Failed to add school.');
                }

                // Redirect to the school listing page
                redirect('Sed_School/SedschoolListing');
                    }
                } 
            else {
            // If the user does not have access, load the "no access" page
            $this->loadThis();
            }
    }
 
        public function deleteSedSchool($schoolId)
        {
            // Check if the user has admin privileges
            if ($this->isAdmin() === TRUE || $this->isCEO() === TRUE) {
                // Attempt to delete the school
                $result = $this->sed_school_model->deleteSchoolById($schoolId);
                
                // Set flash message based on the result
                if ($result) {
                    $this->session->set_flashdata('success', 'School deleted successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete the school. Please try again.');
                }
                
                // Redirect to the school listing page
                redirect('Sed_School/SedschoolListing');
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
    
    public function editSedSchool($schoolId = NULL)
    {
        if ($this->isAdmin() == FALSE ||$this->isCEO() == FALSE) {
            if ($schoolId == null) {
                redirect('Sed_School/SedschoolListing');
            }
            // Get school info along with district and tehsil names
            $data['schoolInfo'] = $this->sed_school_model->getSedSchoolInfo($schoolId);
            
            // Pass district and tehsil data to view
            $data['districts'] = $this->sed_school_model->getAllDistricts();
            $data['tehsils'] = $this->sed_school_model->getTehsilsByDistrict($data['schoolInfo']->school_district_id);

            $this->global['pageTitle'] = 'SED : Edit School';
            $this->loadViews("editSedSchoolInfo", $this->global, $data, NULL);
        } else {
            $this->loadThis();
        }
    }
        public function getTehsilsByDistrict($districtId)
        {
            $tehsils = $this->sed_school_model->getTehsilsByDistrict($districtId);
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

                $data['loggedInUserId'] = $this->session->userdata('userId');
                
                // Get school ID
                $schoolId = $this->input->post('school_id');
                // echo'<pre>';
                // print_r($this->input->post('school_id'));
                // die('1111111');
                // Set form validation rules
                $this->form_validation->set_rules('school_id', 'school id', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('school_department', 'School Department', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('school_type', 'School Type', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('school_name', 'School Name', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('school_address', 'School Address', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('school_district_id', 'District ID', 'trim|required|numeric');
                $this->form_validation->set_rules('school_tehsil_id', 'Tehsil ID', 'trim|required|numeric');
                $this->form_validation->set_rules('school_markaz', 'Markaz', 'trim|max_length[255]');
                $this->form_validation->set_rules('school_level', 'School Level', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('school_gender', 'School Gender', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('school_email', 'School Email', 'trim|required|valid_email|max_length[255]');
                $this->form_validation->set_rules('school_phone', 'School Phone', 'trim|required|max_length[20]|numeric');
                $this->form_validation->set_rules('school_contact_name', 'Contact Name', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('school_contact_mobile', 'Contact Mobile', 'trim|required|max_length[20]|numeric');
                $this->form_validation->set_rules('school_lat', 'Latitude', 'trim|required|decimal');
                $this->form_validation->set_rules('school_lon', 'Longitude', 'trim|required|decimal');
                
                // If validation fails, reload the edit view
                if ($this->form_validation->run() === FALSE) {
                    $this->editSedSchool($schoolId);
                    // echo validation_errors();
                } else {
                    // Prepare data for updating
                    $schoolInfo = array(
                    'school_id'           => $this->input->post('school_id'),
                    'username'           => $this->input->post('username'),
                    'password'           => $this->input->post('password'),
                    'school_department'  => $this->input->post('school_department'),
                    'school_type'        => $this->input->post('school_type'),
                    'school_name'        => $this->input->post('school_name'),
                    'school_address'     => $this->input->post('school_address'),
                    'school_district_id' => $this->input->post('school_district_id'),
                    'school_tehsil_id'   => $this->input->post('school_tehsil_id'),
                    'school_level'       => $this->input->post('school_level'),
                    'school_contact_name' => $this->input->post('school_contact_name'),
                    'school_contact_mobile' => $this->input->post('school_contact_mobile'),
                    'school_email'       => $this->input->post('school_email'),
                    'school_gender'       => $this->input->post('school_gender'),
                    'school_phone'       => $this->input->post('school_phone'),
                    'school_markaz'      => $this->input->post('school_markaz'),
                    'school_status'      => $this->input->post('school_status') ?? 1,
                    'school_createdby'      => $this->input->post('school_createdby') ?? $data['loggedInUserId'],
                    'school_lat'         => $this->input->post('school_lat'),
                    'school_lon'         => $this->input->post('school_lon'),
                    );
                    // Update school information in the database
                    $result = $this->sed_school_model->updateSchool($schoolInfo, $schoolId);
                    
                    // Set flash messages based on the update result
                    if ($result) {
                        $this->session->set_flashdata('success', 'School updated successfully');
                    } else {
                        $this->session->set_flashdata('error', 'School update failed');
                    }
                    
                    // Redirect to the school listing page
                    redirect('Sed_School/SedschoolListing');
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
	
	public function export_sed_school_csv(){ 
		$filename = 'schools_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		
		if($this->session->userdata('userId')==1){
			$school_data= $this->sed_school_model->get_sed_schools_csv_export();
		}		
		else{
			$District_Training_Centr = $this->session->userdata('district');	
			$school_data= $this->sed_school_model->get_sed_ae_schools_csv_export($District_Training_Centr);
		}
		
		//$school_data= $this->school_model->get_schools_csv_export();
		
		$file = fopen('php://output', 'w');
		$header = array("school_id", "username","school_department","school_type","school_name","school_address","school_district_id","school_tehsil_id","school_level","school_gender","school_email","school_phone","school_contact_name","school_contact_mobile","school_lat","school_lon","school_status"); 
                                                                                                                                                                                                
		fputcsv($file, $header);
		foreach ($school_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
   
}
?>