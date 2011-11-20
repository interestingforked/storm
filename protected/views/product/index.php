<?php 
$this->pageTitle = Html::formatTitle($product->content->title, $product->content->meta_title). ' - ' . $this->pageTitle;

 $colors = array();
 $sizes = array();
 $images = array();
 $distinctColor = array();
 foreach ($product->productNodes AS $node):
        if ($node->active == 0)
            continue;
        if ( ! empty($node->color)) {
        if ($product->mainNode->id == $node->id) {
            if (in_array($node->color, array_keys($distinctColor))) {
                unset($colors[$distinctColor[$node->color]]);
            }
            $colors[$node->id] = $node->color;
            $distinctColor[$node->color] = $node->id;
            }
            if ( ! in_array($node->color, array_keys($distinctColor))) {
                $colors[$node->id] = $node->color;
                $distinctColor[$node->color] = $node->id;
            }
        }
        if ( ! empty($node->size) AND $product->mainNode->color == $node->color)
        $sizes[$node->id] = $node->size;
         $attachetImages = Attachment::model()->getAttachments('productNode', $node->id);
         if ($attachetImages AND count($attachetImages) > 0) {
             foreach ($attachetImages AS $attachetImage)
                 $images[] = $attachetImage;
         }
        endforeach;
        ?>
        <div id="products">
	    <div id="product-top">
                  <?php
                   $attachetImage = Attachment::model()->getAttachment('productNode', $product->mainNode->id);
                   if ($attachetImage):
                       echo CHtml::image(
                           Image::thumb(Yii::app()->params['images'].$attachetImage->image, 187), 
                           $product->content->title,
                           array(
                               'id' => 'thumbnail',
                               'class' => 'prod-details',
                               'alt' => $attachetImage->alt,
                           )
                       );
                   endif;
                   ?>
                <p class="results"><a href="<?php echo CHtml::normalizeUrl(array($categoryLink)); ?>">&larr; <?php echo Yii::t('app', 'Back to results'); ?></a></p>
                 <p class="side">
                 <?php
                 if ($images):
                    echo CHtml::link('Смотреть картинки&nbsp;&gt;',
                        Yii::app()->params['images'].$images[0]->image,
                        array('rel' => 'group', 'title' => $images[0]->alt)
                    );
                 endif;
                 array_shift($images);
                 ?>
                 </p>
                 <div class="modal-content">
                 <?php 
                 foreach ($images AS $image) {
                     echo CHtml::link(CHtml::image(Yii::app()->params['images'].$image->image),
                             Yii::app()->params['images'].$image->image,
                            array('rel' => 'group', 'title' => $image->alt)
                     );
                 }
                 ?>
                 </div>
                 
                 <?php if ($product->content->additional): ?>
		 <p class="modal"><a href="#product_specs" class="modal"><?php echo Yii::t('app', 'Read specification'); ?> &gt;</a></p>
                 <div class="modal-content">
                 <div id="product_specs">
                     <h3><?php echo Yii::t('app', 'Specification'); ?></h3>
                     <div class="spec">
                        <?php echo $product->content->additional; ?>
                     </div>
                 </div>
                 </div>
                 <?php endif; ?>
		</div>
		<div id="price-info">
		 
		 <div class="tabs">
                 <?php if ($product->mainNode->new == 1): ?>
                    <div class="new"><?php echo Yii::t('app', 'New'); ?></div>
                 <?php endif; ?>
		 </div>
		 
		 <h1><?php echo $product->content->title; ?></h1>
		 <p><?php echo $product->content->body; ?></p>
		 <div class="hr-products"><hr></div>
                 <?php if (count($colors) > 0): ?>
                 <p class="select"><?php echo Yii::t('app', 'Colors'); ?></p>
		 <p>
		  <select onchange="location.href='?node='+this.options[this.selectedIndex].value" class="color-select" id="" name="">
                      <?php foreach($colors AS $ck => $cv): ?>
                          <option value="<?php echo $ck; ?>" <?php echo ((isset($_GET['node']) AND $_GET['node'] == $ck) OR $ck == $product->mainNode->id) ? 'selected' : ''; ?>><?php echo $this->classifier->getValue('color', $cv); ?></option>
                      <?php endforeach; ?>
		  </select>
		  <span class="smaller">(<?php echo Yii::t('app', 'select to view/buy'); ?>)</span>
		 </p>
                 <?php endif; ?>
                 <?php if (count($sizes) > 0): ?>
                 <p class="select"><?php echo Yii::t('app', 'Sizes'); ?></p>
		 <p>
		  <select onchange="location.href='?node='+this.options[this.selectedIndex].value" class="color-select" id="" name="">
                      <?php foreach($sizes AS $sk => $sv): ?>
                          <option value="<?php echo $sk; ?>" <?php echo ((isset($_GET['node']) AND $_GET['node'] == $sk) OR $sk == $product->mainNode->id) ? 'selected' : ''; ?>><?php echo $this->classifier->getValue('size', $sv); ?></option>
                      <?php endforeach; ?>
		  </select>
		  <span class="smaller">(<?php echo Yii::t('app', 'select to view/buy'); ?>)</span>
		 </p>
                 <?php endif; ?>
		 
                 <div class="sale-tab">
		 <?php if ($product->mainNode->sale == 1): ?>
                    <div class="sale"><?php echo Yii::t('app', 'Sale'); ?></div>
                 <?php endif; ?>
                 </div>
		 <h4>Цена: 
                     <?php 
                     echo Yii::app()->params['currency'];
                     if ($product->mainNode->old_price > 0):
                         echo ' <del>'.number_format($product->mainNode->old_price,0,'.','').'</del>&nbsp;&nbsp;';
                     endif; ?>
                     <?php echo number_format($product->mainNode->price,0,'.',''); ?></h4>
                 <div class="buy">
                 <?php if ($product->mainNode->quantity == 0 AND $product->mainNode->never_runs_out != 1 AND $product->mainNode->preorder != 1): ?>
                    <span id="Availability"><?php echo Yii::t('app', 'Not available'); ?></span>
                    <?php if ($product->mainNode->notify != 0): ?>
                    <span id="email" style="padding:5px 0 0 0;">
                    <?php 
                    echo CHtml::beginForm(array('/product/notify'));
                    echo CHtml::hiddenField('productId', $product->id);
                    echo CHtml::hiddenField('productNodeId', $product->mainNode->id);
                    echo CHtml::hiddenField('returnUrl', Yii::app()->request->requestUri);
                    echo CHtml::textField('email', Yii::t('app', 'Notify when available'), array(
                        'onblur' => "javascript: if (this.value == '') { this.value = '".Yii::t('app', 'Notify when available')."'; }",
                        'onfocus' => "javascript: if (this.value == '".Yii::t('app', 'Notify when available')."') { this.value = ''; }",
                        'id' => 'email-field'
                    ));
                    echo CHtml::submitButton(Yii::t('app', 'Send'), array(
                        'id' => 'add-email-submit',
                        'style' => 'background-color: rgb(0, 0, 0);',
                        'onmouseout' => "this.style.backgroundColor='#000000'",
                        'onmouseover' => "this.style.backgroundColor='#1F1F1F'",
                    ));
                    echo CHtml::endForm(); 
                    ?>
                    </span>
                    <div id="notification" style="clear:both;padding:8px 0;font-size:13px;">
                    <?php
                    if (Yii::app()->user->hasFlash('notification'))
                        echo Yii::app()->user->getFlash('notification');
                    ?>
                    </div>
                    <?php endif; ?>
                 <?php else: ?>
		  <span id="BuyButton" style="">
                    <?php 
                    $buttonLabel = Yii::t('app', 'Buy');
                    if ($product->mainNode->quantity == 0 AND $product->mainNode->preorder == 1) {
                        $buttonLabel = Yii::t('app', 'Preorder');
                    }
                    echo CHtml::beginForm(array('/cart'));
                    echo CHtml::hiddenField('action', 'addItem');
                    echo CHtml::hiddenField('productId', $product->id);
                    echo CHtml::hiddenField('productNodeId', $product->mainNode->id);
                    echo CHtml::hiddenField('price', $product->mainNode->price);
                    echo CHtml::submitButton($buttonLabel, array(
                        'class' => 'buy-add',
                        'style' => 'background-color: rgb(0, 0, 0);',
                        'onmouseout' => "this.style.backgroundColor='#000000'",
                        'onmouseover' => "this.style.backgroundColor='#1F1F1F'",
                    ));
                    echo CHtml::endForm(); 
                    ?>
		  </span>
		 <?php endif; ?>
                    <?php 
                    echo CHtml::beginForm(array('/wishlist'));
                    echo CHtml::hiddenField('action', 'addItem');
                    echo CHtml::hiddenField('productId', $product->id);
                    echo CHtml::hiddenField('productNodeId', $product->mainNode->id);
                    echo CHtml::submitButton(Yii::t('app', 'Add to wishlist'), array(
                        'class' => 'wish-add',
                        'style' => 'background-color: rgb(0, 0, 0);',
                        'onmouseout' => "this.style.backgroundColor='#000000'",
                        'onmouseover' => "this.style.backgroundColor='#1F1F1F'",
                    ));
                    echo CHtml::endForm(); 
                    ?>
		 </div>
		</div>
	   </div>
	   <div id="product-image">
               <?php
               $attachetImage = Attachment::model()->getAttachment('productBig', $product->id);
               if ($attachetImage):
                  $image = CHtml::image(Yii::app()->params['images'].$attachetImage->image, $product->content->title);
                  echo $image;
               endif;
               ?>
	   </div>