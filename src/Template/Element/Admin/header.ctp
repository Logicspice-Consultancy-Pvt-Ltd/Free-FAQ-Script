<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo HTTP_PATH; ?>/admin/admins/dashboard" class="logo">
        <span class="logo-mini"><b><?php
     echo $this->Html->image('mini-logo.png');
    ?></b></span>
        <span class="logo-lg"><?php
     echo $this->Html->image('logo.png');
    ?></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                        <?php //echo $this->Html->image('user2-160x160.jpg', ['alt' => SITE_TITLE, "class" => "user-image"]); ?>
                        <span class="hidden-xs"><?php echo $this->request->session()->read('admin_username') ?></span>
                    </a>
                </li>
                <li><?php echo $this->Html->link('<i class="fa fa-sign-out fa-lg"></i> Logout', ['controller' => 'admins', 'action' => 'logout'], ['escape' => false]); ?>  </li>

            </ul>
        </div>
    </nav>
</header>