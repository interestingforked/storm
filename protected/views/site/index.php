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
	    <!-- <embed width="100%" height="405" allowscriptaccess="sameDomain" wmode="opaque" quality="high" bgcolor="#000000" name="LiquidFlash" id="LiquidFlash" src="/assets/work_files/index_flash.swf" type="application/x-shockwave-flash"> -->
	   </div>
	   <br/><br/>