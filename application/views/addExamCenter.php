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
                <form id="examcenterfrm" method="POST" action="<?= base_url('center/addNewCenter') ?>">
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
                            <?php if ($this->session->userdata('role') == 2) { ?>
                            <input type="hidden" name="school_district_id" id="school_district_id_hidden"
                                value="<?= $this->session->userdata('district'); ?>">
                            <?php } ?>
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
                            <p><strong>School EMIS Code:</strong> <span id="school_id_display"></span> &nbsp; &nbsp;
                                <strong>School Name:</strong> <span id="school_name_display"></span> &nbsp; &nbsp;
                                <strong>School Address:</strong> <span id="school_address_display"></span> &nbsp; &nbsp;
                                <strong>GPS Latitude:</strong> <span id="school_gps1_display"></span> &nbsp; &nbsp;
                                <strong>GPS Longitude:</strong> <span id="school_gps2_display"></span>
                            </p>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <h3 class="mb-3">Select PEF Schools to Appear</h3>
                        <!-- School Rows -->
                        <?php for ($i = 1; $i <= 10; $i++): ?>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="school_<?= $i ?>">School <?= $i ?>:</label>
                                    <!-- <select class="form-control pefschool" name="pefschools_<?= $i ?>" -->
                                    <select class="form-control pefschool" name="pefschools[]>"
                                        id="pefschool_<?= $i ?>">
                                        <option value="">Select PEF School</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="students_<?= $i ?>">Selected Students:</label>
                                    <input type="number" name="students_<?= $i ?>" id="students_<?= $i ?>"
                                        class="form-control pefcount" placeholder="Students count" readonly>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h4>Total Students:</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="number" name="total_students" id="total_students" class="form-control"
                                    placeholder="total_students" readonly>
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary mt-3">Create Exam Center</button>
                        <a href="<?= base_url('center/centerListing') ?>" class="btn-lg btn-secondary mt-3">Cancel</a>
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

        } else {
            $('#school_id').html('<option value="">Select School</option>');
        }
    });
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
                    if (data) 
						  {
                        // Display the school details
                        $('#school_id_display').text(data.username);
                        $('#school_name_display').text(data.school_name);
                        $('#school_address_display').text(data.school_address);
                        $('#school_gps1_display').text(data.school_lat);
                        $('#school_gps2_display').text(data.school_lon);
                        // Ensure the school details section is shown
                        $('#school-details').show();
                        ////////////////////////////////////////////////////////////////
                        // get tehsil pef schools
                        $.ajax({
                            url: '<?= base_url("center/getPefSchoolsByTehsil") ?>',
                            type: 'GET',
                            data: {
                                tehsil_id: $('#school_tehsil_id').val()
                            },
                            dataType: 'json',
                            success: function(data) {
                                let schoolOptions =
                                    '<option value="">Select PEF School</option>';
                                $.each(data, function(key, value) {

                                    /////////////////////////

                                    const lat1 = parseFloat($(
                                            '#school_gps1_display')
                                        .text()) || 0;
                                    const lon1 = parseFloat($(
                                            '#school_gps2_display')
                                        .text()) || 0;
                                    const lat2 = parseFloat(value
                                        .s_lat) || 0;
                                    const lon2 = parseFloat(value
                                        .s_long) || 0;

                                    console.log('School_id:', value
                                        .s_id, 'lat1:', lat1,
                                        'lon1:', lon1, 'lat2:',
                                        lat2, 'lon2:', lon2);

                                    let distance = calculateDistance(
                                        lat1, lon1, lat2, lon2);
                                    if (isNaN(distance)) {
                                        distance = 'Undefined';
                                    } else if (distance > 500) {
                                        distance = 'Undefined';
                                    } else {
                                        distance =
                                            `${distance.toFixed(2)} KM`;
                                    }

                                    schoolOptions +=
                                        `<option value="${value.s_id}">${value.username + "-" + value.s_name + "-" + distance}</option>`;
                                    ////////////////////		


                                });

                                var ctrPefSchools = <?=$i; ?>;
                                for (var x = 0; x < ctrPefSchools; x++) {
                                    $('#pefschool_' + x).html(schoolOptions);
												$('#students_' + x).val('');
                                }
										  $('#total_students').val('');
                            },
                            error: function() {
                                alert(
                                    'Error fetching schools. Please try again.'
                                );
                            }
                        });


                        ////////////////////////////////
                    } 
						  else 
						  {
                        // Clear the values if no data is found
                        $('#school_id_display').text('');
                        $('#school_name_display').text('');
                        $('#school_address_display').text('');
                        $('#school_gps1_display').text('');
                        $('#school_gps2_display').text('');
                        alert('No details found for the selected school.');
                    }
                },
                error: function() {
                    alert('Error fetching school details. Please try again.');
                }
            });
        } else 
		  {
			  let schoolOptions = '<option value="">Select PEF School</option>';
				var ctrPefSchools = <?=$i; ?>;
				for (var x = 0; x < ctrPefSchools; x++) {
					$('#pefschool_' + x).html(schoolOptions);
					$('#students_' + x).val('');
				}
				$('#total_students').val('');
            // Clear the values and keep the labels visible
            $('#school_id_display').text('');
            $('#school_name_display').text('');
            $('#school_address_display').text('');
				$('#school_gps1_display').text('');
				$('#school_gps2_display').text('');
            // Show the labels even when no school is selected
            $('#school-details').show();
        }
    });


    $(document).ready(function() {
        // Delegate the change event to dynamically added .pefschool elements
        $(document).on('change', '.pefschool', function () {
				 const schoolId = $(this).val();
				 const schoolName = $(this).find('option:selected').text().trim(); // Get the selected school's name and trim spaces
				 const index = $(this).attr('id').split('_')[1];
			
				 // Check for duplicate selection, ignoring empty or default values
				 if (schoolId) {
					  let isDuplicate = false;
			
					  $('.pefschool').each(function () {
							if ($(this).val() && $(this).val() === schoolId && $(this).attr('id') !== `pefschool_${index}`) {
								 isDuplicate = true;
								 return false; // Exit loop if a duplicate is found
							}
					  });
			
					  if (isDuplicate) {
							alert(`The school "${schoolName}" has already been selected! Please choose a different school.`);
							$('#pefschool_' + index).val(''); // Reset the dropdown to its default state
							$('#students_' + index).val('');
							calculateTotalStudents(); // Recalculate the total after resetting
							return; // Exit the function
					  }
			
					  // Fetch and update data for the selected school
					  $.ajax({
							url: '<?= base_url("Center/get_total_selected") ?>',
							type: 'POST',
							data: {
								 school_id: schoolId
							},
							dataType: 'json',
							success: function (data) {
								 if (data) {
									  // Update the student count for the selected school
									  $('#students_' + index).val(data.total_selected);
			
									  // Recalculate the total number of students
									  calculateTotalStudents();
			
									  // Check if the total exceeds 280
									  const totalStudents = parseInt($('#total_students').val());
									  if (totalStudents > 260) {
											alert(`The total number of students (${totalStudents}) exceeds the limit of 260. Please select fewer students.`);
											$('#pefschool_' + index).val(''); // Reset the dropdown to its default state
											$('#students_' + index).val('');
											calculateTotalStudents(); // Recalculate the total after resetting
									  }
								 }
							},
							error: function () {
								 alert('Error fetching Students details. Please try again.');
							}
					  });
				 } else {
					  // Clear the student count if no school is selected
					  $('#students_' + index).val('');
					  calculateTotalStudents();
				 }
			});

			
			// Function to calculate the total number of students
			function calculateTotalStudents() {
				 let total = 0;
				 $('.pefcount').each(function () {
					  let value = parseInt($(this).val()) || 0;
					  total += value;
				 });
			
				 // Update the total_students field
				 $('#total_students').val(total);
			}


        // Trigger recalculation whenever .pefcount values change dynamically
        $(document).on('input', '.pefcount', function() {
            calculateTotalStudents();
        });
    });



    <?php if ($this->session->userdata('role') == 2) { ?>
    $('#school_district_id').val(<?= $this->session->userdata('district'); ?>);
    var districtId = <?= $this->session->userdata('district'); ?>;
    $('#school_district_id').attr('disabled', true);
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
    <?php } ?>

});

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radius of the Earth in kilometers
    const toRadians = (degree) => degree * (Math.PI / 180); // Convert degrees to radians

    const dLat = toRadians(lat2 - lat1);
    const dLon = toRadians(lon2 - lon1);

    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return R * c; // Distance in kilometers
}
// Add submit event listener to the form
$('#examcenterfrm').on('submit', function (e) {
    const totalStudents = parseInt($('#total_students').val()) || 0; // Get the total students value

    // Check if the total number of students is less than 240
    if (totalStudents < 30) {
        e.preventDefault(); // Stop form submission
        alert('The total number of students must be at least 30. Please add more students before submitting.');
        return false; // Ensure the function stops execution
    }
});

</script>