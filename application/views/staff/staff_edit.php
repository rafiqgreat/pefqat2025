<style>
td,th{
	border-color:#000000 !important;
}
</style>
<div class="content-wrapper"> 
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="row">
         <div class="col-lg-8"> <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">Center Staff Management</span>&nbsp;&nbsp; <small>Edit Staff</small> </div>
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
            <form method="POST" action="<?= base_url('staff/staff_edit/'.$centerInfo['cid']) ?>">
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
					<?php
					$i = 0;
               foreach($staffDetails as $staffDetail)
               { 
						$i++;
					?>
                  <div class="row">
                     <div class="col-md-12">
                        <h3><?php print $staffDetail['staff_role'];?> Information</h3>
                        <input type="hidden" name="staff_role[]" value="<?php print $staffDetail['staff_role'];?>" />
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="staff_personalno">Personal Number *:</label>
                           <input type="number" min="0" name="staff_personalno[]" id="staff_personalno<?php print $i;?>" value="<?php print $staffDetail['staff_personalno'];?>" class="form-control" placeholder="Personal Number" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="staff_cnic">CNIC *:</label>
                           <input type="text" name="staff_cnic[]" id="staff_cnic<?php print $i;?>" class="form-control" value="<?php print $staffDetail['staff_cnic'];?>" placeholder="CNIC" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="staff_name">Name*:</label>
                           <input type="text" name="staff_name[]" id="staff_name<?php print $i;?>" class="form-control" value="<?php print $staffDetail['staff_name'];?>" placeholder="Name" required>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="s_name">Father Name:</label>
                           <input type="text" name="staff_fathername[]" id="staff_fathername<?php print $i;?>" class="form-control" value="<?php print $staffDetail['staff_fathername'];?>" placeholder="Father Name">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="staff_gender">Gender:</label>
                           <select name="staff_gender[]" class="form-control" id="staff_gender<?php print $i;?>" required>
                              <option <?php if($staffDetail['staff_gender'] == 'Male'){print 'selected="selected"';}?> value="Male">Male</option>
                              <option <?php if($staffDetail['staff_gender'] == 'Female'){print 'selected="selected"';}?> value="Female">Female</option>
                              <option <?php if($staffDetail['staff_gender'] == 'Other'){print 'selected="selected"';}?> value="Other">Other</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="staff_dob">Date of Birth:</label>
                           <?php $value = isset($staffDetail['staff_dob']) ? date('Y-m-d', strtotime($staffDetail['staff_dob'])) : ''; ?>
                           <input type="date" name="staff_dob[]" id="staff_dob<?php print $i;?>" value="<?php echo $value; ?>" class="form-control" placeholder="Date of Birth">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="staff_email">Email:</label>
                           <input type="text" name="staff_email[]" id="staff_email<?php print $i;?>" value="<?php print $staffDetail['staff_email'];?>" class="form-control" placeholder="Email">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="staff_mobile">Mobile Number:</label>
                           <input type="number" min="0" name="staff_mobile[]" id="staff_mobile<?php print $i;?>" value="<?php print $staffDetail['staff_mobile'];?>" class="form-control" placeholder ="Mobile Number">
                        </div>
                     </div>
                  </div>
               <?php		
               }
					?>
               <input type="submit" name="submit" class="btn btn-primary mt-3" value="Edit Staff" />
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
    $i = 0;
    foreach($staffDetails as $staffDetail) { 
        $i++;
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
                url: '<?php echo base_url("staff/check_duplicate_personalno_on_edit"); ?>', // Backend URL for duplicate check
                type: 'POST',
                data: {
                    personalno: personal,
						  staff_cid: <?php print $centerInfo['cid'];?>
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
    <?php } ?>
});
</script>



