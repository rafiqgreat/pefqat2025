<style>
.btnmargin {
    margin-bottom: 5px;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-building"></i> Exam Centers Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>center/addNew">
                        <i class="fa fa-plus"></i> Add New Center
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div class="row">
            <div class="col-md-12">
                <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if ($error) {
                    echo '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . 
                            $error . 
                          '</div>';
                }
                $success = $this->session->flashdata('success');
                if ($success) {
                    echo '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . 
                            $success . 
                          '</div>';
                }
                echo validation_errors('<div class="alert alert-danger alert-dismissable">', 
                                        ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
                ?>
            </div>
        </div>

        <!-- Table -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Exam Centers List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>centerListing" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>"
                                        class="form-control input-sm pull-right" style="width: 150px;"
                                        placeholder="Search" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Center ID</th>
                                    <th>Center Code</th>
                                    <th>Tehsil</th>
                                    <th>Center SED School</th>
                                    <th>PEP Schools</th>
                                    <!-- <th>PEF Students Available</th> -->
                                    <th>PEF Students Selected</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (!empty($centerRecords)) {
                                        foreach ($centerRecords as $record) {
                                ?>
                                <tr>
                                    <td><?php echo $record->cid; ?></td>
                                    <td><?php echo !empty($record->ccode) ? $record->ccode : 'N/A'; ?></td>
                                    <td><?php echo $record->tehsilName; ?></td>
                                    <td><?php print $record->school_name.' ('.$record->username.')'; ?></td>
                                    <td><?php print $record->cpefschools_total; ?></td>
                                    <!-- <td><?php print $record->cpef_students_avail; ?></td> -->
                                    <td><?php print $record->cpef_students_selected; ?></td>
                                    <td>
                                        <?php echo $record->cstatus == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'; ?>
                                    </td>
                                    <td><?php echo date("d-m-Y H:i:s", strtotime($record->ccreated)); ?></td>
                                    <td class="text-center">
                                        <?php 
													$staff = $this->center_model->getCenterStaffByCenterId($record->cid);
													if($staff == 0)
													{
													?>
                                        <a class="btn btn-sm btn-primary btnmargin"
                                            href="<?php echo base_url() . 'staff/staff_add/' . $record->cid; ?>"
                                            title="Add Staff">Add Staff
                                        </a>
                                        <?php }
													 else
													 {?>
                                        <a class="btn btn-sm btn-info btnmargin"
                                            href="<?php echo base_url() . 'staff/staff_edit/' . $record->cid; ?>"
                                            title="Edit Staff">Edit Staff
                                        </a>
                                        <a class="btn btn-sm btn-info btnmargin"
                                            href="<?php echo base_url() . 'staff/staff_view/' . $record->cid; ?>"
                                            title="View Staff">View Staff
                                        </a>
                                        <a class="btn btn-sm btn-danger btnmargin"
                                            href="<?php echo base_url().'staff/staff_delete/'.$record->cid; ?>"
                                            title="Delete Staff"
                                            onclick="return confirm('Are you sure you want to delete exam center staff?');">
                                            <i class="fa fa-trash"></i> Delete Staff
                                        </a>
                                        <?php 
													 }?>
                                        <a class="btn btn-sm btn-info btnmargin"
                                            href="<?php echo base_url() . 'Center/editCenter/' . $record->cid; ?>"
                                            title="Edit"><i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btnmargin"
                                            href="<?php echo base_url().'Center/deleteCenter/'.$record->cid; ?>"
                                            title="Delete Center"
                                            onclick="return confirm('Are you sure you want to delete this center?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                    } else {
                                    ?>
                                <tr>
                                    <td colspan="6" class="text-center">No records found.</td>
                                </tr>
                                <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>


                    <!-- Pagination -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "CenterListing/" + value);
        jQuery("#searchList").submit();
    });
});
</script>