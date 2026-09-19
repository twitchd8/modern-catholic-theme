import assert from 'node:assert/strict';
import { readFile, stat } from 'node:fs/promises';
import test from 'node:test';

const root = new URL('../', import.meta.url);

test('Open Sans is a locally bundled, editor-selectable default font', async () => {
	const theme = JSON.parse(await readFile(new URL('theme.json', root), 'utf8'));
	const openSans = theme.settings.typography.fontFamilies.find(({ slug }) => slug === 'open-sans');

	assert.ok(openSans, 'Open Sans should be available in WordPress typography controls');
	assert.equal(theme.styles.typography.fontFamily, 'var:preset|font-family|open-sans');
	assert.deepEqual(openSans.fontFace.map(({ fontStyle }) => fontStyle).sort(), ['italic', 'normal']);

	for (const face of openSans.fontFace) {
		assert.equal(face.fontWeight, '300 800');
		assert.match(face.src[0], /^file:\.\/assets\/fonts\/open-sans\/.*\.ttf$/);
		const path = new URL(face.src[0].replace('file:./', ''), root);
		assert.ok((await stat(path)).size > 100_000, 'Bundled font face should contain real font data');
		assert.deepEqual([...((await readFile(path)).subarray(0, 4))], [0, 1, 0, 0]);
	}

	const license = await readFile(new URL('assets/fonts/open-sans/OFL.txt', root), 'utf8');
	assert.match(license, /SIL OPEN FONT LICENSE/i);
});
