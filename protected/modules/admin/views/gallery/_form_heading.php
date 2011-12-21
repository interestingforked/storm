<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gallery-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary(array($model, $contentModel)); 
?>
<p>
    <?php echo $form->labelEx($model, 'parent_id'); ?>
    <span class="note error"><?php echo $form->error($model, 'page_id'); ?></span><br/>
    <select name="Gallery[page_id]" id="Gallery_page_id" class="styled big">
        <?php 
        $rendered = new Renderer();
        $rendered->renderRecursive($pages['items'], $model->page_id, Renderer::RENDER_OPTION_LIST);
        ?>
    </select>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'title'); ?><br/>
    <?php echo $form->textField($contentModel,'title', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($contentModel, 'title'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'language'); ?><br/>
    <?php echo $form->dropDownList($contentModel,'language', $this->languages, array('class' => 'styled small')); ?>
</p>
<p>
    <?php echo $form->labelEx($model, 'sort'); ?><br/>
    <?php echo $form->textField($model,'sort', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($model, 'sort'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'active', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'active'); ?>
    <span class="note error"><?php echo $form->error($model, 'active'); ?></span>
</p>
<hr/>
<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>