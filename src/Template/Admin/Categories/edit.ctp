<script type="text/javascript">
    $(document).ready(function () {
        $("#adminForm").validate();
    });

</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit Category
        </h1>
        <ol class="breadcrumb">
            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', ['controller' => 'admins', 'action' => 'dashboard'], ['escape' => false]); ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-table"></i> Categories ', ['controller' => 'categories', 'action' => 'index'], ['escape' => false]); ?></li>
            <li class="active">Edit Category </li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="ersu_message"> <?php echo $this->Flash->render() ?> </div>
            <?php echo $this->Form->create($categories, ['id' => 'adminForm', 'type' => 'file']); ?>
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Category Name <span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->input('Categories.name', ['label' => false, 'type' => 'text', 'div' => false, 'class' => 'form-control required', 'placeholder' => 'Category Name', 'autocomplete' => 'off']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Order By<span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->input('Categories.order_by', ['label' => false, 'type' => 'text', 'div' => false, 'class' => 'form-control required', 'placeholder' => 'Order By', 'autocomplete' => 'off']); ?>
                        </div>
                    </div>

                    <div class="box-footer">
                        <label class="col-sm-2 control-label" for="inputPassword3">&nbsp;</label>
                        <?php echo $this->Form->input('Categories.id', ['label' => false, 'type' => 'hidden']); ?>
                        <?php echo $this->Form->button('Submit', ['type' => 'submit', 'class' => 'btn btn-info', 'div' => false]); ?>
                        <?php echo $this->Html->link('Cancel', ['controller' => 'categories', 'action' => 'index'], ['class' => 'btn btn-default canlcel_le']); ?>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </section>
</div>
