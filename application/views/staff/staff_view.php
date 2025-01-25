<style>
td,th{
	border-color:#000000 !important;
}
</style>
<div class="content-wrapper"> 
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="row">
         <div class="col-lg-8"> <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">Center Staff Management</span>&nbsp;&nbsp; <small>View Staff</small> </div>
      </div>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
				<?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error)
            {
            ?>
               <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $this->session->flashdata('error'); ?> 
               </div>
            <?php 
				}  
				$success = $this->session->flashdata('success');
				if($success)
				{ ?>
               <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $this->session->flashdata('success'); ?> 
               </div>
            <?php } ?>
            <div class="row">
               <div class="col-md-12"> <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> </div>
            </div>
         </div>
      </div>
      
      <!-- Add School Form -->
      <div class="row">
         <div class="col-md-12">
            	<div class="row">
                  <div class="col-md-12">
                     <h3>Center Information</h3>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  	<table class="table-responsive table" style="width:100%" border="1" cellspacing="5" cellpadding="5">
                     	<tr>
                        	<th>Center ID</th>
                        	<th>District</th>
                           <th>Tehsil</th>
                           <th>Center SED School</th>
                           <th>PEP Schools</th>
                           <th>PEF Students Selected</th>
                        </tr>
                        <tr>
                        	<td><?php print $centerInfo['cid']; ?></td>
                        	<td><?php print $centerInfo['district_name_en']; ?></td>
                           <td><?php print $centerInfo['tehsil_name_en']; ?></td>
                           <td><?php print $centerInfo['school_name'].' ('.$centerInfo['username'].')'; ?></td>
                           <td><?php print $centerInfo['cpefschools_total']; ?></td>
                           <td><?php print $centerInfo['cpef_students_selected']; ?></td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <h3>Staff Information</h3>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  	<table class="table-responsive table" style="width:100%" border="1" cellspacing="5" cellpadding="5">
                     	<tr>
                        	<th>Sr#</th>
                           <th>Role</th>
                           <th>Name</th>
                           <th>Father Name</th>
                           <th>Personal Number</th>
                           <th>CNIC</th>                           
                           <th>Gender</th>
                           <th>Date of Birth</th>
                           <th>Email</th>
                           <th>Mobile Number</th>
                        </tr>
                        <?php 
								$i = 0;
								foreach($staffDetails as $staffDetail)
								{
									$i++;
								?>
                        <tr>
                        	<td><?php print $i; ?></td>
                           <td><?php print $staffDetail['staff_role']; ?></td>
                           <td><?php print $staffDetail['staff_name']; ?></td>
                           <td><?php print $staffDetail['staff_fathername']; ?></td>
                           <td><?php print $staffDetail['staff_personalno']; ?></td>
                           <td><?php print $staffDetail['staff_cnic']; ?></td>                           
                           <td><?php print $staffDetail['staff_gender']; ?></td>
                           <td><?php if($staffDetail['staff_dob'] != '0000-00-00 00:00:00')
										print date("m/d/Y", strtotime($staffDetail['staff_dob'])); ?></td>
                           <td><?php print $staffDetail['staff_email']; ?></td>
                           <td><?php if($staffDetail['staff_mobile'] != 0)
													print $staffDetail['staff_mobile']; ?></td>
                        </tr>
                        <?php 
								}
								?>
                     </table>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <a class="btn btn-sm btn-info btnmargin" href="<?php echo base_url() . 'staff/staff_edit/' .$centerInfo['cid']; ?>" title="Edit Staff">Edit Staff</a>
                  </div>
               </div>
               
         </div>
      </div>
   </section>
</div>
