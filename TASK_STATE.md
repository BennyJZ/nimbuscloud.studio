# TASK_STATE

_Last updated: 2026-10-01_

## Current objective

First working version of the WooCommerce watch-strap store on `nimbuscloud.studio`:
custom theme + 3 products with working variations and a real WooCommerce cart flow.

## Architecture chosen

Classic custom PHP theme (`nimbuscloud`) on hosted WordPress.com, WooCommerce as the
commerce backend. **Not headless.** See `DECISIONS.md` for why.

## Environment details (safe to store)

- Site: `https://nimbuscloud.studio` (WordPress.com, **Personal** plan)
- WordPress **7.1.2**, WooCommerce **11.1.2**, PHP **8.4.26**
- Previous theme: `Assembler` (block theme). Now active: **Nimbuscloud**
- Admin: `https://nimbuscloud.studio/wp-admin/`
- Custom theme upload: **permitted** on this plan (verified by installing it)
- Plugin/theme *marketplace* installs are gated, but `.zip` theme upload works
- No SFTP / no database access on this plan
- Credentials: Benny logs in interactively. **No secrets stored in this repo.**

## Completed

- [x] Environment inspected (WP/Woo versions, plan limits, access)
- [x] 3 Etsy listings recovered **from the live Etsy drafts** (source of truth)
- [x] Normalized `product-spec.json`
- [x] Product category `Watch Straps` (id 1372)
- [x] Global `Width` attribute (id 1) with terms 15mm–24mm
- [x] 3 **variable** products created, published, 19 variations total
- [x] Custom theme written, PHP-lint clean, uploaded and **activated**
- [x] Static front page "Home" (id 35)
- [x] `Primary Menu` (id 1383) created and assigned to `primary` + `footer`
- [x] Homepage verified live: hero, 9 width chips, 3 product cards, size guide
- [x] Fixed: duplicate product grid on homepage

## Product IDs

| Product | ID | Slug | Variations | SKU |
|---|---|---|---|---|
| Milanese Mesh Watch Strap | 12 | `milanese-mesh-watch-strap` | 8 (15–22mm) | NCS-CZ356-MIL |
| Woven Nylon Watch Strap with Magnetic Clasp | 21 | `woven-nylon-magnetic-watch-strap` | 9 (16–24mm) | NCS-HU591-NYL |
| Parachute Nylon Watch Strap | 31 | `parachute-nylon-watch-strap` | 2 (20, 22mm) | NCS-MF278-PAR |

## Current blockers

- **Prices are 0.00** — waiting on real prices from Benny. He explicitly rejected
  placeholder pricing, so products stay at 0.00 rather than carrying invented numbers.
- **No images** — Benny is supplying his own photos. Taobao is logged out, so supplier
  photos cannot be fetched.

## Exact next action

Re-upload the theme zip (duplicate-grid fix) and verify on the live product page:
variation select → price updates → Add to Cart → cart count increments.

## Relevant commands

```bash
# rebuild theme zip for upload
python scripts/build-theme.py

# syntax check all templates
for f in $(find wp-content/themes/nimbuscloud -name '*.php'); do php -l "$f"; done
```

Upload: wp-admin → Appearance → Themes → Add New → Upload Theme.
