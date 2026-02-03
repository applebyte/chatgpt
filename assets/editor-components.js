(() => {
  const { createElement } = window.wp.element;
  const { Button, PanelBody, TextControl } = window.wp.components;
  const { PluginSidebar } = window.wp.editPost;
  const { registerPlugin } = window.wp.plugins;
  const { dispatch } = window.wp.data;
  const { parse } = window.wp.blocks;

  const templates = {
    tabs: '<!-- wp:html --><div data-tw-tabs><div data-tw-tab data-label="First">Add content for the first tab.</div><div data-tw-tab data-label="Second">Add content for the second tab.</div></div><!-- /wp:html -->',
    toggle: '<!-- wp:html --><div data-tw-toggle data-label="Details">Add toggle content.</div><!-- /wp:html -->',
    slideshow: '<!-- wp:gallery {"columns":3} --><figure class="wp-block-gallery"><figure class="wp-block-image"><img src="" alt="" /></figure></figure><!-- /wp:gallery -->',
    scrollButtons: '<!-- wp:html --><div data-tw-scroll-buttons></div><!-- /wp:html -->',
  };

  const insertTemplate = (template) => {
    dispatch('core/block-editor').insertBlocks(parse(template));
  };

  const ComponentSidebar = () => {
    return createElement(
      PluginSidebar,
      {
        name: 'minimal-gutenberg-first-components',
        title: 'Theme Components',
      },
      createElement(
        PanelBody,
        { title: 'Insert Patterns', initialOpen: true },
        createElement(Button, { variant: 'primary', onClick: () => insertTemplate(templates.tabs) }, 'Insert Tabs'),
        createElement(Button, { variant: 'secondary', onClick: () => insertTemplate(templates.toggle) }, 'Insert Toggle'),
        createElement(Button, { variant: 'secondary', onClick: () => insertTemplate(templates.slideshow) }, 'Insert Slideshow'),
        createElement(Button, { variant: 'secondary', onClick: () => insertTemplate(templates.scrollButtons) }, 'Insert Scroll Buttons')
      ),
      createElement(
        PanelBody,
        { title: 'Notes', initialOpen: false },
        createElement(TextControl, {
          label: 'How to use',
          value: 'Insert the patterns and edit the placeholder content. The slideshow requires the Customizer option enabled.',
          onChange: () => {},
          readOnly: true,
        })
      )
    );
  };

  registerPlugin('minimal-gutenberg-first-components', {
    render: ComponentSidebar,
  });
})();
