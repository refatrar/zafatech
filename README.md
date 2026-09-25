# Zafa Tech — Website

Single-page marketing site for **Zafa Tech**, a repair and tech-services shop at 18 Rue Littré, 75006 Paris.
Built with HTML5, Tailwind CSS (compiled), Animate.css and vanilla JavaScript. No frameworks.

## Quick start

View the site: open `index.html` in a browser. The compiled CSS is committed, so no build step is needed to view it.

Or serve it locally:

```bash
python3 -m http.server 8000   # then open http://localhost:8000
```

Edit styles:

```bash
npm install        # installs the Tailwind CLI (dev only)
npm run watch      # rebuilds css/style.css while you edit
npm run build      # one-off minified build
```

Always edit `css/input.css`, never `css/style.css` (it's generated).

## Structure

```text
index.html                  All page markup + inline SVG icon sprite + JSON-LD
css/input.css               Tailwind source: tokens, components, animations
css/style.css               Compiled output (generated)
js/app.js                   All interactions (nav, selector, FAQ, form, toasts…)
tailwind.config.js          Brand colours, fonts, breakpoints
assets/logo/                SVG logo lockup, fleur-de-lis mark, favicon
assets/images/              Storefront photo, Open Graph image
DESIGN_ANALYSIS.md          Discovery: reference analysis, brand spec
DESIGN_PLAN.md              Section-by-section design plan
unnamed.webp                Original brand reference photo (kept untouched)
```

## Before launch: placeholders to replace

Search the project for `[` to find them all.

| Placeholder | Where |
|---|---|
| `[Business hours]` | Contact section, footer. Also add `openingHours` to the JSON-LD in `<head>` |
| `[Warranty period & terms]` | "Why Zafa Tech" card, FAQ |
| Privacy / Terms / Service policy text | `initLegal()` in `js/app.js` and the `#legal-dialog` markup |
| Social media links | Footer `data-placeholder-link` anchors: set a real `href` and remove the attribute |
| Refurbished listings | `REFURB_ITEMS` in `js/app.js` (clearly marked demo data) |
| Canonical URL | Commented `<link rel="canonical">` in `<head>`; make `og:image` absolute too |

Contact details (address, phone, email) and the in-store services list were taken from the
Zafa Tech storefront photo. Please double-check them.

## Connecting a backend

- **Repair requests:** replace the body of `submitRepairRequest(payload)` in `js/app.js` with a `fetch`
  to your API. The payload contains `name, phone, email, device, model, problem, contactMethod, consent, submittedAt`.
  Throwing or rejecting shows the error toast automatically. Validate server-side too.
- **Refurbished stock:** fetch items with the same shape as `REFURB_ITEMS` and call the existing render.
- **Device/repair lists:** edit the `REPAIRS` object. Tabs and symptom chips are generated from it.

## Brand tokens

| Token | Hex | Use |
|---|---|---|
| `brand-600` | `#1D4ED8` | Primary: fleur-de-lis blue, buttons, links |
| `navy-900` | `#0A1F44` | Secondary: shop-front navy, dark sections |
| `crimson-500` | `#D6204E` | Accent: wordmark crimson, highlights |
| `signal` | `#22D3EE` | Diagnostic/circuit graphics on dark only |
| `paper` | `#F5F7FC` | Page background |

Fonts: Bricolage Grotesque (display), Manrope (body), JetBrains Mono (technical labels), Cinzel (wordmark only).

## Accessibility & motion

Skip link, landmarks, ARIA tab and accordion patterns, labelled and announced form errors, visible focus rings,
and 44px+ touch targets. `prefers-reduced-motion` disables all custom and Animate.css animation. Content is
visible without JavaScript.
