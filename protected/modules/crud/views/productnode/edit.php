<h1>Update Product node <?php echo $model->id; ?></h1>

<?php 
echo $this->renderPartial('_form', array(
        'errors' => $errors,
        'model' => $model,
        'colors' => $colors,
        'sizes' => $sizes,
        'attachments' => $attachments,
    )
);
?>