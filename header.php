<?php
/**
 * Header template.
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e('Skip to content', 'minimal-gutenberg-first'); ?></a>
<header class="site-header" role="banner">
  <h1 class="site-title" itemprop="name" title="<?php bloginfo('name'); ?>">
    <a href="<?php echo esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
  </h1>
  <p class="site-description" itemprop="description"><?php bloginfo('description'); ?></p>
  <?php
  $header_note = get_theme_mod('minimal_gutenberg_first_header_note');
  if ($header_note) :
    ?>
    <p class="site-note"><?php echo esc_html($header_note); ?></p>
  <?php endif; ?>
</header>
