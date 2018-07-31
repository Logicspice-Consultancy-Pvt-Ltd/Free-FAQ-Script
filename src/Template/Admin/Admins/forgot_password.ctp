<script type="text/javascript">
    $(document).ready(function() {
        $("#adminlogin").validate();
    });

</script>
<div class="login-logo">
    <b>Forgot Password</b>
</div>
<div class="login-box-body">
    <p class="login-box-msg">Forgot Password</p>
    <?= $this->Flash->render() ?>
    <?php echo $this->Form->create($admin, ['id'=>'adminlogin']); ?>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('Admins.email', ['label'=>false, 'type'=>'text',  'div'=>false, 'class'=>'form-control required email', 'placeholder'=>'Email Address']); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox">
                     <?php echo $this->Html->link('I remember my password', ['action' => 'login']); ?>
                </div>
            </div>
            <div class="col-xs-4">
                <?php echo $this->Form->button('Submit', ['class'=>'btn btn-primary btn-block btn-flat']); ?>
            </div>
        </div>
    <?php  echo $this->Form->end(); ?>   
</div>