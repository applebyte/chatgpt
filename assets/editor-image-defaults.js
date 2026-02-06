(() => {
  const { select, dispatch, subscribe } = window.wp.data;
  const { decodeEntities } = window.wp.htmlEntities || {};

  const normalizeName = (name) => name.replace(/[-_]+/g, ' ').trim();

  const getFilename = (url) => {
    if (!url) {
      return '';
    }
    const cleaned = url.split('?')[0].split('#')[0];
    const parts = cleaned.split('/');
    const file = parts[parts.length - 1] || '';
    return file.replace(/\.[^.]+$/, '');
  };

  const updateImageBlock = (block) => {
    if (!block || block.name !== 'core/image') {
      return;
    }

    const { id, url, alt, title } = block.attributes;
    const filename = normalizeName(getFilename(url));
    if (!filename) {
      return;
    }

    const nextAttributes = {};
    if (!alt) {
      nextAttributes.alt = filename;
    }
    if (!title) {
      nextAttributes.title = filename;
    }

    if (Object.keys(nextAttributes).length) {
      dispatch('core/block-editor').updateBlockAttributes(block.clientId, nextAttributes);
    }

    if (id && decodeEntities) {
      const attachment = select('core').getMedia(id);
      if (attachment) {
        const currentAlt = attachment.alt_text || '';
        const currentTitle = attachment.title?.rendered || '';
        const updates = {};
        if (!currentAlt) {
          updates.alt_text = filename;
        }
        if (!currentTitle) {
          updates.title = filename;
        }
        if (Object.keys(updates).length) {
          dispatch('core').editEntityRecord('postType', 'attachment', id, updates);
        }
      }
    }
  };

  const walkBlocks = (blocks) => {
    blocks.forEach((block) => {
      updateImageBlock(block);
      if (block.innerBlocks?.length) {
        walkBlocks(block.innerBlocks);
      }
    });
  };

  let lastRevision = null;
  subscribe(() => {
    const editor = select('core/block-editor');
    if (!editor) {
      return;
    }
    const blocks = editor.getBlocks();
    const revision = editor.getEditedPostContent();
    if (revision === lastRevision) {
      return;
    }
    lastRevision = revision;
    walkBlocks(blocks);
  });
})();
