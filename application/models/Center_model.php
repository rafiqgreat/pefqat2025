<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Center_model extends CI_Model
{
      function getCenterDetailInfoById($dcenter_id)
    {
        $this->db->select('dpefschool_id,total_selected');
        $this->db->from('tbl_examcenter_details');
        $this->db->where('dcenter_id', $dcenter_id);
        $this->db->join('tbl_schools_pef', 's_id = dpefschool_id', 'left');
        $query = $this->db->get();
        
        return $query->result_array();
    }
	 function getCenterPefSchoolIdsInfoById($dcenter_id)
    {
        $this->db->select('GROUP_CONCAT(dpefschool_id) as dpefschool_ids');
        $this->db->from('tbl_examcenter_details');
        $this->db->where('dcenter_id', $dcenter_id);
        $query = $this->db->get();
        
        return $query->row_array();
    }
        function centerListingCount($searchText = '')
        {
            $this->db->select('BaseTbl.cid');
            $this->db->from('tbl_examcenter as BaseTbl');
            $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.ccreatedby', 'left');
            $this->db->join('tbl_district as DistrictTbl', 'DistrictTbl.district_id = BaseTbl.cdistrict_id', 'left');
            $this->db->join('tbl_tehsil as TehsilTbl', 'TehsilTbl.tehsil_id = BaseTbl.cteshil_id', 'left');
				$this->db->join('tbl_schools_sed', 'school_id = BaseTbl.csedschool_id', 'left');
            // Apply search criteria if provided
            if (!empty($searchText)) {
                $likeCriteria = "(BaseTbl.ccode LIKE '%" . $searchText . "%'
                                OR DistrictTbl.district_name_en LIKE '%" . $searchText . "%'
                                OR TehsilTbl.tehsil_name_en LIKE '%" . $searchText . "%'
										  OR tbl_schools_sed.username LIKE '%" . $searchText . "%'
										  OR tbl_schools_sed.school_name LIKE '%" . $searchText . "%')";
                $this->db->where($likeCriteria);
            }
            $this->db->where('BaseTbl.cstatus', 1); 
				if ($this->session->userdata('role') == 2) {
					$this->db->where('DistrictTbl.district_id',$this->session->userdata('district'));
				}
            $query = $this->db->get();
            return $query->num_rows();
        }
		  function centerListing($searchText = '', $page, $segment)
        {
            $this->db->select('
                BaseTbl.cid, 
                BaseTbl.ccode, 
                BaseTbl.cstatus, 
                BaseTbl.ccreated, 
                Role.role, 
                BaseTbl.cdistrict_id, 
                DistrictTbl.district_name_en as districtName,
                BaseTbl.cteshil_id, 
                TehsilTbl.tehsil_name_en as tehsilName,
					 school_name,
					 username,
					 cpefschools_total,
					 cpef_students_avail,
					 cpef_students_selected                
            ');
            $this->db->from('tbl_examcenter as BaseTbl');
            $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.ccreatedby', 'left');
            $this->db->join('tbl_district as DistrictTbl', 'DistrictTbl.district_id = BaseTbl.cdistrict_id', 'left');
            $this->db->join('tbl_tehsil as TehsilTbl', 'TehsilTbl.tehsil_id = BaseTbl.cteshil_id', 'left');
				$this->db->join('tbl_schools_sed', 'school_id = BaseTbl.csedschool_id', 'left');
            // Apply search criteria if provided
            if (!empty($searchText)) {
                $likeCriteria = "(BaseTbl.ccode LIKE '%" . $searchText . "%'
                                OR DistrictTbl.district_name_en LIKE '%" . $searchText . "%'
                                OR TehsilTbl.tehsil_name_en LIKE '%" . $searchText . "%'
										  OR tbl_schools_sed.username LIKE '%" . $searchText . "%'
										  OR tbl_schools_sed.school_name LIKE '%" . $searchText . "%')";
                $this->db->where($likeCriteria);
            }
            $this->db->where('BaseTbl.cstatus', 1); 
				if ($this->session->userdata('role') == 2) {
					$this->db->where('DistrictTbl.district_id',$this->session->userdata('district'));
				}
            $this->db->order_by('BaseTbl.cid', 'DESC');
            $this->db->limit($page, $segment);
            $query = $this->db->get();
            $result = $query->result();
            
            return $result;
        }
		  
        function getCenterInfoById($centerId)
			{
				$this->db->select('*');
				$this->db->from('tbl_examcenter');
				$this->db->where('cid', $centerId);
				$query = $this->db->get();
				
				return $query->row();
			}
         public function deleteCenterById($centerId){
            $this->db->where('cid', $centerId);
        return $this->db->delete('tbl_examcenter'); 
         }
    
        

        function centerListing_($searchText = '', $page, $segment)
        {
            $this->db->select('
                BaseTbl.cid, 
                BaseTbl.ccode, 
                BaseTbl.cstatus,
                BaseTbl.ccreated, 
                tbl_roles.role, 
                BaseTbl.cdistrict_id, 
                tbl_district.district_name_en as districtName
            ');
            $this->db->from('tbl_examcenter as BaseTbl');
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
		  
		  public function getCenterStaffByCenterId($staff_cid)
        {
            $this->db->select('*');
            $this->db->from('tbl_staff');
            $this->db->where('staff_cid', $staff_cid);
            $query = $this->db->get();
            return $query->num_rows();
        }
	
        function getCenterDistricts()
        {
            $this->db->select('district_id, district_name_en');
            $this->db->from('tbl_district');
            //$this->db->where('district_id !=', 1);
            $query = $this->db->get();
            
            return $query->result();
        }
	
    

        function getCenterRoles()
        {
            $this->db->select('roleId, role');
            $this->db->from('tbl_roles');
            $this->db->where('roleId !=', 1);
            $query = $this->db->get();
            
            return $query->result();
        }
    
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
    
    
    
        function addNewCenter($centerInfo)
        {
            $this->db->trans_start();
            $this->db->insert('tbl_centers', $centerInfo);
            
            $insert_id = $this->db->insert_id();
            
            $this->db->trans_complete();
            
            return $insert_id;
        }
    
    
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
    
    
   
        function editCenter($centerInfo, $centerId)
        {
            $this->db->where('centerId', $centerId);
            $this->db->update('tbl_centers', $centerInfo);
            
            return TRUE;
        }
           
        function deleteCenter($centerId, $centerInfo)
        {
            $this->db->where('centerId', $centerId);
            $this->db->update('tbl_centers', $centerInfo);
            
            return $this->db->affected_rows();
        }
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
        function changePassword($centerId, $centerInfo)
        {
            $this->db->where('centerId', $centerId);
            $this->db->where('isDeleted', 0);
            $this->db->update('tbl_centers', $centerInfo);
            
            return $this->db->affected_rows();
        }
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
		  
		  public function calculateDistance($lat1, $lon1, $lat2, $lon2) {
			 $R = 6371; // Radius of the Earth in kilometers
			 $toRadians = function($degree) {
				  return $degree * (pi() / 180); // Convert degrees to radians
			 };
		
			 $dLat = $toRadians($lat2 - $lat1);
			 $dLon = $toRadians($lon2 - $lon1);
		
			 $a = sin($dLat / 2) * sin($dLat / 2) +
					cos($toRadians($lat1)) * cos($toRadians($lat2)) *
					sin($dLon / 2) * sin($dLon / 2);
		
			 $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		
			 return $R * $c; // Distance in kilometers
		}

}
  