<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-8">
                <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">SED Schools Management</span>
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
                <form method="POST" action="<?= base_url('Sed_School/addSchool') ?>">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="emiscode">School EMIS Code</label>
                            <input type="text" class="form-control" id="emiscode" name="emiscode"
                                placeholder="Enter EMIS code">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Enter username" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter password">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_department">School Department</label>
                            <select name="school_department" class="form-control" id="school_department" required>
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

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="school_type">School Type</label>
                            <select name="school_type" class="form-control" id="school_type" required>
                                <option value="Public">Public</option>
                                <option value="Private">Private</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_name">School Name</label>
                            <input type="text" class="form-control" id="school_name" name="school_name"
                                placeholder="Enter school name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_address">School Address</label>
                            <input type="text" class="form-control" id="school_address" name="school_address"
                                placeholder="Enter address">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_district_id">District</label>
                            <select name="school_district_id" id="school_district_id" class="form-control" required>
                                <option value="">Select District</option>
                                <?php foreach ($districts as $district): ?>
                                <option value="<?= $district->district_id; ?>"><?= $district->district_name_en; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="school_tehsil_id">Tehsil</label>
                            <select class="form-control" id="school_tehsil_id" name="school_tehsil_id">
                                <option value="">Select Tehsil</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_markaz">Markaz</label>
                            <input type="text" class="form-control" id="school_markaz" name="school_markaz"
                                placeholder="Enter markaz">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_level">School Level</label>
                            <select name="school_level" class="form-control" id="school_level" required>
                                <option value="Primary">Primary</option>
                                <option value="Elementary">Elementary</option>
                                <option value="High">High</option>
                                <option value="Higher Secondary">Higher Secondary</option>
                                <option value="Secondary">Secondary</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_phone">School Phone</label>
                            <input type="text" class="form-control" id="school_phone" name="school_phone"
                                placeholder="Enter phone">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="school_contact_name">Contact Name</label>
                            <input type="text" class="form-control" id="school_contact_name" name="school_contact_name"
                                placeholder="Headmaster name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_contact_mobile">Contact Mobile</label>
                            <input type="text" class="form-control" id="school_contact_mobile"
                                name="school_contact_mobile" placeholder="Headmaster mobile">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="school_gender">Gender</label>
                            <select name="school_gender" class="form-control" id="school_gender" required>
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                                <option value="BOTH">BOTH</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_email">School Email</label>
                            <input type="text" class="form-control" id="school_email" name="school_email"
                                placeholder="School email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="school_lat">Latitude</label>
                            <input type="text" class="form-control" id="school_lat" name="school_lat"
                                placeholder="Enter latitude">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="school_lon">Longitude</label>
                            <input type="text" class="form-control" id="school_lon" name="school_lon"
                                placeholder="Enter longitude">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Add School</button>
                    <a href="<?= base_url('Sed_School/SedschoolListing') ?>" class="btn btn-secondary mt-3">Cancel</a>

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
document.getElementById('emiscode').addEventListener('input', function() {
    const schoolCode = this.value;
    const usernameField = document.getElementById('username');
    usernameField.value = schoolCode; // Copy EMIS code to username
});
</script>