(() => {
  const { createElement, useEffect, useState } = window.wp.element;

  const Tabs = ({ tabs, initialIndex = 0 }) => {
    const [activeIndex, setActiveIndex] = useState(initialIndex);

    return createElement(
      'div',
      { className: 'tw-tabs', role: 'tablist' },
      createElement(
        'div',
        { className: 'tw-tabs-list' },
        tabs.map((tab, index) =>
          createElement(
            'button',
            {
              key: tab.id,
              type: 'button',
              className: `tw-tab ${index === activeIndex ? 'is-active' : ''}`,
              role: 'tab',
              'aria-selected': index === activeIndex,
              'aria-controls': tab.id,
              onClick: () => setActiveIndex(index),
            },
            tab.label
          )
        )
      ),
      tabs.map((tab, index) =>
        createElement(
          'div',
          {
            key: tab.id,
            id: tab.id,
            className: `tw-tab-panel ${index === activeIndex ? 'is-active' : ''}`,
            role: 'tabpanel',
            hidden: index !== activeIndex,
          },
          tab.content
        )
      )
    );
  };

  const Toggle = ({ label, content, defaultOpen = false }) => {
    const [open, setOpen] = useState(defaultOpen);

    return createElement(
      'div',
      { className: 'tw-toggle' },
      createElement(
        'button',
        {
          type: 'button',
          className: 'tw-toggle-button',
          'aria-expanded': open,
          onClick: () => setOpen(!open),
        },
        label
      ),
      createElement(
        'div',
        { className: 'tw-toggle-panel', hidden: !open },
        content
      )
    );
  };

  const mountTabs = () => {
    document.querySelectorAll('[data-tw-tabs]').forEach((node, index) => {
      const tabs = Array.from(node.querySelectorAll('[data-tw-tab]')).map((tabNode, tabIndex) => ({
        id: `tw-tab-${index}-${tabIndex}`,
        label: tabNode.getAttribute('data-label') || `Tab ${tabIndex + 1}`,
        content: tabNode.innerHTML,
      }));

      if (!tabs.length) {
        return;
      }

      const mount = document.createElement('div');
      node.parentNode?.insertBefore(mount, node);
      node.remove();

      window.wp.element.render(createElement(Tabs, { tabs }), mount);
    });
  };

  const mountToggles = () => {
    document.querySelectorAll('[data-tw-toggle]').forEach((node) => {
      const label = node.getAttribute('data-label') || 'Details';
      const content = node.innerHTML;

      const mount = document.createElement('div');
      node.parentNode?.insertBefore(mount, node);
      node.remove();

      window.wp.element.render(createElement(Toggle, { label, content }), mount);
    });
  };

  const initComponents = () => {
    mountTabs();
    mountToggles();
  };

  const ScrollButtons = () => {
    return createElement(
      'div',
      { className: 'tw-scroll-buttons', role: 'navigation', 'aria-label': 'Scroll controls' },
      createElement(
        'button',
        {
          type: 'button',
          className: 'tw-button',
          onClick: () => window.scrollTo({ top: 0, behavior: 'smooth' }),
        },
        'Up'
      ),
      createElement(
        'button',
        {
          type: 'button',
          className: 'tw-button',
          onClick: () => window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' }),
        },
        'Down'
      )
    );
  };

  const mountScrollButtons = () => {
    const placeholder = document.querySelector('[data-tw-scroll-buttons]');
    if (!placeholder) {
      return;
    }

    const mount = document.createElement('div');
    placeholder.parentNode?.insertBefore(mount, placeholder);
    placeholder.remove();

    window.wp.element.render(createElement(ScrollButtons), mount);
  };

  const initScrollButtons = () => {
    mountScrollButtons();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      initComponents();
      initScrollButtons();
    });
  } else {
    initComponents();
    initScrollButtons();
  }
})();
