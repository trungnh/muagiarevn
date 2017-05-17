<?php
/**
 * Generic search loop content template.
 * Filter down the hierarchy to bypass get_template_part() limitations.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<?php get_template_part( 'content', get_post_type() ); ?>
