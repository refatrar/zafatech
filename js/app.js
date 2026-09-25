/**
 * Zafa Tech — site interactions (vanilla JS, no dependencies).
 *
 * Data at the top (REPAIRS, REFURB_ITEMS) is intentionally plain so it can be
 * replaced by an API response later. The only network touchpoint is
 * `submitRepairRequest()` — wire your backend there.
 */
(() => {
  'use strict';

  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ------------------------------------------------------------------ */
  /* Data                                                                */
  /* ------------------------------------------------------------------ */

  /** Device → common repair categories. `tag` marks board-level work. */
  const REPAIRS = {
    smartphone: {
      label: 'Smartphone', icon: 'i-phone',
      intro: 'From cracked glass to phones that won’t switch on.',
      faults: [
        { label: 'Cracked or unresponsive screen' },
        { label: 'Battery drains fast or swells' },
        { label: 'Won’t charge / loose port' },
        { label: 'Camera or lens damage' },
        { label: 'Broken back glass' },
        { label: 'Water or liquid damage', tag: 'Board' },
        { label: 'No sound or microphone issue' },
        { label: 'Buttons not working' },
        { label: 'Won’t power on', tag: 'Board' },
        { label: 'Software or data problem' },
      ],
    },
    laptop: {
      label: 'Laptop', icon: 'i-laptop',
      intro: 'Windows laptops and MacBooks — hardware and software.',
      faults: [
        { label: 'Broken or flickering screen' },
        { label: 'Keyboard or trackpad fault' },
        { label: 'Battery not holding charge' },
        { label: 'Won’t charge / DC jack' },
        { label: 'Slow — SSD or RAM upgrade' },
        { label: 'Overheating or noisy fan' },
        { label: 'Broken hinge or casing' },
        { label: 'Liquid spill', tag: 'Board' },
        { label: 'Won’t power on (motherboard)', tag: 'Board' },
        { label: 'Virus or OS reinstall' },
      ],
    },
    tablet: {
      label: 'Tablet', icon: 'i-tablet',
      intro: 'Glass, batteries and connectors on popular tablets.',
      faults: [
        { label: 'Cracked screen or digitizer' },
        { label: 'Battery replacement' },
        { label: 'Charging connector' },
        { label: 'Buttons not working' },
        { label: 'Liquid damage', tag: 'Board' },
        { label: 'Software problem' },
      ],
    },
    desktop: {
      label: 'Desktop PC', icon: 'i-desktop',
      intro: 'Towers, all-in-ones and custom builds.',
      faults: [
        { label: 'Won’t boot or start' },
        { label: 'Slow — upgrade needed' },
        { label: 'Power supply fault' },
        { label: 'Component install or swap' },
        { label: 'Virus or OS reinstall' },
        { label: 'Recover files from a drive' },
      ],
    },
    console: {
      label: 'Console', icon: 'i-gamepad',
      intro: 'Home and handheld consoles, plus controllers.',
      faults: [
        { label: 'Disc not reading' },
        { label: 'Overheating or shutting down' },
        { label: 'HDMI port damaged', tag: 'Board' },
        { label: 'Controller drift or buttons' },
        { label: 'USB or charging port' },
        { label: 'Won’t power on', tag: 'Board' },
      ],
    },
    smartwatch: {
      label: 'Smartwatch', icon: 'i-watch',
      intro: 'Screens and batteries on popular smartwatches.',
      faults: [
        { label: 'Cracked screen or glass' },
        { label: 'Battery replacement' },
        { label: 'Won’t charge' },
        { label: 'Buttons or crown' },
        { label: 'Water damage' },
      ],
    },
    other: {
      label: 'Other', icon: 'i-diagnose',
      intro: 'Not on the list? Tell us what’s going on.',
      faults: [
        { label: 'Data recovery' },
        { label: 'Diagnosis only' },
        { label: 'Setup or software help' },
        { label: 'Something else' },
      ],
    },
  };

  /**
   * DEMO DATA — placeholder listings, not real inventory or prices.
   * Replace with a fetch from your backend, keeping the same shape.
   */
  const REFURB_ITEMS = [
    { id: 'demo-1', category: 'phone', icon: 'i-phone', title: 'Refurbished smartphone', spec: '[Model] · [Storage] · [Colour]', grade: '[Grade]' },
    { id: 'demo-2', category: 'phone', icon: 'i-phone', title: 'Refurbished smartphone', spec: '[Model] · [Storage] · [Colour]', grade: '[Grade]' },
    { id: 'demo-3', category: 'laptop', icon: 'i-laptop', title: 'Refurbished laptop', spec: '[Model] · [RAM] · [SSD]', grade: '[Grade]' },
    { id: 'demo-4', category: 'laptop', icon: 'i-laptop', title: 'Refurbished laptop', spec: '[Model] · [RAM] · [SSD]', grade: '[Grade]' },
    { id: 'demo-5', category: 'tablet', icon: 'i-tablet', title: 'Refurbished tablet', spec: '[Model] · [Storage] · [Wi-Fi / Cellular]', grade: '[Grade]' },
    { id: 'demo-6', category: 'other', icon: 'i-watch', title: 'Other devices', spec: 'Smartwatches, consoles & more — ask us', grade: '[Grade]' },
  ];

  const icon = (id, cls = '') => `<svg class="icon ${cls}" aria-hidden="true"><use href="#${id}"/></svg>`;
  const escapeHTML = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

  /* ------------------------------------------------------------------ */
  /* Toasts                                                              */
  /* ------------------------------------------------------------------ */
  const TOAST_ICONS = { success: ['i-check', 'text-emerald-600 bg-emerald-50'], error: ['i-alert', 'text-crimson-600 bg-crimson-50'], info: ['i-alert', 'text-brand-600 bg-brand-50'] };

  function toast(message, { type = 'info', title = '', timeout = 5000 } = {}) {
    const region = $('#toast-region');
    if (!region) return;
    // A new error replaces the previous one; a success clears outdated errors
    if (type === 'error' || type === 'success') $$('.toast-error', region).forEach((t) => t.remove());
    const [ic, tone] = TOAST_ICONS[type] || TOAST_ICONS.info;
    const el = document.createElement('div');
    el.className = `toast toast-${type}`;
    el.setAttribute('role', type === 'error' ? 'alert' : 'status');
    el.innerHTML = `
      <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full ${tone}">${icon(ic, 'h-5 w-5')}</span>
      <div class="min-w-0 flex-1 pt-0.5">
        ${title ? `<p class="font-semibold text-navy-900">${escapeHTML(title)}</p>` : ''}
        <p class="text-sm text-muted">${escapeHTML(message)}</p>
      </div>
      <button type="button" class="-m-1 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-muted hover:bg-paper" aria-label="Dismiss notification">${icon('i-x', 'h-4 w-4')}</button>`;
    const remove = () => {
      if (!el.isConnected) return;
      el.classList.add('is-leaving');
      setTimeout(() => el.remove(), reducedMotion ? 0 : 300);
    };
    el.querySelector('button').addEventListener('click', remove);
    region.appendChild(el);
    // Keep the stack short so toasts never bury the page
    const live = $$('.toast:not(.is-leaving)', region);
    if (live.length > 3) live[0].remove();
    if (timeout) setTimeout(remove, timeout);
  }

  /* ------------------------------------------------------------------ */
  /* Header + back-to-top (IntersectionObserver instead of scroll events) */
  /* ------------------------------------------------------------------ */
  function initHeader() {
    const header = $('#site-header');
    const sentinel = $('#top-sentinel');
    const backToTop = $('#back-to-top');
    if (!header || !sentinel || !('IntersectionObserver' in window)) return;

    new IntersectionObserver(([entry]) => {
      header.classList.toggle('is-scrolled', !entry.isIntersecting);
    }).observe(sentinel);

    if (backToTop) {
      const deep = document.createElement('div');
      deep.setAttribute('aria-hidden', 'true');
      deep.style.cssText = 'position:absolute;top:700px;left:0;width:1px;height:1px;pointer-events:none';
      document.body.appendChild(deep);
      new IntersectionObserver(([entry]) => {
        // Only visible once the marker has scrolled *above* the viewport
        const visible = !entry.isIntersecting && entry.boundingClientRect.top < 0;
        backToTop.classList.toggle('is-visible', visible);
        backToTop.tabIndex = visible ? 0 : -1;
      }).observe(deep);
      backToTop.tabIndex = -1;
    }
  }

  /* ------------------------------------------------------------------ */
  /* Mobile navigation                                                   */
  /* ------------------------------------------------------------------ */
  function initMobileNav() {
    const toggle = $('#nav-toggle');
    const panel = $('#mobile-nav');
    if (!toggle || !panel) return;

    const isOpen = () => toggle.getAttribute('aria-expanded') === 'true';

    const setOpen = (open, { returnFocus = true } = {}) => {
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      panel.classList.toggle('is-open', open);
      document.body.classList.toggle('nav-open', open);
      $('#site-header').classList.toggle('is-scrolled', open || window.scrollY > 10);
      if (open) {
        const first = panel.querySelector('a');
        setTimeout(() => first && first.focus({ preventScroll: true }), 150);
      } else if (returnFocus) {
        toggle.focus({ preventScroll: true });
      }
    };

    toggle.addEventListener('click', () => setOpen(!isOpen()));

    panel.addEventListener('click', (e) => {
      if (e.target.closest('a')) setOpen(false, { returnFocus: false });
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && isOpen()) setOpen(false);
      // Keep keyboard focus inside the open menu
      if (e.key === 'Tab' && isOpen()) {
        const focusables = [toggle, ...$$('a, button', panel)];
        const first = focusables[0];
        const last = focusables[focusables.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });

    // Click outside (on the header area, outside panel and toggle) closes the menu
    document.addEventListener('click', (e) => {
      if (isOpen() && !panel.contains(e.target) && !toggle.contains(e.target)) setOpen(false, { returnFocus: false });
    });

    // Close if the viewport grows past the mobile breakpoint
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (mq) => {
      if (mq.matches && isOpen()) setOpen(false, { returnFocus: false });
    });
  }

  /* ------------------------------------------------------------------ */
  /* Scroll-spy for nav links                                            */
  /* ------------------------------------------------------------------ */
  function initScrollSpy() {
    if (!('IntersectionObserver' in window)) return;
    const links = $$('.nav-link, .m-link');
    const ids = [...new Set(links.map((a) => a.getAttribute('href').slice(1)))];
    const sections = ids.map((id) => document.getElementById(id)).filter(Boolean);

    const setActive = (id) => {
      links.forEach((a) => {
        if (a.getAttribute('href') === `#${id}`) a.setAttribute('aria-current', 'true');
        else a.removeAttribute('aria-current');
      });
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => { if (entry.isIntersecting) setActive(entry.target.id); });
    }, { rootMargin: '-45% 0px -50% 0px' });

    sections.forEach((s) => observer.observe(s));
  }

  /* ------------------------------------------------------------------ */
  /* Smooth scroll: CSS handles motion; JS moves focus for keyboard users */
  /* ------------------------------------------------------------------ */
  function initSmoothScroll() {
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a[href^="#"]');
      if (!link || link.hasAttribute('data-placeholder-link')) return;
      const id = link.getAttribute('href').slice(1);
      if (!id) return;
      const target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
      history.replaceState(null, '', id === 'top' ? location.pathname + location.search : `#${id}`);
      if (!target.hasAttribute('tabindex')) target.setAttribute('tabindex', '-1');
      target.focus({ preventScroll: true });
    });
  }

  /* ------------------------------------------------------------------ */
  /* Scroll reveal using Animate.css                                     */
  /* ------------------------------------------------------------------ */
  function initReveal() {
    const items = $$('[data-reveal]');
    if (reducedMotion || !('IntersectionObserver' in window)) return;

    items.forEach((el) => el.classList.add('reveal-pending'));

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const name = el.dataset.reveal || 'fadeInUp';
        const delay = parseInt(el.dataset.delay || '0', 10);
        if (delay) el.style.animationDelay = `${delay}ms`;
        el.classList.remove('reveal-pending');
        el.classList.add('animate__animated', `animate__${name}`);
        el.addEventListener('animationend', () => {
          el.classList.remove('animate__animated', `animate__${name}`);
          el.style.animationDelay = '';
        }, { once: true });
        obs.unobserve(el);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

    items.forEach((el) => observer.observe(el));

    // Process timeline fill
    const fill = $('#timeline-fill');
    if (fill) {
      new IntersectionObserver(([entry], obs) => {
        if (entry.isIntersecting) { fill.classList.add('is-filled'); obs.disconnect(); }
      }, { threshold: 0.4 }).observe(fill.parentElement);
    }
  }

  /* ------------------------------------------------------------------ */
  /* Hero diagnostic ticker                                              */
  /* ------------------------------------------------------------------ */
  function initHeroTicker() {
    const el = $('#hero-ticker');
    if (!el || reducedMotion) return;
    const lines = ['Testing charge circuit…', 'Checking battery wear…', 'Inspecting port pins…', 'Measuring board power…', 'Preparing your quote…'];
    let i = 0;
    setInterval(() => {
      if (document.hidden) return;
      el.style.opacity = '0';
      setTimeout(() => {
        i = (i + 1) % lines.length;
        el.textContent = lines[i];
        el.style.opacity = '1';
      }, 300);
    }, 2600);
  }

  /* ------------------------------------------------------------------ */
  /* Device selector                                                     */
  /* ------------------------------------------------------------------ */
  const selection = { device: 'smartphone', faults: new Set() };

  function initDeviceSelector() {
    const tabsEl = $('#device-tabs');
    const panel = $('#device-panel');
    const list = $('#fault-list');
    const title = $('#device-panel-title');
    const intro = $('#device-panel-intro');
    const summary = $('#fault-summary');
    const btnContinue = $('#fault-continue');
    const btnClear = $('#fault-clear');
    if (!tabsEl || !panel || !list) return;

    const keys = Object.keys(REPAIRS);

    tabsEl.innerHTML = keys.map((key, i) => `
      <button type="button" role="tab" class="device-tab lg:w-full" id="tab-${key}" data-device="${key}"
        aria-selected="${i === 0}" aria-controls="device-panel" tabindex="${i === 0 ? 0 : -1}">
        ${icon(REPAIRS[key].icon)}<span>${REPAIRS[key].label}</span>
      </button>`).join('');

    const tabs = $$('[role="tab"]', tabsEl);

    // Horizontal tabs on small screens, vertical on desktop
    const mqDesktop = window.matchMedia('(min-width: 1024px)');
    const syncOrientation = () => tabsEl.setAttribute('aria-orientation', mqDesktop.matches ? 'vertical' : 'horizontal');
    syncOrientation();
    mqDesktop.addEventListener('change', syncOrientation);

    const updateSummary = () => {
      const n = selection.faults.size;
      summary.textContent = n === 0
        ? 'No symptoms selected yet.'
        : `${REPAIRS[selection.device].label} · ${n} symptom${n > 1 ? 's' : ''} selected`;
      btnContinue.setAttribute('aria-disabled', String(n === 0));
    };

    const renderFaults = () => {
      const data = REPAIRS[selection.device];
      title.textContent = data.label;
      intro.textContent = data.intro;
      panel.setAttribute('aria-labelledby', `tab-${selection.device}`);
      list.innerHTML = data.faults.map((f, i) => `
        <button type="button" class="fault-chip ${reducedMotion ? '' : 'animate__animated animate__fadeInUp'}"
          style="animation-delay:${i * 35}ms;--animate-duration:.45s" aria-pressed="${selection.faults.has(f.label)}" data-fault="${escapeHTML(f.label)}">
          <span class="chk">${icon('i-check', 'h-4 w-4')}</span>
          <span>${escapeHTML(f.label)}</span>
          ${f.tag ? `<span class="fault-tag">${f.tag}</span>` : ''}
        </button>`).join('');
      updateSummary();
    };

    const selectTab = (tab, focus = false) => {
      const key = tab.dataset.device;
      tabs.forEach((t) => {
        const active = t === tab;
        t.setAttribute('aria-selected', String(active));
        t.tabIndex = active ? 0 : -1;
      });
      if (key !== selection.device) {
        selection.device = key;
        selection.faults.clear();
        renderFaults();
      }
      if (focus) tab.focus();
      tab.scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: reducedMotion ? 'auto' : 'smooth' });
    };

    tabsEl.addEventListener('click', (e) => {
      const tab = e.target.closest('[role="tab"]');
      if (tab) selectTab(tab);
    });

    tabsEl.addEventListener('keydown', (e) => {
      const idx = tabs.indexOf(document.activeElement);
      if (idx < 0) return;
      const map = { ArrowRight: 1, ArrowDown: 1, ArrowLeft: -1, ArrowUp: -1 };
      let next = null;
      if (e.key in map) next = tabs[(idx + map[e.key] + tabs.length) % tabs.length];
      else if (e.key === 'Home') next = tabs[0];
      else if (e.key === 'End') next = tabs[tabs.length - 1];
      if (next) { e.preventDefault(); selectTab(next, true); }
    });

    list.addEventListener('click', (e) => {
      const chip = e.target.closest('.fault-chip');
      if (!chip) return;
      const label = chip.dataset.fault;
      const on = !selection.faults.has(label);
      on ? selection.faults.add(label) : selection.faults.delete(label);
      chip.setAttribute('aria-pressed', String(on));
      updateSummary();
    });

    btnClear.addEventListener('click', () => {
      selection.faults.clear();
      $$('.fault-chip', list).forEach((c) => c.setAttribute('aria-pressed', 'false'));
      updateSummary();
    });

    btnContinue.addEventListener('click', () => {
      if (selection.faults.size === 0) {
        toast('Tick at least one symptom, or skip straight to the form below.', { type: 'info', title: 'Nothing selected yet' });
        return;
      }
      prefillBooking(selection.device, [...selection.faults]);
    });

    renderFaults();
  }

  /** Pre-fills the booking form and scrolls to it. Used by selector + service cards. */
  function prefillBooking(device, faults = []) {
    const form = $('#booking-form');
    if (!form) return;
    const select = form.elements.device;
    if (device && select.querySelector(`option[value="${device}"]`)) select.value = device;
    if (faults.length) {
      const problem = form.elements.problem;
      const text = `Symptoms: ${faults.join(', ')}.`;
      problem.value = problem.value.trim() ? `${problem.value.trim()}\n${text}` : `${text}\n`;
      problem.dispatchEvent(new Event('input'));
    }
    [select, form.elements.problem].forEach((f) => clearFieldError(f));
    const section = $('#booking');
    section.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
    setTimeout(() => form.elements.name.focus({ preventScroll: true }), reducedMotion ? 0 : 700);
    if (faults.length) toast('Your device and symptoms have been added to the form.', { type: 'success', title: 'Details carried over' });
  }

  function initServicePrefill() {
    document.addEventListener('click', (e) => {
      const link = e.target.closest('[data-prefill-device]');
      if (!link) return;
      e.preventDefault();
      e.stopPropagation();
      prefillBooking(link.dataset.prefillDevice);
    }, true);
  }

  /* ------------------------------------------------------------------ */
  /* Refurbished (demo data)                                             */
  /* ------------------------------------------------------------------ */
  function initRefurbished() {
    const grid = $('#refurb-grid');
    const filters = $('#refurb-filters');
    if (!grid || !filters) return;

    const render = (filter = 'all') => {
      const items = REFURB_ITEMS.filter((it) => filter === 'all' || it.category === filter);
      grid.innerHTML = items.map((it, i) => `
        <li class="${reducedMotion ? '' : 'animate__animated animate__fadeIn'}" style="animation-delay:${i * 50}ms">
          <article class="card group flex h-full flex-col overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-lift">
            <div class="relative flex aspect-[16/10] items-center justify-center overflow-hidden bg-gradient-to-br from-brand-50 via-white to-paper">
              <div class="grid-bg absolute inset-0 opacity-70" aria-hidden="true"></div>
              <span class="relative inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-white text-brand-600 shadow-soft transition duration-500 group-hover:scale-110 group-hover:-rotate-3">${icon(it.icon, 'h-10 w-10')}</span>
              <span class="absolute left-4 top-4 rounded-full bg-navy-900 px-2.5 py-1 font-mono text-[0.68rem] font-medium uppercase tracking-wider text-white">Demo listing</span>
              <span class="absolute right-4 top-4 rounded-full bg-white px-2.5 py-1 font-mono text-[0.7rem] text-muted shadow-sm">${escapeHTML(it.grade)}</span>
            </div>
            <div class="flex flex-1 flex-col p-6">
              <h3 class="text-lg font-bold">${escapeHTML(it.title)}</h3>
              <p class="mt-1 font-mono text-xs text-muted">${escapeHTML(it.spec)}</p>
              <div class="mt-auto flex items-center justify-between gap-3 pt-6">
                <span class="text-sm font-semibold text-navy-900">Price on request</span>
                <a href="#booking" class="inline-flex min-h-[44px] items-center gap-1.5 text-sm font-semibold text-brand-700 hover:underline" data-refurb="${escapeHTML(it.title)}">Ask availability${icon('i-arrow-right', 'h-4 w-4')}</a>
              </div>
            </div>
          </article>
        </li>`).join('');
    };

    filters.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-filter]');
      if (!btn) return;
      $$('[data-filter]', filters).forEach((b) => b.setAttribute('aria-pressed', String(b === btn)));
      render(btn.dataset.filter);
    });

    grid.addEventListener('click', (e) => {
      const link = e.target.closest('[data-refurb]');
      if (!link) return;
      e.preventDefault();
      e.stopPropagation();
      const form = $('#booking-form');
      form.elements.device.value = 'refurbished';
      const problem = form.elements.problem;
      if (!problem.value.trim()) {
        problem.value = `I'm interested in a ${link.dataset.refurb.toLowerCase()}. Budget / preferences: `;
        problem.dispatchEvent(new Event('input'));
      }
      prefillBooking('refurbished');
    });

    render();
  }

  /* ------------------------------------------------------------------ */
  /* FAQ accordion (single-open, keyboard accessible)                    */
  /* ------------------------------------------------------------------ */
  function initFAQ() {
    const root = $('#faq-list');
    if (!root) return;
    const triggers = $$('.faq-trigger', root);

    const setItem = (trigger, open) => {
      trigger.setAttribute('aria-expanded', String(open));
      trigger.closest('.faq-item').classList.toggle('is-open', open);
      const panel = document.getElementById(trigger.getAttribute('aria-controls'));
      // `inert` keeps links inside collapsed answers out of the tab order
      if (panel) panel.inert = !open;
    };

    triggers.forEach((t) => setItem(t, false));

    root.addEventListener('click', (e) => {
      const trigger = e.target.closest('.faq-trigger');
      if (!trigger) return;
      const willOpen = trigger.getAttribute('aria-expanded') !== 'true';
      triggers.forEach((t) => setItem(t, t === trigger ? willOpen : false));
    });

    root.addEventListener('keydown', (e) => {
      const idx = triggers.indexOf(document.activeElement);
      if (idx < 0) return;
      let next = null;
      if (e.key === 'ArrowDown') next = triggers[(idx + 1) % triggers.length];
      else if (e.key === 'ArrowUp') next = triggers[(idx - 1 + triggers.length) % triggers.length];
      else if (e.key === 'Home') next = triggers[0];
      else if (e.key === 'End') next = triggers[triggers.length - 1];
      if (next) { e.preventDefault(); next.focus(); }
    });
  }

  /* ------------------------------------------------------------------ */
  /* Booking form                                                        */
  /* ------------------------------------------------------------------ */
  const RULES = {
    name: (v) => (v.trim().length >= 2 ? '' : 'Please enter your name.'),
    phone: (v) => {
      const digits = v.replace(/[\s.\-()]/g, '');
      if (!digits) return 'Please enter a phone number.';
      return /^\+?\d{9,15}$/.test(digits) ? '' : 'Please enter a valid phone number, e.g. 06 12 34 56 78.';
    },
    email: (v) => {
      if (!v.trim()) return 'Please enter your email address.';
      return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim()) ? '' : 'Please enter a valid email address.';
    },
    device: (v) => (v ? '' : 'Please choose a device type.'),
    model: (v) => (v.trim().length >= 2 ? '' : 'Please tell us the model (or “not sure”).'),
    problem: (v) => (v.trim().length >= 10 ? '' : 'Please describe the problem in a few words (10+ characters).'),
    contact: (v) => (v ? '' : 'Please choose how we should contact you.'),
    consent: (_, el) => (el.checked ? '' : 'Please agree so we can contact you about your request.'),
  };

  function fieldErrorEl(name) { return document.getElementById(`e-${name}`); }

  function setFieldError(field, message) {
    const name = field.name;
    const err = fieldErrorEl(name);
    const targets = field instanceof RadioNodeList ? [...field] : [field];
    targets.forEach((el) => el.setAttribute('aria-invalid', message ? 'true' : 'false'));
    if (err) {
      err.innerHTML = message ? `${icon('i-alert', 'h-4 w-4')}<span>${escapeHTML(message)}</span>` : '';
      err.classList.toggle('is-visible', Boolean(message));
    }
  }

  function clearFieldError(field) { if (field) setFieldError(field, ''); }

  function validateField(form, name) {
    const field = form.elements[name];
    if (!field) return '';
    const value = field instanceof RadioNodeList ? field.value : field.value;
    const message = RULES[name](value, field);
    if (field instanceof RadioNodeList) {
      const err = fieldErrorEl(name);
      if (err) {
        err.innerHTML = message ? `${icon('i-alert', 'h-4 w-4')}<span>${escapeHTML(message)}</span>` : '';
        err.classList.toggle('is-visible', Boolean(message));
      }
    } else {
      setFieldError(field, message);
    }
    return message;
  }

  /**
   * Replace this stub with a real API call, e.g.
   *   return fetch('/api/repair-requests', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) })
   *     .then((r) => { if (!r.ok) throw new Error('Request failed'); return r.json(); });
   * No data leaves the browser in the current version.
   */
  function submitRepairRequest(payload) {
    return new Promise((resolve) => {
      setTimeout(() => resolve({ ok: true, received: payload }), 900);
    });
  }

  function initBookingForm() {
    const form = $('#booking-form');
    if (!form) return;
    const success = $('#booking-success');
    const submitBtn = $('#booking-submit');
    const label = submitBtn.querySelector('.btn-label');
    const counter = $('#problem-count');
    const names = Object.keys(RULES);
    const touched = new Set();

    form.elements.problem.addEventListener('input', (e) => {
      counter.textContent = `${e.target.value.length} / ${e.target.maxLength}`;
    });

    // Validate on blur; re-validate live once a field has been touched
    form.addEventListener('focusout', (e) => {
      const name = e.target.name;
      if (!RULES[name] || name === 'contact') return;
      if (e.target.value || touched.has(name)) { touched.add(name); validateField(form, name); }
    });
    form.addEventListener('input', (e) => {
      if (touched.has(e.target.name)) validateField(form, e.target.name);
    });
    form.addEventListener('change', (e) => {
      if (['device', 'consent', 'contact'].includes(e.target.name)) validateField(form, e.target.name);
    });

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (form.elements.company.value) return; // honeypot filled → silently ignore

      const errors = names.map((n) => [n, validateField(form, n)]).filter(([, m]) => m);
      names.forEach((n) => touched.add(n));

      if (errors.length) {
        const first = form.elements[errors[0][0]];
        const el = first instanceof RadioNodeList ? first[0] : first;
        el.focus();
        el.classList.remove('shake'); void el.offsetWidth; el.classList.add('shake');
        toast(`Please check ${errors.length === 1 ? 'the highlighted field' : `the ${errors.length} highlighted fields`}.`, { type: 'error', title: 'Almost there' });
        return;
      }

      const payload = {
        name: form.elements.name.value.trim(),
        phone: form.elements.phone.value.trim(),
        email: form.elements.email.value.trim(),
        device: form.elements.device.value,
        model: form.elements.model.value.trim(),
        problem: form.elements.problem.value.trim(),
        contactMethod: form.elements.contact.value,
        consent: form.elements.consent.checked,
        submittedAt: new Date().toISOString(),
      };

      submitBtn.disabled = true;
      label.textContent = 'Sending…';
      try {
        await submitRepairRequest(payload);
        const methods = { phone: 'by phone', sms: 'by SMS', email: 'by email' };
        $('#booking-success-text').textContent = `Thanks, ${payload.name.split(' ')[0]}. We'll contact you ${methods[payload.contactMethod]} to confirm the next steps.`;
        form.classList.add('hidden');
        success.classList.remove('hidden');
        success.focus();
        toast('We’ll be in touch shortly.', { type: 'success', title: 'Request sent' });
      } catch (err) {
        toast('Something went wrong. Please try again or call us on 07 53 19 40 03.', { type: 'error', title: 'Couldn’t send request' });
      } finally {
        submitBtn.disabled = false;
        label.textContent = 'Send repair request';
      }
    });

    $('#booking-reset').addEventListener('click', () => {
      form.reset();
      touched.clear();
      names.forEach((n) => {
        const f = form.elements[n];
        if (f instanceof RadioNodeList) validateField(form, n); else clearFieldError(f);
      });
      counter.textContent = `0 / ${form.elements.problem.maxLength}`;
      success.classList.add('hidden');
      form.classList.remove('hidden');
      form.elements.name.focus();
    });
  }

  /* ------------------------------------------------------------------ */
  /* Legal dialog + placeholder links                                    */
  /* ------------------------------------------------------------------ */
  function initLegal() {
    const dialog = $('#legal-dialog');
    if (!dialog || typeof dialog.showModal !== 'function') return;
    const copy = {
      privacy: ['Privacy Policy', 'How Zafa Tech collects, uses and stores the personal data you share with us (for example through the repair request form).'],
      terms: ['Terms of Service', 'The terms that apply when using this website and Zafa Tech services.'],
      service: ['Service Policy', 'Quotes, diagnosis, repair conditions, warranty, collection deadlines and liability.'],
    };
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-legal]');
      if (btn) {
        const [t, b] = copy[btn.dataset.legal] || copy.privacy;
        $('#legal-title').textContent = t;
        $('#legal-body').textContent = b;
        dialog.showModal();
        return;
      }
      if (e.target.closest('[data-close-dialog]') || e.target === dialog) dialog.close();

      const ph = e.target.closest('[data-placeholder-link]');
      if (ph) {
        e.preventDefault();
        toast(`Our ${ph.dataset.placeholderLink} page is coming soon.`, { type: 'info' });
      }
    });
  }

  /* ------------------------------------------------------------------ */
  document.addEventListener('DOMContentLoaded', () => {
    const year = $('#year');
    if (year) year.textContent = new Date().getFullYear();

    initHeader();
    initMobileNav();
    initScrollSpy();
    initServicePrefill();
    initSmoothScroll();
    initDeviceSelector();
    initRefurbished();
    initFAQ();
    initBookingForm();
    initLegal();
    initReveal();
    initHeroTicker();
  });
})();
