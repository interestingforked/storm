<script type="text/javascript">
$(document).ready(function() {
    $('#search-form').submit(function () {
        var query = $('#query', this).val();
        if (query == '' || query.length < 3) {
            alert('<?php echo Yii::t('app', 'Искомое слово/фраза не может быть пустой и должна состоять как минимум из 3-ёх букв!'); ?>');
            return false;
        }
        return true;
    });
});
</script>
<form id="search-form" action="<?php echo CHtml::normalizeUrl(array('/search')); ?>">
	 <input class="poisk" type="text" name="query" id="query" />
	 <input class="submit" type="submit" value="<?php echo Yii::t('app', 'Искать'); ?>" name="" />
	</form>