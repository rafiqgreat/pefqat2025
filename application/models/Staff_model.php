<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Staff_model extends CI_Model
{
	public function getCenterInfoById($cid)
	{
		$this->db->select('*');
		$this->db->from('tbl_examcenter');
		$this->db->join('tbl_district', 'district_id = cdistrict_id', 'left');
		$this->db->join('tbl_tehsil', 'tehsil_id = cteshil_id', 'left');
		$this->db->join('tbl_schools_sed', 'school_id = csedschool_id', 'left');
		$this->db->where('cid', $cid);
		$query = $this->db->get();
		return $query->row_array();
	}
	public function add_staff($centerInfo)
	{
		$this->db->trans_start();
		$this->db->insert('tbl_staff', $centerInfo);
		$insert_id = $this->db->insert_id();		
		$this->db->trans_complete();		
		return $insert_id;
	}
   
	public function edit_school($centerInfo, $centerId)
	{
		$this->db->where('centerId', $centerId);
		$this->db->update('tbl_centers', $centerInfo);
		return TRUE;
	}
	public function getStaffInfoById($cid)
	{
		$this->db->select('*');
		$this->db->from('tbl_staff');
		$this->db->where('staff_cid', $cid);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function check_personalno_exists($personalno) 
	{
		 // Query to check if personal number exists
		 $this->db->select('staff_personalno');
		 $this->db->from('tbl_staff');  // Replace with your actual table name
		 $this->db->where('staff_personalno', $personalno);
	
		 $query = $this->db->get();
	
		 // Return true if duplicate exists, false otherwise
		 if ($query->num_rows() > 0) {
			  return true;  // Duplicate found
		 } else {
			  return false; // No duplicate
		 }
	}
	public function check_personalno_exists_on_edit($personalno,$staff_cid) 
	{
		 // Query to check if personal number exists
		 $this->db->select('staff_personalno');
		 $this->db->from('tbl_staff');  // Replace with your actual table name
		 $this->db->where('staff_personalno', $personalno);
		 $this->db->where_not_in('staff_cid', [$staff_cid]); // Single value in array	
		 $query = $this->db->get();
	
		 // Return true if duplicate exists, false otherwise
		 if ($query->num_rows() > 0) {
			// print $this->db->last_query();die;
			  return true;  // Duplicate found
		 } else {
			  return false; // No duplicate
		 }
	}

}
  