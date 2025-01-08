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
        $this->load->model('center_model');
		$this->isLoggedIn();   
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
	
    /**
     * This function is used to load the Center list
     */
    function centerListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->center_model->centerListingCount($searchText);
			$returns = $this->paginationCompress ( "centerListing/", $count, 10 );
            
            $data['centerRecords'] = $this->center_model->centerListing($searchText, $returns["page"], $returns["segment"]);
            //echo '<pre>';
			///print_r($data['centerRecords']);
			//die();
            $this->global['pageTitle'] = 'PEC : center Listing';
            
            $this->loadViews("centers", $this->global, $data, NULL);
        }
    }
  
    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('center_model');
            $data['roles'] = $this->center_model->getCenterRoles();
			
			 $data['districts'] = $this->center_model->getCenterDistricts();
            
            $this->global['pageTitle'] = 'PEC : Add New Center';
            $this->loadViews("addExamCenter", $this->global, $data, NULL);
        }
    }
    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $centerId = $this->input->post("centerId");
        $email = $this->input->post("email");
        if(empty($centerId)){
            $result = $this->center_model->checkEmailExists($email);
        } else {
            $result = $this->center_model->checkEmailExists($email, $centerId);
        }
        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new center to the system
     */
    function addNewCenter()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
			$this->form_validation->set_rules('district','Role','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
				$district = $this->input->post('district');
                
                $centerInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'), 'district'=>$district);
                
                $this->load->model('center_model');
                $result = $this->center_model->addNewCenter($centerInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Center created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Center creation failed');
                }
                
                redirect('addNew');
            }
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
    function editCenter()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $centerId = $this->input->post('centerId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
			$this->form_validation->set_rules('district','Role','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($centerId);
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
				$district = $this->input->post('district');
                
                $centerInfo = array();
                
                if(empty($password))
                {
                    $centerInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'), 'district'=>$district);
                }
                else
                {
                    $centerInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'), 'district'=>$district);
                }
                
                $result = $this->center_model->editCenter($centerInfo, $centerId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Center updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Center updation failed');
                }
                
                redirect('centerListing');
            }
        }
    }
    /**
     * This function is used to delete the center using centerId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCenter()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $centerId = $this->input->post('centerId');
            $centerInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->center_model->deleteCenter($centerId, $centerInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
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
    /**
     * This function used to show login history
     * @param number $centerId : This is center id
     */
    function loginHistoy($centerId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $centerId = ($centerId == NULL ? 0 : $centerId);
            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');
            $data["centerInfo"] = $this->center_model->getCenterInfoById($centerId);
            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->center_model->loginHistoryCount($centerId, $searchText, $fromDate, $toDate);
            $returns = $this->paginationCompress ( "login-history/".$centerId."/", $count, 10, 3);
            $data['centerRecords'] = $this->center_model->loginHistory($centerId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'PEC : Center Login History';
            
            $this->loadViews("loginHistory", $this->global, $data, NULL);
        }        
    }
    /**
     * This function is used to show centers profile
     */
    function profile($active = "details")
    {
        $data["centerInfo"] = $this->center_model->getCenterInfoWithRole($this->vendorId);
        $data["active"] = $active;
        
        $this->global['pageTitle'] = $active == "details" ? 'PEC : My Profile' : 'PEC : Change Password';
        $this->loadViews("profile", $this->global, $data, NULL);
    }
    /**
     * This function is used to update the center details
     * @param text $active : This is flag to set the active tab
     */
    function profileUpdate($active = "details")
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|callback_emailExists');        
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            
            $centerInfo = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->center_model->editCenter($centerInfo, $this->vendorId);
            
            if($result == true)
            {
                $this->session->set_centerdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Profile updation failed');
            }
            redirect('profile/'.$active);
        }
    }
    /**
     * This function is used to change the password of the center
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->center_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else
            {
                $centersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->center_model->changePassword($this->vendorId, $centersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('profile/'.$active);
            }
        }
    }
    /**
     * This function is used to check whether email already exist or not
     * @param {string} $email : This is centers email
     */
    function emailExists($email)
    {
        $centerId = $this->vendorId;
        $return = false;
        if(empty($centerId)){
            $result = $this->center_model->checkEmailExists($email);
        } else {
            $result = $this->center_model->checkEmailExists($email, $centerId);
        }
        if(empty($result)){ $return = true; }
        else {
            $this->form_validation->set_message('emailExists', 'The {field} already taken');
            $return = false;
        }
        return $return;
    }
}
?>