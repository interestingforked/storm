<div class="flash-wrapper">
	    <div class="over-flash">
		 <div class="flash-column"><?php echo $block1; ?></div>
		 <div class="flash-column central">
                     <h2><?php echo $page->content->title; ?></h2>
                     <p>
                         <?php 
                         foreach ($articles AS $article): 
                             echo CHtml::link($article->content->title, array('/'.$page->slug.'/'.$article->slug)).'<br/>';
                         endforeach;
                         ?>
                     </p>
                 </div>
		 <div class="flash-column"><?php echo $block2; ?></div>
		</div>
	    <embed width="690" height="406" allowscriptaccess="sameDomain" wmode="opaque" quality="high" bgcolor="#000000" name="LiquidFlash" id="LiquidFlash" src="/images/index_flash.swf" type="application/x-shockwave-flash"> 
	   </div>
	   <div class="official">Official STORM website &copy; 2011 STORM</div>
<br/>