<?php
$this->pageTitle = Yii::app()->name . ' - ' . $category->content->title;
?>

<h1><?php echo $category->content->title; ?></h1>
<div class="hr-title"><hr /></div>
<?php echo $category->content->body; ?>
<?php if ($category->childs): ?>
<div class="prod-wrapper center">
<table class="category">
<?php 
foreach ($category->childs AS $child): 
if ($child->active != 1) {
    continue;
}
$childCategory = Category::model()->getCategory($child->slug);
?>
<tr>
 <td>
     <?php echo CHtml::link(CHtml::image(Yii::app()->params['categories'].$childCategory->image), $childCategory->slug); ?>
 </td>
 <td class="sec-row">
     <?php echo CHtml::link('<h2>'.$childCategory->content->title.'</h2>', $childCategory->slug); ?>
     <?php echo $childCategory->content->body; ?>
 </td>
</tr>
<?php endforeach; ?>
</table>
</div>
<?php endif; ?>