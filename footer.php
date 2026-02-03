<?php
/**
 * Footer template.
 */

?>
<footer class="site-footer">
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
