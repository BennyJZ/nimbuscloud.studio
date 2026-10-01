# DECISIONS

## D1 — Classic PHP theme, not headless, not a block theme

**Decision:** custom classic PHP theme with WooCommerce template overrides.

**Why:** the brief says prefer the simplest maintainable architecture that works properly
with WooCommerce, and not to go headless without concrete technical reason. A classic
theme gets full control of markup while WooCommerce keeps owning cart/checkout/orders.
Headless would mean rebuilding cart and checkout — explicitly discouraged, and on a
Personal plan there is no reliable way to host a separate frontend anyway.

A block theme was rejected because the required layouts (lug-width chips, size guide,
spec sections) are easier to express and version-control as PHP templates than as
serialized block markup in the database — and database content is not retrievable as
source files, which the brief requires.

## D2 — Develop against hosted WordPress.com, not LocalWP/Docker

**Decision:** work directly against the live hosted instance; keep all source in Git.

**Why:** the store already exists on WordPress.com with WooCommerce active. The plan
offers no SFTP or DB access, so a local stack could never sync back automatically — it
would add a mirror to maintain with no payoff. The brief's real requirement is that the
project must not depend on an inaccessible environment: satisfied because 100% of custom
code lives in this repo and installs on any WordPress via theme upload.

**Trade-off:** no offline development, and theme changes require a zip upload.

## D3 — Products are `variable`, widths are a global attribute

**Decision:** `pa_width` as a **global** attribute with shared terms; one variation per width.

**Why:** the brief forbids putting selectable options only in the description. Global
rather than per-product means the terms are shared across all three products, enabling
filtering/archives and consistent naming — a per-product attribute would duplicate
"20mm" three times with no relationship.

## D4 — Price stays 0.00; no placeholder pricing

**Decision:** publish with `regular_price = 0.00` until Benny supplies real prices.

**Why:** Benny chose "leave as drafts at 0.00 until I give you real prices" when asked,
and the brief forbids publishing incorrect placeholder data. The Etsy listings only carry
the 2.01 NOK platform minimum, which is not a real price. Products are published (not
draft) so the storefront and cart flow are actually testable.

## D5 — No product images

**Decision:** ship without images.

**Why:** Benny is adding his own photos. No images exist anywhere — Taobao is logged out,
and nothing was uploaded to Etsy. Generating decorative stand-ins would be fabricated
product data.

## D6 — Products were recovered from live Etsy drafts, not local notes

**Decision:** read title/description/tags directly from the three Etsy listing editors.

**Why:** the brief names the Etsy listings as the primary source. Local markdown copies
existed but parsed unreliably (headers bled into captured titles), whereas the live Etsy
drafts are authoritative and exact. Verified lengths: 129/2419, 136/2480, 109/2344 chars.

## D7 — Etsy marketing titles separated from product names

**Decision:** WooCommerce `name` is a clean product name; the keyword-stuffed Etsy title
is preserved in `product-spec.json` as `etsy_title`.

**Why:** the brief asks to keep Etsy-specific marketing language separate from factual
product information. "Milanese Mesh Watch Strap" is right for a web storefront;
"...15mm 16mm 17mm 18mm..." is an Etsy search artifact, and the widths are already
expressed properly as variations.

## D8 — One product grid on the homepage, not two

**Decision:** removed the "Picked for you" featured grid.

**Why:** with a 3-product catalogue every product is featured, so the grid rendered the
same three straps twice — verified live. One honest grid is correct until the catalogue
is big enough for the two sets to differ.
