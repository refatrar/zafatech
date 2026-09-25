# Zafa Tech — Design Analysis (Phase 1: Discovery)

## 1. Project inventory

| Item | Finding |
|---|---|
| Existing files | Only `unnamed.webp` (470×510 photo) |
| Build system | None. No `package.json`, no HTML/CSS/JS |
| Existing assets | The storefront photo only. No vector logo, no icons |
| Tooling available | Node 20 / npm, Python 3, Google Chrome (used for headless QA) |

Because there is no existing architecture, the recommended structure from the brief is adopted
(`index.html`, `css/`, `js/`, `assets/`). Tailwind is compiled with the official Tailwind CLI
(see DESIGN_PLAN.md §9 for why not the Play CDN).

## 2. `unnamed.webp` analysis

The image is **not a standalone logo** — it is a street photo of the real Zafa Tech shop front.
It is still the most authoritative brand source available and contains real business facts.

### 2.1 Logo
- **Mark:** a solid, royal-blue **fleur-de-lis** (symmetric, three petals, band, three lower lobes).
- **Wordmark:** "ZafaTech" in a **small-caps serif**, crimson/magenta, set over a thin horizontal rule
  that crosses the lower part of the fleur-de-lis.
- **Tagline:** "All solutions on demand" (dark, sans-serif).
- **Resolution:** the logo is ~60px tall in the photo → unusable as a raster. It is **redrawn as SVG**
  (`assets/logo/`) keeping the same concept: blue fleur-de-lis + crimson "ZafaTech" + rule.

### 2.2 Facts visible on the storefront (real, not invented)
| Field | Value |
|---|---|
| Address | 18 Rue Littré, 75006 Paris |
| Phone | 07 53 19 40 03 |
| Email | zafatechparis@gmail.com |
| Sign services | Réparation · Accessoires · Photocopie · Impression |
| Window services | Email · Scan · Carte SIM · Réparations informatiques · Réparations mobiles |
| Other | "Ria — disponible ici" (money-transfer point), accessories wall (headphones, cases, cables) |

Not visible, therefore **placeholders**: business hours, warranty period, prices, social links, founding year.

### 2.3 Colour sampling (pixel-sampled, then normalised for screen use)
| Source in photo | Sampled | Normalised token |
|---|---|---|
| Shop-front paint | `#02244B` / `#002F68` | **Navy `#0A1F44`** |
| Fleur-de-lis | `#03419C` | **Royal blue `#1D4ED8`** (brightened for UI contrast) |
| Wordmark + sign bullets | crimson/magenta | **Crimson `#D6204E`** |
| Sign panel | white/cool blue | **Paper `#F5F7FC`** |

### 2.4 Branding specification
```text
Brand:       Zafa Tech  — "All solutions on demand"
Primary:     #1D4ED8   royal blue (fleur-de-lis)       → buttons, links, icons
Primary-600: #1A3FB3   hover / pressed
Secondary:   #0A1F44   navy (shop front)               → dark sections, headings, footer
Navy-950:    #06142E   deepest background (lab section)
Accent:      #D6204E   crimson (wordmark)              → badges, highlights, sparing CTAs
Accent-soft: #FFE4EA
Signal:      #22D3EE   cyan — only inside "diagnostic UI" / circuit graphics on dark
Background:  #F5F7FC   paper
Surface:     #FFFFFF
Border:      #E3E8F2
Text:        #0B1733
Muted:       #52607A   (≥ 4.5:1 on #FFFFFF and #F5F7FC)
```
Visual direction: **light, clean base with deep-navy feature sections** (mirrors the white sign on a
navy shop front). Gradients only blue→navy, crimson used as a spark, never a large fill.

## 3. Reference website analysis (clinique-mobile-informatique.fr)

Used strictly to understand the business model. No text, layout or graphics are reused.

### 3.1 Business model
Independent, multi-brand electronics repair workshop network (3 shops + home service in Seine-et-Marne),
selling refurbished devices and accessories on the side. Explicitly independent from manufacturers.

