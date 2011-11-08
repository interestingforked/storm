<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if ( ! empty($this->metaTitle))
    $this->pageTitle .= ' - '.$this->metaTitle;
?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="description" content="<?php echo CHtml::encode($this->metaDescription); ?>" />
<meta name="keywords" content="<?php echo CHtml::encode($this->metaKeywords); ?>" />
<link href="/css/style.css" type="text/css" rel="stylesheet" />
<link href="/css/content.css" type="text/css" rel="stylesheet" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="/css/ie6.css" media="all" /><![endif]-->

<?php if ( ! isset(Yii::app()->clientScript->corePackages['autocomplete'])): ?>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<?php endif; ?>
<script type="text/javascript" src="/js/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="/js/jquery.mousewheel-3.0.4.pack.js"></script> 
<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.fancybox-1.3.4.css" media="screen" /> 
<script type="text/javascript">
function formatTitle(title, currentArray, currentIndex, currentOpts) {
    return '<div class="formatTitle">' + (title && title.length ? '<h3>' + title + '</h3>' : '' ) + 'Image ' + (currentIndex + 1) + ' of ' + currentArray.length + '</div>';
}
$(document).ready(function() {
    $('.modal').fancybox({
        'scrolling':'no','centerOnScroll':true,'titleShow':false
    });
    $('a[rel=group]').fancybox({
        'transitionIn':'none', 
        'transitionOut':'none', 
        'titlePosition':'over', 
        'titleFormat':formatTitle, 
        'cyclic':true
    });
});
</script>

</head>
<?php 
$class = "";
if (Yii::app()->controller->route == 'site/index')
    $class = ' class="index"';
if (Yii::app()->controller->route == 'product/index')
    $class = ' class="product-page"';

$background = '';
if ( ! empty($this->background)) {
    $background = 'style="background-image:url('.Yii::app()->params['backgrounds'].$this->background.');"';
}

?>
<body>

<div id="layout" <?php echo $class; ?>>
 <div id="container">
  <div id="right-wrapper">
   <div id="col-right">
    <div id="content-wrapper" <?php echo $background; ?>>
	 <div class="inner">
	  <div class="content">
              <?php echo $content; ?>
	  </div>
	 </div>
	</div>
   </div>
  </div>
  
  <div id="col-left">
   <div class="logo"><a href="/"><img src="/images/storm_london_logo.gif" width="157" height="86"/></a></div>
   <div id="navigation">
       <?php
       $this->widget('zii.widgets.CMenu', array(
           'items' => $this->categories['items'],
           'activeCssClass' => 'current',
           'activateParents' => true,
       ));
       ?>
       <?php
       $this->widget('zii.widgets.CMenu', array(
           'items' => $this->menu['items'],
           'id' => 'navigation-info',
           'activeCssClass' => 'current',
           'activateParents' => true,
       ));
       ?>
   </div>
  </div>
 </div>
 
 <?php if (Yii::app()->controller->route != 'site/index'): ?>
 <div id="crumbs">
   <?php if (isset($this->breadcrumbs)): ?>
         <?php
         $this->widget('zii.widgets.CBreadcrumbs', array(
             'links' => $this->breadcrumbs,
             'separator' => ' <em>/</em> ',
         ));
         ?>
    <?php endif ?>
 </div>
 <?php endif; ?>
 
 <div id="footer">
  <div class="inner">
   <div class="search">
       <?php echo $this->search(); ?>
   </div>
   
   <div class="menu">
       <?php echo $this->bottomMenu(); ?>
   </div>
  </div>
 </div>
 
 </div> 

</body>
</html>


