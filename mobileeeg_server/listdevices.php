  <?php ?>

  <div class="container">
    <div class="row mt-4">
      <div class="col-lg-12 d-flex justify-content-between align-items-center">
        <div>
          <h4 class="text-primary">List of all device registered to <?php echo $userProfile[0]['nama'];?></h4>
        </div>
        <div>
          <!-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addNewUserModal2">Add New Device</button> -->
          <a href="/index.php?action=addnewdevice" class="btn btn-primary" target="_parent" >Add New Device</a> 
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-lg-12">
        <div id="showAlert"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered text-center">
            <thead>
              <tr>
                <th>ID</th>
                <th>Device Model</th>
                <th>Short Name</th>
                <th>Description</th>
                <th>Current Patient ID</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            $owneddevices=getDevicesByOwnerID($userProfile[0]['userid']);
            if(sizeof($owneddevices)>0){
            	for($i=0;$i<sizeof($owneddevices);$i++){
            		?>
              <tr>
                <th><?php echo $owneddevices[$i]['deviceid'];?></th>
                <th><?php echo getDeviceModelById($owneddevices[$i]['modelid'])['modelname'];?></th>
                <th><?php echo $owneddevices[$i]['shortname'];?></th>
                <th><?php echo $owneddevices[$i]['description'];?></th>
                <th><?php echo $owneddevices[$i]['patientid'];?></th>
                <th>
                    <a href="/index.php?action=showwaveform&deviceid=<?php echo $owneddevices[$i]['deviceid'];?>" target="_parent" class="btn btn-primary btn-sm">
                    <i class="fa fa-folder-open"></i>&nbsp; View</a>
                    <a href="/index.php?action=editdeviceinfo&deviceid=<?php echo $owneddevices[$i]['deviceid'];?>" target="_parent" class="btn btn-secondary btn-sm">
                    <i class="fa fa-gear"></i>&nbsp; Edit</a>
                    <a href="/index.php?action=showdevicetoken&deviceid=<?php echo $owneddevices[$i]['deviceid'];?>" target="_parent" class="btn btn-success btn-sm">
                    <i class="fa fa-magic"></i>&nbsp; Token</a>
                    <a href="/index.php?action=deletedevice&deviceid=<?php echo $owneddevices[$i]['deviceid'];?>" target="_parent" class="btn btn-warning btn-sm">
                    <i class="fa fa-exclamation-circle"></i>&nbsp; Delete</button>
                     </th>
              </tr>
            	<?php }
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
     <div class="row mt-4">
      <div class="col-lg-12 d-flex justify-content-between align-items-center">
       
      </div>
    </div>
  </div>

