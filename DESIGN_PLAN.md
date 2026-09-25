# Zafa Tech — Design Plan (Phase 2)

Concept: **"Atelier Bleu"** — a Parisian neighbourhood repair lab. Clean white "sign-panel" surfaces on
deep shop-front navy, royal-blue precision, a crimson spark. Visual motifs: fine circuit traces, exploded
device layers, monospaced diagnostic readouts, the fleur-de-lis mark.

## 1. Sections

| # | Section (id) | Desktop | Mobile | Motion |
|---|---|---|---|---|
| 1 | Header | Logo · 5 links · phone chip · "Book a Repair" | Logo · CTA icon · hamburger → slide-down panel | Blur/shadow after 24px scroll; burger morphs to ✕ |
| 2 | Hero `#top` | 2-col: copy left, **exploded-phone diagnostic visual** right (screen layer lifted off chassis, circuit board below, live "scan" readout card) | Copy, CTAs, compact visual | Layer float loops, scan line, typed status cycling; `fadeInUp` on copy |
| 3 | Services `#services` | Bento-style grid, 4 cols, 10 cards (icon, title, text, "Request →") | 1–2 cols, full tap area | Lift + glow + icon wiggle + arrow slide |
| 4 | Device selector `#diagnose` | Tabs left (vertical) · panel right: fault chips + "Selected: …" summary + "Continue to booking" | Horizontal scroll-snap tabs above panel | Chips stagger in (`fadeInUp`, 40ms steps) |
| 5 | Board-level lab `#lab` | Dark navy, animated SVG circuit with travelling pulses, capability list, "microscope" readout panel | Stacked | Pulse dash animation, subtle grid drift |
| 6 | Why Zafa Tech `#why` | 4×2 icon cards + shop photo card with address | 1–2 cols | Reveal only |
| 7 | How it works `#process` | Horizontal 4-step timeline with connecting line that fills on reveal | Vertical timeline, line on the left | Line fill + step `fadeInUp` |
| 8 | In-store services `#instore` | Strip of 7 compact tiles (printing, photocopy, scan, email, SIM, accessories, Ria) | 2-col grid | Hover tint |
| 9 | Refurbished `#refurbished` | Filter pills (All/Phones/Laptops/Tablets/Other) + product cards rendered from a JS data array ("Demo listing" badge, "Price on request") | 1–2 cols | Card fade on filter |
| 10 | Booking `#booking` | Navy panel: benefits left, form right | Form full width | Toast feedback, field shake on error |
| 11 | FAQ `#faq` | 2-col: intro + contact CTA left, accordion right | Single col | Height transition via grid-rows trick |
| 12 | Contact `#contact` | Info cards (phone, email, address, hours) + map link card with shop photo | Stacked | Reveal |
| 13 | Footer | Logo + blurb, Services, Navigate, Contact, socials, legal row + independence notice | Stacked accordion-free columns | — |

Floating **back-to-top** button (bottom-right) appears after 600px.

## 2. Component structure
- `.btn`, `.btn-primary`, `.btn-ghost`, `.btn-light` — pill buttons with arrow nudge on hover.
- `.eyebrow` — mono uppercase label with crimson dot (echoes the sign bullets).
- `.card` — white surface, 1px border, soft shadow, radius 24px.
- `.service-card`, `.device-tab`, `.fault-chip`, `.step`, `.faq-item`, `.product-card`, `.toast`.
- Icons: one inline SVG `<symbol>` sprite at top of `<body>` (works on `file://`, no extra requests),
  referenced with `<use href="#i-…">`.

