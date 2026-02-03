<?php
/**
 * Page template.
 */

get_header();

$layout = <<<'HTML'
<!-- wp:group {"tagName":"main","className":"site-main tw-container"} -->
<main id="main" class="site-main tw-container">
  <div class="tw-grid tw-grid-cols-2">
    <div class="tw-stack tw-prose">
      <!-- wp:post-title {"className":"entry-title"} /-->
      <!-- wp:post-content {"layout":{"type":"constrained"}} /-->
    </div>
    <aside class="site-sidebar" role="complementary" aria-label="Sidebar">
      <?php if (is_active_sidebar('primary-sidebar')) : ?>
        <?php dynamic_sidebar('primary-sidebar'); ?>
      <?php else : ?>
        <!-- wp:paragraph -->
        <p><?php esc_html_e('Add widgets to the sidebar in Appearance → Widgets.', 'minimal-gutenberg-first'); ?></p>
        <!-- /wp:paragraph -->
      <?php endif; ?>
    </aside>
  </div>
</main>
<!-- /wp:group -->
HTML;

echo do_blocks($layout);

get_footer();
