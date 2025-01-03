<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class School_model extends CI_Model
{
	function updateNulls()
	{
		//UPDATE tbl_schools SET Name_of_TA = NULL WHERE Name_of_TA = ''
		$this->db->where('Name_of_TA', '');        
        $this->db->update('tbl_schools', ['Name_of_TA'=>NULL]);        
        return $this->db->affected_rows();
		
	}
	function getStatisticsDistricts()
	{	
		$this->db->select('school_district,COUNT(*) AS totalschools, COUNT(Name_of_TA) AS assignedSchools');
		$this->db->from('tbl_schools');
		$this->db->group_by('school_district'); 
		$query = $this->db->get();
        return $query->result();        
    }
	function getStatisticsSchools()
	{	
		$this->db->select('School_Id');
		$this->db->from('tbl_schools');
		$this->db->where('Name_of_TA !=','');
		$assingedSchools = $this->db->count_all_results();
		$totalSchools = $this->db->count_all('tbl_schools');
		return ['totalSchools'=>$totalSchools,'assignedSchools'=>$assingedSchools,'unassignedSchools'=>($totalSchools-$assingedSchools)];
	}
	function getStatisticsSchoolsCEO()
	{	
		$this->db->select('School_Id');
		$this->db->from('tbl_schools');
		$this->db->where('school_district', $this->session->userdata('district'));
		$totalSchools = $this->db->count_all_results();
		
		$this->db->select('School_Id');
		$this->db->from('tbl_schools');
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
    function schoolListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.School_Id,BaseTbl.PEC_Sch_Code, BaseTbl.Sch_Admn_Body, BaseTbl.S_Name, BaseTbl.school_district, BaseTbl.Tehsil, BaseTbl.Sch_Level,BaseTbl.Sch_Type,BaseTbl.Sch_Area, BaseTbl.Name_of_TA, BaseTbl.Designation, BaseTbl.Cell_No');
        $this->db->from('tbl_schools as BaseTbl');        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.School_Id  LIKE '%".$searchText."%'
                            OR  BaseTbl.Sch_EMIS  LIKE '%".$searchText."%'
                            OR  BaseTbl.S_Name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
	 function schoolListingCountCEO($searchText = '')
    {
        $this->db->select('BaseTbl.School_Id,BaseTbl.PEC_Sch_Code, BaseTbl.Sch_Admn_Body, BaseTbl.S_Name, BaseTbl.school_district, BaseTbl.Tehsil, BaseTbl.Sch_Level,BaseTbl.Sch_Type,BaseTbl.Sch_Area, BaseTbl.Name_of_TA, BaseTbl.Designation, BaseTbl.Cell_No');
        $this->db->from('tbl_schools as BaseTbl');   
		 
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.School_Id  LIKE '%".$searchText."%'
                            OR  BaseTbl.Sch_EMIS  LIKE '%".$searchText."%'
                            OR  BaseTbl.S_Name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);			
        }
		$this->db->where('BaseTbl.school_district', $this->session->userdata('district'));
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
    function schoolListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.School_Id, BaseTbl.PEC_Sch_Code, BaseTbl.Sch_Admn_Body, BaseTbl.S_Name, BaseTbl.school_district, BaseTbl.Tehsil, BaseTbl.Sch_Level,BaseTbl.Sch_Type,BaseTbl.Sch_Area, BaseTbl.Name_of_TA, BaseTbl.Designation, BaseTbl.Cell_No');
        $this->db->from('tbl_schools as BaseTbl');        		
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.School_Id  LIKE '%".$searchText."%'
                            OR  BaseTbl.Sch_EMIS  LIKE '%".$searchText."%'
                            OR  BaseTbl.S_Name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('BaseTbl.School_Id', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
     function schoolListingCEO($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.School_Id, BaseTbl.PEC_Sch_Code, BaseTbl.Sch_Admn_Body, BaseTbl.S_Name, BaseTbl.school_district, BaseTbl.Tehsil, BaseTbl.Sch_Level,BaseTbl.Sch_Type,BaseTbl.Sch_Area, BaseTbl.Name_of_TA, BaseTbl.Designation, BaseTbl.Cell_No');
        $this->db->from('tbl_schools as BaseTbl');        
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.School_Id  LIKE '%".$searchText."%'
                            OR  BaseTbl.Sch_EMIS  LIKE '%".$searchText."%'
                            OR  BaseTbl.S_Name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);			
        }
		$this->db->where('BaseTbl.school_district', $this->session->userdata('district'));
        $this->db->order_by('BaseTbl.School_Id', 'ASC');
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
    function getSchoolInfo($schoolId)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools');
        $this->db->where('School_Id', $schoolId);
        $query = $this->db->get();
        
        return $query->row();
    }
	 function getSchoolInfoCEO($schoolId)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools');
        $this->db->where('School_Id', $schoolId);
		$this->db->where('school_district', $this->session->userdata('district'));
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_schools', $userInfo);
        
        return TRUE;
    }
	
	 function updateSchool($schoolInfo, $schoolId)
    {
        $this->db->where('School_Id', $schoolId);
        $this->db->update('tbl_schools', $schoolInfo);
        
        return TRUE;
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
    function getSchoolInfoById($schoolId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_schools');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
}
  