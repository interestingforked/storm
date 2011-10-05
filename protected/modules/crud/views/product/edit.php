<h1>Update Product <?php echo $productModel->id; ?></h1>

<?php 
echo $this->renderPartial('_form', array(
        'errors' => $errors,
        'categories' => $categories,
        'productModel' => $productModel,
        'contentModel' => $contentModel,
        'activeCategories' => $activeCategories,
        'attachmentModels' => $attachmentModels,
    )
);
?>