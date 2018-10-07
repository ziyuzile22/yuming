<?php if (!defined('THINK_PATH')) exit();?><!doctype html public "-//w3c//dtd xhtml 1.0 frameset//en" "http://www.w3.org/tr/xhtml1/dtd/xhtml1-frameset.dtd">
<html>

<head>
    <meta http-equiv=content-type content="text/html; charset=utf-8" />
    <meta http-equiv=pragma content=no-cache />
    <meta http-equiv=cache-control content=no-cache />
    <meta http-equiv=expires content=-1000 />

    <title>
        <?php echo BIND_SYSNAME; ?>
    </title>
</head>


<frameset cols="200px,*" border=0 framespacing=0 frameborder=0>
    <frame name=left src="/admin.php/Index/left.html" frameborder=0 noresize />

    <?php if($role_id == 52): ?><frame name=right src="/admin.php/Index/right.html" frameborder=0 noresize scrolling=yes />
        <?php else: ?>
        <frame name=right src="/admin.php/Index/content.html" frameborder=0 noresize scrolling=yes /><?php endif; ?>


</frameset>




<noframes>
</noframes>

</html>