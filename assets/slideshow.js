(() => {
  const { createElement, useEffect, useState } = window.wp.element;

  const GallerySlideshow = ({ images, intervalMs }) => {
    const [index, setIndex] = useState(0);
    const total = images.length;

    useEffect(() => {
      if (!intervalMs || total < 2) {
        return undefined;
      }
      const timer = setInterval(() => {
        setIndex((current) => (current + 1) % total);
      }, intervalMs);
      return () => clearInterval(timer);
    }, [intervalMs, total]);

    if (total === 0) {
      return null;
    }

    const currentImage = images[index];

    return createElement(
      'div',
      { className: 'tw-slideshow', role: 'region', 'aria-label': 'Image slideshow' },
      createElement('img', {
        src: currentImage.src,
        alt: currentImage.alt || '',
        loading: 'lazy',
        decoding: 'async',
      }),
      total > 1
        ? createElement(
            'div',
            { className: 'tw-slideshow-controls' },
            createElement(
              'button',
              {
                type: 'button',
                className: 'tw-button',
                onClick: () => setIndex((index - 1 + total) % total),
              },
              'Previous'
            ),
            createElement(
              'span',
              { className: 'tw-slideshow-status', 'aria-live': 'polite' },
              `${index + 1} / ${total}`
            ),
            createElement(
              'button',
              {
                type: 'button',
                className: 'tw-button',
                onClick: () => setIndex((index + 1) % total),
              },
              'Next'
            )
          )
        : null
    );
  };

  const initSlideshows = () => {
    const settings = window.minimalGutenbergFirstSlideshow || {};
    if (!settings.enabled) {
      return;
    }

    document.querySelectorAll('.wp-block-gallery').forEach((gallery) => {
      const images = Array.from(gallery.querySelectorAll('img')).map((img) => ({
        src: img.currentSrc || img.src,
        alt: img.alt,
      }));

      if (!images.length) {
        return;
      }

      const mount = document.createElement('div');
      mount.className = 'js-gallery-slideshow';
      gallery.parentNode?.insertBefore(mount, gallery);
      gallery.setAttribute('aria-hidden', 'true');

      window.wp.element.render(
        createElement(GallerySlideshow, {
          images,
          intervalMs: settings.intervalMs,
        }),
        mount
      );
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSlideshows);
  } else {
    initSlideshows();
  }
})();
