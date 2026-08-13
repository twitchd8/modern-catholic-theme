== Modern Catholic ==

Contributors: Andrew T. Schmitt
Requires at least: 7.0
Tested up to: 7.0
Requires PHP: 7.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html


== Description ==

A modern WordPress block theme built specifically with the Catholic Church in mind.


== Current Theme Foundation ==

* Uses the WordPress 7.0 theme.json schema and Global Styles system.
* Enables the standard appearance tools available in the Site Editor.
* Uses the visitor's system font stack without requiring an external font service.
* Uses a readable 42rem maximum content width and a 75rem wide-content maximum.
* Uses fluid horizontal page gutters that scale from 1rem to 2.5rem according to the viewport width.
* Frames the entire site in a fluid, centered shell with an 80rem maximum width.
* Keeps full-width blocks, including the front-page hero, inside that shared site shell.
* Uses a warm off-white site surface while preserving Global Styles background textures in the outer margins.
* Bundles a subtle paper texture as the portable outer-background default while allowing Global Styles to replace or remove it.
* Provides a semantic WordPress color system for canvas, surfaces, foreground text, borders, three tonal color scales, and accessible contrast colors.
* Includes the photo-inspired Sanctuary default plus Marian Blue, Cloister Green, and Advent Violet style variations.
* Allows standard and custom block colors to override theme defaults, including navigation submenu and mobile-overlay colors.
* Maps theme surfaces, text, links, buttons, shadows, overlays, and structural accents to reusable palette variables.
* Includes reusable header and footer template parts.
* Uses the responsive Navigation block, including its built-in mobile overlay behavior.
* Overlays the front-page header on the hero and converts it to a readable sticky bar after the hero scrolls away.
* Includes a constrained index template with a post query, featured images, post metadata, and pagination.
* Uses native block responsiveness and a small dependency-free front-page script for the sticky-header transition.


== Choosing a Color Palette ==

1. Open Appearance > Editor.
2. Open Styles, then Browse styles.
3. Choose Default for the Sanctuary palette, or select Marian Blue, Cloister Green, or Advent Violet.
4. Save the Global Styles change.

Colors selected directly on a block remain more specific than theme defaults. Navigation's Text, Background, Submenu & overlay text, and Submenu & overlay background controls can therefore be adjusted independently after choosing a palette.


== Changelog ==

= 1.7.0 =
* Replaced fixed color names with semantic Canvas, Surface, Foreground, Border, Primary, Secondary, Accent, and contrast roles.
* Added 100, 300, base, 700, and 900 tonal steps for the Primary, Secondary, and Accent color families.
* Added Marian Blue, Cloister Green, and Advent Violet WordPress style variations alongside the Sanctuary default.
* Enabled custom colors in the WordPress color picker.
* Removed forced navigation, submenu, mobile-overlay, title, footer, and button colors that overrode Site Editor choices.
* Added conditional color defaults that apply only when a block has no editor-selected text or background color.
* Migrated theme-supplied patterns and template parts to semantic palette slugs.
* Added dynamic compatibility aliases for content created with the former Almandine, Barley, Mountain Moss, Sanctuary Burgundy, Ink, and White slugs.

= 1.6.3 =
* Bundled the default paper texture with the theme so it remains available on fresh installations and in manually uploaded release packages.
* Added a native `theme.json` outer-background default that remains overridable through WordPress Global Styles.
* Removed the Today’s Readings template part and front-page placement so plugin-related visuals remain owned by the Today’s Readings plugin.

= 1.6.2 =
* Added the canonical Modern Catholic theme repository URL to the theme metadata.
* Standardized the theme metadata, documentation, and bundled license on GNU GPL version 3.0 only.

= 1.6.1 =
* Replaced the footer Parish Name placeholder with a Block Binding that displays the current year and centralized Parish Name setting.

