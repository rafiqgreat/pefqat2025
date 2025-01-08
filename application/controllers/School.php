<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
/**
 * Class : School (SchoolController)
 * School Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class School extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('school_model');
        $this->isLoggedIn();   
    }
        
    /**
     * This function is used to load the user list
     */
	function schoolListing()
    {
        if($this->isAdmin() == FALSE)
        {
			$searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->school_model->schoolListingCount($searchText);
			$returns = $this->paginationCompress ( "schoolListing/", $count, 10 );
            
            $data['schoolRecords'] = $this->school_model->schoolListing($searchText, $returns["page"], $returns["segment"]);
				// Get the total number of records
    		 $total_schools = $this->school_model->count_records();
			
			 $data['total_records'] = $total_schools[0]->totalschools;
			
            $this->global['pageTitle'] = 'PEC : Schools Listing';
            
            $this->loadViews("schools", $this->global, $data, NULL);
		}
		else if ($this->isCEO() == FALSE)
		{
        
			$total_schools = $this->school_model->schoolListingCountCEO();
			$data['total_records'] = $total_schools;  
			$searchText = $this->security->xss_clean($this->input->post('searchText'));
			$data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->school_model->schoolListingCountCEO($searchText);
			$returns = $this->paginationCompress ( "schoolListing/", $count, 10 );
            
            $data['schoolRecords'] = $this->school_model->schoolListingCEO($searchText, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'PEC : Schools Listing';
            
            $this->loadViews("schools", $this->global, $data, NULL);
        }
        else
        {        
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
            $result = $this->school_model->checkTeacherExists($cnicTA);
        } 
        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editSchool($schoolId = NULL)
    {
        if($this->isAdmin() == FALSE )
         {
            if($schoolId == null)
            {
                redirect('schoolListing');
            }
            $data['schoolInfo'] = $this->school_model->getSchoolInfo($schoolId);
            $this->global['pageTitle'] = 'PEC : Edit School Teacher';
            $this->loadViews("editTeacherInfo", $this->global, $data, NULL);
        }
		else if ($this->isCEO() == FALSE)
		{
            if($schoolId == null)
            {
                redirect('schoolListing');
            }
            $data['schoolInfo'] = $this->school_model->getSchoolInfoCEO($schoolId);
            $this->global['pageTitle'] = 'PEC : Edit School Teacher';
            $this->loadViews("editTeacherInfo", $this->global, $data, NULL);
        }
        else
        {
            $this->loadThis();
        }
    }
    
    /**
     * This function is used to edit the user information
     */
    function updateSchool()
    {
        if($this->isAdmin() == FALSE)
        {
			$this->load->library('form_validation');
			$schoolId = $this->input->post('school_id');
			$this->form_validation->set_rules('Name_of_TA','Name of Teacher','trim|required|max_length[255]');
            $this->form_validation->set_rules('Designation','Designation','trim|required');
            $this->form_validation->set_rules('Gender','Gender','required');
            $this->form_validation->set_rules('CNIC','CNIC','trim|required');
            $this->form_validation->set_rules('Cell_No','Cell No','trim|required');
            $this->form_validation->set_rules('Father_Name_as_per_CNIC','Father Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('DOB_as_per_CNIC','Date of Birth','trim|required');
            $this->form_validation->set_rules('Place_of_Posting','Place of Posting','trim|required');
			if($this->form_validation->run() == FALSE)
            {
                $this->editSchool($schoolId);
            }
            else
            {       
				$Name_of_TA = $this->input->post('Name_of_TA');
				$Designation = $this->input->post('Designation');
				$Gender = $this->input->post('Gender');
				$CNIC = $this->input->post('CNIC');
				$Cell_No = $this->input->post('Cell_No');
				$Father_Name_as_per_CNIC = $this->input->post('Father_Name_as_per_CNIC');
				$DOB_as_per_CNIC = $this->input->post('DOB_as_per_CNIC');
				$Place_of_Posting = $this->input->post('Place_of_Posting');
				
                $schoolInfo = array(
										'Name_of_TA'=>$Name_of_TA,
										'Designation'=>$Designation, 
										'Gender'=>$Gender,
										'CNIC'=>$CNIC,
										'Cell_No'=>$Cell_No, 
										'Father_Name_as_per_CNIC'=>$Father_Name_as_per_CNIC, 
										'DOB_as_per_CNIC'=>$DOB_as_per_CNIC,
                    					'Place_of_Posting'=>$Place_of_Posting, 
										'school_updatedby'=>$this->vendorId, 
									);
                $result = $this->school_model->updateSchool($schoolInfo, $schoolId);
				
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'School updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'School updation failed');
                }
                redirect('schoolListing');
            }
        }
		elseif($this->isCEO() == FALSE)
        {
			$this->load->library('form_validation');
			$schoolId = $this->input->post('school_id');
			$this->form_validation->set_rules('Name_of_TA','Name of Teacher','trim|required|max_length[255]');
            $this->form_validation->set_rules('Designation','Designation','trim|required');
            $this->form_validation->set_rules('Gender','Gender','required');
            $this->form_validation->set_rules('CNIC','CNIC','trim|required');
            $this->form_validation->set_rules('Cell_No','Cell No','trim|required');
            $this->form_validation->set_rules('Father_Name_as_per_CNIC','Father Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('DOB_as_per_CNIC','Date of Birth','trim|required');
            $this->form_validation->set_rules('Place_of_Posting','Place of Posting','trim|required');
          //  $this->form_validation->set_rules('LSA_Allotted_School','School Alloted','trim|required');
			if($this->form_validation->run() == FALSE)
            {
                $this->editSchool($schoolId);
            }
            else
            {       
				$Name_of_TA = $this->input->post('Name_of_TA');
				$Designation = $this->input->post('Designation');
				$Gender = $this->input->post('Gender');
				$CNIC = $this->input->post('CNIC');
				$Cell_No = $this->input->post('Cell_No');
				$Father_Name_as_per_CNIC = $this->input->post('Father_Name_as_per_CNIC');
				$DOB_as_per_CNIC = $this->input->post('DOB_as_per_CNIC');
				$Place_of_Posting = $this->input->post('Place_of_Posting');
				$LSA_Allotted_School = $this->input->post('LSA_Allotted_School');
				
                $schoolInfo = array(
										'Name_of_TA'=>$Name_of_TA, 
										'Designation'=>$Designation, 
										'Gender'=>$Gender,
										'CNIC'=>$CNIC, 
										'Cell_No'=>$Cell_No, 
										'Father_Name_as_per_CNIC'=>$Father_Name_as_per_CNIC, 
										'DOB_as_per_CNIC'=>$DOB_as_per_CNIC, 
										'Place_of_Posting'=>$Place_of_Posting, 
										'school_updatedby'=>$this->vendorId, 
									);
                $result = $this->school_model->updateSchool($schoolInfo, $schoolId);
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'School updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'School updation failed');
                }
                redirect('schoolListing');
            }
        }
		else
		{
			$this->loadThis();
		}	
    }
        
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'PEC : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    } 
	
	public function export_school_csv(){ 
		$filename = 'schools_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		
		if($this->session->userdata('userId')==1){
			$school_data= $this->school_model->get_schools_csv_export();
		}		
		else{
			$District_Training_Centr = $this->session->userdata('district');	
			$school_data= $this->school_model->get_ae_schools_csv_export($District_Training_Centr);
		}
		
		//$school_data= $this->school_model->get_schools_csv_export();
		
		$file = fopen('php://output', 'w');
		$header = array("school_id", "school_lsacode", "school_lsagrade", "school_emis", "school_name", "school_address", "school_district", "Tehsil", "school_level", "school_gender", "school_enrollment", "school_lsagrade", "school_phone", "school_head", "school_headmobile", "Name_of_TA", "Designation", "Gender", "CNIC", "Cell_No", "Father_Name_as_per_CNIC", "DOB_as_per_CNIC", "Place_of_Posting"); 
                                                                                                                                                                                                
		fputcsv($file, $header);
		foreach ($school_data as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
   
}
?>