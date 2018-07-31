<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview <?php if(isset($dashboard)){ echo 'active';} ?>">
                <a href="<?php echo HTTP_PATH;?>/admin/admins/dashboard">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            
            <li class="treeview <?php if(isset($leftBar)) { echo 'active';} ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-gears"></i> <span>Configuration</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($leftBar)){ echo 'active';} ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Manage Sidebar', ['controller'=>'admins', 'action' => 'leftBar'], ['escape'=>false]); ?></li>
                </ul>
            </li>
            
             <li class="treeview <?php if(isset($faqsList) || isset($faqAdd)){ echo 'active';} ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-question-circle"></i> <span>Manage FAQ</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($faqsList)){ echo 'active';} ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> List FAQ', ['controller'=>'faqs', 'action' => 'index'], ['escape'=>false]); ?></li>
                    <li class="<?php if(isset($faqAdd)){ echo 'active';} ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Add FAQ', ['controller'=>'faqs', 'action' => 'add'], ['escape'=>false]); ?></li>
                </ul>
            </li>
            
               <li class="treeview <?php if(isset($categoryList) || isset($categoryAdd)){ echo 'active';} ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-table"></i> <span>Manage Categories</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if(isset($categoryList)){ echo 'active';} ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> List Categories', ['controller'=>'categories', 'action' => 'index'], ['escape'=>false]); ?></li>
                    <li class="<?php if(isset($categoryAdd)){ echo 'active';} ?>"><?php echo $this->Html->link('<i class="fa fa-circle-o"></i> Add Category', ['controller'=>'categories', 'action' => 'add'], ['escape'=>false]); ?></li>
                </ul>
            </li>
            
        </ul>
    </section>
</aside>