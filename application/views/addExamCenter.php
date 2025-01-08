<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-8">
                <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">Exam Centers
                    Management</span>
                <small>Add New Center</small>
            </div>
            <!-- <div class="col-lg-4">

                <a href="<?= base_url().'Pef_School/export_pef_school_csv'; ?>" class="btn btn-success"
                    style="float:right;">
                    Export as CSV
                </a>
            </div> -->

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

        <!-- Add Exam Center Form -->
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="<?= base_url('Sed_School/addSchool') ?>">
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-3">
                            <label for="school_district_id">District</label>
                            <select name="school_district_id" id="school_district_id" class="form-control" required>
                                <option value="">Select District</option>
                                <?php foreach ($districts as $district): ?>
                                <option value="<?= $district->district_id; ?>"><?= $district->district_name_en; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="school_tehsil_id">Tehsil</label>
                            <select class="form-control" id="school_tehsil_id" name="school_tehsil_id">
                                <option value="">Select Tehsil</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="school_id">School</label>
                            <select class="form-control" id="school_id" name="school_id" required>
                                <option value="">Select School</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div id="school-details" class="mt-4" style="">
                            <h3>Selected School Details</h3>
                            <p><strong>School EMIS Code:</strong> <span id="school_id_display"></span></p>
                            <p><strong>School Name:</strong> <span id="school_name_display"></span></p>
                            <p><strong>School Address:</strong> <span id="school_address_display"></span></p>
                        </div>
                    </div>

                    <div class="container mt-5">
                        <h3 class="mb-3">Select PEF Schools to Appear</h3>
                        <!-- School Rows -->
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
									
									<label for="school_<?= $i ?>">School <?= $i ?>:</label>
                            <select class="form-control" name="pefschools[]" id="pefschool_<?= $i ?>" >
                                <option value="">Select PEF School</option>
                            </select>
                                   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="students_<?= $i ?>">Selected Students:</label>
                                    <input type="number" name="students_<?= $i ?>" id="students_<?= $i ?>"
                                        class="form-control" placeholder="Students count" readonly >
                                </div>
                            </div>                           
                        </div>
                        <?php endfor; ?>
                    </div>

                    <div class="form-row">
                        <button type="submit" class="btn btn-primary mt-3">Create Exam Center</button>
                        <a href="<?= base_url('Sed_School/SedschoolListing') ?>"
                            class="btn-lg btn-secondary mt-3">Cancel</a>
                    </div>

                </form>
            </div>
        </div>


</div>


</section>
</div>
<script>
// Update Tehsils dynamically based on selected District
$(document).ready(function() {
    $('#school_district_id').change(function() {
        var districtId = $(this).val();

        // Clear existing tehsil options
        $('#school_tehsil_id').html('<option value="">Select Tehsil</option>');

        if (districtId) {
            $.ajax({
                url: '<?php echo base_url("Sed_School/getTehsilsByDistrict"); ?>/' +
                    districtId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#school_tehsil_id').append('<option value="' + value
                                .tehsil_id + '">' + value.tehsil_name_en +
                                '</option>');
                        });
                    } else {
                        alert('No tehsils found for the selected district.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while fetching tehsil data: ' + error);
                }
            });
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $('#school_tehsil_id').change(function() {
        const tehsilId = $(this).val();
        if (tehsilId) {
			// get tehsil sed schools
            $.ajax({
                url: '<?= base_url("Sed_School/getSchoolsByTehsil") ?>',
                type: 'GET',
                data: {
                    tehsil_id: tehsilId
                },
                dataType: 'json',
                success: function(data) {
                    let schoolOptions = '<option value="">Select School</option>';
                    $.each(data, function(key, value) {
                        schoolOptions +=
                            `<option value="${value.school_id}">${value.username + "-" +value.school_name}</option>`;
                    });
                    $('#school_id').html(schoolOptions);
                },
                error: function() {
                    alert('Error fetching schools. Please try again.');
                }
            });
			// get tehsil pef schools
			 $.ajax({
                url: '<?= base_url("center/getPefSchoolsByTehsil") ?>',
                type: 'GET',
                data: {
                    tehsil_id: tehsilId
                },
                dataType: 'json',
                success: function(data) {
                    let schoolOptions = '<option value="">Select PEF School</option>';
                    $.each(data, function(key, value) {
                        schoolOptions +=
                            `<option value="${value.s_id}">${value.username + "-" +value.s_name}</option>`;
                    });
					
					var ctrPefSchools = <?=$i; ?>;
					for(var x=0;x<ctrPefSchools;x++)
						{
							$('#pefschool_'+x).html(schoolOptions);
						}
					
                    
                },
                error: function() {
                    alert('Error fetching schools. Please try again.');
                }
            });
			
        } else {
            $('#school_id').html('<option value="">Select School</option>');
        }
    });
    // Fetch and display school details based on selected school
    // Fetch and display school details based on selected school
    $('#school_id').change(function() {
        const schoolId = $(this).val();
        if (schoolId) {
            $.ajax({
                url: '<?= base_url("Sed_School/getSchoolsById") ?>',
                type: 'GET',
                data: {
                    school_id: schoolId
                },
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        // Display the school details
                        $('#school_id_display').text(data.username);
                        $('#school_name_display').text(data.school_name);
                        $('#school_address_display').text(data.school_address);
                        // Ensure the school details section is shown
                        $('#school-details').show();
                    } else {
                        // Clear the values if no data is found
                        $('#school_id_display').text('');
                        $('#school_name_display').text('');
                        $('#school_address_display').text('');
                        alert('No details found for the selected school.');
                    }
                },
                error: function() {
                    alert('Error fetching school details. Please try again.');
                }
            });
        } else {
            // Clear the values and keep the labels visible
            $('#school_id_display').text('');
            $('#school_name_display').text('');
            $('#school_address_display').text('');
            // Show the labels even when no school is selected
            $('#school-details').show();
        }
    });


});
</script>