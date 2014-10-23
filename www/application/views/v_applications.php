<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>ARI/Stasis Sandbox</title>
    <meta name="generator" content="Bootply"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="http://bootswatch.com/united/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="<?php echo $this->session->userdata('BASEPATH'); ?>/../css/styles.css" rel="stylesheet">
</head>
<body>
<!-- Header -->
<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ARI/Stasis Sandbox</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <!--
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i> Admin <span class="caret"></span></a>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                        <li><a href="#">My Profile</a></li>
                    </ul>
                </li>
                -->
                <li><a href="login/logout"> Logout</a></li>
            </ul>
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /Header -->

<!-- Main -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <!-- Left column -->
            <strong>Stasis Application</strong>
            <hr>
            <ul class="list-unstyled">
                <li class="nav-header"><h5><a
                            href="<?php echo $this->session->userdata('BASEPATH'); ?>/welcome/applications">Application
                            Manager</a></h5>
                    <ul class="list-unstyled " id="userMenu">
                        <li><a href="#" onclick='clearApplicationForm(); return false;'>Create Application</a></li>
                        <?php
                            foreach ($applications as $application) {
                                ?>
                                <li><a href="#" onclick='loadApplicationConfiguration("<?php echo $application->application_name; ?>"); return false;'><i
                                            class="glyphicon glyphicon-cog"></i> <?php echo $application->application_name; ?>
                                    </a></li>
                            <?php
                            }
                        ?>
                    </ul>
                </li>
            </ul>
            <ul class="list-unstyled">
                <li class="nav-header"><h5><a href="<?php echo $this->session->userdata('BASEPATH'); ?>/welcome/index">Event
                            Handlers</a></h5>
                    <!--
                    <ul class="list-unstyled " id="userMenu">
                        <li><a href="#">Add Event Handler</a></li>
                        <?php
                        foreach ($events as $applicationName => $applicationData) {
                            foreach ($applicationData as $event) {
                                ?>
                                    <li><a href="#"
                                           onclick='loadEventCode("<?php echo $applicationName; ?>", "<?php echo $event; ?>"); return false;'><i
                                                class="glyphicon glyphicon-cog"></i> <?php echo $applicationName . "::" . $event; ?>
                                        </a></li>
                                <?php

                            }
                        }
                    ?>
                    </ul>
                    -->
                </li>
            </ul>

        </div>
        <!-- /col-3 -->
        <div class="col-sm-10">

            <a href="#"><strong> Application: </strong></a>

            <hr>

            <div class="row">

                <!-- center left-->
                <div class="col-md-12">
                    <div class="well"><h1><strong>Application Setup</strong></h1>
                        <hr>
                        <div class="form-group">
                            <label for="applicationName">Application Name</label>
                            <input type="text" class="form-control" id="applicationName"
                                   placeholder="Enter Stasis Application Name">
                        </div>
                        <div class="form-group">
                            <label for="stasisServer">Stasis Server</label>
                            <input type="text" class="form-control" id="stasisServer"
                                   placeholder="Enter Stasis Server IP">
                        </div>
                        <div class="form-group">
                            <label for="stasisPort">Stasis Port Number</label>
                            <input type="text" class="form-control" id="stasisPort"
                                   placeholder="Enter Stasis Server Port">
                        </div>
                        <div class="form-group">
                            <label for="ariEndpoint">ARI Endpoint</label>
                            <input type="text" class="form-control" id="ariEndpoint" value="/ari">
                        </div>
                        <div class="form-group">
                            <label for="ariUsername">ARI Username</label>
                            <input type="text" class="form-control" id="ariUsername" placeholder="ARI Username">
                        </div>
                        <div class="form-group">
                            <label for="ariPassword">ARI Password</label>
                            <input type="text" class="form-control" id="ariPassword" placeholder="ARI Password">
                        </div>
                        <button type="submit" class="btn btn-default" onclick="submitApplicationData(); return false;">
                            Submit
                        </button>
                    </div>

                </div>
                <!--/row-->


            </div>
            <!--/col-span-9-->
        </div>
    </div>
    <!-- /Main -->

    <!-- script references -->
    <script src="<?php echo $this->session->userdata('BASEPATH'); ?>/../js/jquery.min.js"></script>
    <script src="<?php echo $this->session->userdata('BASEPATH'); ?>/../js/bootstrap.min.js"></script>
    <script src="<?php echo $this->session->userdata('BASEPATH'); ?>/../js/scripts.js"></script>

    <script>

        function loadApplicationConfiguration(appname) {
            var obj = {};

            jQuery.get("<?php echo $this->session->userdata('BASEPATH'); ?>/ajax/get_application/" + appname, obj,
                function (data) {
                    console.log(data);
                    jQuery("#applicationName").val(data.application_name);
                    jQuery("#stasisServer").val(data.application_server);
                    jQuery("#stasisPort").val(data.application_port);
                    jQuery("#ariEndpoint").val(data.application_endpoint);
                    jQuery("#ariUsername").val(data.application_username);
                    jQuery("#ariPassword").val(data.application_password);
                },
                "JSON");
        };

        function clearApplicationForm() {
            jQuery("#applicationName").val(null);
            jQuery("#stasisServer").val(null);
            jQuery("#stasisPort").val(null);
            jQuery("#ariEndpoint").val("/ari");
            jQuery("#ariUsername").val(null);
            jQuery("#ariPassword").val(null);
        }

        function generateStasisApplication() {
            var obj = {};
            var selectApp = jQuery("#selectApp").val();

            jQuery.get("<?php echo $this->session->userdata('BASEPATH'); ?>/ajax/generate_app/" + selectApp, obj,
                function (data) {
                    console.log(data);
                    jQuery("#generatedCode").val(data.sourcecode);
                },
                "JSON");
        }
        ;

        function executeStasisApplication() {
            var obj = {};
            var selectApp = jQuery("#selectApp").val();

            jQuery.get("<?php echo $this->session->userdata('BASEPATH'); ?>/ajax/exec_app/" + selectApp, obj,
                function (data) {
                    console.log(data);
                    alert(data.message);
                },
                "JSON");
        }
        ;

        function submitEventCode() {
            var obj = {
                sourcecode: jQuery("#eventCode").val(),
                event: jQuery("#eventname").val(),
                appid: jQuery("#appid").val()
            };

            jQuery.post("<?php echo $this->session->userdata('BASEPATH'); ?>/ajax/update_event", obj,
                function (data) {
                    console.log(data);
                    alert(data.message);
                },
                "JSON");
        }
    </script>
</body>
</html>