= 1.6.0 =
* Consolidated the parish welcome message into the front-page hero and removed the redundant welcome section and I'm New action.
* Replaced the default theme thumbnail with a current Modern Catholic site screenshot.
* Replaced the stock WordPress footer credit with the theme author link and editable parish copyright text.
* Matched the footer and shared header to semantic palette variables so future palette variations can change them consistently.
* Added MC Theme Settings as a dedicated top-level administration screen.
* Added centralized Parish Name, Mass schedule, Reconciliation, address, telephone, and email settings with WordPress-native validation.
* Defaulted a missing or deleted Parish Name to the current WordPress Site Title.
* Connected reusable Mass Times blocks through the WordPress Block Bindings API.
* Added documented shortcodes for displaying every centralized parish setting in posts, pages, templates, and widget areas.
* Applied the palette-aware shared header globally, with a translucent treatment when it overlays the front-page hero or a Single Post featured image.
* Extended the centered 80rem site frame and warm content surface to every theme template, Site Editor canvas, and compatible plugin-rendered page.
* Preserved light, palette-derived Site Title and tagline contrast on standard and plugin-rendered headers.

= 1.5.1 =
* Moved Search from the fixed mobile header into the managed mobile navigation drawer.
* Forced the hamburger treatment through the complete mobile and tablet breakpoint.
* Prevented the expanded mobile header from obscuring front-page hero text.

= 1.5.0 =
* Added a separate desktop utility-navigation tier for Bulletin, Contact Us, and Register Here.
* Connected Primary, Utility, and Mobile headers to independently managed WordPress Navigation records.
* Kept portable Navigation Link fallbacks in the theme source for new installations.
* Combined primary and utility destinations into a single full-viewport navigation drawer on mobile.

= 1.4.5 =
* Matched the front-page hero actions to the standard Sanctuary Burgundy button treatment.
* Derived hover and sticky-header shades from semantic palette variables for future style variations.

= 1.4.4 =
* Added a subtle Sanctuary Burgundy wash behind the header while it overlays the hero.

= 1.4.3 =
* Removed the obsolete mobile admin-bar offset when the front-page header enters sticky mode.

= 1.4.2 =
* Prevented saved Site Editor color utilities from darkening the front-page site title.

= 1.4.1 =
* Strengthened the front-page site title against both the hero image and sticky burgundy header.

= 1.4.0 =
* Added a modular, photo-inspired color palette to Global Styles.
* Applied Almandine Ivory to the site surface, Barley Gold to the welcome section, and Sanctuary Burgundy to links and primary actions.
* Added Ink and White as accessible text colors while reserving Mountain Moss for secondary structure.

= 1.3.1 =
* Removed the default block gap between the front-page overlay header and hero.
* Added a warm off-white site surface to distinguish content from outer background textures.

= 1.3.0 =
* Added a centered, fluid 80rem maximum site shell for the complete site layout.
* Kept the front-page hero and navigation within the same responsive shell.
* Preserved Site Editor background images and textures around a warm, contrasting content surface.
* Added a transparent hero-overlay header that becomes a dark sticky bar after the hero passes.
* Accounted for the WordPress admin bar, reduced-motion preferences, and scrollbar-safe widths.

= 1.0.0 =
* Created the initial full-site-editing theme structure.
* Added the site header, responsive navigation, footer, and index query template.
* Enabled Global Styles appearance controls and a system-font typography foundation.
* Converted the content and wide layout limits from pixels to rem units.
* Added fluid root gutters with clamp() for phone, tablet, and desktop layouts.
* Enabled root-padding-aware full-width alignments.
* Documented the responsive foundation and current theme inventory.


== Copyright ==

Modern Catholic WordPress Theme, (C) 2026 Andrew T. Schmitt
Modern Catholic is distributed under GNU GPL version 3.0 only.

The bundled `assets/images/textured-paper.png` theme asset is distributed under the same GNU GPL version 3.0-only license.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, version 3 of the License only.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
