<?php echo $this->Html->script('facebox.js'); ?>
<?php echo $this->Html->css('facebox.css'); ?>
<script type="text/javascript">
    $(document).ready(function ($) {
        $('.close_image').hide();
        $('a[rel*=facebox]').facebox({
            loadingImage: '<?php echo HTTP_IMAGE ?>/loading.gif',
            closeImage: '<?php echo HTTP_IMAGE ?>/close.png'
        })


    })


</script>
<div class="admin_loader" id="loaderID"><?php echo $this->Html->image('loader_large_blue.gif'); ?></div>
<?php if (!$faqs->isEmpty()) { ?> 
    <div class="panel-body">
        <div class="ersu_message"> <?php echo $this->Flash->render() ?></div>
        <?php echo $this->Form->create('', ['id' => 'actionFrom', "method" => "Post"]); ?>
        <section id="no-more-tables" class="lstng-section">
            <div class="topn">
                <div class="topn_left">FAQ List</div>
                <div class="topn_right ajshort" id="pagingLinks" align="right">
                    <?php
                    $this->Paginator->options(array('update' => '#listID', 'url' => ['controller' => 'faqs', 'action' => 'index', $separator]));
                    echo $this->Paginator->counter();
                    echo $this->Paginator->prev('« Prev');
                    echo $this->Paginator->numbers();
                    echo $this->Paginator->next('Next »');
                    ?>
                </div>
            </div>   

            <div class="tbl-resp-listing">
                <table class="table table-bordered table-striped table-condensed cf">
                    <thead class="cf ajshort">
                        <tr>
                            <th style="width:5%">#</th>
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('category_id', 'Category'); ?></th>
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('question', 'Question'); ?></th>
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('answer', 'Answer'); ?></th>
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                            <th class="action_dvv"><i class=" fa fa-gavel"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($faqs as $faq) { ?>

                            <tr>
                                <td data-title=""><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId[]" value="<?php echo $faq->id; ?>" /></td>
                                <td data-title="Category"><?php echo $faq['categories']->name ? $faq['categories']->name : 'N/A'; ?></td>
                                <td data-title="Question"><?php echo $faq->question ? $faq->question : 'N/A'; ?></td>
                                <td data-title="Answer"><?php echo $faq->answer ? $faq->answer : 'N/A'; ?></td>
                                <td data-title="Created"><?php echo date('M d, Y', strtotime($faq->created)); ?></td>
                                <td data-title="Action">
                                    <div id="loderstatus<?php echo $faq->id; ?>" class="right_action_lo"><?php echo $this->Html->image("loading.gif"); ?></div>
                                    <span class="right_acdc" id="status<?php echo $faq->id; ?>">
                                        <?php
                                        if ($faq->status == '1') {
                                            echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', ['controller' => 'faqs', 'action' => 'deactivate', $faq->slug], ['escape' => false, 'title' => 'Deactivate', 'class' => 'deactivate']);
                                        } else {
                                            echo $this->Html->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', ['controller' => 'faqs', 'action' => 'activate', $faq->slug], ['class' => "activate", 'escape' => false, 'title' => 'Activate']);
                                        }
                                        ?>
                                    </span>

                                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'faqs', 'action' => 'edit', $faq->slug], ['escape' => false, 'title' => 'Edit', 'class' => 'btn btn-primary btn-xs']); ?>
                                    <?php echo $this->Html->link('<i class="fa fa-trash-o"></i>', ['controller' => 'faqs', 'action' => 'delete', $faq->slug], ['escape' => false, 'title' => 'Delete', 'class' => 'btn btn-danger btn-xs action-list delete-list', 'confirm' => 'Are you sure you want to Delete ?']); ?>
                                    <a href="#info<?php echo $faq->id; ?>" rel="facebox" title="View" class="btn btn-info btn-xs eyee"><i class="fa fa-eye "></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="search_frm">
            <button type="button" name="chkRecordId" onclick="checkAll(true);"  class="btn btn-info">Select All</button>
            <button type="button" name="chkRecordId" onclick="checkAll(false);" class="btn btn-info">Unselect All</button>
            <?php
            $arr = array(
                "" => "Action for selected record",
                'Activate' => "Activate",
                'Deactivate' => "Deactivate",
                'Delete' => "Delete",
            );
            ?>
            <div class="list_sel"><?php echo $this->Form->input('action', ['options' => $arr, 'type' => 'select', 'label' => false, 'class' => "small form-control", 'id' => 'action']); ?></div>
            <button type="submit" class="small btn btn-success btn-cons btn-info" onclick="return ajaxActionFunction();" id="submit_action">OK</button>
        </div>
        <?php
        if (isset($keyword) && $keyword != '') {
            echo $this->Form->input('Faqs.keyword', ['label' => false, 'type' => 'hidden', 'value' => $keyword]);
        }
        ?>
        <?php echo $this->Form->end(); ?>

    </div>
<?php } else { ?>
    <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
    <div class="admin_no_record">No record found.</div>
<?php }
?>

<?php foreach ($faqs as $faq) { ?>
    <div id="info<?php echo $faq->id; ?>" style="display: none;">
        <!-- Fieldset -->
        <div class="nzwh-wrapper">
            <fieldset class="nzwh">
                <legend class="head_pop">
                    FAQ Details
                </legend>
                <div class="drt">
                    <div class="admin_pop">
                        <span>Category : </span>  <label><?php echo $faq['categories']->name ? $faq['categories']->name : 'N/A'; ?></label>
                    </div>
                    <div class="admin_pop">
                        <span>Question: </span>  <label><?php echo $faq->question ? $faq->question : 'N/A'; ?></label>
                    </div>
                    <div class="admin_pop">
                        <span>Answer : </span>  <label><?php echo $faq->answer ? $faq->answer : 'N/A'; ?></label>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
<?php } ?>