import assert from 'node:assert/strict';
import fs from 'node:fs';
import path from 'node:path';
import test from 'node:test';
import { fileURLToPath } from 'node:url';

const root = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const readJson = (file) => JSON.parse(fs.readFileSync(path.join(root, file), 'utf8'));

const expectedVariations = new Map([
	['Sanctuary', ['#e9e2d4', '#f7f1e2', '#28251f', '#7a2038', '#52695b', '#a17b28']],
	['Marian Blue', null],
	['Cloister Green', null],
	['Advent Violet', null],
	['Cathedral Navy', ['#e7e2d8', '#faf7ef', '#1f2630', '#243b53', '#7b2d3b', '#b08b3e']],
	['Franciscan Earth', ['#e9e1d3', '#faf4e8', '#2f2922', '#6a4932', '#66725b', '#b17c2f']],
	['Stained Glass Teal', ['#e1e8e5', '#f7f4ea', '#202c2c', '#176b69', '#6e315d', '#c28a2c']],
	['Paschal Gold', ['#ece6d7', '#fffbf1', '#29251c', '#9a741c', '#315f86', '#7a2038']],
	['Pentecost Red', ['#eee1d9', '#fff7ed', '#2d211f', '#9d2b27', '#b7642a', '#d3a83e']],
	['Ordinary Time Green', ['#e3e8dc', '#f8f6e9', '#213027', '#2f6f48', '#70513b', '#b7972f']],
	['Roman Gold', ['#e8e0cf', '#fbf6e9', '#2b261d', '#806019', '#542a3b', '#315768']],
	['Sacred Heart Crimson', ['#eadfd8', '#fff5e9', '#2c2020', '#811b2d', '#425f4e', '#c19a36']],
	['Monastic Charcoal', ['#dedbd1', '#f5f2e9', '#1f2223', '#34383b', '#665b4b', '#a8863f']],
]);

const baseSlugs = ['canvas', 'surface', 'foreground', 'primary', 'secondary', 'accent'];
const toRgb = (hex) => hex.match(/[a-f\d]{2}/gi).map((value) => parseInt(value, 16) / 255);
const luminance = (hex) => toRgb(hex).map((value) => value <= 0.04045 ? value / 12.92 : ((value + 0.055) / 1.055) ** 2.4).reduce((sum, value, index) => sum + value * [0.2126, 0.7152, 0.0722][index], 0);
const contrast = (a, b) => (Math.max(luminance(a), luminance(b)) + 0.05) / (Math.min(luminance(a), luminance(b)) + 0.05);

test('all 13 curated styles expose the six editable foundation colors', () => {
	const documents = [readJson('theme.json'), ...fs.readdirSync(path.join(root, 'styles')).filter((name) => name.endsWith('.json')).map((name) => readJson(path.join('styles', name)))];
	const byTitle = new Map(documents.map((document, index) => [document.title ?? (index === 0 ? 'Sanctuary' : ''), document]));
	assert.deepEqual([...byTitle.keys()].sort(), [...expectedVariations.keys()].sort());
	for (const [title, expected] of expectedVariations) {
		const palette = new Map(byTitle.get(title).settings.color.palette.map(({ slug, color }) => [slug, color.toLowerCase()]));
		assert.ok(baseSlugs.every((slug) => palette.has(slug)), `${title} is missing a foundation color`);
		if (expected) assert.deepEqual(baseSlugs.map((slug) => palette.get(slug)), expected);
	}
});

test('gradients remain palette-driven and duotones remain concrete', () => {
	for (const file of ['theme.json', ...fs.readdirSync(path.join(root, 'styles')).filter((name) => name.endsWith('.json')).map((name) => path.join('styles', name))]) {
		const color = readJson(file).settings.color;
		assert.equal(color.gradients.length, 4, `${file} should expose four gradients`);
		assert.ok(color.gradients.every(({ gradient }) => gradient.includes('var(--wp--preset--color--')), `${file} gradients must follow palette variables`);
		assert.equal(color.duotone.length, 4, `${file} should expose four duotones`);
		assert.ok(color.duotone.every(({ colors }) => colors.every((value) => /^#[0-9a-f]{6}$/i.test(value))), `${file} duotones must be concrete`);
	}
});

test('theme disables arbitrary colors and exposes the public semantic contract', () => {
	const theme = readJson('theme.json');
	assert.equal(theme.settings.color.custom, false);
	assert.equal(theme.settings.color.customGradient, false);
	assert.equal(theme.settings.color.customDuotone, false);
	const css = fs.readFileSync(path.join(root, 'style.css'), 'utf8');
	for (const name of ['canvas','surface','surface-alt','foreground','text-muted','border','primary','primary-soft','primary-strong','secondary','secondary-soft','secondary-strong','accent','accent-soft','accent-strong','on-primary','on-secondary','on-accent','on-image','scrim','focus','info','success','warning','danger']) {
		assert.match(css, new RegExp(`--mc-color-${name}\\s*:`), `missing --mc-color-${name}`);
	}
	assert.match(css, /contrast-color\(/);
});

test('curated solid brand backgrounds meet WCAG AA with their fallback text colors', () => {
	for (const file of ['theme.json', ...fs.readdirSync(path.join(root, 'styles')).filter((name) => name.endsWith('.json')).map((name) => path.join('styles', name))]) {
		const document = readJson(file);
		const palette = new Map(document.settings.color.palette.map(({ slug, color }) => [slug, color]));
		for (const role of ['primary', 'secondary', 'accent']) {
			assert.ok(contrast(palette.get(role), palette.get(`on-${role}`)) >= 4.5, `${document.title ?? 'Sanctuary'} ${role} fallback is below 4.5:1`);
		}
	}
});
