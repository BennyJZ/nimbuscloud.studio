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
- [x] Fixed: empty Cart/Checkout pages (added `page.php`; `index.php` now uses `the_content()`)
- [x] Added cart/checkout/mobile CSS, covering both classic and block Woo markup
- [x] Git repo initialized, 2 commits, secret scan clean

## Product IDs

| Product | ID | Slug | Variations | SKU |
|---|---|---|---|---|
| Milanese Mesh Watch Strap | 12 | `milanese-mesh-watch-strap` | 8 (15–22mm) | NCS-CZ356-MIL |
| Woven Nylon Watch Strap with Magnetic Clasp | 21 | `woven-nylon-magnetic-watch-strap` | 9 (16–24mm) | NCS-HU591-NYL |
| Parachute Nylon Watch Strap | 31 | `parachute-nylon-watch-strap` | 2 (20, 22mm) | NCS-MF278-PAR |

## Verification performed (live, 2026-10-01)

| Check | Result |
|---|---|
| 3 products appear on shop + homepage | PASS — 3 cards, 3-col grid |
| Product pages load | PASS — all 3 |
| Variation selector present | PASS — 8 / 9 / 2 options, `attribute_pa_width` |
| Variation resolves | PASS — 20mm → variation id 26, SKU → `NCS-HU591-NYL-20` |
| Invalid combo blocked | PASS — Add to Cart disabled until a width is chosen |
| Add to Cart | PASS — real Woo cart, header count → 1 |
| Cart contents | PASS — correct product + `Width: 20mm` + qty controls |
| Checkout | PASS — Woo block checkout, 10 fields, item carried, "Place Order" |
| Navigation | PASS — Home/Shop/Cart/About in header + footer |
| Responsive | PASS — 375 / 768 / 1440px, no horizontal overflow |
| Console errors | PASS — zero on home, shop, product |
| Secrets exposed | PASS — git secret scan clean, `dist/` ignored |
| Direct URLs / refresh | PASS — all routes load directly |

Test cart item was removed afterwards via the Store API, so the cart is empty.

## Legal / policy pages (added 2026-10-01)

Four pages published, written for **Norway/EEA** (GDPR + angrerettloven):

| Page | ID | URL | Wired into |
|---|---|---|---|
| Privacy Policy | 43 | `/privacy-policy/` | Settings → Privacy (`page_for_privacy_policy`) |
| Delivery | 44 | `/delivery/` | Footer menu |
| Returns & Refunds | 45 | `/returns-refunds/` | Footer menu |
| Terms & Conditions | 46 | `/terms-conditions/` | Woo → Advanced → Terms page |

- Source of truth: `content/policy-pages/*.html` (version-controlled, not DB-only)
- Nav menu **Legal** (id 1384) assigned to the `footer` location; `Primary Menu`
  (1383) keeps the header
- Checkout now shows an **explicit, unticked consent checkbox** linking both policies
  (`checkout-terms-block {"checkbox":true}` — Woo's default is implied consent, which is
  weaker than GDPR affirmative action wants)
- WooCommerce's unused `refund_returns` stub page (id 9) was trashed to avoid two
  competing returns policies
- **21 `TO COMPLETE` markers** remain across the four pages: business identity, org.nr,
  contact email, carrier names, delivery times and rates. Deliberately not invented.

### Store settings that still need fixing before launch

WooCommerce is configured as **country US:CA, currency USD**, with an empty store address
and **no shipping zones**. For a Norwegian business this is wrong and affects tax,
currency and which consumer law the policies should cite.

## Current blockers

- **Prices are 0.00** — waiting on real prices from Benny. He explicitly rejected
  placeholder pricing, so products stay at 0.00 rather than carrying invented numbers.
- **No images** — Benny is supplying his own photos. Taobao is logged out, so supplier
  photos cannot be fetched.

## Exact next action

**Milestone 1 is complete and verified.** Waiting on Benny for real prices and product
images. When prices arrive:

```
PUT /wp-json/wc/v3/products/<id>/variations/<vid>  { "regular_price": "<price>" }
```
(run from a logged-in wp-admin tab so the REST nonce applies)

Then: set images per product, and decide whether to launch the site.

## Relevant commands

```bash
# rebuild theme zip for upload
python scripts/build-theme.py

# syntax check all templates
for f in $(find wp-content/themes/nimbuscloud -name '*.php'); do php -l "$f"; done
```

Upload: wp-admin → Appearance → Themes → Add New → Upload Theme.
