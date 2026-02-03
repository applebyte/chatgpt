<?php
/**
 * Theme functions and definitions.
 */

declare(strict_types=1);

function minimal_gutenberg_first_setup(): void {
  add_theme_support('title-tag');
  add_theme_support('wp-block-styles');
  add_theme_support('editor-styles');
  add_theme_support('responsive-embeds');
  add_theme_support('html5', ['style', 'script', 'comment-form', 'comment-list', 'gallery', 'caption']);
}
add_action('after_setup_theme', 'minimal_gutenberg_first_setup');

function minimal_gutenberg_first_enqueue_assets(): void {
  wp_enqueue_style(
    'minimal-gutenberg-first-style',
    get_stylesheet_uri(),
    [],
    wp_get_theme()->get('Version')
  );

  wp_enqueue_script(
    'minimal-gutenberg-first-react',
    'https://unpkg.com/react@18/umd/react.production.min.js',
    [],
    '18.3.1',
    true
  );

  wp_enqueue_script(
    'minimal-gutenberg-first-react-dom',
    'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js',
    ['minimal-gutenberg-first-react'],
    '18.3.1',
    true
  );

  wp_enqueue_script(
    'minimal-gutenberg-first-components',
    get_template_directory_uri() . '/assets/components.js',
    ['minimal-gutenberg-first-react', 'minimal-gutenberg-first-react-dom', 'wp-element'],
    wp_get_theme()->get('Version'),
    true
  );

  $slideshow_enabled = (bool) get_theme_mod('minimal_gutenberg_first_slideshow_enabled', false);
  if ($slideshow_enabled) {
    wp_enqueue_script(
      'minimal-gutenberg-first-slideshow',
      get_template_directory_uri() . '/assets/slideshow.js',
      ['minimal-gutenberg-first-react', 'minimal-gutenberg-first-react-dom', 'wp-element'],
      wp_get_theme()->get('Version'),
      true
    );

    wp_localize_script(
      'minimal-gutenberg-first-slideshow',
      'minimalGutenbergFirstSlideshow',
      [
        'enabled' => true,
        'intervalMs' => (int) get_theme_mod('minimal_gutenberg_first_slideshow_interval', 5000),
      ]
    );
  }
}
add_action('wp_enqueue_scripts', 'minimal_gutenberg_first_enqueue_assets');

function minimal_gutenberg_first_enqueue_editor_assets(): void {
  wp_enqueue_script(
    'minimal-gutenberg-first-editor-components',
    get_template_directory_uri() . '/assets/editor-components.js',
    [
      'minimal-gutenberg-first-react',
      'minimal-gutenberg-first-react-dom',
      'wp-plugins',
      'wp-edit-post',
      'wp-element',
      'wp-components',
      'wp-blocks',
      'wp-data',
    ],
    wp_get_theme()->get('Version'),
    true
  );
}
add_action('enqueue_block_editor_assets', 'minimal_gutenberg_first_enqueue_editor_assets');

