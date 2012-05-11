<?php do_action('before_title'); ?>

<h1><?php echo do_filter('title', 'This is my title');?></h1>

<?php do_action('after_title'); ?>

<?php do_action('before_content'); ?>

<?php echo do_filter('content', $content); ?>

<?php do_action('after_content'); ?>