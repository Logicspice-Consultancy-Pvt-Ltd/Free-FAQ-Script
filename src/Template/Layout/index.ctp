<?php
/**
 Article Main View
*/

$Description = 'Tutorial'; 
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $Description ?>:
        <?= $this->fetch('title') ?>
        <a href="../../Model/Table/UsersTable.php"></a>
        <a href="../../Model/Table/UsersTable.php"></a>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
     <?= $this->Html->css('custom-style.css') ?>
<a href="../../Model/Table/UsersTable.php"></a>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?php echo $this->element('Articles/header');?>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <section class="article-view-section">
        <?= $this->fetch('content') ?>
        </section>
    </div>
    <?php echo $this->element('Articles/footer');?>
</body>
</html>
