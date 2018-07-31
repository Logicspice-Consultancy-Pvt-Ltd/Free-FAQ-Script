<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTTP_PATH; ?>/img/front/favicon.ico" />   
        <title><?php echo isset($title_for_layout) ? $title_for_layout : SITE_TITLE; ?></title>

        <!-- Bootstrap -->
        <?php echo $this->Html->css('front/bootstrap.min.css'); ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php echo $this->Html->css('front/font-awesome.css'); ?>
        <?php echo $this->Html->script('front/jquery.min.js'); ?>
        <?php // echo $this->Html->script('front/bootstrap.min.js'); ?>
    </head>

    <body>

        <?php echo $this->element('header'); ?>
        <?php echo $this->fetch('content'); ?>
        <?php echo $this->element('footer'); ?>

        <div id="toTop"><img src="<?php echo HTTP_PATH; ?>/img/front/arrow-top.png" alt="top"></div>
        <script type="text/javascript">

            $(window).scroll(function () {
                if ($(this).scrollTop() > 0) {
                    $('#toTop').fadeIn();
                } else {
                    $('#toTop').fadeOut();
                }
            });

            $('#toTop').click(function () {
                $('body,html').animate({scrollTop: 0}, 800);
            });

        </script>
    </body>
</html>
