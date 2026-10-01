# Policy page source

The authoritative source for the store's four legal pages. These are **WordPress pages**,
so their content normally lives only in the database — these files exist so the wording is
version-controlled and portable to another WordPress install.

| File | Page ID | Slug | Wired into |
|---|---|---|---|
| `privacy-policy.html` | 43 | `/privacy-policy/` | Settings → Privacy (`page_for_privacy_policy`) |
| `delivery.html` | 44 | `/delivery/` | Footer menu only |
| `returns-refunds.html` | 45 | `/returns-refunds/` | Footer menu only |
| `terms-conditions.html` | 46 | `/terms-conditions/` | WooCommerce → Advanced → Terms page |

## Unfinished business

Every file contains `TO COMPLETE` markers. **They are deliberate.** Business identity,
carrier names, delivery times and shipping rates were not invented, because a privacy
policy naming the wrong data controller, or a delivery page promising times no carrier
agreed to, is worse than an obvious blank.

Search for `TO COMPLETE` before launch:

```bash
grep -rn "TO COMPLETE" content/policy-pages/
```

## Re-publishing after an edit

Edit the HTML here, then push it to WordPress from a logged-in wp-admin tab:

```js
const n = window.wpApiSettings.nonce;
await fetch('/wp-json/wp/v2/pages/43', {
  method:'PUT', credentials:'same-origin',
  headers:{'X-WP-Nonce':n,'Content-Type':'application/json'},
  body: JSON.stringify({ content: /* file contents */ })
});
```

Keep this directory and the live pages in sync; the live page is what customers rely on,
but this directory is what survives a host migration.

## Legal basis for the wording

Written for a **Norway/EEA** consumer store:

- **GDPR** (EU 2016/679), applied in Norway via the EEA Agreement and personopplysningsloven
- **Angrerettloven** — Act of 20 June 2014 no. 27: the 14-day right of withdrawal
- **Forbrukerkjøpsloven** — 2-year (5-year for durable goods) complaint right
- **Bokføringsloven § 13** — 5-year accounting retention, cited as the retention basis
- Supervisory authority: **Datatilsynet**; dispute bodies: **Forbrukertilsynet**,
  Forbrukerklageutvalget

If the business is ever operated from outside Norway, these references must be revisited.

## Not legal advice

I am not a lawyer. These pages follow the statutes above and standard EEA e-commerce
practice, but have them reviewed before trading at volume.
