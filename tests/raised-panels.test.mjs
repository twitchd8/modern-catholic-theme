import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import test from 'node:test';

const root = new URL('../', import.meta.url);

test('theme information panels expose reusable palette-aware card treatments', async () => {
	const css = await readFile(new URL('style.css', root), 'utf8');

	for (const className of ['mc-card', 'mc-card-accent1', 'mc-card-accent2', 'mc-card-accent3', 'is-style-mc-card']) {
		assert.match(css, new RegExp(`\\.${className}\\b`), `${className} should be available site-wide`);
	}
	assert.match(css, /--mc-card-strip:\s*var\(--mc-color-accent\)/);
	assert.match(css, /--mc-card-strip:\s*var\(--mc-color-secondary\)/);
	assert.match(css, /--mc-card-strip:\s*var\(--mc-color-primary\)/);
	assert.match(css, /background-color:\s*var\(--mc-color-surface\)/);
	assert.match(css, /border-block-start-width:\s*0\.25rem/);
	assert.match(css, /:not\(\.has-border-color\)\s*\{[^}]*border-block-start-color:\s*var\(--mc-card-strip\)/s);
	assert.match(css, /box-shadow:\s*0 0\.5rem 1\.5rem var\(--modern-catholic-shadow-soft\)/);
});

test('the site canvas contrasts with the raised panel surface', async () => {
	const css = await readFile(new URL('style.css', root), 'utf8');
	const siteShell = css.match(/body > \.wp-site-blocks,\s*\.editor-styles-wrapper \.is-root-container\s*\{([^}]*)\}/s);
	assert.ok(siteShell);
	assert.match(siteShell[1], /background-color:\s*var\(--mc-color-canvas\)/);
	assert.match(css, /:not\(\.has-background\)\s*\{\s*background-color:\s*var\(--mc-color-surface\)/s);
});

test('the raised-panel treatment is available in the Group and Column Styles controls', async () => {
	const php = await readFile(new URL('functions.php', root), 'utf8');
	assert.match(php, /foreach \( array\( 'core\/group', 'core\/column' \) as \$block_name \)/);
	assert.match(php, /register_block_style\(\s*\$block_name,\s*array\(\s*'name'\s*=>\s*'mc-card'/s);
});

test('theme-owned information sections use raised panels by default', async () => {
	for (const part of ['parish-mass-times.html', 'parish-life-links.html']) {
		const html = await readFile(new URL(`parts/${part}`, root), 'utf8');
		assert.match(html, /className":"mc-card-accent1"/);
		assert.match(html, /class="wp-block-column mc-card-accent1"/);
	}
});
