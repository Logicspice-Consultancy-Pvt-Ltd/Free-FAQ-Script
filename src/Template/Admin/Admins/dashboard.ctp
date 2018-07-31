<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            <!-- Faq Count !-->

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $total_faqs; ?></h3>
                        <p>Faqs</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-question-circle"></i>
                    </div>
                    <?php echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>', ['controller' => 'faqs', 'action' => 'index'], ['escape' => false, 'title' => 'More info', 'class' => 'small-box-footer']); ?>
                </div>
            </div>

            <div class="col-lg-12 col-xs-12">
                <h4 class="admin_st">Faq Statistics</h2>
                    <div class="relative_box_esjad">
                        <div class="company_tab">
                            <span class="cpc" id="cchart0" onclick="updateFaq(0)">Today</span>
                            <span class="cpc" id="cchart1"  onclick="updateFaq(1)">Yesterday</span>
                            <span class="cpc active" id="cchart2"  onclick="updateFaq(2)">Last 30 days</span>
                            <span  class="cpc" id="cchart3" onclick="updateFaq(3)">Last 12 months</span>
                        </div>
                        <div class="chart_loader" id="faq_chart_loader"><?php echo $this->Html->image('website_load.svg'); ?></div>
                        <div class="admin_chart" id="faq_chart"></div>
                    </div>
            </div>
        </div>



    </section>
</div>

<script>
    $(function () {
        updateFaq(2);
    });

    function updateFaq(daycnt) {
        $('.cpc').removeClass('active');
        $('#cchart' + daycnt).addClass('active');
        $.ajax({
            type: 'POST',
            url: '<?php echo HTTP_PATH; ?>/admin/admins/faqChart/' + daycnt,
            beforeSend: function () {
                $("#faq_chart_loader").show();
            },
            success: function (result) {
                $("#faq_chart").html(result);
            }

        });
    }

</script>