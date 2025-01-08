<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class : Center_model (Center Model)
 * Center model class to get to handle center related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Center_model extends CI_Model
{
    /**
     * This function is used to get the center listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function centerListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.centerId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_centers as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the center listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function centerListing($searchText = '', $page, $segment)
{
    $this->db->select('
        BaseTbl.centerId, 
        BaseTbl.email, 
        BaseTbl.name, 
        BaseTbl.mobile, 
        BaseTbl.createdDtm, 
        Role.role, 
        BaseTbl.district, 
        DistrictTbl.district_name_en as districtName
    ');
    $this->db->from('tbl_centers as BaseTbl');
    $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId', 'left');
    $this->db->join('tbl_district as DistrictTbl', 'DistrictTbl.district_id = BaseTbl.district_id', 'left');
    if (!empty($searchText)) {
        $likeCriteria = "(BaseTbl.email LIKE '%" . $searchText . "%'
                        OR BaseTbl.name LIKE '%" . $searchText . "%'
                        OR BaseTbl.mobile LIKE '%" . $searchText . "%')";
        $this->db->where($likeCriteria);
    }
    $this->db->where('BaseTbl.isDeleted', 0);
    $this->db->where('BaseTbl.roleId !=', 1);
    $this->db->order_by('BaseTbl.centerId', 'DESC');
    $this->db->limit($page, $segment);
    $query = $this->db->get();
    
    $result = $query->result();
    return $result;
}

	/**
     * This function is used to get the center roles information
     * @return array $result : This is result of the query
     */
    function getCenterDistricts()
    {
        $this->db->select('district_id, district_name_en');
        $this->db->from('tbl_district');
        $this->db->where('district_id !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
    
    /**
     * This function is used to get the center roles information
     * @return array $result : This is result of the query
     */
    function getCenterRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $centerId : This is center id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $centerId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_centers");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($centerId != 0){
            $this->db->where("centerId !=", $centerId);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /**
     * This function is used to add new center to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewCenter($centerInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_centers', $centerInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get center information by id
     * @param number $centerId : This is center id
     * @return array $result : This is center information
     */
    function getCenterInfo($centerId)
    {
        $this->db->select('centerId, name, email, mobile, roleId, district, district_id');
        $this->db->from('tbl_centers');
        $this->db->where('isDeleted', 0);
		$this->db->where('roleId !=', 1);
        $this->db->where('centerId', $centerId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the center information
     * @param array $centerInfo : This is centers updated information
     * @param number $centerId : This is center id
     */
    function editCenter($centerInfo, $centerId)
    {
        $this->db->where('centerId', $centerId);
        $this->db->update('tbl_centers', $centerInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the center information
     * @param number $centerId : This is center id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCenter($centerId, $centerInfo)
    {
        $this->db->where('centerId', $centerId);
        $this->db->update('tbl_centers', $centerInfo);
        
        return $this->db->affected_rows();
    }
    /**
     * This function is used to match centers password for change password
     * @param number $centerId : This is center id
     */
    function matchOldPassword($centerId, $oldPassword)
    {
        $this->db->select('centerId, password');
        $this->db->where('centerId', $centerId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_centers');
        
        $center = $query->result();
        if(!empty($center)){
            if(verifyHashedPassword($oldPassword, $center[0]->password)){
                return $center;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change centers password
     * @param number $centerId : This is center id
     * @param array $centerInfo : This is center updation info
     */
    function changePassword($centerId, $centerInfo)
    {
        $this->db->where('centerId', $centerId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_centers', $centerInfo);
        
        return $this->db->affected_rows();
    }
    /**
     * This function is used to get center login history
     * @param number $centerId : This is center id
     */
    function loginHistoryCount($centerId, $searchText, $fromDate, $toDate)
    {
        $this->db->select('BaseTbl.centerId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.centerAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($centerId >= 1){
            $this->db->where('BaseTbl.centerId', $centerId);
        }
        $this->db->from('tbl_last_login as BaseTbl');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    /**
     * This function is used to get center login history
     * @param number $centerId : This is center id
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function loginHistory($centerId, $searchText, $fromDate, $toDate, $page, $segment)
    {
        $this->db->select('BaseTbl.centerId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.centerAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        $this->db->from('tbl_last_login as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($centerId >= 1){
            $this->db->where('BaseTbl.centerId', $centerId);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    /**
     * This function used to get center information by id
     * @param number $centerId : This is center id
     * @return array $result : This is center information
     */
    function getCenterInfoById($centerId)
    {
        $this->db->select('centerId, name, email, mobile, roleId');
        $this->db->from('tbl_centers');
        $this->db->where('isDeleted', 0);
        $this->db->where('centerId', $centerId);
        $query = $this->db->get();
        
        return $query->row();
    }
    /**
     * This function used to get center information by id with role
     * @param number $centerId : This is center id
     * @return aray $result : This is center information
     */
    function getCenterInfoWithRole($centerId)
    {
        $this->db->select('BaseTbl.centerId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.roleId, Roles.role');
        $this->db->from('tbl_centers as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.centerId', $centerId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }
}
  