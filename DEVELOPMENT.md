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
