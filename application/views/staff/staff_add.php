<style>
td,th{
	border-color:#000000 !important;
}
</style>
<div class="content-wrapper"> 
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="row">
         <div class="col-lg-8"> <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">Center Staff Management</span>&nbsp;&nbsp; <small>Add Staff</small> </div>
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
            <form method="POST" action="<?= base_url('staff/staff_add/'.$centerInfo['cid']) ?>">
            	<div class="row">
                  <div class="col-md-12">
                     <h3>Center Information</h3>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  	<table class="table-responsive table" style="width:100%" border="1" cellspacing="5" cellpadding="5">
                     	<tr>
                        	<th>District</th>
                           <th>Tehsil</th>
                           <th>Center SED School</th>
                           <th>PEP Schools</th>
                           <th>PEF Students Available</th>
                           <th>PEF Students Selected</th>
                        </tr>
                        <tr>
                        	<td><?php print $centerInfo['district_name_en']; ?></td>
                           <td><?php print $centerInfo['tehsil_name_en']; ?></td>
                           <td><?php print $centerInfo['school_name'].' ('.$centerInfo['username'].')'; ?></td>
                           <td><?php print $centerInfo['cpefschools_total']; ?></td>
                           <td><?php print $centerInfo['cpef_students_avail']; ?></td>
                           <td><?php print $centerInfo['cpef_students_selected']; ?></td>
                        </tr>
                     </table>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <h3>Resident Inspector Information</h3>
                     <input type="hidden" name="staff_role" value="Resident Inspector" />
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="staff_personalno">Teacher Salary Slip Personal No. *:</label>
                        <input type="number" min="0" name="staff_personalno" id="staff_personalno" class="form-control" placeholder="Teacher Salary Slip Personal No." required>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="staff_cnic">CNIC *:(Auto fill)</label>
                        <input type="text" name="staff_cnic" id="staff_cnic" class="form-control" placeholder="CNIC" required readonly>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="staff_name">Name *:(Auto fill)</label>
                        <input type="text" name="staff_name" id="staff_name" class="form-control" placeholder="Name" required readonly>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="s_name">Father/Husband Name:</label>
                        <input type="text" name="staff_fathername" id="staff_fathername" class="form-control" placeholder="Father/Husband Name" required>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="staff_gender">Gender:(Auto fill)</label>
                        <select name="staff_gender" class="form-control" id="staff_gender" required>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                           <option value="Other">Other</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="staff_dob">Date of Birth:</label>
                        <input type="date" name="staff_dob" id="staff_dob" class="form-control" placeholder="Date of Birth">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="staff_email">Email:(Auto fill)</label>
                        <input type="text" name="staff_email" id="staff_email" class="form-control" placeholder="Email">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="staff_mobile">Mobile Number:(Auto fill - can change to new one) </label>
                        <input type="number" min="0" name="staff_mobile" id="staff_mobile" class="form-control" placeholder ="Mobile Number">
                     </div>
                  </div>
               </div>
               
               <div class="row">
                  <div class="col-md-12">
                     <h3>Supervisor Information</h3>
                     <input type="hidden" name="sup_staff_role" value="Supervisor" />
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="sup_staff_personalno">Teacher Salary Slip Personal No. *:</label>
                        <input type="number" min="0" name="sup_staff_personalno" id="sup_staff_personalno" class="form-control" placeholder="Teacher Salary Slip Personal No." required>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="sup_staff_cnic">CNIC *:</label>
                        <input type="text" name="sup_staff_cnic" id="sup_staff_cnic" class="form-control" placeholder="CNIC" required>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="sup_staff_name">Name *:</label>
                        <input type="text" name="sup_staff_name" id="sup_staff_name" class="form-control" placeholder="Name" required>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="s_name">Father Name:</label>
                        <input type="text" name="sup_staff_fathername" id="sup_staff_fathername" class="form-control" placeholder="Father Name">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="sup_staff_gender">Gender:</label>
                        <select name="sup_staff_gender" class="form-control" id="sup_staff_gender" required>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                           <option value="Other">Other</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="sup_staff_dob">Date of Birth:</label>
                        <input type="date" name="sup_staff_dob" id="sup_staff_dob" class="form-control" placeholder="Date of Birth">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="sup_staff_email">Email:</label>
                        <input type="text" name="sup_staff_email" id="sup_staff_email" class="form-control" placeholder="Email">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="sup_staff_mobile">Mobile Number:</label>
                        <input type="number" min="0" name="sup_staff_mobile" id="sup_staff_mobile" class="form-control" placeholder ="Mobile Number">
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
                           <input type="hidden" name="inv<?= $i;?>_staff_role" value="Invigilator <?= $i;?>" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="inv<?= $i;?>_staff_personalno">Teacher Salary Slip Personal No. *:</label>
                              <input type="number" min="0" name="inv<?= $i;?>_staff_personalno" id="inv<?= $i;?>_staff_personalno" class="form-control" placeholder="Teacher Salary Slip Personal No." required>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="inv<?= $i;?>_staff_cnic">CNIC * (auto fill):</label>
                              <input type="text" name="inv<?= $i;?>_staff_cnic" id="inv<?= $i;?>_staff_cnic" class="form-control" placeholder="CNIC" required>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="inv<?= $i;?>_staff_name">Name*: (auto fill)</label>
                              <input type="text" name="inv<?= $i;?>_staff_name" id="inv<?= $i;?>_staff_name" class="form-control" placeholder="Name" required>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="s_name">Father Name:</label>
                              <input type="text" name="inv<?= $i;?>_staff_fathername" id="inv<?= $i;?>_staff_fathername" class="form-control" placeholder="Father Name">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="inv<?= $i;?>_staff_gender">Gender: (auto fill)</label>
                              <select name="inv<?= $i;?>_staff_gender" class="form-control" id="inv<?= $i;?>_staff_gender" required>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                                 <option value="Other">Other</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="inv<?= $i;?>_staff_dob">Date of Birth:</label>
                              <input type="date" name="inv<?= $i;?>_staff_dob" id="inv<?= $i;?>_staff_dob" class="form-control" placeholder="Date of Birth">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="inv<?= $i;?>_staff_email">Email: (auto fill)</label>
                              <input type="text" name="inv<?= $i;?>_staff_email" id="inv<?= $i;?>_staff_email" class="form-control" placeholder="Email">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="inv<?= $i;?>_staff_mobile">Mobile Number: (auto fill / can change to new</label>
                              <input type="number" min="0" name="inv<?= $i;?>_staff_mobile" id="inv<?= $i;?>_staff_mobile" class="form-control" placeholder ="Mobile Number">
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
// Update Tehsils dynamically based on selected District
$(document).ready(function() {
   
	$('#staff_personalno').blur(function() {
    const personal = $(this).val();
    if (personal) {
        $.ajax({
            url: '<?php echo "https://www.sis.pesrp.edu.pk.educationservices.pk/api/verification.php"; ?>',
            type: 'GET',
            data: {
                personal: personal
            },
            dataType: 'json', // Automatically parses the JSON response
            success: function(response) {
                if (response && response.status === "success" && response.data) {
                    // Populate the fields with data
                    const data = response.data;
                    $('#staff_cnic').val(data.teacher_cnic);
					 $('#staff_name').val(data.teacher_name);
					 $('#staff_gender').val(data.teacher_gender);
					 $('#staff_email').val(data.teacher_email);
					 $('#staff_mobile').val(data.teacher_mobile);
                    // Populate other fields as needed
                } else {
                    // Handle case where no data is returned
                    $('#staff_cnic').val('');
					 $('#staff_name').val('');
					 $('#staff_gender').val('');
					 $('#staff_email').val('');
					 $('#staff_mobile').val('');
                    alert('No teacher found.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                console.log("Response Text: ", xhr.responseText); // Log the response for debugging
                alert('Error fetching teacher details. Please try again.');
            }
        });
    } else {
        // Clear the values if no personal number is entered
        $('#staff_cnic').val('');
    }
});

	
 
});
</script>