<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Pef_School_model extends CI_Model
{
    public function get_total_selected($schoolId)
    {
        $this->db->select('total_selected');
        $this->db->from('tbl_schools_pef');
        $this->db->where('s_id', $schoolId);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Get all districts
public function getAllDistricts()
{
    $query = $this->db->get('tbl_district');
    return $query->result();
}

// Get tehsils by district
public function getTehsilsByDistrict($districtId)
{
    $this->db->where('tehsil_district_id', $districtId);
    $query = $this->db->get('tbl_tehsil');
    return $query->result();
}
 function getPefSchoolsByTehsil($tehsilId)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools_pef');
        $this->db->where('s_tehsil_id', $tehsilId);
        $query = $this->db->get();
        return $query->result();
    }
	
	function updateNulls()
	{
		//UPDATE tbl_schools SET Name_of_TA = NULL WHERE Name_of_TA = ''
		$this->db->where('s_name', '');        
        $this->db->update('tbl_schools_pef', ['s_name'=>NULL]);        
        return $this->db->affected_rows();
		
	}
	function getStatisticsDistricts()
	{	
		$this->db->select('school_district, COUNT(*) AS totalschools, COUNT(Name_of_TA) AS assignedSchools');
		$this->db->from('tbl_schools_pef');
		$this->db->group_by('school_district'); 
		$query = $this->db->get();
        return $query->result();        
    }
	function getStatisticsSchools()
	{	
		$this->db->select('school_id');
		$this->db->from('tbl_schools_pef');
		$this->db->where('Name_of_TA !=','');
		$assingedSchools = $this->db->count_all_results();
		$totalSchools = $this->db->count_all('tbl_schools_pef');
		return ['totalSchools'=>$totalSchools,'assignedSchools'=>$assingedSchools,'unassignedSchools'=>($totalSchools-$assingedSchools)];
	}
	function getStatisticsSchoolsCEO()
	{	
		$this->db->select('school_id');
		$this->db->from('tbl_schools_pef');
		$this->db->where('school_district', $this->session->userdata('district'));
		$totalSchools = $this->db->count_all_results();
		
		$this->db->select('school_id');
		$this->db->from('tbl_schools_pef');
		$this->db->where('Name_of_TA !=','');
		$this->db->where('school_district', $this->session->userdata('district'));
		$assingedSchools = $this->db->count_all_results();
		
		return ['totalSchools'=>$totalSchools,'assignedSchools'=>$assingedSchools,'unassignedSchools'=>($totalSchools-$assingedSchools)];
	}
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function PefschoolListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_schools_pef as BaseTbl');        
        if(!empty($searchText)) {
        $likeCriteria = "(BaseTbl.s_id  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_school_code  LIKE '%".$searchText."%'
							
							OR  BaseTbl.s_program  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_phase  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
	 function PefschoolListingCountCEO($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_schools_pef as BaseTbl');   

		 
        if(!empty($searchText)) {
        $likeCriteria = "(BaseTbl.s_id  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_school_code  LIKE '%".$searchText."%'
							
							OR  BaseTbl.s_program  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_phase  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
		$this->db->where('BaseTbl.s_district_id', $this->session->userdata('district'));
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**	
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
	function count_records()
	{
		
		$this->db->select('COUNT(*) AS totalschools');
		$this->db->from('tbl_schools_pef');
		$query = $this->db->get();
        return $query->result();        
		
	}
	
	function count_records_ceo($district)
	{
		$this->db->select('COUNT(*) AS totalschools');
		$this->db->from('tbl_schools_pef');
		
		$query = $this->db->get();
        return $query->result();        
	}
    function PefschoolListing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools_pef as BaseTbl');        		
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.s_id  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_school_code  LIKE '%".$searchText."%'
							
							OR  BaseTbl.s_program  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_phase  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('BaseTbl.s_id', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
     function PefschoolListingCEO($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools_pef as BaseTbl');        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.s_id  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_school_code  LIKE '%".$searchText."%'
							
							OR  BaseTbl.s_program  LIKE '%".$searchText."%'
                            OR  BaseTbl.s_phase  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);			
        }
		$this->db->where('BaseTbl.s_district_id', $this->session->userdata('district'));
        $this->db->order_by('BaseTbl.s_id', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
   
   
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getPefSchoolInfo_($schoolId)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools_pef');
        $this->db->where('s_id', $schoolId);
        $query = $this->db->get();
        return $query->row();
    }

    // Modify your model function to get district and tehsil names
    public function getPefSchoolInfo($schoolId)
    {
        $this->db->select('tbl_schools_pef.*, tbl_district.district_name_en, tbl_tehsil.tehsil_name_en');
        $this->db->from('tbl_schools_pef');
        $this->db->join('tbl_district', 'tbl_district.district_id = tbl_schools_pef.s_district_id', 'left');
        $this->db->join('tbl_tehsil', 'tbl_tehsil.tehsil_id = tbl_schools_pef.s_tehsil_id', 'left');
        $this->db->where('s_id', $schoolId);
        $query = $this->db->get();
        return $query->row();
    }


	 function getPefSchoolInfoCEO($schoolId)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools_pef');
        $this->db->where('s_id', $schoolId);
		$this->db->where('s_district_id', $this->session->userdata('district'));
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */

     public function insertSchool($data)
    {
        return $this->db->insert('tbl_schools_pef', $data);
    }

    function editPefUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_schools_pef', $userInfo);
        
        return TRUE;
    }
	
	function updateSchool($schoolInfo, $schoolId)
    {
        $this->db->where('s_id', $schoolId);
        $this->db->update('tbl_schools_pef', $schoolInfo);
		return TRUE;
    }
    
    
        public function deleteSchoolById($schoolId)
    {
        $this->db->where('s_id', $schoolId);
        return $this->db->delete('tbl_schools_pef'); // Replace 'pef_schools' with your actual table name
    }

    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getPefSchoolInfoById($schoolId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_schools_pef');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
	
	function get_pef_schools_csv_export(){
		$this->db->select('*')
		        ->select('s_id, s_program,s_school_code,s_phase,s_name,s_address,s_district_id,s_tehsil_id,s_owner_name,s_owner_cell,s_level,s_lat,s_long,s_status,')
        //"school_id", "PEC_Sch_Code", "Sch_Admn_Body", "Sch_EMIS", "S_Name", "Sch_Per_Address", "District_Training_Centr", "Tehsil", "Sch_Level", "Sch_Type", "Sch_Area", "Grade", "Sch_Phone_No", "Sch_Head_Owner_Name", "Sch_Head_Owner_Phon_No", "Name_of_TA", "Designation", "Gender", "CNIC", "Cell_No", "Father_Name_as_per_CNIC", "DOB_as_per_CNIC", "Place_of_Posting"
				 ->from('tbl_schools_pef');
				 //->join('tbl_users', 'userId= updatedby');
		$query = $this->db->get();
		return $result = $query->result_array();
	}
	function get_pef_ae_schools_csv_export($District_Training_Centr){			
			$this->db
            ->select('s_id, s_program,s_school_code,s_phase,s_name,s_address,s_district_id,s_tehsil_id,s_owner_name,s_owner_cell,s_level,s_lat,s_long,s_status,')
            //->select('*')
					 ->from('tbl_schools_pef')
					 ->where('s_district_id', $District_Training_Centr);
					 //->where('District_Training_Centr IN ('.$District_Training_Centr.')');
			$query = $this->db->get();
			//print_r($this->db->last_query());
			//die($this->db->last_query());
			return $result = $query->result_array();
		}
}
  