<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_PATH; ?>/img/front/favicon.ico" /> 
        <?php echo $this->Html->css('bootstrap.min.css'); ?>
        <?php echo $this->Html->css('AdminLTE.min.css'); ?>
        <?php echo $this->Html->css('all-skins.min.css'); ?>
        <?php echo $this->Html->css('admin.css'); ?>
        <?php echo $this->Html->script('jquery-2.1.0.min.js'); ?>
        <?php echo $this->Html->script('jquery.validate.js'); ?>
        <?php echo $this->Html->script('app.min.js'); ?>
        <?php echo $this->Html->script('listing.js'); ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php echo $this->element('Admin/header'); ?>
            <?php echo $this->element('Admin/left_menu'); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
        <script type="text/javascript">
            window.onload = function () {
                setTimeout("hideSessionMessage()", 8000);
            };
            function hideSessionMessage() {
                $('.ersu_message').fadeOut("slow");
            }
        </script> 
    </body>
</html>
