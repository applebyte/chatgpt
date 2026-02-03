<?php
/**
 * Main template file.
 */

get_header();

$layout = <<<'HTML'
<!-- wp:group {"tagName":"main","className":"site-main tw-container"} -->
<main id="main" class="site-main tw-container">
  <!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":true},"displayLayout":{"type":"flex","columns":2},"className":"tw-grid tw-grid-cols-2"} -->
  <div class="wp-block-query tw-grid tw-grid-cols-2">
    <!-- wp:post-template -->
    <!-- wp:group {"className":"tw-stack"} -->
    <div class="wp-block-group tw-stack">
      <!-- wp:post-title {"isLink":true,"className":"entry-title"} /-->
      <!-- wp:post-excerpt {"className":"entry-content tw-prose"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
    <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
      <!-- wp:query-pagination-previous /-->
      <!-- wp:query-pagination-next /-->
    <!-- /wp:query-pagination -->
  </div>
  <!-- /wp:query -->
</main>
<!-- /wp:group -->
HTML;

echo do_blocks($layout);

get_footer();
