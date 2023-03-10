<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">


    <!-- Title Page-->
    <title>mobileEEG v.1.0</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- plottable js css-->
    <link rel="stylesheet" href="/js/plottable/plottable.css" charset="utf-8">
    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

    <!-- JQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <img src="images/icon/logo-white.png" alt="mobileEEG" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="https://ui-avatars.com/api/?size=128&name=<?php echo $userProfile[0]['nama'];?>" alt="<?php echo $userProfile[0]['nama'];?>" />
                    </div>
                    <h4 class="name"><?php echo $userProfile[0]['nama'];?></h4>
                    <a href="/index.php?action=logout">Sign out</a>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        
                        <li>
                            <a href="/index.php?show=devicelist">
                                <i class="fas fa-shopping-basket"></i>Devices</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <img src="images/icon/logo-white.png" alt="mobileEEG" />
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </header>
           

            <!-- BREADCRUMB-->
            <section class="au-breadcrumb m-t-75">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left">
                                        <span class="au-breadcrumb-span">You are here:</span>
                                        <ul class="list-unstyled list-inline au-breadcrumb__list">
                                            <li class="list-inline-item active">
                                                <a href="#">Home</a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            <li class="list-inline-item">Dashboard</li>
                                        </ul>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END BREADCRUMB-->
    <!-- add content here -->
    <?php
    if($_GET['show']=='devicelist'){
        include('./listdevices.php');
    }
    elseif($_GET['action']=='addnewdevice'){
        include('./addnewdevice.php');
        #print_r($myvars['modelselectvalues']);
    }
    elseif($_GET['action']=='doaddnewdevice'){
        if(sizeof(getDeviceProfileByShortName($_POST['shortname']))==0){
            $newdeviceid=addNewDevice($userProfile[0]['userid'], $_POST['modelid'],$_POST['shortname'],$_POST['description']);
            $newdeviceProfile=getDeviceProfileByID($newdeviceid);
            if(sizeof($newdeviceProfile)>0){
                $formresponsemessage="<h2>Device Add Successfull</h2>";
                $formresponsemessage.="Device Token: <br>".$newdeviceProfile[0]['devicetoken']."<br><br>";
                $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
                include('./form-response2.php'); 
            }
        } else {
            $formresponsemessage="<h2>Device <b>".$_POST['shortname']."</b> already exists.</h2>";
            $formresponsemessage.="<a href=\"/index.php?show=addnewdevice\">Return to Add New Device</a>";
            include('./form-response2.php'); 
        }
    }
    elseif($_GET['action']=='deletedevice'){
        include('./deletedevices.php');
    }
    elseif($_GET['action']=='editdeviceinfo'){
        include('./editdeviceinfo.php');
    }
    elseif($_GET['action']=='doeditdeviceinfo'){
        $results=processEditDeviceInfo($auth);
        if($results['status']){
        $formresponsemessage="<h2>Edit Device Info Successfull</h2>";
        $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
        include('./form-response2.php'); 
        } else {
        $formresponsemessage="<h2>Edit Device Info Failed</h2>";
        $formresponsemessage.="Error: ".$results['message']."<br>";
        $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
        include('./form-response2.php');             
        }
    }
    elseif($_GET['action']=='dodeletedevice'){
        $results=processDeleteDevice($auth);
        if($results['status']){
        $formresponsemessage="<h2>Device Delete Successfull</h2>";
        $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
        include('./form-response2.php'); 
        } else {
        $formresponsemessage="<h2>Device Delete Failed</h2>";
        $formresponsemessage.="Error: ".$results['message']."<br>";
        $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
        include('./form-response2.php');             
        }
    }
    elseif($_GET['action']=='showdevicetoken'){
        $deviceProfile=getDeviceProfileByID($_GET['deviceid']);
        if($userid==$deviceProfile[0]['ownerid']){
        $formresponsemessage="<h2>Secret Device Token</h2>";
        $formresponsemessage.="Use this device token to identify your device when sending data. This must be kept secret.<br><br>";
        $formresponsemessage.="<strong>".$deviceProfile[0]['devicetoken']."</strong><br><br>";

        $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
        include('./form-response2.php'); 
        } else {
        $formresponsemessage="<h2>Can not show device token</h2>";
        $formresponsemessage.="Error: you do not have access right to this information<br><br>";
        $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
        include('./form-response2.php');             
        }
    }
    elseif($_GET['action']=='showwaveform'){
        include('./waveformblock3.php');
    }
    else {
        include('./listdevices.php');
    }
    ?>

            
    <!-- end content -->
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                           
                        </div>
                    </div>
                </div>
            </section>
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

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
    <script src="vendor/vector-map/jquery.vmap.js"></script>
    <script src="vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="vendor/vector-map/jquery.vmap.world.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
