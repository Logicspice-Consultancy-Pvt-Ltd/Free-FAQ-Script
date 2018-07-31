<?php echo $this->Html->script('ckeditor/ckeditor.js'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace('Faqs[answer]', {
            toolbarGroups:
                    [
                        {name: 'document', groups: ['mode', 'document', 'doctools']},
                        {name: 'clipboard', groups: ['clipboard', 'undo']},
                        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
                        {name: 'forms'},
                        '/',
                        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
                        {name: 'links'},
                        {name: 'insert'},
                        '/',
                        {name: 'styles'},
                        {name: 'colors'},
                        {name: 'tools'},
                        {name: 'others'},
                        {name: 'about'}
                    ],
            filebrowserUploadUrl: '<?php echo HTTP_PATH; ?>/admin/faqs/faqimages',
            language: '',
            height: 300,
            //uiColor: '#884EA1'
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#adminForm").validate();
    });

</script>
<?php
use Cake\ORM\TableRegistry;
$this->categories = TableRegistry::get('categories');
$query = $this->categories->find('list', [
            'keyField' => 'id',
            'valueField' => function ($e) {
                return $e->get('name');
            }
        ])->where(['parent_id' => 0]);
$categories = $query->toArray();
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit FAQ
        </h1>
        <ol class="breadcrumb">
            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span> ', ['controller' => 'admins', 'action' => 'dashboard'], ['escape' => false]); ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-question-circle"></i> Faqs ', ['controller' => 'faqs', 'action' => 'index'], ['escape' => false]); ?></li>
            <li class="active">Edit FAQ </li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">&nbsp;</h3>
            </div>
            <div class="ersu_message"> <?php echo $this->Flash->render() ?> </div>
            <?php echo $this->Form->create($faqs, ['id' => 'adminForm', 'type' => 'file']); ?>
            <div class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Category<span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->input('Faqs.category_id', ['label' => false, 'type' => 'select', 'options' => $categories, 'empty' => 'Please Select Category', 'class' => 'form-control required', 'id' => 'category_id', 'placeholder' => 'Category List', 'div' => false]); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Question <span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->input('Faqs.question', ['label' => false, 'type' => 'text', 'div' => false, 'class' => 'form-control required', 'placeholder' => 'Question']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Answer<span class="require">*</span></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->input('Faqs.answer', array('label' => false, 'type' => 'textarea', 'class' => 'form-control required', 'autocomplete' => 'off')); ?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <label class="col-sm-2 control-label" for="inputPassword3">&nbsp;</label>
                        <?php echo $this->Form->input('Faqs.id', ['label' => false, 'type' => 'hidden']); ?>
                        <?php echo $this->Form->button('Submit', ['type' => 'submit', 'class' => 'btn btn-info', 'div' => false]); ?>
                        <?php echo $this->Html->link('Cancel', ['controller' => 'users', 'action' => 'index'], ['class' => 'btn btn-default canlcel_le']); ?>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </section>
</div>
