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
            
            $this->global['pageTitle'] = 'PEC : Schools Listing';
            
            $this->loadViews("schools", $this->global, $data, NULL);
		}
		else if ($this->isCEO() == FALSE)
		{
           
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
			$schoolId = $this->input->post('School_Id');
			
			$this->form_validation->set_rules('Name_of_TA','Name of Teacher','trim|required|max_length[255]');
            $this->form_validation->set_rules('Designation','Designation','trim|required');
            $this->form_validation->set_rules('Gender','Gender','required');
            $this->form_validation->set_rules('CNIC','CNIC','trim|required');
            $this->form_validation->set_rules('Cell_No','Cell No','trim|required');
            $this->form_validation->set_rules('Father_Name_as_per_CNIC','Father Name','trim|required|max_length[255]');
            $this->form_validation->set_rules('DOB_as_per_CNIC','Date of Birth','trim|required');
            $this->form_validation->set_rules('Place_of_Posting','Place of Posting','trim|required');
            //$this->form_validation->set_rules('LSA_Allotted_School','School Alloted','trim|required');
			
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
                
                $schoolInfo = array('Name_of_TA'=>$Name_of_TA, 'Designation'=>$Designation, 'Gender'=>$Gender,
                    'CNIC'=>$CNIC, 'Cell_No'=>$Cell_No, 'Father_Name_as_per_CNIC'=>$Father_Name_as_per_CNIC, 'DOB_as_per_CNIC'=>$DOB_as_per_CNIC, 
                    'Place_of_Posting'=>$Place_of_Posting, 'updatedby'=>$this->vendorId, 
                    'updated'=>date('Y-m-d H:i:s'));
            
                
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
			$schoolId = $this->input->post('School_Id');
			
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
                
                $schoolInfo = array('Name_of_TA'=>$Name_of_TA, 'Designation'=>$Designation, 'Gender'=>$Gender,
                    'CNIC'=>$CNIC, 'Cell_No'=>$Cell_No, 'Father_Name_as_per_CNIC'=>$Father_Name_as_per_CNIC, 'DOB_as_per_CNIC'=>$DOB_as_per_CNIC, 
                    'Place_of_Posting'=>$Place_of_Posting, 'updatedby'=>$this->vendorId, 
                    'updated'=>date('Y-m-d H:i:s'));
            
                
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
   
}
?>