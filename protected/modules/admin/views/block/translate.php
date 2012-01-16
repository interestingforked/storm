<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Blocks / Translate block : <?php echo $title; ?></h2>
    </div>
    <div class="block_content">
        <?php 
        echo $this->renderPartial('_form_translate', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
        ));
        ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>