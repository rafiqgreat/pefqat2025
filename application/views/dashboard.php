<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $stats['totalSchools']; ?></h3>
                  <p>TOTAL SCHOOLS SELECTED</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo base_url(); ?>schoolListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->            
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $stats['assignedSchools']; ?></h3>
                  <p>TOTAL ASSIGNED TEACHERS</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url(); ?>schoolListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $stats['unassignedSchools']; ?></h3>
                  <p>PENDING ASSIGNMENT SCHOOLS</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?php echo base_url(); ?>schoolListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
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
					<th style="border: 1px solid #070241">TOTAL SCHOOLS</th>
					<th style="border: 1px solid #070241">ASSIGNED TEACHER SCHOOLS</th>
					<th style="border: 1px solid #070241">PENDING ASSIGNEMENT SCHOOLS</th>
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
					<td style="border: 1px solid #070241"><?php echo $district->school_district; ?></td>
					<td style="border: 1px solid #070241"><?php echo $district->totalschools; ?></td>
					<td style="border: 1px solid #070241"><?php echo $district->assignedSchools; ?></td>					
					<td style="border: 1px solid #070241"><?php echo ($district->totalschools-$district->assignedSchools) ?></td>	
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