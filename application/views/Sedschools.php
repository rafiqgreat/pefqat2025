<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-8">
                <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">SED Schools Management</span>
                <small>Add Edit Delete School</small>
            </div>
            <div class="col-lg-4">
            	<a href="<?= base_url().'Sed_School/addSchoolForm'; ?>" class="btn btn-success"
                    style="float:right; margin-left: 5px;">
                    Add School
                </a>
                <a href="<?= base_url().'Sed_School/export_sed_school_csv'; ?>" class="btn btn-success"
                    style="float:right;">
                    Export as CSV
                </a>
                <!-- <a href="<?= base_url().'Sed_School/ImportSchool'; ?>" class="btn btn-success"
                    style="float:right; margin-left: 5px;margin-right: 5px;">
                    Import School
                </a> -->
                
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
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Sed Schools List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>Sed_School/SedschoolListing" method="POST"
                                id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>"
                                        class="form-control input-sm pull-right" style="width: 150px;"
                                        placeholder="Search" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>School ID</th>
                                <th>Username</th>
                                <th>School Name</th>
                                <th>School Address</th>
                                <th>School Level</th>
                                <th>School Headname</th>
                                <th>School Phone</th>
                                <th>School Email</th>
                                <th>School Head Cell</th>

                                <th class="text-center">Actions</th>
                            </tr>
                            <?php
                    if(!empty($schoolRecords))
                    {
                        foreach($schoolRecords as $record)
                        {
                    ?>
                            <tr>
                                <td><?php echo $record->school_id ?></td>
                                <td><?php echo $record->username ?></td>
                                <td><?php echo $record->school_name ?></td>
                                <td><?php echo $record->school_address ?></td>
                                <td><?php echo $record->school_level ?></td>
                                <td><?php echo $record->school_contact_name ?></td>
                                <td><?php echo $record->school_phone ?></td>
                                <td><?php echo $record->school_email ?></td>
                                <td><?php echo $record->school_contact_mobile ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info"
                                        href="<?php echo base_url().'Sed_School/editSedSchool/'.$record->school_id; ?>"
                                        title="Edit School Detail"><i class="fa fa-pencil"></i></a>
                                </td>
                                <td><a class="btn btn-sm btn-danger"
                                        href="<?php echo base_url().'Sed_School/deleteSedSchool/'.$record->school_id; ?>"
                                        title="Delete School"
                                        onclick="return confirm('Are you sure you want to delete this school?');">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>

                    <p>Total Number SED Schools in Punjab: <?php echo $total_records; ?></p>
                </div><!-- /.box -->
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
        jQuery("#searchList").attr("action", baseURL + "SedschoolListing/" + value);
        jQuery("#searchList").submit();
    });
});
</script>