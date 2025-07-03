# DC-DN

This repository hosts multiple sites. Each site now commits third-party assets locally for consistency.

## Asset structure

For every site (`DC`, `DN`, `ONL`, `ZB`) vendor assets are stored in:

- `vendor/` – CSS and JS from Bootstrap and jQuery.
- `js/vendor/` – Minified JS utilities (Vue, Axios, etc.).

Keeping the same structure across sites simplifies updates and ensures deployments do not rely on external CDNs.

## Environment variables

Deployment for each site relies on three environment variables that override the defaults in every `config.php` file:

- `ONL_BASE_URL` – canonical site URL used when generating links and Open Graph metadata.
- `BASE_API_URL` – base URL of the remote API serving profile data and banners.
- `APP_DEBUG` – set to `true` to enable PHP error reporting during development.

If not set, each site falls back to the hard coded values in its own `config.php`. Specifying these variables per environment lets the same code run for all four directories (`DC`, `DN`, `ONL`, `ZB`).


## Generating sitemaps

Run `php generate_sitemap.php` inside any site directory (`DC`, `DN`, `ONL`, `ZB`) to rebuild its `sitemap.xml` file. You can automate this with a cron job to keep search indexes fresh.

