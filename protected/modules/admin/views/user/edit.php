<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Users / Edit user : <?php echo $title; ?></h2>
    </div>
    <div class="block_content">
        <?php 
        echo $this->renderPartial('_form', array(
            'errors' => $errors,
            'model' => $model,
            'profile' => $profile,
            'rangeSex' => $rangeSex,
            'rangeAge' => $rangeAge,
        ));
        ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>