## 3. JavaScript (`js/app.js`, one IIFE, no dependencies)
| Module | Behaviour |
|---|---|
| `initHeader` | `IntersectionObserver` on a sentinel → toggles `.is-scrolled` (no scroll handler). |
| `initMobileNav` | Toggle, `aria-expanded`, body scroll-lock, Esc, outside click, closes on link click, returns focus. |
| `initScrollSpy` | IO on sections → `aria-current` + active style on nav links. |
| `initSmoothScroll` | Native `scroll-behavior` + `scroll-padding-top`; JS only moves focus to target for a11y. |
| `initReveal` | `[data-reveal="fadeInUp"]` + optional `data-delay`; IO adds `animate__animated animate__{name}` once. Skipped under reduced motion. |
| `initDeviceSelector` | Data map `REPAIRS` → renders chips; tablist with arrow/Home/End keys; multi-select chips; "Continue" pre-fills booking (device + problem) and scrolls. |
| `initFAQ` | Single-open accordion, `aria-expanded`/`aria-controls`/`hidden`-free grid transition, arrow-key navigation between headers. |
| `initRefurbished` | Renders `REFURB_DEMO` array; filter pills with `aria-pressed`. |
| `initBookingForm` | Validation rules per field, inline errors (`aria-invalid`, `aria-describedby`), first-invalid focus, `submitRepairRequest(payload)` stub returning a Promise (single place to wire an API). |
| `toast()` | Stackable, `role="status"`/`aria-live`, auto-dismiss, close button. |
| `initBackToTop` | IO on a sentinel. |
| `initHeroTicker` | Cycles diagnostic status text (paused under reduced motion). |

## 4. Animation strategy
- Animate.css (CDN 4.1.1) **only** for scroll reveals and chip entry; duration shortened to 700ms via CSS var.
- Custom keyframes: `float-a/b/c` (hero layers), `scan` (hero line), `pulse-dash` (circuit), `grid-drift`,
  `gradient-pan` (CTA/booking glow), `wiggle` (icons on hover), `shake` (invalid field).
- Transform/opacity only. `will-change` avoided except on the 3 hero layers.
- `@media (prefers-reduced-motion: reduce)`: all custom animations off, Animate.css reveals disabled
  (elements rendered visible), smooth scroll off.
- Elements are visible by default; `.reveal-pending` (opacity 0) is only added by JS, so no-JS users see everything.

## 5. Accessibility
Skip link · landmarks (`header`, `nav`, `main`, `footer`) · one H1, sequential H2/H3 · `:focus-visible`
ring (royal blue + white offset, cyan on dark) · labels on every field, errors announced · tablist/accordion
ARIA patterns · 44px min targets · decorative SVG `aria-hidden` · contrast checked for muted text and
white-on-blue buttons (#1D4ED8 on white = 6.7:1).

## 6. SEO
Title + description · canonical placeholder comment · Open Graph + Twitter tags · `theme-color` ·
`LocalBusiness`/`ElectronicsStore`-style JSON-LD with **only** facts from the storefront
(name, address, phone, email) — no hours, ratings or prices · descriptive alt on the shop photo.

## 7. Content rules
- Real facts from storefront used: address, phone, email, in-store services.
- Placeholders in `[brackets]` for: hours, warranty period, social links, prices, legal pages.
- No statistics, reviews, certifications or years of experience.
- Refurbished products are clearly labelled **demo data** in code and UI.

## 8. Assets
- `assets/logo/zafatech-logo.svg` (horizontal lockup), `zafatech-mark.svg` (fleur-de-lis), `favicon.svg`.
- `assets/images/zafatech-storefront.webp` — copy of the provided photo (original left untouched).
- `assets/images/og-image.jpg` — 1200×630 generated from the hero via headless Chrome.

## 9. Build decision (architectural note)
Tailwind's Play CDN is explicitly "not for production" (runtime JIT in the browser, ~300KB script,
flash of unstyled content). Instead: `tailwindcss@3` CLI as a **dev dependency** compiles
`css/input.css` → `css/style.css` (minified, purged). The compiled `style.css` is kept in the repo so
`index.html` works by simply opening it — no build step needed to *view* the site, only to *change* styles.
