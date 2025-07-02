# Dating Nebenan

This repository contains the source code for **Dating Nebenan**, a small PHP and Vue.js website for discovering local dating opportunities in Germany. The site renders dynamic profiles pulled from a remote API and provides landing pages for each German province.

## Setup

1. Ensure you have PHP 7.4 or higher installed.
2. Clone this repository and install dependencies (none are required outside of the provided `vendor` directory).
3. Start a development server from the project root using the provided
   `router.php` so that pretty URLs are rewritten correctly:

```bash
php -S localhost:8000 router.php
```

4. Visit `http://localhost:8000` in your browser.

## Environment variables

The project uses a few hard coded URLs that may need to be adjusted for different environments:

- **Base URL** – configure via the `BASE_URL` environment variable or edit `includes/config.php`. This value is referenced when generating canonical and Open Graph URLs.
- **API endpoints** – various pages define `api_url` JavaScript variables (see `index.php`, `profile.php` and `provincie.php`). Update these values to point to your own API server.

## Running locally

After updating the URLs if necessary, launch the built‑in PHP server with
`router.php` to enable URL rewriting as shown above. The site should load
locally with fully static assets and API calls hitting the configured
endpoints.
