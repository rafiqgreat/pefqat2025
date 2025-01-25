<?php echo $schoolInfo->s_id; ?><div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> PEF School Edit
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
                    <form role="form" action="<?php echo base_url() ?>Pef_School/updateSchool" method="post"
                        id="editSchool" role="form" onSubmit="return checkGender();">
                        <div class="box-body">
                            <div class="row">
                                <!-- School ID (Read-only) -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_id">School ID</label>
                                        <input type="text" class="form-control" id="s_id" name="s_id"
                                            value="<?php echo $schoolInfo->s_id; ?>" readonly>
                                    </div>
                                </div>
                                <!-- School Code -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_school_code">Username</label>
                                        <input type="text" class="form-control" id="s_school_code" name="s_school_code"
                                            value="<?php echo $schoolInfo->s_school_code; ?>" readonly>
                                    </div>
                                </div>
                                <!-- School Program -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_program">School Program</label>
                                        <input type="text" class="form-control" id="s_program" name="s_program"
                                            value="<?php echo $schoolInfo->s_program; ?>">
                                    </div>
                                </div>
                                <!-- School Phase -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_phase">Phase</label>
                                        <input type="text" class="form-control" id="s_phase" name="s_phase"
                                            value="<?php echo $schoolInfo->s_phase; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- District -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_district_id">District</label>
                                        <select class="form-control" id="s_district_id" name="s_district_id">
                                            <option value="">Select District</option>
                                            <?php foreach ($districts as $district): ?>
                                            <option value="<?php echo $district->district_id; ?>"
                                                <?php echo ($district->district_id == $schoolInfo->s_district_id) ? 'selected' : ''; ?>>
                                                <?php echo $district->district_name_en; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tehsil -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_tehsil_id">Tehsil</label>
                                        <select class="form-control" id="s_tehsil_id" name="s_tehsil_id">
                                            <option value="">Select Tehsil</option>
                                            <?php foreach ($tehsils as $tehsil): ?>
                                            <option value="<?php echo $tehsil->tehsil_id; ?>"
                                                <?php echo ($tehsil->tehsil_id == $schoolInfo->s_tehsil_id) ? 'selected' : ''; ?>>
                                                <?php echo $tehsil->tehsil_name_en; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- School Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="s_name">School Name</label>
                                        <input type="text" class="form-control" id="s_name" name="s_name"
                                            value="<?php echo $schoolInfo->s_name; ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <!-- School Address -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_address">School Address</label>
                                        <input type="text" class="form-control" id="s_address" name="s_address"
                                            value="<?php echo $schoolInfo->s_address; ?>">
                                    </div>
                                </div>

                                <!-- School Level -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_level">School Level</label>
                                        <select name="s_level" class="form-control form-group" id="s_level"
                                            required="required">
                                            <option value="Primary"
                                                <?php echo ($schoolInfo->s_level == 'Primary') ? 'selected' : ''; ?>>
                                                Primary</option>
                                            <option value="Elementary"
                                                <?php echo ($schoolInfo->s_level == 'Elementary') ? 'selected' : ''; ?>>
                                                Elementary</option>
                                            <option value="High"
                                                <?php echo ($schoolInfo->s_level == 'High') ? 'selected' : ''; ?>>
                                                High</option>
                                            <option value="Higher Secondary"
                                                <?php echo ($schoolInfo->s_level == 'Higher Secondary') ? 'selected' : ''; ?>>
                                                Higher Secondary</option>
                                            <option value="Secondary"
                                                <?php echo ($schoolInfo->s_level == 'Secondary') ? 'selected' : ''; ?>>
                                                Secondary</option>
                                            <option value="sMosque"
                                                <?php echo ($schoolInfo->s_level == 'Mosque') ? 'selected' : ''; ?>>
                                                Mosque</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_gender">School Gender</label>
                                        <select name="s_gender" class="form-control form-group" id="s_gender"
                                            required="required">
                                            <option value="MALE"
                                                <?php echo ($schoolInfo->s_gender == 'MALE') ? 'selected' : ''; ?>>
                                                MALE</option>
                                            <option value="FEMALE"
                                                <?php echo ($schoolInfo->s_gender == 'FEMALE') ? 'selected' : ''; ?>>
                                                FEMALE</option>
                                            <option value="BOTH"
                                                <?php echo ($schoolInfo->s_gender == 'BOTH') ? 'selected' : ''; ?>>
                                                BOTH</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_email"> School Email</label>
                                        <input type="email" class="form-control" id="s_email" name="s_email"
                                            value="<?php echo $schoolInfo->s_email; ?>">
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <!-- Owner Name -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_owner_name">School Owner Name</label>
                                        <input type="text" class="form-control" id="s_owner_name" name="s_owner_name"
                                            value="<?php echo $schoolInfo->s_owner_name; ?>">
                                    </div>
                                </div>

                                <!-- Owner Cell -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_owner_cell">School Owner Cell</label>
                                        <input type="text" class="form-control" id="s_owner_cell" name="s_owner_cell"
                                            value="<?php echo $schoolInfo->s_owner_cell; ?>">
                                    </div>
                                </div>

                                <!-- Latitude -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_lat">Latitude</label>
                                        <input type="text" class="form-control" id="s_lat" name="s_lat"
                                            value="<?php echo $schoolInfo->s_lat; ?>">
                                    </div>
                                </div>

                                <!-- Longitude -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_long">Longitude</label>
                                        <input type="text" class="form-control" id="s_long" name="s_long"
                                            value="<?php echo $schoolInfo->s_long; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <div class="row">

                                <!-- Department -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_department">Department</label>
                                        <select class="form-control" id="s_department" name="s_department">
                                            <option value="SED"
                                                <?php echo ($schoolInfo->s_department == 'SED') ? 'selected' : ''; ?>>
                                                SED</option>
                                            <option value="FEDERAL"
                                                <?php echo ($schoolInfo->s_department == 'FEDERAL') ? 'selected' : ''; ?>>
                                                FEDERAL</option>
                                            <option value="PEF"
                                                <?php echo ($schoolInfo->s_department == 'PEF') ? 'selected' : ''; ?>>
                                                PEF</option>
                                            <option value="WORKERSWELFARE"
                                                <?php echo ($schoolInfo->s_department == 'WORKERSWELFARE') ? 'selected' : ''; ?>>
                                                WORKERS WELFARE</option>
                                            <option value="COMMUNITY"
                                                <?php echo ($schoolInfo->s_department == 'COMMUNITY') ? 'selected' : ''; ?>>
                                                COMMUNITY</option>
                                            <option value="LITERACY"
                                                <?php echo ($schoolInfo->s_department == 'LITERACY') ? 'selected' : ''; ?>>
                                                LITERACY</option>
                                            <option value="PSSP"
                                                <?php echo ($schoolInfo->s_department == 'PSSP') ? 'selected' : ''; ?>>
                                                PSSP</option>
                                            <option value="DANISH"
                                                <?php echo ($schoolInfo->s_department == 'DANISH') ? 'selected' : ''; ?>>
                                                DANISH</option>
                                            <option value="INSAFAFTERNOON"
                                                <?php echo ($schoolInfo->s_department == 'INSAFAFTERNOON') ? 'selected' : ''; ?>>
                                                INSAF AFTERNOON</option>
                                            <option value="OTHERS"
                                                <?php echo ($schoolInfo->s_department == 'OTHERS') ? 'selected' : ''; ?>>
                                                OTHERS</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Type -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_type">School Type</label>
                                        <select name="s_type" class="form-control form-group" id="s_type"
                                            required="required">
                                            <option value="Public"
                                                <?php echo ($schoolInfo->s_type == 'Public') ? 'selected' : ''; ?>>
                                                Public</option>
                                            <option value="Private"
                                                <?php echo ($schoolInfo->s_type == 'Private') ? 'selected' : ''; ?>>
                                                Private</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            value="<?php echo $schoolInfo->password; ?>">
                                    </div>
                                </div>
                                <!-- Status -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="s_status">Status</label>
                                        <select class="form-control" id="s_status" name="s_status">
                                            <option value="1"
                                                <?php echo ($schoolInfo->s_status == 1) ? 'selected' : ''; ?>>Active
                                            </option>
                                            <option value="0"
                                                <?php echo ($schoolInfo->s_status == 0) ? 'selected' : ''; ?>>Inactive
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
document.getElementById('s_district_id').value = "<?php echo $schoolInfo->s_district_id; ?>";
document.getElementById('Gender').value =
    "<?php if($schoolInfo->Gender!= ''){ echo $schoolInfo->Gender;}else{echo 'Male';} ?>";

function checkGender() {
    if (document.getElementById('Sch_Type').value != '' && document.getElementById('Sch_Type').value !== document
        .getElementById('Gender').value) {
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