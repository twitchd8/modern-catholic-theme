import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import test from 'node:test';

const themeRoot = new URL('../', import.meta.url);

function classNames(selector) {
	return [...selector.matchAll(/\.([a-z0-9_-]+)/gi)].map((match) => match[1]);
}

test('the no-overlay header is available as a reusable Header pattern', async () => {
	const pattern = await readFile(new URL('patterns/header-stacked.php', themeRoot), 'utf8');

	assert.match(pattern, /Categories:\s*header/i);
	assert.match(pattern, /"slug":"header"/);
	assert.match(pattern, /"className":"front-page-stacked-header"/);
});

test('the stacked header pattern has a normal-flow presentation', async () => {
	const stylesheet = await readFile(new URL('style.css', themeRoot), 'utf8');
	const rule = stylesheet.match(/\.front-page-stacked-header\s*\{([^}]*)\}/s);

	assert.ok(rule, 'Expected a .front-page-stacked-header rule');
	assert.match(rule[1], /position:\s*relative/);
	assert.match(rule[1], /inset:\s*auto/);
});

test('the desktop header grid wins over WordPress generated flex layout CSS', async () => {
	const stylesheet = await readFile(new URL('style.css', themeRoot), 'utf8');
	const desktopRule = stylesheet.match(
		/@media \(min-width:\s*75\.001rem\)\s*\{\s*([^{}]*modern-catholic-header-bar[^{}]*)\{([^}]*)\}/s,
	);

	assert.ok(desktopRule, 'Expected a desktop rule for the header bar');

	const display = desktopRule[2].match(/display:\s*([^;]+)/)?.[1].trim();
	const elementClasses = new Set([
		'wp-block-group',
		'modern-catholic-header-bar',
		'is-layout-flex',
	]);
	const matchingRules = [
		{ selector: desktopRule[1].trim(), display, order: 0 },
		{ selector: '.is-layout-flex', display: 'flex', order: 1 },
	].filter(({ selector }) => classNames(selector).every((name) => elementClasses.has(name)));
	const winner = matchingRules.sort(
		(a, b) => classNames(a.selector).length - classNames(b.selector).length || a.order - b.order,
	).at(-1);

	assert.equal(winner?.display, 'grid');
});

test('quick-link separators receive equal spacing on both sides', async () => {
	const stylesheet = await readFile(new URL('style.css', themeRoot), 'utf8');
	const containerRule = stylesheet.match(
		/\.modern-catholic-utility-navigation \.wp-block-navigation__container\s*\{([^}]*)\}/s,
	);
	const separatorRule = stylesheet.match(
		/\.modern-catholic-utility-navigation \.modern-catholic-menu-utility \+ \.modern-catholic-menu-utility::before\s*\{([^}]*)\}/s,
	);

	assert.ok(containerRule, 'Expected a Quick Links container rule');
	assert.match(containerRule[1], /column-gap:\s*0/);
	assert.ok(separatorRule, 'Expected a Quick Links separator rule');
	assert.match(
		separatorRule[1],
		/margin-inline:\s*calc\(var\(--wp--style--block-gap,\s*0\.75rem\)\s*\/\s*2\)/,
	);
	assert.doesNotMatch(separatorRule[1], /margin-inline-(?:start|end)/);
});
