<?php echo $this->Html->script('ajax-pagging.js'); ?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
         Manage Categories 
      </h1>
      <ol class="breadcrumb">
          <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller'=>'admins', 'action'=>'dashboard'), array('escape'=>false));?></li>
          <li class="active"> Categories List </li>
      </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="ersu_message"> <?php echo $this->Flash->render() ?></div>
            <div class="admin_search">
                <?php echo $this->Form->create(Null, ['id'=>'adminSearch']); ?>
                    <div class="form-group align_box dtpickr_inputs">
                       <span class="hints">Search by Category Name</span>
                       <span class="hint">
                           <?php echo $this->Form->input('Categories.keyword', ['label'=>false, 'type'=>'text',  'div'=>false, 'class'=>'form-control', 'placeholder'=>'Search by keyword']); ?>
                       </span>
                      
                       <div class="admin_asearch">
                            <div class="ad_s ajshort"> <?php echo $this->Form->button('Search', ['class'=>'btn btn-info admin_ajax_search', 'type'=>'button']); ?></div>
                            <div class="ad_cancel"> <?php echo $this->Html->link('Clear Search', ['controller'=>'categories', 'action'=>'index'], ['escape'=>false, 'class'=>'btn btn-default canlcel_le']);?></div>
                       </div>
                    </div>
                <?php echo $this->Form->end(); ?>
                <div class="add_new_record"><?php echo $this->Html->link('<i class="fa fa-plus"></i> Add Category', ['controller'=>'categories', 'action'=>'add'], ['escape'=>false, 'class'=>'btn btn-default']);?></div>
            </div>
            <div class="m_content" id="listID">
                <?php echo $this->element("Admin/Categories/index"); ?>
            </div>
            
        </div>
    </section>
</div>
