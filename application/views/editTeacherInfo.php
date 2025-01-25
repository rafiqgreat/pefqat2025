<?php echo $schoolInfo->school_id; ?><div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> School Teacher Assignment Panel
        <small>Add / Edit Teacher</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">School Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url() ?>updateSchool" method="post" id="editSchool" role="form" onSubmit="return checkGender();">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="school_id">School ID</label>
                                        <input type="text" class="form-control" id="school_id" placeholder="School ID" name="school_id" value="<?php echo $schoolInfo->school_id; ?>" readonly >   
										<input type="hidden" name="school_id" id="school_id" value="<?php echo $schoolInfo->school_id; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_lsacode">School LSA Code</label>
                                        <input type="text" class="form-control" id="school_lsacode" placeholder="School LSA Code" name="school_lsacode" value="<?php echo $schoolInfo->school_lsacode; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_emis">EMIS Code</label>
                                        <input type="text" class="form-control" id="school_emis" placeholder="EMIS Code" name="school_emis" value="<?php echo $schoolInfo->school_emis; ?>" readonly>
                                    </div>
                                </div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_lsagrade">School LSA Grade</label>
                                        <input type="text" class="form-control" id="school_lsagrade" placeholder="School LSA Grade" name="school_lsagrade" value="<?php echo $schoolInfo->school_lsagrade; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_district">District</label>
                                        <input type="text" class="form-control" id="school_district" placeholder="District" name="school_district" value="<?php echo $schoolInfo->school_district; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="Tehsil">Tehsil</label>
                                        <input type="text" class="form-control" id="school_tehsil" placeholder="Tehsil" name="school_tehsil" value="<?php echo $schoolInfo->school_tehsil; ?>" readonly>
                                    </div>
                                </div>
								<div class="col-md-3">
                                     <div class="form-group">
                                        <label for="school_level">School Level</label>
                                        <input type="text" class="form-control" id="school_level" placeholder="School Level" name="school_level" value="<?php echo $schoolInfo->school_level; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="school_level">School Gender</label>
                                        <input type="text" class="form-control" id="school_gender" placeholder="School Gender" name="school_gender" value="<?php echo $schoolInfo->school_gender; ?>" readonly>
                                    </div>
                                </div>
							</div>
							<div class="row">
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="school_name">School Name</label>
                                        <input type="text" class="form-control" id="school_name" placeholder="School Name" name="school_name" value="<?php echo $schoolInfo->school_name; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="school_address">School Address</label>
                                        <input type="text" class="form-control" id="school_address" placeholder="School Address" name="school_address" value="<?php echo $schoolInfo->school_address; ?>" readonly>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="school_head">Head / Owner Name</label>
                                        <input type="text" class="form-control" id="school_head" placeholder="Head / Owner Name" name="school_head" value="<?php echo $schoolInfo->school_head; ?>" readonly>
                                    </div>
                                </div>
								<div class="col-md-3">
                                     <div class="form-group">
                                        <label for="school_headmobile">Head / Owner Name</label>
                                        <input type="text" class="form-control" id="school_headmobile" placeholder="Head / Owner Name" name="school_headmobile" value="<?php echo $schoolInfo->school_headmobile; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="school_phone">School Phone #</label>
                                        <input type="text" class="form-control" id="school_phone" placeholder="School Phone #" name="school_phone" value="<?php echo $schoolInfo->school_phone; ?>" readonly>
                                    </div>
                                </div>
								 <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="school_enrollment">School Enrollment</label>
                                        <input type="text" class="form-control" id="school_enrollment" placeholder="School Enrollment" name="school_enrollment" value="<?php echo $schoolInfo->school_enrollment; ?>" readonly>
                                    </div>
                                </div>
							</div>
							 <div class="row">
                                <div class="col-md-12"><h4 class="box-title">Teacher Assigned Information</h4> </div> 
							</div>
							<div class="row">
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="Name_of_TA">Teacher Name</label>
                                        <input type="text" class="form-control" id="Name_of_TA" placeholder="Teacher Name" name="Name_of_TA" value="<?php echo $schoolInfo->Name_of_TA; ?>" required >
                                    </div>
                                </div>
								<div class="col-md-3">
                                     <div class="form-group">
                                        <label for="Designation">Designation</label>
                                        <input type="text" class="form-control" id="Designation" placeholder="Designation" name="Designation" value="<?php echo $schoolInfo->Designation; ?>" required >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="Gender">Gender</label>
                                        <select class="form-control required" id="Gender" name="Gender">
                                            <option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
                                    </div>
                                </div>
								<div class="col-md-3">
                                     <div class="form-group">
                                        <label for="CNIC">Teacher CNIC</label>
                                        <input type="text" class="form-control" id="CNIC" placeholder="CNIC" name="CNIC" value="<?php echo $schoolInfo->CNIC; ?>" required >
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="Cell_No">Cell No.</label>
                                        <input type="text" class="form-control" id="Cell_No" placeholder="Cell No" name="Cell_No" value="<?php echo $schoolInfo->Cell_No; ?>" required >
                                    </div>
                                </div>
								<div class="col-md-3">
                                     <div class="form-group">
                                        <label for="Father_Name_as_per_CNIC">Father Name as per CNIC</label>
                                        <input type="text" class="form-control" id="Father_Name_as_per_CNIC" placeholder="Father Name" name="Father_Name_as_per_CNIC" value="<?php echo $schoolInfo->Father_Name_as_per_CNIC; ?>" required >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label for="DOB_as_per_CNIC">DOB as per CNIC</label>
                                        <input type="date" class="form-control" id="DOB_as_per_CNIC" placeholder="DOB" name="DOB_as_per_CNIC" value="<?php echo $schoolInfo->DOB_as_per_CNIC; ?>" required >
                                    </div>
                                </div>
								<div class="col-md-3">
                                     <div class="form-group">
                                        <label for="Place_of_Posting">Place of Posting</label>
                                        <input type="text" class="form-control" id="Place_of_Posting" placeholder="Place of Posting" name="Place_of_Posting" value="<?php echo $schoolInfo->Place_of_Posting; ?>" required >
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>
<script type="text/javascript">
document.getElementById('school_district').value = "<?php echo $schoolInfo->school_district; ?>";
document.getElementById('Gender').value = "<?php if($schoolInfo->Gender!= ''){ echo $schoolInfo->Gender;}else{echo 'Male';} ?>";
function checkGender()
{
	if(document.getElementById('Sch_Type').value!='' && document.getElementById('Sch_Type').value !== document.getElementById('Gender').value)
	{
		alert('Teacher Gender and School Type Gender must be same i.e.(Male can be appointed to male school or vice versa!)');
		return false;
	}
	else
		return true;
}
</script>
