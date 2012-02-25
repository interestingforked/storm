<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Administration : <?php echo $this->pageTitle; ?></title>
        <style type="text/css" media="all">
            @import url("/css/admin/style.css");
            @import url("/css/admin/jquery.wysiwyg.css");
            @import url("/css/admin/wysiwyg.css");
            @import url("/css/admin/facebox.css");
            @import url("/css/admin/visualize.css");
            @import url("/css/admin/date_input.css");
            @import url("/css/admin/fileuploader.css");
            @import url("/css/admin/smoothness/jquery-ui-1.8.13.custom.css");
            @import url("/css/admin/elfinder.css");
			@import url("/css/admin/elrte.min.css");
        </style>
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=7" /><![endif]-->
        <!--[if lt IE 8]><style type="text/css" media="all">@import url("/css/admin/ie.css");</style><![endif]-->
        <!--[if IE]><script type="text/javascript" src="/js/admin/excanvas.js"></script><![endif]-->
        <script type="text/javascript" src="/js/admin/jquery.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.img.preload.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.filestyle.mini.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.date_input.pack.js"></script>
        <script type="text/javascript" src="/js/admin/facebox.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.visualize.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.select_skin.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.json-2.3.min.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.cookie.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.tablesorter.pager.js"></script>
        <script type="text/javascript" src="/js/admin/ajaxupload.js"></script>
        <script type="text/javascript" src="/js/admin/jquery.pngfix.js"></script>
        <script type="text/javascript" src="/js/admin/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript" src="/js/admin/elrte.min.js"></script>
        <script type="text/javascript" src="/js/admin/elfinder.min.js"></script>
        <script type="text/javascript" src="/js/admin/custom.js"></script>
    </head>
    <body>
        <div id="hld">
            <div class="wrapper">
                <div id="header">
                    <div class="hdrl"></div>
                    <div class="hdrr"></div>
                    <h1><a href="/admin">Admin</a></h1>
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => $this->menu,
                        'activeCssClass' => 'active',
                        'activateParents' => true,
                        'id' => 'nav'
                    ));
                    ?>
                    <p class="user">
                        <?php echo CHtml::link($this->user['profile']->firstname, array('/user/profile')); ?> | 
                        <?php echo CHtml::link('Logout', array('/user/logout')); ?>
                    </p>
                </div>
                <?php echo $content; ?>
                <div id="footer">
                    <p class="left"><?php echo CHtml::link('Stormlondon.ru', array('/')); ?></p>
                    <p class="right">powered by <a href="http://themeforest.net/item/adminus-beautiful-admin-panel-interface/94668?ref=enstyled">Adminus</a> v1.4</p>
                </div>
            </div>
        </div>
    </body>
</html>