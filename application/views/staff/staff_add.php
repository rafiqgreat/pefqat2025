<style>
td,
th {
    border-color: #000000 !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-8"> <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">Center
                    Staff Management</span>&nbsp;&nbsp; <small>Add Staff</small> </div>
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
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add School Form -->
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="<?= base_url('staff/staff_add/'.$centerInfo['cid']) ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Center Information</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table-responsive table" style="width:100%" border="1" cellspacing="5"
                                cellpadding="5">
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
                            <h3>Resident Inspector Information</h3>
                            <input type="hidden" name="staff_role[]" value="Resident Inspector" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_personalno">Teacher Salary Slip Personal No. *:</label>
                                <input type="number" min="0" name="staff_personalno[]" id="staff_personalno1"
                                    class="form-control" placeholder="Teacher Salary Slip Personal No." required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_cnic">CNIC *:(Auto fill)</label>
                                <input type="text" name="staff_cnic[]" id="staff_cnic1" class="form-control"
                                    placeholder="CNIC" required readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_name">Name *:(Auto fill)</label>
                                <input type="text" name="staff_name[]" id="staff_name1" class="form-control"
                                    placeholder="Name" required readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="s_name">Father/Husband Name:</label>
                                <input type="text" name="staff_fathername[]" id="staff_fathername1" class="form-control"
                                    placeholder="Father/Husband Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_gender">Gender:(Auto fill)</label>
                                <select name="staff_gender[]" class="form-control" id="staff_gender1" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_dob">Date of Birth:</label>
                                <input type="date" name="staff_dob[]" id="staff_dob1" class="form-control"
                                    placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_email">Email:(Auto fill)</label>
                                <input type="text" name="staff_email[]" id="staff_email1" class="form-control"
                                    placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_mobile">Mobile Number:(Auto fill - can change to new one) </label>
                                <input type="number" min="0" name="staff_mobile[]" id="staff_mobile1" class="form-control"
                                    placeholder="Mobile Number">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Supervisor Information</h3>
                            <input type="hidden" name="staff_role[]" value="Supervisor" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_personalno">Teacher Salary Slip Personal No. *:</label>
                                <input type="number" min="0" name="staff_personalno[]" id="staff_personalno2"
                                    class="form-control" placeholder="Teacher Salary Slip Personal No." required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_cnic">CNIC *:</label>
                                <input type="text" name="staff_cnic[]" id="staff_cnic2" class="form-control"
                                    placeholder="CNIC" required readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_name">Name *:</label>
                                <input type="text" name="staff_name[]" id="staff_name2" class="form-control"
                                    placeholder="Name" required readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="s_name">Father Name:</label>
                                <input type="text" name="staff_fathername[]" id="staff_fathername2"
                                    class="form-control" placeholder="Father Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_gender">Gender:</label>
                                <select name="staff_gender[]" class="form-control" id="staff_gender2" required readonly>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_dob">Date of Birth:</label>
                                <input type="date" name="staff_dob[]" id="staff_dob2" class="form-control"
                                    placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_email">Email:</label>
                                <input type="text" name="staff_email[]" id="staff_email2" class="form-control"
                                    placeholder="Email" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_mobile">Mobile Number:</label>
                                <input type="number" min="0" name="staff_mobile[]" id="staff_mobile2"
                                    class="form-control" placeholder="Mobile Number">
                            </div>
                        </div>
                    </div>

                    <?php
					if($centerInfo['cpef_students_selected'] != 0 && $centerInfo['cpef_students_selected'] != '')
					{
						$numberOfInvigilator = ceil($centerInfo['cpef_students_selected']/40)-1;
						?>
                    <input type="hidden" name="numberOfInvigilator" value="<?= $numberOfInvigilator ?>" />
                    <?php
						for($i = 1; $i <= $numberOfInvigilator; $i++)
						{ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Invigilator <?= $i;?> Information</h3>
                            <input type="hidden" name="staff_role[]" value="Invigilator <?= $i;?>" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_personalno">Teacher Salary Slip Personal No. *:</label>
                                <input type="number" min="0" name="staff_personalno[]"
                                    id="staff_personalno<?= $i+2;?>" class="form-control"
                                    placeholder="Teacher Salary Slip Personal No." required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_cnic">CNIC * (auto fill):</label>
                                <input type="text" name="staff_cnic[]" id="staff_cnic<?= $i+2;?>"
                                    class="form-control" placeholder="CNIC" required readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_name">Name*: (auto fill)</label>
                                <input type="text" name="staff_name[]" id="staff_name<?= $i+2;?>"
                                    class="form-control" placeholder="Name" required readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="s_name">Father Name:</label>
                                <input type="text" name="staff_fathername[]"
                                    id="staff_fathername<?= $i+2;?>" class="form-control" placeholder="Father Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_gender">Gender: (auto fill)</label>
                                <select name="staff_gender[]" class="form-control"
                                    id="staff_gender<?= $i+2;?>" required readonly>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_dob">Date of Birth:</label>
                                <input type="date" name="staff_dob[]" id="staff_dob<?= $i+2;?>"
                                    class="form-control" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_email">Email: (auto fill)</label>
                                <input type="text" name="staff_email[]" id="staff_email<?= $i+2;?>"
                                    class="form-control" placeholder="Email" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="staff_mobile">Mobile Number: (auto fill / can change to
                                    new)</label>
                                <input type="number" min="0" name="staff_mobile[]"
                                    id="staff_mobile<?= $i+2;?>" class="form-control" placeholder="Mobile Number">
                            </div>
                        </div>
                    </div>
                    <?php		
						}
					}
					?>
                    <input type="submit" name="submit" class="btn btn-primary mt-3" value="Add Staff" />
                    <a href="<?= base_url('Center/centerListing') ?>" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
// Store all entered personal numbers to check for duplicates
$(document).ready(function() {
    <?php 
		$numberOfInvigilator = ceil($centerInfo['cpef_students_selected']/40)-1;
		
		for($i = 1; $i <= $numberOfInvigilator+2; $i++)
		{
		 ?>
		 $('#staff_personalno<?php print $i; ?>').blur(function() {
			  const personal = $(this).val().trim();
			  const currentField = $(this);
	
			  if (personal) {
					// Check if the personal number is already present in other input fields
					let isDuplicate = false;
					$('input[id^="staff_personalno"]').each(function() {
						 if ($(this).val().trim() === personal && !$(this).is(currentField)) {
							  isDuplicate = true;
							  return false; // Break the loop
						 }
					});
	
					if (isDuplicate) {
						 alert('Duplicate Personal Number found in another field.');
						 clearSpecificFields(currentField); // Clear only the current input's fields
						 return; // Stop further processing
					}
	
					// Check if the number exists in the database
					$.ajax({
						 url: '<?php echo base_url("staff/check_duplicate_personalno"); ?>', // Backend URL for duplicate check
						 type: 'POST',
						 data: {
							  personalno: personal
						 },
						 dataType: 'json',
						 success: function(response) {
							  if (response.status === 'duplicate') {
									alert('This Teacher already assigned.');
									clearSpecificFields(currentField); // Clear only the current input's fields
							  } else {
									// Fetch additional details from external API if no duplicate
									fetchTeacherDetails(personal, currentField);
							  }
						 },
						 error: function(xhr, status, error) {
							  alert('Error checking for duplicate Personal Number. Please try again.');
							  clearSpecificFields(currentField); // Clear only the current input's fields
						 }
					});
			  }
		 });
	
		 // Function to fetch teacher details from the external API
		 function fetchTeacherDetails(personal, currentField) {
			  $.ajax({
					url: 'https://www.sis.pesrp.edu.pk.educationservices.pk/api/verification.php',
					type: 'GET',
					data: {
						 personal: personal
					},
					dataType: 'json',
					success: function(response) {
						 if (response && response.status === "success" && response.data) {
							  // Populate the fields with the fetched data
							  const data = response.data;
							  const currentId = currentField.attr('id').replace('staff_personalno', '');
							  $('#staff_cnic' + currentId).val(data.teacher_cnic);
							  $('#staff_name' + currentId).val(data.teacher_name);
							  $('#staff_gender' + currentId).val(data.teacher_gender);
							  $('#staff_email' + currentId).val(data.teacher_email);
							  $('#staff_mobile' + currentId).val(data.teacher_mobile);
						 } else {
							  alert('No teacher found.');
							  clearSpecificFields(currentField); // Clear only the current input's fields
						 }
					},
					error: function(xhr, status, error) {
						 alert('Error fetching teacher details. Please try again.');
						 clearSpecificFields(currentField); // Clear only the current input's fields
					}
			  });
		 }
	
		 // Function to clear specific fields
		 function clearSpecificFields(field) {
			  const currentId = field.attr('id').replace('staff_personalno', '');
			  $('#staff_personalno' + currentId).val('');
			  $('#staff_cnic' + currentId).val('');
			  $('#staff_name' + currentId).val('');
			  $('#staff_gender' + inputId).val('Male').change();
			  $('#staff_email' + currentId).val('');
			  $('#staff_mobile' + currentId).val('');
		 }
    <?php 
	 } ?>
});
</script>
