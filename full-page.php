<?php
/**
 * Template Name: Full Page
 * Description: Full-width page template without a sidebar.
 */

get_header();

$layout = <<<'HTML'
<!-- wp:group {"tagName":"main","className":"site-main tw-container"} -->
<main id="main" class="site-main tw-container">
  <div class="tw-stack tw-prose">
    <!-- wp:post-title {"className":"entry-title"} /-->
    <!-- wp:post-content {"layout":{"type":"constrained"}} /-->
  </div>
</main>
<!-- /wp:group -->
HTML;

echo do_blocks($layout);

get_footer();
