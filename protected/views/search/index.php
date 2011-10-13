<?php
$this->pageTitle = Yii::app()->name . ' - ' . $page;
?>

<h1><?php echo $page; ?></h1>
<div class="hr-title"><hr/></div>
<?php 
if (isset($result['page'])):
    echo '<h2>'.Yii::t('app', 'Pages').'</h2>';
    echo '<ul>';
    foreach ($result['page'] AS $record):
        echo '<li>'.CHtml::link($record['title'], array('/'.$record['slug'])).'</li>';
    endforeach;
    echo '</ul><br/>';
endif; 
if (isset($result['article'])):
    echo '<h2>'.Yii::t('app', 'Articles').'</h2>';
    echo '<ul>';
    foreach ($result['article'] AS $record):
        echo '<li>'.CHtml::link($record['title'], array('/'.$record['slug'])).'</li>';
    endforeach;
    echo '</ul><br/>';
endif; 
?>