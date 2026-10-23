# Zafa Tech — WordPress deliverables

## Package
- `theme/zafatech` — installable theme (ZIP: `dist/zafatech-theme.zip`)
- `plugin/zafatech-core` — companion plugin (ZIP: `dist/zafatech-plugin.zip`)
- `demo-content/` — bundled demo media and importer data
- `dist/` — ready-to-upload ZIP files

## Installation
1. Install WordPress and activate a clean theme.
2. Upload `dist/zafatech-plugin.zip` under Plugins → Add New → Upload. Activate "Zafa Tech Core".
3. Upload `dist/zafatech-theme.zip` under Appearance → Themes → Add New → Upload. Activate "Zafa Tech".
4. For bilingual support, install and activate Polylang (recommended) or WPML. Create English and French languages if required.
5. In WordPress admin, go to Tools → Zafa Tech Demo and click "Import Demo Content". Running it again is safe; existing items are skipped.
6. Assign menus if not already assigned by the importer: Appearance → Menus → Manage Locations.
7. Set permalinks to "Post name" for clean URLs.

## Theme customization (Appearance → Customize)
- **Site Identity → Logo**: header logo (light background). Defaults to the bundled navy Zafa Tech logo.
- **Site Identity → Footer logo (dark background)**: logo on the navy footer. Defaults to the bundled white logo.
- **Site Identity → Site Title**: used as the logo alt text and in the footer copyright.
- **Site Identity → Site Icon**: favicon. Defaults to the bundled device-mark icon.
- **Zafa Tech: Contact & Social**: phone, email, address, opening hours (FR/EN) and Instagram/Facebook/TikTok URLs, shown in the header, mobile menu and footer. Empty hours and social links keep the `[ ]` placeholders.
- **Menus**: Primary, Footer and Mobile locations. Without Polylang/WPML each location has an English and a French slot (e.g. "Primary Menu (French)"); with them, assign one menu per language. With no menu assigned, the built-in on-page links are shown. Only top-level items are displayed.
- **Homepage Settings**: the page chosen in "Your homepage displays → A static page" is shown; `?lang=en` / `?lang=fr` swaps to its linked translation.
- Homepage body content is edited in Pages → Accueil / Home. Its phone, email, address and map links are filled from **Zafa Tech: Contact & Social** when the demo is imported or refreshed (Tools → Zafa Tech Demo → Refresh Homepage Demo Layout); after that they are ordinary page content.

## Multilingual approach
- Theme UI labels use WordPress i18n (`__()` / `zt_t()`) and support English/French.
- Companion plugin stores French equivalents in post meta (`_zt_title_fr`, `_zt_excerpt_fr`, `_zt_content_fr`) for custom post types.
- Pages are created in pairs (English + French under `/fr/` parent) by the demo importer, with `_zt_translation_id` linking them.
- Language switcher uses Polylang APIs when available; otherwise it falls back to `?lang=` query parameters and displays both options.

## Demo content
- Importer creates pages, menus, custom post types (services, FAQs, testimonials, locations), media attachments, and front-page setting.
- Bundled images are stored locally. No remote image dependencies.
- Placeholders are marked with `[ ]` brackets (business hours, warranty terms, privacy policy text, social links).

## Configuration
- Replace placeholders listed in `README.original.md`.
- Booking requests are demo-only: no e-mail is sent and no personal data is stored until a backend is configured.
- Integration point: `submitRepairRequest()` in `theme/zafatech/assets/js/app.js`.

## Validation performed
- PHP lint (`php -l`) on all PHP files: no syntax errors.
- JavaScript syntax check (`node --check`) on `assets/js/app.js`: passed.
- Zip packages created and inspected.

## Limitations
- No live WordPress instance was available in this environment, so end-to-end import/render testing could not be performed.
- Taxes, legal text, pricing, reviews and business hours are placeholders and must be replaced with real data.
