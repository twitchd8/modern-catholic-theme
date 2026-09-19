# Modern Catholic Theme

Part of **Modern Catholic** — modular WordPress tools for Catholic parish websites.

---

# Modern Catholic

![License: GPL-3.0-only](https://img.shields.io/badge/License-GPL--3.0--only-blue.svg)
![WordPress: 7.0+](https://img.shields.io/badge/WordPress-7.0%2B-21759b.svg)
![PHP: 7.4+](https://img.shields.io/badge/PHP-7.4%2B-777bbb.svg)
![Theme: Block](https://img.shields.io/badge/Theme-Block-3858e9.svg)

A modern WordPress block theme designed for Catholic parish websites, with semantic color palettes, responsive navigation, reusable parish settings, and full Site Editor support.

---

## Features

- WordPress Global Styles and full-site editing
- Responsive shared header, navigation, footer, and page templates
- Overlay and stacked header treatments
- Native two-column and three-column Mega Menu styles
- Semantic Canvas, Surface, Foreground, Primary, Secondary, and Accent color roles
- Sanctuary, Marian Blue, Cloister Green, and Advent Violet style variations
- Palette-aware gradients and photographic duotones
- Raised information panels with palette-aware accent strips, available as a Group/Column style or `mc-card-accent1`, `mc-card-accent2`, and `mc-card-accent3` classes
- Centralized parish name, Mass schedule, reconciliation, address, telephone, and email settings
- Block Bindings and shortcodes for reusable parish information
- Locally bundled Open Sans typography, an optional system font, and a bundled paper texture with no external font dependency

---

## Installation

1. Upload or clone `modern-catholic-theme` into `wp-content/themes/`.
2. Activate **Modern Catholic** under **Appearance → Themes**.
3. Open **Appearance → Editor** to choose a style variation and customize templates.
4. Configure shared parish information under **MC Theme Settings**.

Site Editor changes may be stored in the WordPress database and override source templates. Deliberately synchronize reusable changes into the theme before publishing a release or exporting with Create Block Theme.

---

## Component boundary

The theme owns presentation, templates, patterns, styles, and layout. Parish functionality such as Bulletins, Alerts, Events, Homilies, Today’s Readings, and updates remains in independently maintained Modern Catholic plugins.

---

## Changelog

### 1.8.5

- Add a raised-panel class reference to the admin Color & Style Guide, with palette-role descriptions and example uses.
- Explain how to apply the classes or use the Raised Panel block style in the Site Editor.

### 1.8.4

- Add palette-aware raised information panels and reusable Accent, Secondary, and Primary strip classes.
- Use Canvas for the content backdrop and Surface for raised panels, while preserving explicit editor-selected block backgrounds.
- Bundle Open Sans locally as the default font, with the system font still selectable.
- Add a desktop search icon to the shared header used by overlay and stacked layouts.

### 1.8.3

- Add a reusable Stacked (No Overlay) Header pattern that continues to use the shared Header template part.
- Keep the desktop navigation right-aligned when WordPress-generated flex layout CSS is loaded after the theme stylesheet.
- Center Quick Links separators by dividing the shared spacing evenly on both sides.

### 1.8.2

- Add a WordPress-native semantic color contract with six editable foundation colors and dynamic supporting tones.
- Expand the theme to 13 curated style variations with variable-driven gradients and variation-specific duotones.
- Add the Modern Catholic admin menu and read-only Color & Style Guide.
- Add automatic contrast, shared status roles, accessible focus treatment, and regression checks.

### 1.8.1

- Add a fully formatted GitHub README with Modern Catholic branding, compatibility badges, installation guidance, component boundaries, and GPL-3.0-only licensing.

### 1.8.0

- Refine semantic styles, responsive navigation, header treatments, Mega Menu layouts, and portable theme assets.

---

## License

Licensed under the GNU General Public License version 3.0 only (`GPL-3.0-only`). The bundled paper texture is distributed under the same license. Open Sans is bundled under the SIL Open Font License 1.1 in [`assets/fonts/open-sans/OFL.txt`](assets/fonts/open-sans/OFL.txt).
