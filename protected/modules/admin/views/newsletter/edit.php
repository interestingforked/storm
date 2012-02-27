<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Newsletters / Edit newsletter : <?php echo $title; ?></h2>
    </div>
    <div class="block_content">
        <?php 
        echo $this->renderPartial('_form', array(
            'errors' => $errors,
            'model' => $model,
            'userStatuses' => $userStatuses
        ));
        ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>