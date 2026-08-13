# Development and Release Workflow

## Branches

- `main` is the production-ready branch. The live HFCC release should come from `main` or from a dated release tag.
- `dev` is the integration branch for ongoing development.
- Create a short-lived feature branch from `dev` when a change is large, risky, or needs isolated testing.

## Starting Work

1. Switch the ATS working copy to `dev`.
2. Pull the latest `dev`.
3. Make and test changes locally.
4. Commit the tested change to `dev`, or merge a feature branch into `dev`.

## Releasing

1. Confirm the `dev` working tree is clean.
2. Test the complete change in ATS-WP-DEV.
3. Open a pull request from `dev` to `main`.
4. Review the diff and merge only when it is ready for production.
5. Deploy the resulting `main` commit.
6. Create and push a dated release tag for the deployed commit.

## Emergency Recovery

The initial production breakpoint is tagged:

`hfcc-live-2026-07-28`

A tag identifies an exact historical commit. Do not move or reuse an existing release tag.

## Important WordPress Boundary

WordPress Navigation records and saved template-part overrides live in the site database, not in the theme repository.

- Site Editor changes do not update theme files automatically. Deliberately synchronize reusable changes into the repository or export them with Create Block Theme.
- ATS-WP-DEV currently uses separately managed Primary, Utility, and Mobile Navigation records.
- The active saved Header template part references those records.
- `parts/header.html` retains equivalent inline Navigation Link fallbacks so the theme remains portable.
- A new installation must not silently create navigation records on activation. Any future setup action must require administrator consent.
- The Bulletin destination is provided by the Parish Bulletins plugin. Contact Us and Register Here require pages to be created before launch.

## Semantic Color Contract

Theme presentation must reference semantic WordPress preset variables instead of fixed color values. A palette variation may change the atmosphere, but it must preserve these slugs and their intended roles:

- Foundation: `canvas`, `surface`, `surface-alt`, `foreground`, `text-muted`, and `border-subtle`.
- Primary scale: `primary-100`, `primary-300`, `primary`, `primary-700`, and `primary-900`.
- Secondary scale: `secondary-100`, `secondary-300`, `secondary`, `secondary-700`, and `secondary-900`.
- Accent scale: `accent-100`, `accent-300`, `accent`, `accent-700`, and `accent-900`.
- Contrast roles: `on-primary`, `on-secondary`, `on-accent`, `on-image`, and `scrim`.

Every file in `styles` must define the complete slug set. Keep normal text/background pairs at WCAG AA contrast or better. Use the `on-*` role paired with its named base family, and use `on-image` with `scrim` for text over photography.

Block and Global Styles choices are authoritative. Theme CSS may provide a default only when the relevant block does not carry WordPress's `has-text-color` or `has-background` class. Do not use `!important` for color or background declarations. Layout-only `!important` declarations may be retained where required to control responsive Navigation visibility.

The legacy Almandine, Barley, Mountain Moss, Sanctuary Burgundy, Ink, and White utility classes are compatibility aliases only. New theme markup must use semantic slugs.
