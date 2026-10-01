# Nimbuscloud Store

Custom WooCommerce storefront for **nimbuscloud.studio** — replacement watch straps.

## 1. Development environment used

**Development is against the live hosted WordPress.com instance** (`nimbuscloud.studio`),
not a local stack. Reasons:

- The store is already hosted on WordPress.com (Personal plan) with WooCommerce 11.1.2 active.
- WordPress.com manages PHP/MySQL; there is no DB access or SFTP on this plan, so a local
  stack could not be synced back automatically anyway.
- Custom theme `.zip` upload **is** permitted on this plan, which is enough to ship a
  fully custom PHP theme.

**All custom source lives in this repository**, so the project is NOT dependent on the
hosted environment. The theme can be re-zipped and installed on any WordPress site.

## 2. Where the custom source code lives

```
nimbuscloud-store/
├── wp-content/themes/nimbuscloud/   <- the entire custom theme
│   ├── style.css                     theme metadata (WP requires this file)
│   ├── functions.php                 WooCommerce support + hooks
│   ├── header.php / footer.php
│   ├── front-page.php                homepage
│   ├── index.php                     fallback template
│   ├── woocommerce/
│   │   ├── single-product.php        product page wrapper (template override)
│   │   └── content-single-product.php product page body (template override)
│   └── assets/css/main.css, assets/js/product.js
├── scripts/build-theme.py           re-zip the theme for upload
├── product-spec.json                normalized product data (source of truth for re-import)
├── TASK_STATE.md                    current status / next action
├── DECISIONS.md                     why things are the way they are
└── TODO.md
```

## 3. Required software

- **Git** (2.53+) — version control
- **Python 3.9+** — only to run `scripts/build-theme.py` (stdlib only, no packages)
- **PHP CLI 8.x** *(optional)* — to syntax-check templates before upload

No Node.js build step. No Composer. No bundler. The theme is plain PHP + CSS, which keeps
it maintainable and removes an entire class of build breakage.

## 4. Installing dependencies

None to install. The theme has zero runtime dependencies beyond WordPress + WooCommerce.

Optional lint check with a portable PHP:

```bash
for f in $(find wp-content/themes/nimbuscloud -name '*.php'); do php -l "$f"; done
```

## 5. Running the site

The site runs on WordPress.com. There is no local server.

To work on it:

1. Edit files under `wp-content/themes/nimbuscloud/`.
2. Rebuild the zip: `python scripts/build-theme.py`
3. Upload at **wp-admin → Appearance → Themes → Add New → Upload Theme**
   (replacing the existing copy when prompted).

To run it locally instead, see *Deploying elsewhere* below — the theme is portable.

## 6. How the frontend integrates with WooCommerce

This is a **classic PHP child-less theme** that WooCommerce treats as fully supported.
It is NOT headless; WooCommerce remains the sole source of truth for products, prices,
variations, cart, checkout and orders.

Integration points:

| Mechanism | Where | Purpose |
|---|---|---|
| `add_theme_support('woocommerce')` | `functions.php` | Required, or Woo forces its own wrappers |
| `wc-product-gallery-zoom` / `-lightbox` / `-slider` | `functions.php` | Opt-in gallery features |
| `woocommerce_before/after_main_content` | `functions.php` | Swap Woo's wrappers for this theme's grid |
| Template override dir `woocommerce/` | theme root | WooCommerce auto-loads overrides from here |
| `do_action('woocommerce_single_product_summary')` | `content-single-product.php` | Emits title, price, **variation form**, add-to-cart |
| `[products]` shortcode | `front-page.php` | Renders the grid through Woo's own loop + hooks |
| `woocommerce_add_to_cart_fragments` | `functions.php` | Keeps the header cart count in sync via AJAX |

**Critical design rule:** the product page prints *no* commerce markup itself. Title,
price, variation selectors and add-to-cart all come from WooCommerce hooks. Hard-coding
that markup is the usual reason custom themes break variable products and AJAX cart —
and every product here is a variable product with multiple widths.

## 7. Deploying to another WordPress installation

1. `python scripts/build-theme.py` → produces `dist/nimbuscloud.zip`
2. Target site → **Appearance → Themes → Add New → Upload Theme** → activate.
3. Install + activate **WooCommerce**.
4. Recreate commerce config that is NOT in source control (see section 8).

Or copy `wp-content/themes/nimbuscloud/` straight into the target's themes directory.

## 8. WooCommerce configuration not representable in source files

These live in the database and must be recreated on a new install. `product-spec.json`
holds the product data needed to rebuild them.

- **Product category:** `Watch Straps` (slug `watch-straps`)
- **Global attribute:** `Width` (`pa_width`), terms 15mm–24mm
- **3 variable products**, 19 variations total — see `product-spec.json`
- **Front page:** Settings → Reading → static page "Home"
- **Menu:** `Primary Menu` assigned to both `primary` and `footer` locations
- **Woo pages:** Shop / Cart / Checkout / My account (created by WooCommerce itself)

No database dump is included, since it would contain order and user data.

## 9. Known gaps (deliberate, not bugs)

- **Prices are 0.00.** Benny supplies real prices; placeholders were explicitly rejected.
- **No product images.** Benny is adding his own photos.
- **Site is unlaunched** ("Coming Soon"), so logged-out visitors see an interstitial.
