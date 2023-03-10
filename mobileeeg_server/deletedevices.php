<?php ?>
            <section>
                <div class="container-fluid">
                    <div class="row mt-4">
                        <div class="col-lg-3"> 
                        </div>
                            <div class="col-lg-6"> 
                               <div class="card">
                                    <div class="card-header">
                                        <strong>Confirm Deleting Device</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="/index.php?action=dodeletedevice" method="post" class="form-horizontal">
                                            <?php
                                               $deviceProfile=getDeviceProfileByID($_GET['deviceid']);
                                               $keys=Array('deviceid','model','shortname','description','patientid');
                                               $labels=Array('Device ID','Device Model','Device Shortname','Description','Current Patient ID');
                                               for($i=0;$i<sizeof($keys);$i++){
                                            ?>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-email" class=" form-control-label"><?php echo $labels[$i];?></label>
                                                </div>

                                                <div class="col-12 col-md-9">
                                                <span class="help-block"><?php echo $deviceProfile[0][$keys[$i]];?></span>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-email" class=" form-control-label"><strong>Your Email:</strong></label>
                                                </div>

                                                <div class="col-12 col-md-9">
                                                <span class="help-block">Write your registered email to confirm that you really want to delete this device.</span>
                                                <input type="email" id="email" name="email" placeholder="Enter Email..." class="form-control">
                                                </div>
                                            </div>
                                            <input type="hidden" name="deviceid" value="<?php echo $deviceProfile[0]['deviceid'];?>">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Delete Device
                                        </button>
                                        <a href="/index.php?show=devicelist" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Cancel</a>
                                        </form>
                                    </div>
                            </div>
                      </div> 
                    </div>
                <div class="col-lg-3"> 
                </div>
                </div>
            </div>
        </section>


    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
