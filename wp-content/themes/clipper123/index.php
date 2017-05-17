<?php
/**
 * Template Name: Blog Template
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	die();
}
?>


<div id="content">

	<?php get_template_part( 'loop' ); ?>

</div>

<?php get_sidebar( 'blog' ); ?>
