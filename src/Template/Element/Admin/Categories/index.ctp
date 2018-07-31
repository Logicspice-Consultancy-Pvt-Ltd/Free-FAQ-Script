<div class="admin_loader" id="loaderID"><?php echo $this->Html->image('loader_large_blue.gif'); ?></div>
<?php if (!$categories->isEmpty()) { ?> 
    <div class="panel-body">
        <div class="ersu_message"> <?php echo $this->Flash->render() ?></div>
        <?php echo $this->Form->create('Categories', ['id' => 'actionFrom', "method" => "Post"]); ?>
        <section id="no-more-tables" class="lstng-section">
            <div class="topn">
                <div class="topn_left">Categories List</div>
                <div class="topn_right ajshort" id="pagingLinks" align="right">
                    <?php
                    $this->Paginator->options(array('update' => '#listID', 'url' => ['controller' => 'categories', 'action' => 'index', $separator]));
                    echo $this->Paginator->counter('{{page}} of {{pages}} &nbsp;');
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
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('name', 'Category Name'); ?></th> 
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('order_by', 'Order By'); ?></th> 
                            <th class="sorting_paging"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                            <th class="action_dvv"><i class=" fa fa-gavel"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) { ?>
                            <?php //pr($category); exit;?> 
                            <tr>
                                <td data-title=""><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId[]" value="<?php echo $category->id; ?>" /></td>
                                <td data-title="Category Name"><?php echo $category->name; ?></td>
                                <td data-title="Order By"><?php echo $category->order_by; ?></td>
                                <td data-title="Created"><?php echo date('M d, Y', strtotime($category->created)); ?></td>
                                <td data-title="Action">
                                    <div id="loderstatus<?php echo $category->id; ?>" class="right_action_lo"><?php echo $this->Html->image("loading.gif"); ?></div>
                                    <span class="right_acdc" id="status<?php echo $category->id; ?>">
                                        <?php
                                        if ($category->status == '1') {
                                            echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', ['controller' => 'categories', 'action' => 'deactivatecategory', $category->slug], ['escape' => false, 'title' => 'Deactivate']);
                                        } else {
                                            echo $this->Html->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', ['controller' => 'categories', 'action' => 'activatecategory', $category->slug], ['escape' => false, 'title' => 'Activate']);
                                        }
                                        ?>
                                    </span>

                                    <?php echo $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'categories', 'action' => 'edit', $category->slug], ['escape' => false, 'title' => 'Edit', 'class' => 'btn btn-primary btn-xs']); ?>
                                    <?php echo $this->Html->link('<i class="fa fa-trash-o"></i>', ['controller' => 'categories', 'action' => 'deletecategory', $category->slug], ['escape' => false, 'title' => 'Delete', 'class' => 'btn btn-danger btn-xs action-list delete-list', 'confirm' => 'Are you sure you want to Delete ?']); ?>

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
            echo $this->Form->input('Categories.keyword', ['label' => false, 'type' => 'hidden', 'value' => $keyword]);
        }
        ?>
        <?php echo $this->Form->end(); ?>

    </div>
<?php } else { ?>
    <div id="listingJS" style="display: none;" class="alert alert-success alert-block fade in"></div>
    <div class="admin_no_record">No record found.</div>
<?php }
?>