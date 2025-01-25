<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<div class="row">
        	<div class="col-lg-8">
            	    <i class="fa fa-users"></i> <span style="font-size:20px; font-weight:bold">Schools Management</span>
                    <small>Edit school Teacher</small>
            </div>
            <div class="col-lg-4"><a href="<?= base_url().'School/export_school_csv'; ?>" class="btn btn-success" style="float:right">Export as CSV</a></div>
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
                    <h3 class="box-title">Schools List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>schoolListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>School ID</th>
                        <th>LSA Code</th>
                        <th>Grade</th>
                        <th>EMIS Code</th>
						<th>School Name</th>
						<th>Tehsil</th>
						<th>District</th>
                        <th>Teacher Assigned</th>
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
                        <td><?php echo $record->school_lsacode ?></td>
                        <td><?php echo $record->school_lsagrade ?></td>
                        <td><?php echo $record->school_emis ?></td>
						<td><?php echo $record->school_name ?></td>
						<td><?php echo $record->school_tehsil ?></td>
						<td><?php echo $record->school_district ?></td>
						<td><?php echo $record->Name_of_TA.' '.$record->Cell_No ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editSchool/'.$record->school_id; ?>" title="Edit Teacher Detail"><i class="fa fa-pencil"></i></a> 
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
				  
				  <p>Total Number of Schools for LSA-2024 in Punjab: <?php echo $total_records; ?></p>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "schoolListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
