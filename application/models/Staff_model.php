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
}
  