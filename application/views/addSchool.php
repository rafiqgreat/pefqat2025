<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-8">
                <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">PEF Schools Management</span>
                <small>Add New School</small>
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

        <!-- Add School Form -->
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="<?= base_url('Pef_School/addSchool') ?>">
                    <!-- School Details -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_program">School Program:</label>
                                <input type="text" name="s_program" id="s_program" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_school_code">School EMIS Code:</label>
                                <input type="text" name="s_school_code" id="s_school_code" class="form-control"
                                    placeholder="EMIS Code" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_phase">Phase:</label>
                                <input type="text" name="s_phase" id="s_phase" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_name">School Name:</label>
                                <input type="text" name="s_name" id="s_name" class="form-control"
                                    placeholder="School Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_address">School Address:</label>
                                <input type="text" name="s_address" id="s_address" class="form-control"
                                    placeholder="School Address" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_level">School Level:</label>
                                <select name="s_level" class="form-control" id="s_level" required>
                                    <option value="Primary">Primary</option>
                                    <option value="Elementary">Elementary</option>
                                    <option value="High">High</option>
                                    <option value="Higher Secondary">Higher Secondary</option>
                                    <option value="Secondary">Secondary</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Location Details -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_district_id">District:</label>
                                <select name="s_district_id" id="s_district_id" class="form-control" required>
                                    <option value="">Select District</option>
                                    <?php foreach ($districts as $district): ?>
                                    <option value="<?= $district->district_id; ?>"><?= $district->district_name_en; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_tehsil_id">Tehsil:</label>
                                <select name="s_tehsil_id" id="s_tehsil_id" class="form-control" required>
                                    <option value="">Select Tehsil</option>
                                    <?php foreach ($tehsils as $tehsil): ?>
                                    <option value="<?= $tehsil->tehsil_id; ?>"><?= $tehsil->tehsil_name_en; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_lat">Latitude:</label>
                                <input type="text" name="s_lat" id="s_lat" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_long">Longitude:</label>
                                <input type="text" name="s_long" id="s_long" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_owner_name">School Owner Name:</label>
                                <input type="text" name="s_owner_name" id="s_owner_name" class="form-control"
                                    placeholder="school owner name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_owner_cell">School Owner Cell:</label>
                                <input type="text" name="s_owner_cell" id="s_owner_cell" class="form-control"
                                    placeholder="school owner cell" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_email">School Email:</label>
                                <input type="email" name="s_email" id="s_email" class="form-control"
                                    placeholder="School Email">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_department">Department:</label>
                                <select name="s_department" class="form-control" id="s_department" required>
                                    <option value="SED">SED</option>
                                    <option value="FEDERAL">FEDERAL</option>
                                    <option value="PEF">PEF</option>
                                    <option value="WORKERSWELFARE">WORKERSWELFARE</option>
                                    <option value="COMMUNITY">COMMUNITY</option>
                                    <option value="LITERACY">LITERACY</option>
                                    <option value="PSSP">PSSP</option>
                                    <option value="DANISH">DANISH</option>
                                    <option value="INSAFAFTERNOON">INSAFAFTERNOON</option>
                                    <option value="OTHERS">OTHERS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_type">Type:</label>
                                <select name="school_type" class="form-control" id="school_type" required>
                                    <option value="Public">Public</option>
                                    <option value="Private">Private</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_gender">Gender:</label>
                                <select name="s_gender" class="form-control" id="s_gender" required>
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                    <option value="BOTH">BOTH</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Login Details -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Username" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="s_status">Status:</label>
                                <select name="s_status" id="s_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Add School</button>
                    <a href="<?= base_url('Pef_School/PefschoolListing') ?>" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>

    </section>
</div>
<script>
// Update Tehsils dynamically based on selected District
$(document).ready(function() {
    $('#s_district_id').change(function() {
        var districtId = $(this).val();

        // Clear existing tehsil options
        $('#s_tehsil_id').html('<option value="">Select Tehsil</option>');

        if (districtId) {
            $.ajax({
                url: '<?php echo base_url("Pef_School/getTehsilsByDistrict"); ?>/' +
                    districtId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#s_tehsil_id').append('<option value="' + value
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
document.getElementById('s_school_code').addEventListener('input', function() {
    const schoolCode = this.value;
    const usernameField = document.getElementById('username');
    usernameField.value = schoolCode; // Copy EMIS code to username
});
</script>