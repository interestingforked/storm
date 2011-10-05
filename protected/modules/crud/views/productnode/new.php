<h1>Create Product node</h1>

<?php 
echo $this->renderPartial('_form', array(
        'errors' => $errors,
        'model' => $model,
    )
);
?>