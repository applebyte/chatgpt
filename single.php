<?php
/**
 * Single post template.
 */

get_header();

$columns = (int) get_theme_mod('minimal_gutenberg_first_single_columns', 2);
$columns = max(1, min(4, $columns));
$columns_class = sprintf('tw-grid-cols-%d', $columns);
$more_posts = esc_html__('More Posts', 'minimal-gutenberg-first');

$layout = <<<HTML
<!-- wp:group {"tagName":"main","className":"site-main tw-container"} -->
<main id="main" class="site-main tw-container">
  <article class="tw-stack tw-prose" itemscope itemtype="https://schema.org/Article">
    <!-- wp:post-title {"className":"entry-title","level":1} /-->
    <!-- wp:post-content {"layout":{"type":"constrained"}} /-->
  </article>
  <!-- wp:separator {"className":"tw-divider"} /-->
  <!-- wp:heading {"level":2} -->
  <h2>{$more_posts}</h2>
  <!-- /wp:heading -->
  <!-- wp:query {"queryId":1,"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false},"displayLayout":{"type":"flex","columns":$columns},"className":"tw-grid $columns_class"} -->
  <div class="wp-block-query tw-grid {$columns_class}">
    <!-- wp:post-template -->
    <!-- wp:group {"className":"tw-stack"} -->
    <div class="wp-block-group tw-stack">
      <!-- wp:post-title {"isLink":true,"className":"entry-title"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->
</main>
<!-- /wp:group -->
HTML;

echo do_blocks($layout);

get_footer();
