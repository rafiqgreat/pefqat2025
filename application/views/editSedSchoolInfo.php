<?php echo $schoolInfo->school_id; ?><div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> SED School Edit
            <small>Edit School</small>
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
                    <form role="form" action="<?php echo base_url() ?>Sed_School/updateSchool" method="post"
                        id="editSchool" role="form" onSubmit="return checkGender();">
                        <div class="box-body">
                            <div class="row">
                                <!-- School ID (Read-only) -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_id">School ID</label>
                                        <input type="text" class="form-control" id="school_id" name="school_id"
                                            value="<?php echo $schoolInfo->school_id; ?>" readonly>
                                    </div>
                                </div>
                                <!-- School Code -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="<?php echo $schoolInfo->username; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="<?php echo $schoolInfo->password; ?>">
                                    </div>
                                </div>
                                <!-- School Program -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_department">Department</label>
                                        <select class="form-control" id="school_department" name="school_department">
                                            <option value="SED"
                                                <?php echo ($schoolInfo->school_department == 'SED') ? 'selected' : ''; ?>>
                                                SED</option>
                                            <option value="FEDERAL"
                                                <?php echo ($schoolInfo->school_department == 'FEDERAL') ? 'selected' : ''; ?>>
                                                FEDERAL</option>
                                            <option value="PEF"
                                                <?php echo ($schoolInfo->school_department == 'PEF') ? 'selected' : ''; ?>>
                                                PEF</option>
                                            <option value="WORKERSWELFARE"
                                                <?php echo ($schoolInfo->school_department == 'WORKERSWELFARE') ? 'selected' : ''; ?>>
                                                WORKERS WELFARE</option>
                                            <option value="COMMUNITY"
                                                <?php echo ($schoolInfo->school_department == 'COMMUNITY') ? 'selected' : ''; ?>>
                                                COMMUNITY</option>
                                            <option value="LITERACY"
                                                <?php echo ($schoolInfo->school_department == 'LITERACY') ? 'selected' : ''; ?>>
                                                LITERACY</option>
                                            <option value="PSSP"
                                                <?php echo ($schoolInfo->school_department == 'PSSP') ? 'selected' : ''; ?>>
                                                PSSP</option>
                                            <option value="DANISH"
                                                <?php echo ($schoolInfo->school_department == 'DANISH') ? 'selected' : ''; ?>>
                                                DANISH</option>
                                            <option value="INSAFAFTERNOON"
                                                <?php echo ($schoolInfo->school_department == 'INSAFAFTERNOON') ? 'selected' : ''; ?>>
                                                INSAF AFTERNOON</option>
                                            <option value="OTHERS"
                                                <?php echo ($schoolInfo->school_department == 'OTHERS') ? 'selected' : ''; ?>>
                                                OTHERS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- School Phase -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_type">School Type</label>
                                        <select name="school_type" class="form-control form-group" id="school_type"
                                            required="required">
                                            <option value="Public"
                                                <?php echo ($schoolInfo->school_type == 'Public') ? 'selected' : ''; ?>>
                                                Public</option>
                                            <option value="Private"
                                                <?php echo ($schoolInfo->school_type == 'Private') ? 'selected' : ''; ?>>
                                                Private</option>
                                        </select>

                                    </div>
                                </div>
                                <!-- School Name -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_name">School Name</label>
                                        <input type="text" class="form-control" id="school_name" name="school_name"
                                            value="<?php echo $schoolInfo->school_name; ?>">
                                    </div>
                                </div>
                                <!-- School Address -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_address">School Address</label>
                                        <input type="text" class="form-control" id="school_address"
                                            name="school_address" value="<?php echo $schoolInfo->school_address; ?>">
                                    </div>
                                </div>
                                <!-- District -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_district_id">District</label>
                                        <select class="form-control" id="school_district_id" name="school_district_id">
                                            <option value="">Select District</option>
                                            <?php foreach ($districts as $district): ?>
                                            <option value="<?php echo $district->district_id; ?>"
                                                <?php echo ($district->district_id == $schoolInfo->school_district_id) ? 'selected' : ''; ?>>
                                                <?php echo $district->district_name_en; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Tehsil -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_tehsil_id">Tehsil</label>
                                        <select class="form-control" id="school_tehsil_id" name="school_tehsil_id">
                                            <option value="">Select Tehsil</option>
                                            <?php foreach ($tehsils as $tehsil): ?>
                                            <option value="<?php echo $tehsil->tehsil_id; ?>"
                                                <?php echo ($tehsil->tehsil_id == $schoolInfo->school_tehsil_id) ? 'selected' : ''; ?>>
                                                <?php echo $tehsil->tehsil_name_en; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- School Level -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_level">Level</label>
                                        <select name="school_level" class="form-control form-group" id="school_level"
                                            required="required">
                                            <option value="Primary"
                                                <?php echo ($schoolInfo->school_level == 'Primary') ? 'selected' : ''; ?>>
                                                Primary</option>
                                            <option value="Elementary"
                                                <?php echo ($schoolInfo->school_level == 'Elementary') ? 'selected' : ''; ?>>
                                                Elementary</option>
                                            <option value="High"
                                                <?php echo ($schoolInfo->school_level == 'High') ? 'selected' : ''; ?>>
                                                High</option>
                                            <option value="Higher Secondary"
                                                <?php echo ($schoolInfo->school_level == 'Higher Secondary') ? 'selected' : ''; ?>>
                                                Higher Secondary</option>
                                            <option value="Secondary"
                                                <?php echo ($schoolInfo->school_level == 'Secondary') ? 'selected' : ''; ?>>
                                                Secondary</option>
                                            <option value="sMosque"
                                                <?php echo ($schoolInfo->school_level == 'sMosque') ? 'selected' : ''; ?>>
                                                sMosque</option>
                                        </select>

                                    </div>
                                </div>
                                <!-- Gender -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_gender">Gender</label>
                                        <select name="school_gender" class="form-control form-group" id="school_gender"
                                            required="required">
                                            <option value="MALE"
                                                <?php echo ($schoolInfo->school_gender == 'MALE') ? 'selected' : ''; ?>>
                                                MALE</option>
                                            <option value="FEMALE"
                                                <?php echo ($schoolInfo->school_gender == 'FEMALE') ? 'selected' : ''; ?>>
                                                FEMALE</option>
                                            <option value="BOTH"
                                                <?php echo ($schoolInfo->school_gender == 'BOTH') ? 'selected' : ''; ?>>
                                                BOTH</option>
                                        </select>

                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_email"> School Email</label>
                                        <input type="email" class="form-control" id="school_email" name="school_email"
                                            value="<?php echo $schoolInfo->school_email; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- School Phone -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_phone"> School Phone</label>
                                        <input type="text" class="form-control" id="school_phone" name="school_phone"
                                            value="<?php echo $schoolInfo->school_phone; ?>">
                                    </div>
                                </div>
                                <!-- School Contact Name -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_contact_name">School Contact Name</label>
                                        <input type="text" class="form-control" id="school_contact_name"
                                            name="school_contact_name"
                                            value="<?php echo $schoolInfo->school_contact_name; ?>">
                                    </div>
                                </div>
                                <!-- School Contact Mobile -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_contact_mobile">School Contact Mobile</label>
                                        <input type="text" class="form-control" id="school_contact_mobile"
                                            name="school_contact_mobile"
                                            value="<?php echo $schoolInfo->school_contact_mobile; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_markaz">Markaz</label>
                                        <input type="text" class="form-control" id="school_markaz" name="school_markaz"
                                            value="<?php echo $schoolInfo->school_markaz; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- School Location -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_lat">Latitude</label>
                                        <input type="text" class="form-control" id="school_lat" name="school_lat"
                                            value="<?php echo $schoolInfo->school_lat; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_gender">Longitude</label>
                                        <input type="text" class="form-control" id="school_lon" name="school_lon"
                                            value="<?php echo $schoolInfo->school_lon; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="school_status">Status</label>
                                        <select class="form-control" id="school_status" name="s_status">
                                            <option value="1"
                                                <?php echo ($schoolInfo->school_status == 1) ? 'selected' : ''; ?>>
                                                Active
                                            </option>
                                            <option value="0"
                                                <?php echo ($schoolInfo->school_status == 0) ? 'selected' : ''; ?>>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-body -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Update" />
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
document.getElementById('school_district_id').value = "<?php echo $schoolInfo->school_district_id; ?>";
document.getElementById('school_gender').value =
    "<?php if($schoolInfo->Gender!= ''){ echo $schoolInfo->Gender;}else{echo 'Male';} ?>";

function checkGender() {
    if (document.getElementById('school_type').value != '' && document.getElementById('school_type').value !== document
        .getElementById('school_gender').value) {
        alert(
            'Teacher Gender and School Type Gender must be same i.e.(Male can be appointed to male school or vice versa!)'
        );
        return false;
    } else
        return true;
}
</script>
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