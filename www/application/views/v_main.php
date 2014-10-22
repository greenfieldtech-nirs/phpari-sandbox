<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>ARI/Stasis Sandbox</title>
    <meta name="generator" content="Bootply"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../css/styles.css" rel="stylesheet">
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
                <li class="nav-header"><h5>Application Manager </h5>
                    <ul class="list-unstyled " id="userMenu">
                        <li><a href="#">Create Application</a></li>
                        <?php
                            foreach ($applications as $application) {
                                ?>
                                <li><a href="#"><i
                                            class="glyphicon glyphicon-cog"></i> <?php echo $application->application_name; ?>
                                    </a></li>
                            <?php
                            }
                        ?>
                    </ul>
                </li>
            </ul>
            <ul class="list-unstyled">
                <li class="nav-header"><h5>Event Handlers </h5>
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
                </li>
            </ul>

        </div>
        <!-- /col-3 -->
        <div class="col-sm-10">

            <a href="#"><strong> Application: </strong></a>

            <hr>

            <div class="row">

                <!-- center left-->
                <div class="col-md-6">
                    <div class="well"><strong>Event Code</strong>
                        <hr>
                        <input type="hidden" name="appid" id="appid" value="">
                        <input type="hidden" name="eventname" id="eventname" value="">
                        <textarea cols="88" rows="24" draggable="false" name="eventCode" id="eventCode"></textarea>
                        <button type="button" class="btn btn-success" onclick="submitEventCode(); return false;">
                            Submit
                        </button>
                    </div>


                </div>
                <!--/col-->
                <div class="col-md-6">
                    <div class="well"><strong>Generated Code</strong>
                        <hr>
                        <textarea cols="88" rows="24" draggable="false" name="generatedCode"
                                  id="generatedCode"></textarea>
                        <select class="form-control" name="selectApp" id="selectApp">
                            <?php
                                foreach ($applications as $application) {
                                    ?>
                                    <option><?php echo $application->application_name; ?></option>
                                <?php
                                }
                            ?>
                        </select>
                        <br/>
                        <button type="button" class="btn btn-general"
                                onclick="generateStasisApplication(); return false;">Generate
                        </button>
                        <button type="button" class="btn btn-success"
                                onclick="executeStasisApplication(); return false;">Execute
                        </button>

                    </div>
                </div>
                <!--/col-span-6-->

            </div>
            <!--/row-->


        </div>
        <!--/col-span-9-->
    </div>
</div>
<!-- /Main -->

<!-- script references -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>

<script>

    function loadEventCode(appname, event) {
        var obj = {};

        jQuery.get("../index.php/ajax/get_event_code/" + appname + "/" + event, obj,
            function (data) {
                console.log(data);
                jQuery("#eventCode").val(data.sourcecode);
                jQuery("#appid").val(data.application_id);
                jQuery("#eventname").val(data.stasis_event);
            },
            "JSON");
    };

    function generateStasisApplication() {
        var obj = {};
        var selectApp = jQuery("#selectApp").val();

        jQuery.get("../index.php/ajax/generate_app/" + selectApp, obj,
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

        jQuery.get("../index.php/ajax/exec_app/" + selectApp, obj,
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

        jQuery.post("../index.php/ajax/update_event", obj,
            function (data) {
                console.log(data);
                alert(data.message);
            },
            "JSON");
    }
</script>
</body>
</html>