<div class="content-wrapper"> 
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1> <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <small>Control panel</small> </h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-lg-4 col-xs-6"> 
            <!-- small box -->
            <div class="small-box bg-aqua">
               <div class="inner">
                  <h3><?php echo $stats['totalCenter']; ?></h3>
                  <p>TOTAL CENTER CREATED</p>
               </div>
               <div class="icon"> <i class="ion ion-bag"></i> </div>
               <a href="<?php echo base_url(); ?>Center/centerListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-4 col-xs-6"> 
            <!-- small box -->
            <div class="small-box bg-yellow">
               <div class="inner">
                  <h3><?php echo $staff['totalStaff']; ?></h3>
                  <p>STAFF ALLOCATED ON CENTERS TEACHERS</p>
               </div>
               <div class="icon"> <i class="ion ion-person-add"></i> </div>
               <a href="<?php echo base_url(); ?>Center/centerListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
         </div>
         <!-- ./col -->
         <?php /*?><div class="col-lg-3 col-xs-6"> 
            <!-- small box -->
            <div class="small-box bg-red">
               <div class="inner">
                  <h3><?php echo $stats['unassignedSchools']; ?></h3>
                  <p>PENDING ASSIGNMENT SCHOOLS</p>
               </div>
               <div class="icon"> <i class="ion ion-pie-graph"></i> </div>
               <a href="<?php echo base_url(); ?>Center/centerListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
         </div><?php */?>
         <!-- ./col --> 
      </div>
      <div class="row">
         <?php
				if(isset($districtStats))
				{
					?>
               <table class="table" style="border: 1px solid #000; width: 75%; margin:20px;">
                  <thead>
                     <tr>
                        <th style="border: 1px solid #070241">SR</th>
                        <th style="border: 1px solid #070241">DISTRICT NAME</th>
                        <th style="border: 1px solid #070241">TOTAL CENTER CREATED</th>
                        <th style="border: 1px solid #070241">NO. OF STAFF</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $x=0;
                     foreach($districtStats as $district)
                     {
                        ?>
                     <tr style="border: 1px solid #070241">
                        <td style="border: 1px solid #070241"><?php echo ++$x; ?></td>
                        <td style="border: 1px solid #070241"><?php echo $district->district_name_en; ?></td>
                        <td style="border: 1px solid #070241"><?php echo $district->total_cid; ?></td>
                        <td style="border: 1px solid #070241"><?php echo $district->staff_count; ?></td>
                     </tr>
                     <?php
                     }
                     ?>
                  </tbody>
               </table>
         <?php
				}				
				
				?>
      </div>
   </section>
</div>
