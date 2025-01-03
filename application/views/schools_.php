<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Schools Management
        <small>Edit school Teacher</small>
      </h1>
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
                        <th>Type</th>
                        <th>Name</th>
                        <th>District</th>
						<th>Tehsil</th>
						<th>Level</th>
						<th>Type/Area</th>
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
                        <td><?php echo $record->PEC_Sch_Code ?></td>
                        <td><?php echo $record->Sch_Admn_Body ?></td>
                        <td><?php echo $record->S_Name ?></td>
                        <td><?php echo $record->school_district ?></td>
						<td><?php echo $record->Tehsil ?></td>
						<td><?php echo $record->Sch_Level ?></td>
						<td><?php echo $record->Sch_Type.'/'. $record->Sch_Area ?></td>
						<td><?php echo $record->Name_of_TA.' '.$record->Designation.' '.$record->Cell_No ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editSchool/'.$record->School_Id; ?>" title="Edit Teacher Detail"><i class="fa fa-pencil"></i></a> 
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
