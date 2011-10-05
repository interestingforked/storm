<h1>Create Product</h1>

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