<?php
if($status=='1'){
	echo $this->Html->link('<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>', $action, ["escape"=>false,'title' => 'Deactivate']);
}else{
	echo $this->Html->link('<button class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button>', $action, ["escape"=>false,'title' => 'Activate']);
}
?>