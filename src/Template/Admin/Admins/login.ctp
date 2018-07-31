<script type="text/javascript">
    $(document).ready(function() {
        $("#adminlogin").validate();
    });
</script>
<div class="login-logo">
    <?php
     echo $this->Html->image('logo-footer.png');
    ?>
</div>
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?= $this->Flash->render() ?>
    <?php echo $this->Form->create($admin, ['id'=>'adminlogin']); ?>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('Admins.username', ['label'=>false, 'type'=>'text',  'div'=>false, 'class'=>'form-control required', 'placeholder'=>'Username']); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('Admins.password', ['label'=>false, 'type'=>'password',  'div'=>false, 'class'=>'form-control required', 'placeholder'=>'Password']); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label><?php echo $this->Form->input('Admins.remember', ['type' => 'checkbox', 'label'=>false, 'div'=>false]);?> Remember Me
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <?php echo $this->Form->button('Sign In', ['class'=>'btn btn-primary btn-block btn-flat']); ?>
            </div>
        </div>
    <?php  echo $this->Form->end(); ?>

</div>
