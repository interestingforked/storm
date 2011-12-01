<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Error <?php echo $code; ?></h2>
    </div>
    <div class="block_content">
        <div class="message errormsg">
            <p><?php echo CHtml::encode($message); ?></p>
        </div>
        <pre>
            <?php print_r($traces); ?>
        </pre>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>