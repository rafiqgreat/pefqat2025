<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-8">
                <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">Exam Centers
                    Management</span>
                <small>Edit Center Info</small>
            </div>
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

        <!-- Edit Center Info Form -->
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="<?= base_url('center/updateCenterInfo') ?>">
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-3">
                            <label for="school_district_id">District</label>
                            <select name="school_district_id" id="school_district_id" class="form-control" required>
                                <option value="">Select District</option>
                                <?php foreach ($districts as $district): ?>
                                <option value="<?= $district->district_id; ?>"
                                    <?= $district->district_id == $center->school_district_id ? 'selected' : ''; ?>>
                                    <?= $district->district_name_en; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="school_tehsil_id">Tehsil</label>
                            <select class="form-control" id="school_tehsil_id" name="school_tehsil_id">
                                <option value="">Select Tehsil</option>
                                <?php foreach ($tehsils as $tehsil): ?>
                                <option value="<?= $tehsil->tehsil_id; ?>"
                                    <?= $tehsil->tehsil_id == $center->school_tehsil_id ? 'selected' : ''; ?>>
                                    <?= $tehsil->tehsil_name_en; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="school_id">School</label>
                            <select class="form-control" id="school_id" name="school_id" required>
                                <option value="">Select School</option>
                                <?php foreach ($schools as $school): ?>
                                <option value="<?= $school->school_id; ?>"
                                    <?= $school->school_id == $center->school_id ? 'selected' : ''; ?>>
                                    <?= $school->school_name; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div id="school-details" class="mt-4">
                            <h3>Selected School Details</h3>
                            <p><strong>School EMIS Code:</strong> <span
                                    id="school_id_display"><?= $center->school_emis_code; ?></span></p>
                            <p><strong>School Name:</strong> <span
                                    id="school_name_display"><?= $center->school_name; ?></span></p>
                            <p><strong>School Address:</strong> <span
                                    id="school_address_display"><?= $center->school_address; ?></span></p>
                        </div>
                    </div>
                    <div class="container mt-5">
                        <h3 class="mb-3">Update PEF Schools</h3>
                        <!-- School Rows -->
                        <?php foreach ($pefSchools as $index => $school): ?>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="school_<?= $index ?>">School <?= $index + 1 ?>:</label>
                                    <select class="form-control" name="pefschools[]" id="pefschool_<?= $index ?>">
                                        <option value="">Select PEF School</option>
                                        <?php foreach ($pefSchoolOptions as $option): ?>
                                        <option value="<?= $option->s_id; ?>"
                                            <?= $option->s_id == $school['id'] ? 'selected' : ''; ?>>
                                            <?= $option->s_name; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="students_<?= $index ?>">Selected Students:</label>
                                    <input type="number" name="students_<?= $index ?>" id="students_<?= $index ?>"
                                        class="form-control" value="<?= $school['students']; ?>"
                                        placeholder="Students count">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary mt-3">Update Center Info</button>
                        <a href="<?= base_url('center/centerListing') ?>" class="btn-lg btn-secondary mt-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
</div>
</section>
</div>