### 3.2 Target customers
Local individuals with broken phones/computers who want fast, affordable, walk-in repair; secondarily
customers wanting cheaper refurbished devices.

### 3.3 Device categories & repairs
- **Smartphones / smartwatches:** screen, back glass, camera, water damage, battery, charging, audio, micro-soldering
- **Tablets:** screen, connector, battery
- **Computers (PC/Mac, laptop/desktop):** screen, battery, chassis, charging connector, power button; upgrades (RAM, HDD, SSD)
- **Consoles:** disc reading, overheating, controllers, HDMI/USB/charging ports
- **Advanced:** micro-soldering / board-level work presented as a speciality

### 3.4 Workflows
- **Booking:** location/home → device & model → fault → address → date/time → contact → confirmation reference by email.
- **Contact:** per-shop phone, one email, walk-in without appointment.
- **Quote:** "demande de devis" CTA; free diagnosis when no deep diagnostic is required.

### 3.5 Policies & trust signals (reference's own — NOT transferred to Zafa Tech)
6–12-month parts warranty, free basic diagnosis, express repair, Google rating, repair-quality label,
years of experience, customer counts. **None of these are claimed for Zafa Tech**; equivalent slots
use placeholders (e.g. `[Warranty period]`).

### 3.6 Useful content concepts extracted
Hero with speed + trust message · device-first navigation · fault-level repair lists · "why us" benefits ·
step-based process · quote/booking CTA · shop location & hours · FAQ · legal footer (independence notice,
privacy, terms).

### 3.7 UX patterns worth adapting
- Device → fault drill-down (reimagined as an interactive in-page selector feeding the booking form).
- Walk-in + appointment dual path.
- Persistent booking CTA.

### 3.8 What Zafa Tech has that the reference doesn't
The storefront shows a **neighbourhood tech-services hub**: repairs *plus* printing, photocopies, scanning,
email help, SIM cards, accessories and a Ria transfer point. The site gives these their own section — it is
genuinely differentiating and matches the tagline "All solutions on demand".

## 4. Typography recommendation
- **Display:** *Bricolage Grotesque* (600–800) — characterful grotesque, feels crafted/workshop rather than corporate.
- **Body/UI:** *Manrope* (400–700) — highly legible, geometric-humanist.
- **Technical labels:** *JetBrains Mono* (500) — used only for diagnostic readouts, step numbers, part codes.
- Fluid scale via `clamp()`; H1 ≈ 40→76px, H2 ≈ 30→48px, body 16–18px.

## 5. UX strategy
1. **Device-first:** most visitors know *what* is broken, not *which service*. The "What needs fixing?"
   selector is the centrepiece and pre-fills the booking form.
2. **Two clear paths everywhere:** *Book a repair* (form) and *Call / walk in* (tel link + address).
3. **Honesty over hype:** no invented numbers; trust is built through process transparency, a real
   address and a real photo of the shop.
4. **Local identity:** Paris 6e, fleur-de-lis, shop photo — a real neighbourhood shop, not a faceless brand.

## 6. Page structure
Header → Hero → Services grid → Device selector → Board-level lab (dark) → Why Zafa Tech →
How it works → In-store services → Refurbished → Booking form → FAQ → Contact/visit → Footer.

## 7. Interaction strategy
Mobile nav (hamburger ↔ close morph, slide-down panel, Esc/outside-click/focus return) · sticky header with
blur after scroll · device selector tabs (ARIA tablist, arrow keys) with animated option chips · FAQ accordion
(single-open, ARIA) · IntersectionObserver-driven Animate.css reveals · validated booking form with toasts ·
back-to-top · scroll-spy active nav link · smooth anchor scrolling with header offset.

## 8. Responsive strategy
Mobile-first Tailwind. Breakpoints: `sm 640`, `md 768`, `lg 1024`, `xl 1280`, `2xl 1440` container cap.
Hero stacks (visual below copy) under `lg`; service grid 1→2→3→4 columns; timeline vertical under `lg`;
device tabs scroll-snap horizontally on narrow screens; min 44px touch targets; `overflow-x: clip` on body
as a safety net, with decorative elements contained inside `overflow-hidden` sections.