function minimal_gutenberg_first_register_sidebars(): void {
  register_sidebar(
    [
      'name' => __('Primary Sidebar', 'minimal-gutenberg-first'),
      'id' => 'primary-sidebar',
      'description' => __('Widgets displayed in the sidebar.', 'minimal-gutenberg-first'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>',
    ]
  );

  for ($index = 1; $index <= 4; $index++) {
    register_sidebar(
      [
        'name' => sprintf(__('Footer Column %d', 'minimal-gutenberg-first'), $index),
        'id' => sprintf('footer-%d', $index),
        'description' => __('Widgets displayed in the footer.', 'minimal-gutenberg-first'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
      ]
    );
  }
}
add_action('widgets_init', 'minimal_gutenberg_first_register_sidebars');

function minimal_gutenberg_first_customize_register(WP_Customize_Manager $wp_customize): void {
  $wp_customize->add_section(
    'minimal_gutenberg_first_notes',
    [
      'title' => __('Theme Notes', 'minimal-gutenberg-first'),
      'priority' => 160,
    ]
  );

  $wp_customize->add_section(
    'minimal_gutenberg_first_layout',
    [
      'title' => __('Layout', 'minimal-gutenberg-first'),
      'priority' => 170,
    ]
  );

  $wp_customize->add_setting(
    'minimal_gutenberg_first_single_columns',
    [
      'default' => 2,
      'sanitize_callback' => static function ($value) {
        $value = (int) $value;
        return max(1, min(4, $value));
      },
    ]
  );

  $wp_customize->add_control(
    'minimal_gutenberg_first_single_columns',
    [
      'label' => __('Single post items per row', 'minimal-gutenberg-first'),
      'section' => 'minimal_gutenberg_first_layout',
      'type' => 'select',
      'choices' => [
        1 => __('1 column', 'minimal-gutenberg-first'),
        2 => __('2 columns', 'minimal-gutenberg-first'),
        3 => __('3 columns', 'minimal-gutenberg-first'),
        4 => __('4 columns', 'minimal-gutenberg-first'),
      ],
    ]
  );

  $wp_customize->add_setting(
    'minimal_gutenberg_first_slideshow_enabled',
    [
      'default' => false,
      'sanitize_callback' => 'rest_sanitize_boolean',
    ]
  );

  $wp_customize->add_control(
    'minimal_gutenberg_first_slideshow_enabled',
    [
      'label' => __('Enable gallery slideshow', 'minimal-gutenberg-first'),
      'section' => 'minimal_gutenberg_first_layout',
      'type' => 'checkbox',
    ]
  );

  $wp_customize->add_setting(
    'minimal_gutenberg_first_slideshow_interval',
    [
      'default' => 5000,
      'sanitize_callback' => static function ($value) {
        $value = (int) $value;
        return max(2000, min(10000, $value));
      },
    ]
  );

  $wp_customize->add_control(
    'minimal_gutenberg_first_slideshow_interval',
    [
      'label' => __('Slideshow interval (ms)', 'minimal-gutenberg-first'),
      'section' => 'minimal_gutenberg_first_layout',
      'type' => 'number',
      'input_attrs' => [
        'min' => 2000,
        'max' => 10000,
        'step' => 500,
      ],
    ]
  );

  $wp_customize->add_setting(
    'minimal_gutenberg_first_footer_columns',
    [
      'default' => 4,
      'sanitize_callback' => static function ($value) {
        $value = (int) $value;
        return max(1, min(4, $value));
      },
    ]
  );

  $wp_customize->add_control(
    'minimal_gutenberg_first_footer_columns',
    [
      'label' => __('Footer widget columns', 'minimal-gutenberg-first'),
      'section' => 'minimal_gutenberg_first_layout',
      'type' => 'select',
      'choices' => [
        1 => __('1 column', 'minimal-gutenberg-first'),
        2 => __('2 columns', 'minimal-gutenberg-first'),
        3 => __('3 columns', 'minimal-gutenberg-first'),
        4 => __('4 columns', 'minimal-gutenberg-first'),
      ],
    ]
  );

  $wp_customize->add_setting(
    'minimal_gutenberg_first_header_note',
    [
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ]
  );

  $wp_customize->add_control(
    'minimal_gutenberg_first_header_note',
    [
      'label' => __('Header note', 'minimal-gutenberg-first'),
      'section' => 'minimal_gutenberg_first_notes',
      'type' => 'text',
    ]
  );

  $wp_customize->add_setting(
    'minimal_gutenberg_first_footer_note',
    [
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ]
  );

  $wp_customize->add_control(
    'minimal_gutenberg_first_footer_note',
    [
      'label' => __('Footer note', 'minimal-gutenberg-first'),
      'section' => 'minimal_gutenberg_first_notes',
      'type' => 'text',
    ]
  );
}
add_action('customize_register', 'minimal_gutenberg_first_customize_register');
