
<?php echo $this->Html->css('front/accordiancss/reset.css'); ?>
<?php echo $this->Html->css('front/accordiancss/style.css'); ?>
<?php echo $this->Html->script('front/accordian/modernizr.js'); ?>
<?php

use Cake\ORM\TableRegistry;
?>
<section class="cd-faq">

    <div class="container">
        <div class="row">
            <div class="inner_wrap">
                <?php if ($adminInfo->leftbar) { ?>
                    <ul class="cd-faq-categories" >
                        <?php
                        $i = 0;
                        if ($categoriesList) {
                            foreach ($categoriesList as $categoriesLists) {
                                ?>
                                <li><a class = "<?php echo $i == 0 ? "selected" : '' ?>" href = "#<?php echo $categoriesLists->slug; ?>"><?php echo $categoriesLists->name; ?></a></li>

                                <?php
                                $i++;
                            }
                        }
                        ?>

                    </ul>
                <?php } ?>

                <div class = "cd-faq-items" style="width:<?php echo $adminInfo->leftbar ? '80%':'100%';?>">

                    <?php
                    $i = 0;
                    if ($categoriesList) {
                        foreach ($categoriesList as $categoriesLists) {
                            ?>
                            <ul id = "<?php echo $categoriesLists->slug; ?>" class = "cd-faq-group">
                                <li class = "cd-faq-title"><h2><?php echo $categoriesLists->name; ?></h2></li>
                                <?php
                                $this->Faqs = TableRegistry::get('Faqs');
                                $faqsList = $this->Faqs->find()->contain(['Categories'])->where(['Faqs.status' => '1', 'Faqs.category_id' => $categoriesLists->id])->all();
                                if (count($faqsList) > 0) {
                                    foreach ($faqsList as $faqsLists) {
                                        ?>
                                        <li>
                                            <a class = "cd-faq-trigger" href = "#0"><?php echo $faqsLists->question; ?></a>
                                            <div class = "cd-faq-content">
                                                <?php echo $faqsLists->answer; ?>
                                            </div> <!--cd-faq-content -->
                                        </li>

                                        <?php
                                    }
                                } else {
                                    echo "<li> <p class='norecordfont'>No FAQ's are available.</p></li>";
                                }
                                echo '</ul>';
                            }
                        } else {
                            echo "<div class='norecordfont'>No FAQ's are available.</div>";
                        }
                        ?>
                </div>
            </div>
        </div>
    </div><!-- cd-faq-items -->

</section> 


<?php echo $this->Html->script('front/accordian/main.js'); ?>
<?php echo $this->Html->script('front/jquery.mobile.custom.min.js'); ?>
