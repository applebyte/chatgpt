<?php
/**
 * Footer template.
 */

?>
<footer class="site-footer">
  <?php
  $footer_columns = (int) get_theme_mod('minimal_gutenberg_first_footer_columns', 4);
  $footer_columns = max(1, min(4, $footer_columns));
  $footer_class = sprintf('tw-grid-cols-%d', $footer_columns);
  $has_footer_widgets = false;
  for ($index = 1; $index <= 4; $index++) {
    if (is_active_sidebar("footer-{$index}")) {
      $has_footer_widgets = true;
      break;
    }
  }
  if ($has_footer_widgets) :
    ?>
    <div class="site-footer-widgets tw-grid <?php echo esc_attr($footer_class); ?>">
      <?php for ($index = 1; $index <= 4; $index++) : ?>
        <?php if (is_active_sidebar("footer-{$index}")) : ?>
          <div class="footer-widget-column">
            <?php dynamic_sidebar("footer-{$index}"); ?>
          </div>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
  <p><?php echo esc_html(sprintf(__('Proudly powered by %s', 'minimal-gutenberg-first'), 'WordPress')); ?></p>
  <?php
  $footer_note = get_theme_mod('minimal_gutenberg_first_footer_note');
  if ($footer_note) :
    ?>
    <p class="site-note"><?php echo esc_html($footer_note); ?></p>
  <?php endif; ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
