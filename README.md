# DC-DN

This repository hosts multiple sites. Each site now commits third-party assets locally for consistency.

## Asset structure

For every site (`DC`, `DN`, `ONL`, `ZB`) vendor assets are stored in:

- `vendor/` – CSS and JS from Bootstrap and jQuery.
- `js/vendor/` – Minified JS utilities (Vue, Axios, etc.).

Keeping the same structure across sites simplifies updates and ensures deployments do not rely on external CDNs.
