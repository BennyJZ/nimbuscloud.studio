# TODO

## Blocked on Benny

- [ ] **Fill the 21 `TO COMPLETE` markers** in `content/policy-pages/` — business name,
      org.nr, address, contact email, carriers, delivery times, shipping rates
      (`grep -rn "TO COMPLETE" content/policy-pages/`)
- [ ] **Fix store country/currency** — WooCommerce says `US:CA` / `USD`; should be Norway
      and the currency you intend to sell in
- [ ] **Configure shipping zones** — none exist, so the Delivery page cannot be completed
- [ ] **Enable a payment gateway** — none enabled; the privacy policy must then name the
      processor as a recipient

- [ ] **Real prices** for all 3 products (currently 0.00)
- [ ] **Product images** — main image + gallery per product
- [ ] Decide whether to **launch the site** (currently "Coming Soon", so logged-out
      visitors see an interstitial instead of the store)

## Next up

- [ ] Verify Add to Cart → cart → checkout end to end on the live site
- [ ] Mobile layout check at 375px / 768px
- [ ] Confirm invalid variation combinations cannot be purchased
- [ ] Shipping classes / weights per strap (needs real weights)
- [ ] Per-variation SKUs are set; add per-variation stock if Benny wants stock tracking

## Nice to have later

- [ ] Width filter widget on the shop page (the global `pa_width` attribute supports it)
- [ ] 1-pack / 2-pack variation for the parachute strap (supplier offers both)
- [ ] Colour attribute once supplier colour data is available
