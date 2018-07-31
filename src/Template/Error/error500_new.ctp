<?php
$this->layout = 'error';
$this->assign('title', 'Page Not Found');
?>
<div class="inner_bodyarea">
    <div class="wrapper">
        <div class="errr"> 
            <div class="not_foun_serc">
                <div class="not_foun_serc_cell">
                    <div class="im_not_found">
                        <a href="<?php echo HTTP_PATH;?>"><img src="<?php echo HTTP_PATH; ?>/img/404.png" /></a>
                        <div class="clear"></div>

                        <div class="clear"></div>
                        <p></p>
                    </div>        
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    .right_part_fulls_not_found{padding:50px 30px; text-align: center;}
    .not_foun_serc{width: 100%; height: 100%; display: table; vertical-align: middle;}
    .not_foun_serc img{vertical-align: middle; }
    .not_foun_serc_cell{display: table-row; width: 100%;}
    .im_not_found{display: table-cell; vertical-align: middle; text-align: center; padding-top: 50px;}

</style>