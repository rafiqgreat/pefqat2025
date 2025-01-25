<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
        $this->db->update('tbl_schools', ['Name_of_TA' => NULL]);
        return $this->db->affected_rows();
    }
	 function getTotalCenterStaffStatics()
    {
        $this->db->select('e.cdistrict_id,district_name_en,
								 COUNT(DISTINCT e.cid) AS total_cid,
								 COUNT(s.staff_id) AS staff_count');
        $this->db->from('tbl_examcenter e');
		  $this->db->join('tbl_staff s', 'e.cid = s.staff_cid', 'left');
		  $this->db->join('tbl_district', 'e.cdistrict_id = district_id', 'left');
		  if ($this->session->userdata('role') == 2) {
			  $this->db->where('e.cdistrict_id',$this->session->userdata('district'));
		  }
		  $this->db->group_by('e.cdistrict_id');
		  $query = $this->db->get();
        return $result = $query->result();
    }
	 
    function getStatisticsDistricts()
    {
        $this->db->select('school_district, COUNT(*) AS totalschools, COUNT(Name_of_TA) AS assignedSchools');
        $this->db->from('tbl_schools');
        $this->db->group_by('school_district');
        $query = $this->db->get();
        return $query->result();
    }
    function getStatisticsSchools()
    {
        $this->db->select('school_id');
        $this->db->from('tbl_schools');
        $this->db->where('Name_of_TA !=', '');
        $assingedSchools = $this->db->count_all_results();
        $totalSchools = $this->db->count_all('tbl_schools');
        return ['totalSchools' => $totalSchools, 'assignedSchools' => $assingedSchools, 'unassignedSchools' => ($totalSchools - $assingedSchools)];
    }
	 function getTotalCenterCreated()
    {
        $this->db->select('*');
        $this->db->from('tbl_examcenter');
		  if ($this->session->userdata('role') == 2) {
				$this->db->where('cdistrict_id',$this->session->userdata('district'));
			}
        $totalCenter = $this->db->count_all_results();
		  //print $this->db->last_query();die('123');
        return ['totalCenter' => $totalCenter];
    }
	 function getTotalStaffAllocatedToCenters()
    {
        $this->db->select('*');
        $this->db->from('tbl_staff');
		  if ($this->session->userdata('role') == 2) {
			   $this->db->join('tbl_examcenter', 'cid = staff_cid');
				$this->db->where('cdistrict_id',$this->session->userdata('district'));
			}
        $totalStaff = $this->db->count_all_results();
		  //print $this->db->last_query();die('123');
        return ['totalStaff' => $totalStaff];
    }
    function getStatisticsSchoolsCEO()
    {
        $this->db->select('school_id');
        $this->db->from('tbl_schools');
        $this->db->where('school_district', $this->session->userdata('district'));
        $totalSchools = $this->db->count_all_results();

        $this->db->select('school_id');
        $this->db->from('tbl_schools');
        $this->db->where('Name_of_TA !=', '');
        $this->db->where('school_district', $this->session->userdata('district'));
        $assingedSchools = $this->db->count_all_results();

        return ['totalSchools' => $totalSchools, 'assignedSchools' => $assingedSchools, 'unassignedSchools' => ($totalSchools - $assingedSchools)];
    }
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function schoolListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_schools as BaseTbl');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.school_id  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_emis  LIKE '%" . $searchText . "%'
							
							OR  BaseTbl.school_lsacode  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_name  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();

        return $query->num_rows();
    }
    function schoolListingCountCEO($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('tbl_schools as BaseTbl');


        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.school_id  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_emis  LIKE '%" . $searchText . "%'
							
							OR  BaseTbl.school_lsacode  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_name  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.school_district_id', $this->session->userdata('district'));
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
        $this->db->from('tbl_schools');
        $query = $this->db->get();
        return $query->result();
    }

    function count_records_ceo($district)
    {
        $this->db->select('COUNT(*) AS totalschools');
        $this->db->from('tbl_schools');

        $query = $this->db->get();
        return $query->result();
    }
    function schoolListing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools as BaseTbl');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.school_id  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_emis  LIKE '%" . $searchText . "%'
							
							OR  BaseTbl.school_lsacode  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_name  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('BaseTbl.school_id', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
    function schoolListingCEO($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools as BaseTbl');
        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.school_id  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_emis  LIKE '%" . $searchText . "%'
							
							OR  BaseTbl.school_lsacode  LIKE '%" . $searchText . "%'
                            OR  BaseTbl.school_name  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.school_district_id', $this->session->userdata('district'));
        $this->db->order_by('BaseTbl.school_id', 'ASC');
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
        $this->db->where('school_id', $schoolId);
        $query = $this->db->get();
        return $query->row();
    }
    function getSchoolInfoCEO($schoolId)
    {
        $this->db->select('*');
        $this->db->from('tbl_schools');
        $this->db->where('school_id', $schoolId);
        $this->db->where('school_district_id', $this->session->userdata('district'));
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
        $this->db->where('school_id', $schoolId);
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

    function get_schools_csv_export()
    {
        $this->db->select('*')
            ->select('school_id, school_lsacode, school_lsagrade, school_emis, school_name, school_address, school_district, school_tehsil, school_level, school_gender, school_enrollment, school_lsagrade, school_phone, school_head, school_headmobile, Name_of_TA, Designation, Gender, CNIC, Cell_No, Father_Name_as_per_CNIC, DOB_as_per_CNIC, Place_of_Posting')
            //"school_id", "PEC_Sch_Code", "Sch_Admn_Body", "Sch_EMIS", "S_Name", "Sch_Per_Address", "District_Training_Centr", "Tehsil", "Sch_Level", "Sch_Type", "Sch_Area", "Grade", "Sch_Phone_No", "Sch_Head_Owner_Name", "Sch_Head_Owner_Phon_No", "Name_of_TA", "Designation", "Gender", "CNIC", "Cell_No", "Father_Name_as_per_CNIC", "DOB_as_per_CNIC", "Place_of_Posting"
            ->from('tbl_schools');
        //->join('tbl_users', 'userId= updatedby');
        $query = $this->db->get();
        return $result = $query->result_array();
    }
    function get_ae_schools_csv_export($District_Training_Centr)
    {
        $this->db
            ->select('school_id, school_lsacode, school_lsagrade, school_emis, school_name, school_address, school_district, school_tehsil, school_level, school_gender, school_enrollment, school_lsagrade, school_phone, school_head, school_headmobile, Name_of_TA, Designation, Gender, CNIC, Cell_No, Father_Name_as_per_CNIC, DOB_as_per_CNIC, Place_of_Posting')
            //->select('*')
            ->from('tbl_schools')
            ->where('school_district', $District_Training_Centr);
        //->where('District_Training_Centr IN ('.$District_Training_Centr.')');
        $query = $this->db->get();
        //print_r($this->db->last_query());
        //die($this->db->last_query());
        return $result = $query->result_array();
    }
}
