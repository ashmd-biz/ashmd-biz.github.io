<?php
/**
 * フロントページテンプレート
 *
 * @package UNIMAT_LIFE
 */

get_header();
?>

<?php get_template_part('template-parts/section-hero'); ?>
<?php get_template_part('template-parts/section-concept'); ?>
<?php get_template_part('template-parts/section-news'); ?>
<?php get_template_part('template-parts/section-service'); ?>
<?php get_template_part('template-parts/section-recruit'); ?>
<?php get_template_part('template-parts/section-useful-links'); ?>
<?php get_template_part('template-parts/section-campaign'); ?>
<?php get_template_part('template-parts/section-promo'); ?>

<?php
get_footer();
?>
