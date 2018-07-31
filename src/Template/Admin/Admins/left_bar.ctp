<script type="text/javascript">
    $(document).ready(function () {
        $("#adminForm").validate();
    });

</script>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
         Manage Sidebar
        </h1>
        <ol class="breadcrumb">
            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', array('controller' => 'admins', 'action' => 'dashboard'), array('escape' => false)); ?></li>
            <li><a href="javascript:void(0);"><i class="fa fa-cogs"></i> Configuration</a></li>
            <li class="active">Sidebar</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="ersu_message"> <?php echo $this->Flash->render() ?> </div>
            <?php echo $this->Form->create($admin, ['id' => 'adminForm']); ?>
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label for="happy" class="col-sm-2 control-label">Left  Bar</label>
                        <div class="col-sm-10  new_design">
                            <div class="input-group">
                                <div id="radioBtn" class="btn-group">
                                    <a class="btn btn-primary btn-sm <?php echo  $adminInfo->leftbar ? 'active':'notActive'?>" data-toggle="leftbar" data-title="1">Show</a>
                                    <a class="btn btn-primary btn-sm <?php echo $adminInfo->leftbar ? 'notActive':'active'?>" data-toggle="leftbar" data-title="0">Hide</a>
                                </div>
                                <?php echo $this->Form->hidden('Admins.leftbar', ['id'=>'leftbar']);?>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <label class="col-sm-2 control-label" for="inputPassword3">&nbsp;</label>
                        <?php echo $this->Form->button('Submit', ['type' => 'submit', 'class' => 'btn btn-info', 'div' => false]); ?>
                        <?php echo $this->Html->link('Cancel', ['action' => 'dashboard'], ['class' => 'btn btn-default canlcel_le']); ?>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </section>
</div>



<script>

    $('#radioBtn a').on('click', function () {
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        $('#' + tog).prop('value', sel);

        $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
    })
</script>