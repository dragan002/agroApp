<!DOCTYPE html>
<html lang="sr-Latn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgroApp Prnjavor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#3d5a3a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html, body { height: 100%; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; background: #faf6ef; color: #1f1a14; -webkit-tap-highlight-color: transparent; }
            :root {
                --font-serif: 'Fraunces', 'DM Serif Display', Georgia, 'Times New Roman', serif;
                --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
                --font-mono: 'JetBrains Mono', 'SF Mono', ui-monospace, monospace;
                --color-primary: #3d5a3a;
                --color-primary-dark: #2a3f27;
                --color-primary-light: #4a6a3a;
                --color-primary-subtle: #e8efe4;
                --color-accent: #c06643;
                --color-accent-soft: #f3e0d4;
                --color-accent-deep: #b8902a;
                --color-gold: #b8902a;
                --color-bg: #faf6ef;
                --color-surface: #ffffff;
                --color-surface-alt: #f2ece0;
                --color-card: #ffffff;
                --color-border: #e4ddd0;
                --color-divider: #ece5d6;
                --color-ink: #2a2218;
                --color-text-primary: #1f1a14;
                --color-text-secondary: #7a6f5f;
                --color-text-muted: #a89a85;
                --color-success: #4a7a3e;
                --color-danger: #b83232;
                --color-viber: #7360F2;
                --color-whatsapp: #25D366;
            }
            .screen { display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 64px; overflow-y: auto; -webkit-overflow-scrolling: touch; background: var(--color-bg); }
            .screen.active { display: block; }
            #app { position: relative; height: 100vh; overflow: hidden; max-width: 480px; margin: 0 auto; }
            .bottom-nav { position: absolute; bottom: 0; left: 0; right: 0; height: 64px; background: #fff; border-top: 1px solid #ece5d6; display: flex; align-items: center; padding-bottom: env(safe-area-inset-bottom, 0); z-index: 50; }
            .nav-btn { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2px; font-size: 10px; color: var(--color-text-muted); cursor: pointer; padding: 8px 4px; border: none; background: none; transition: color 0.15s; }
            .nav-btn.active { color: var(--color-primary); }
            .nav-btn svg { width: 22px; height: 22px; }
            .top-bar { position: sticky; top: 0; z-index: 10; background: #faf6ef; border-bottom: 1px solid var(--color-divider); display: flex; align-items: center; padding: 0 16px; height: 56px; gap: 12px; }
            .top-bar-title { font-size: 17px; font-weight: 600; color: var(--color-text-primary); flex: 1; }
            .top-bar-logo { font-size: 20px; font-weight: 500; font-family: var(--font-serif); color: var(--color-primary); flex: 1; letter-spacing: -0.3px; }
            .icon-btn { width: 40px; height: 40px; border-radius: 50%; border: none; background: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--color-text-secondary); }
            .icon-btn:active { background: var(--color-primary-subtle); }
            .btn-primary { background: var(--color-primary); color: #fff; border: none; border-radius: 12px; padding: 14px 24px; font-size: 15px; font-weight: 600; cursor: pointer; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.15s; }
            .btn-primary:active { background: var(--color-primary-light); }
            .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
            .btn-secondary { background: var(--color-primary-subtle); color: var(--color-primary); border: none; border-radius: 12px; padding: 14px 24px; font-size: 15px; font-weight: 600; cursor: pointer; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; }
            .btn-ghost { background: none; color: var(--color-primary); border: 1.5px solid var(--color-primary); border-radius: 12px; padding: 13px 24px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; }
            .btn-danger { background: none; color: var(--color-danger); border: none; font-size: 15px; font-weight: 500; cursor: pointer; padding: 8px; }
            .card { background: var(--color-card); border-radius: 16px; border: 1px solid var(--color-border); overflow: hidden; }
            .section-title { font-size: 17px; font-weight: 700; color: var(--color-text-primary); padding: 16px 16px 8px; }
            .chip { padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 500; border: 1.5px solid var(--color-border); background: #fff; color: var(--color-text-secondary); cursor: pointer; white-space: nowrap; transition: all 0.15s; }
            .chip.active { background: var(--color-primary); color: #fff; border-color: var(--color-primary); }
            .form-group { margin-bottom: 16px; }
            .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 6px; }
            .form-input { width: 100%; padding: 12px 14px; border: 1.5px solid var(--color-border); border-radius: 10px; font-size: 15px; color: var(--color-text-primary); background: #fff; outline: none; transition: border-color 0.15s; }
            .form-input:focus { border-color: var(--color-primary); }
            .form-input.error { border-color: var(--color-danger); }
            .form-error { font-size: 12px; color: var(--color-danger); margin-top: 4px; }
            .form-textarea { resize: vertical; min-height: 80px; }
            .farmer-card-h { display: flex; flex-direction: column; width: 160px; flex-shrink: 0; background: var(--color-card); border-radius: 14px; border: 1px solid var(--color-border); overflow: hidden; cursor: pointer; }
            .farmer-card-h img, .farmer-card-h .img-placeholder { width: 100%; height: 100px; object-fit: cover; background: var(--color-primary-subtle); display: flex; align-items: center; justify-content: center; font-size: 32px; }
            .product-card { display: flex; gap: 12px; background: var(--color-card); border-radius: 14px; border: 1px solid var(--color-border); padding: 12px; cursor: pointer; }
            .product-card-thumb { width: 80px; height: 80px; border-radius: 10px; object-fit: cover; flex-shrink: 0; background: var(--color-primary-subtle); display: flex; align-items: center; justify-content: center; font-size: 28px; }
            .fresh-badge { display: inline-flex; align-items: center; gap: 4px; background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 20px; }
            .contact-bar { position: sticky; bottom: 0; background: #fff; border-top: 1px solid var(--color-border); padding: 12px 16px; padding-bottom: calc(12px + env(safe-area-inset-bottom, 0)); display: flex; gap: 10px; }
            .btn-call { flex: 1; background: var(--color-primary); color: #fff; border: none; border-radius: 10px; padding: 12px 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; }
            .btn-viber { flex: 1; background: var(--color-viber); color: #fff; border: none; border-radius: 10px; padding: 12px 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; }
            .btn-whatsapp { flex: 1; background: var(--color-whatsapp); color: #fff; border: none; border-radius: 10px; padding: 12px 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; }
            .photo-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 4px; }
            .photo-slot { aspect-ratio: 1; border-radius: 8px; overflow: hidden; background: var(--color-primary-subtle); display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; }
            .photo-slot img { width: 100%; height: 100%; object-fit: cover; }
            .photo-slot .add-icon { font-size: 28px; color: var(--color-primary); }
            .toggle-switch { position: relative; width: 48px; height: 28px; flex-shrink: 0; }
            .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
            .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--color-border); border-radius: 28px; transition: 0.2s; }
            .toggle-slider:before { position: absolute; content: ""; height: 22px; width: 22px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: 0.2s; }
            input:checked + .toggle-slider { background: var(--color-primary); }
            input:checked + .toggle-slider:before { transform: translateX(20px); }
            .step-indicator { display: flex; align-items: center; justify-content: center; gap: 0; padding: 12px 24px; }
            .step-dot { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0; }
            .step-dot.done { background: var(--color-primary); color: #fff; }
            .step-dot.active { background: var(--color-primary); color: #fff; box-shadow: 0 0 0 4px var(--color-primary-subtle); }
            .step-dot.pending { background: var(--color-border); color: var(--color-text-muted); }
            .step-line { flex: 1; height: 2px; background: var(--color-border); max-width: 40px; }
            .step-line.done { background: var(--color-primary); }
            .gallery { position: relative; overflow: hidden; }
            .gallery-track { display: flex; transition: transform 0.3s ease; }
            .gallery-slide { min-width: 100%; aspect-ratio: 16/9; background: var(--color-primary-subtle); overflow: hidden; }
            .gallery-slide img { width: 100%; height: 100%; object-fit: cover; }
            .gallery-dots { display: flex; justify-content: center; gap: 6px; padding: 8px; }
            .gallery-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--color-border); transition: background 0.2s; }
            .gallery-dot.active { background: var(--color-primary); }
            .toast { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: #2a2218; color: #fff; padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 500; z-index: 9999; max-width: 320px; text-align: center; animation: fadeIn 0.2s; pointer-events: none; }
            .toast.error { background: var(--color-danger); }
            .spinner { width: 24px; height: 24px; border: 3px solid var(--color-primary-subtle); border-top-color: var(--color-primary); border-radius: 50%; animation: spin 0.8s linear infinite; }
            .spinner-overlay { position: fixed; inset: 0; background: rgba(255,255,255,0.7); display: flex; align-items: center; justify-content: center; z-index: 100; }
            .product-edit-photo-large { width: 160px; height: 160px; border-radius: 12px; background: var(--color-primary-subtle); display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; position: relative; flex-shrink: 0; }
            .product-edit-photo-small { width: 72px; height: 72px; border-radius: 10px; background: var(--color-primary-subtle); display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; position: relative; }
            .product-edit-photo-large img, .product-edit-photo-small img { width: 100%; height: 100%; object-fit: cover; }
            .product-edit-photo-large .add-icon, .product-edit-photo-small .add-icon { font-size: 28px; color: var(--color-primary); }
            .select-input { width: 100%; padding: 12px 14px; border: 1.5px solid var(--color-border); border-radius: 10px; font-size: 15px; color: var(--color-text-primary); background: #fff; outline: none; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%235A6B5A' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
            .select-input:focus { border-color: var(--color-primary); }
            .fresh-toggle-card { background: #FFFBEB; border: 1.5px solid #FDE68A; border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
            .my-product-row { display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: #fff; border-bottom: 1px solid var(--color-border); }
            .my-product-thumb { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; background: var(--color-primary-subtle); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
            .avatar-circle { border-radius: 50%; object-fit: cover; background: var(--color-primary-subtle); display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; color: var(--color-primary); }
            .empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 24px; gap: 12px; text-align: center; }
            .empty-state-icon { font-size: 56px; }
            .empty-state-text { font-size: 16px; font-weight: 600; color: var(--color-text-secondary); }
            .empty-state-sub { font-size: 14px; color: var(--color-text-muted); }
            @keyframes spin { to { transform: rotate(360deg); } }
            @keyframes fadeIn { from { opacity: 0; transform: translateX(-50%) translateY(-8px); } to { opacity: 1; transform: translateX(-50%) translateY(0); } }
            .hidden { display: none !important; }
            .farmer-profile-hero { position: relative; }
            .farmer-avatar-overlap { position: absolute; bottom: -32px; left: 16px; width: 64px; height: 64px; border: 3px solid #fff; border-radius: 50%; z-index: 2; }
        </style>
    @endif
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>
</head>
<body>
<div id="app">

    <!-- ============================================================ -->
    <!-- SCREEN: HOME                                                  -->
    <!-- ============================================================ -->
    <div id="screen-home" class="screen active">
        <!-- Top bar -->
        <div class="top-bar" style="background:#faf6ef;border-bottom:1px solid #ece5d6;">
            <div class="top-bar-logo">🌿 AgroApp</div>
            <button class="icon-btn" onclick="onLoginIconTap()" id="home-auth-btn" title="Prijava">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            </button>
        </div>

        <!-- Search bar (tappable, navigates to search) -->
        <div style="padding:12px 16px 0;">
            <div onclick="showSearchScreen()" style="display:flex;align-items:center;gap:10px;background:#fff;border:1.5px solid #e4ddd0;border-radius:14px;padding:12px 16px;cursor:pointer;box-shadow:0 1px 4px rgba(42,34,24,0.06);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#a89a85" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <span style="color:#a89a85;font-size:15px;font-family:var(--font-sans);">Pretraži farmere i proizvode...</span>
            </div>
        </div>

        <!-- Category chips -->
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;padding:12px 16px;display:flex;gap:8px;scrollbar-width:none;" id="home-category-chips">
            <button class="chip active" data-cat="" onclick="selectHomeCategory(this,'')">Sve</button>
            <button class="chip" data-cat="povrce" onclick="selectHomeCategory(this,'povrce')">Povrće</button>
            <button class="chip" data-cat="voce" onclick="selectHomeCategory(this,'voce')">Voće</button>
            <button class="chip" data-cat="mlijeko" onclick="selectHomeCategory(this,'mlijeko')">Mlijeko</button>
            <button class="chip" data-cat="meso" onclick="selectHomeCategory(this,'meso')">Meso</button>
            <button class="chip" data-cat="jaja" onclick="selectHomeCategory(this,'jaja')">Jaja</button>
            <button class="chip" data-cat="med" onclick="selectHomeCategory(this,'med')">Med</button>
            <button class="chip" data-cat="zitarice" onclick="selectHomeCategory(this,'zitarice')">Žitarice</button>
            <button class="chip" data-cat="rakija" onclick="selectHomeCategory(this,'rakija')">Rakija</button>
            <button class="chip" data-cat="zimnica" onclick="selectHomeCategory(this,'zimnica')">Zimnica</button>
            <button class="chip" data-cat="ostalo" onclick="selectHomeCategory(this,'ostalo')">Ostalo</button>
            <button id="home-fresh-chip" class="chip" style="background:#FEF3C7;border-color:#F59E0B;color:#92400E;flex-shrink:0;" onclick="toggleHomeFresh(this)">🌞 Svježe danas</button>
        </div>

        <!-- City filter chips -->
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;padding:0 16px 10px;display:flex;gap:8px;scrollbar-width:none;" id="home-city-chips">
            <button class="chip active" data-city="" onclick="selectHomeCity(this,'')">Svi gradovi</button>
        </div>

        <!-- Fresh today banner -->
        <div id="fresh-banner" onclick="showFreshFilter()" style="display:none;margin:0 16px 4px;background:#FEF3C7;border-radius:12px;padding:12px 16px;align-items:center;justify-content:space-between;cursor:pointer;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:20px;">🌞</span>
                <div>
                    <div style="font-size:14px;font-weight:600;color:#92400E;">Svježe danas</div>
                    <div id="fresh-count" style="font-size:12px;color:#B45309;">Učitavam...</div>
                </div>
            </div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#92400E" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>

        <!-- Farmers section -->
        <div class="section-title">Farmeri</div>
        <div id="home-farmers-list" style="overflow-x:auto;-webkit-overflow-scrolling:touch;padding:0 16px 16px;display:flex;gap:12px;scrollbar-width:none;">
            <div style="color:var(--color-text-muted);font-size:14px;padding:8px 0;">Učitavam...</div>
        </div>

        <!-- Products section -->
        <div class="section-title" style="display:flex;align-items:baseline;gap:6px;">Proizvodi <span id="home-products-total" style="font-size:12px;font-weight:400;color:var(--color-text-muted);"></span></div>
        <div id="home-products-list" style="padding:0 16px 16px;display:flex;flex-direction:column;gap:10px;">
            <div style="color:var(--color-text-muted);font-size:14px;padding:8px 0;">Učitavam...</div>
        </div>
        <div style="padding:0 16px 80px;">
            <button onclick="showAllProducts()" style="width:100%;padding:13px;background:#fff;border:1.5px solid #e4ddd0;border-radius:14px;font-family:var(--font-sans);font-size:14px;font-weight:600;color:#3d5a3a;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;box-shadow:0 1px 4px rgba(42,34,24,0.06);">
                Prikaži sve proizvode
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3d5a3a" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
    <!-- Bottom nav: customer -->
    <div id="nav-customer" class="bottom-nav">
        <button class="nav-btn active" onclick="showScreen('screen-home');setNavActive('nav-customer',0)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Farmeri
        </button>
        <button class="nav-btn" onclick="showSearchScreen();setNavActive('nav-customer',1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Pretraga
        </button>
        <button class="nav-btn" onclick="onProfileNavTap();setNavActive('nav-customer',2)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profil
        </button>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: SEARCH                                               -->
    <!-- ============================================================ -->
    <div id="screen-search" class="screen">
        <div class="top-bar">
            <button class="icon-btn" onclick="goBack()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div class="top-bar-title">Pretraga</div>
        </div>

        <div style="padding:12px 16px 0;">
            <input id="search-input" type="search" class="form-input" placeholder="Šta tražite?" autocomplete="off"
                oninput="onSearchInput()" style="font-size:16px;">
        </div>

        <!-- Category chips -->
        <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;padding:10px 16px;display:flex;gap:8px;scrollbar-width:none;" id="search-chips">
            <button class="chip active" data-cat="" onclick="selectSearchCategory(this,'')">Sve</button>
            <button class="chip" data-cat="povrce" onclick="selectSearchCategory(this,'povrce')">Povrće</button>
            <button class="chip" data-cat="voce" onclick="selectSearchCategory(this,'voce')">Voće</button>
            <button class="chip" data-cat="mlijeko" onclick="selectSearchCategory(this,'mlijeko')">Mlijeko</button>
            <button class="chip" data-cat="meso" onclick="selectSearchCategory(this,'meso')">Meso</button>
            <button class="chip" data-cat="jaja" onclick="selectSearchCategory(this,'jaja')">Jaja</button>
            <button class="chip" data-cat="med" onclick="selectSearchCategory(this,'med')">Med</button>
            <button class="chip" data-cat="zitarice" onclick="selectSearchCategory(this,'zitarice')">Žitarice</button>
            <button class="chip" data-cat="rakija" onclick="selectSearchCategory(this,'rakija')">Rakija</button>
            <button class="chip" data-cat="zimnica" onclick="selectSearchCategory(this,'zimnica')">Zimnica</button>
            <button class="chip" data-cat="ostalo" onclick="selectSearchCategory(this,'ostalo')">Ostalo</button>
        </div>

        <!-- Fresh toggle -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding:0 16px 12px;">
            <span style="font-size:14px;font-weight:500;color:var(--color-text-secondary);">Samo svježi danas</span>
            <label class="toggle-switch">
                <input type="checkbox" id="search-fresh-toggle" onchange="onSearchFreshToggle()">
                <span class="toggle-slider"></span>
            </label>
        </div>

        <!-- Results -->
        <div id="search-results" style="padding:0 16px 80px;">
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <div class="empty-state-text">Unesite pojam za pretragu</div>
                <div class="empty-state-sub">ili pregledajte po kategoriji</div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: FARMER PROFILE                                       -->
    <!-- ============================================================ -->
    <div id="screen-farmer-profile" class="screen">
        <div id="farmer-profile-content">
            <!-- Dynamic content inserted by JS -->
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: PRODUCT DETAIL                                       -->
    <!-- ============================================================ -->
    <div id="screen-product-detail" class="screen">
        <div id="product-detail-content">
            <!-- Dynamic content inserted by JS -->
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: FARMER SIGNUP (4 STEPS)                              -->
    <!-- ============================================================ -->
    <div id="screen-farmer-signup" class="screen">
        <div class="top-bar">
            <button class="icon-btn" onclick="goBack()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div class="top-bar-title">Postani farmer</div>
        </div>

        <!-- Step indicator -->
        <div class="step-indicator" id="signup-step-indicator">
            <div class="step-dot active" id="step-dot-1">1</div>
            <div class="step-line" id="step-line-1"></div>
            <div class="step-dot pending" id="step-dot-2">2</div>
            <div class="step-line" id="step-line-2"></div>
            <div class="step-dot pending" id="step-dot-3">3</div>
            <div class="step-line" id="step-line-3"></div>
            <div class="step-dot pending" id="step-dot-4">4</div>
        </div>

        <!-- Step 1: Account -->
        <div id="signup-step-1" style="padding:8px 16px 80px;">
            <div style="font-size:20px;font-weight:700;color:var(--color-text-primary);margin-bottom:4px;">Kreirajte nalog</div>
            <div style="font-size:14px;color:var(--color-text-muted);margin-bottom:20px;">Unesite vaše podatke za registraciju</div>
            <div class="form-group">
                <label class="form-label">Ime i prezime *</label>
                <input id="reg-name" type="text" class="form-input" placeholder="Marko Petrović" autocomplete="name">
                <div class="form-error hidden" id="reg-name-err"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Email adresa *</label>
                <input id="reg-email" type="email" class="form-input" placeholder="marko@email.com" autocomplete="email">
                <div class="form-error hidden" id="reg-email-err"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Lozinka *</label>
                <input id="reg-password" type="password" class="form-input" placeholder="Najmanje 8 znakova" autocomplete="new-password">
                <div class="form-error hidden" id="reg-password-err"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Potvrdi lozinku *</label>
                <input id="reg-password2" type="password" class="form-input" placeholder="Ponovite lozinku" autocomplete="new-password">
                <div class="form-error hidden" id="reg-password2-err"></div>
            </div>
            <button class="btn-primary" onclick="submitSignupStep1()">Dalje →</button>
            <div style="text-align:center;margin-top:16px;font-size:14px;color:var(--color-text-muted);">
                Već imate nalog? <button onclick="showScreen('screen-login')" style="background:none;border:none;color:var(--color-primary);font-weight:600;cursor:pointer;font-size:14px;">Prijavite se</button>
            </div>
        </div>

        <!-- Step 2: Contact -->
        <div id="signup-step-2" style="display:none;padding:8px 16px 80px;">
            <div style="font-size:20px;font-weight:700;color:var(--color-text-primary);margin-bottom:4px;">Kontakt podaci</div>
            <div style="font-size:14px;color:var(--color-text-muted);margin-bottom:20px;">Kupci će vas kontaktirati na ovaj broj</div>
            <div class="form-group">
                <label class="form-label">Broj telefona *</label>
                <input id="contact-phone" type="tel" class="form-input" placeholder="+38765..." autocomplete="tel">
                <div class="form-error hidden" id="contact-phone-err"></div>
            </div>
            <div style="background:#fff;border:1px solid var(--color-border);border-radius:12px;overflow:hidden;margin-bottom:16px;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid var(--color-border);">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:20px;">💜</span>
                        <div>
                            <div style="font-size:14px;font-weight:600;">Viber</div>
                            <div style="font-size:12px;color:var(--color-text-muted);">Isti broj kao telefon</div>
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="contact-viber-toggle">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="font-size:20px;">💚</span>
                        <div>
                            <div style="font-size:14px;font-weight:600;">WhatsApp</div>
                            <div style="font-size:12px;color:var(--color-text-muted);">Isti broj kao telefon</div>
                        </div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="contact-wa-toggle">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
            <button class="btn-primary" onclick="submitSignupStep2()">Dalje →</button>
            <button class="btn-secondary" style="margin-top:10px;" onclick="setSignupStep(1)">← Natrag</button>
        </div>

        <!-- Step 3: Farm info -->
        <div id="signup-step-3" style="display:none;padding:8px 16px 80px;">
            <div style="font-size:20px;font-weight:700;color:var(--color-text-primary);margin-bottom:4px;">Vaše gazdinstvo</div>
            <div style="font-size:14px;color:var(--color-text-muted);margin-bottom:20px;">Recite nam više o vašoj farmi</div>
            <div class="form-group">
                <label class="form-label">Naziv gazdinstva *</label>
                <input id="farm-name" type="text" class="form-input" placeholder="npr. Organska farma Petrović">
                <div class="form-error hidden" id="farm-name-err"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Grad *</label>
                <select id="farm-city" class="select-input">
                    <option value="">-- Odaberite grad --</option>
                    <option value="prnjavor">Prnjavor</option>
                    <option value="doboj">Doboj</option>
                    <option value="banja_luka">Banja Luka</option>
                    <option value="bijeljina">Bijeljina</option>
                    <option value="trebinje">Trebinje</option>
                    <option value="prijedor">Prijedor</option>
                    <option value="zvornik">Zvornik</option>
                    <option value="srbac">Srbac</option>
                    <option value="celinac">Čelinac</option>
                    <option value="laktasi">Laktaši</option>
                    <option value="derventa">Derventa</option>
                    <option value="gradiska">Gradiška</option>
                    <option value="modrica">Modriča</option>
                    <option value="kotor_varos">Kotor Varoš</option>
                    <option value="foca">Foča</option>
                    <option value="istocno_sarajevo">Istočno Sarajevo</option>
                    <option value="brcko">Brčko</option>
                    <option value="mrkonjic_grad">Mrkonjić Grad</option>
                </select>
                <div class="form-error hidden" id="farm-city-err"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Adresa / Selo</label>
                <input id="farm-address" type="text" class="form-input" placeholder="npr. Lišnja, Ul. Kralja Petra 5">
            </div>
            <div class="form-group">
                <label class="form-label">Opis gazdinstva</label>
                <textarea id="farm-description" class="form-input form-textarea" placeholder="Kratko opišite šta uzgajate i kako radite..."></textarea>
            </div>
            <button class="btn-primary" onclick="submitSignupStep3()">Dalje →</button>
            <button class="btn-secondary" style="margin-top:10px;" onclick="setSignupStep(2)">← Natrag</button>
        </div>

        <!-- Step 4: Photos -->
        <div id="signup-step-4" style="display:none;padding:8px 16px 80px;">
            <div style="font-size:20px;font-weight:700;color:var(--color-text-primary);margin-bottom:4px;">Dodajte fotografije</div>
            <div style="font-size:12px;color:var(--color-text-muted);margin-bottom:16px;">Prva fotografija je naslovna. Maksimalno 30 slika.</div>
            <input type="file" id="farm-photos-input" accept="image/*" multiple style="display:none;" onchange="handleFarmPhotosSelected()">
            <div id="farm-photos-grid" class="photo-grid" style="margin-bottom:16px;">
                <div class="photo-slot" onclick="document.getElementById('farm-photos-input').click()">
                    <span class="add-icon">+</span>
                </div>
            </div>
            <button class="btn-primary" onclick="submitSignupComplete()">Završi i objavi profil</button>
            <button class="btn-ghost" style="margin-top:10px;width:100%;" onclick="submitSignupComplete()">Preskoči fotografije</button>
            <button class="btn-secondary" style="margin-top:10px;" onclick="setSignupStep(3)">← Natrag</button>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: LOGIN                                                -->
    <!-- ============================================================ -->
    <div id="screen-login" class="screen">
        <div class="top-bar">
            <button class="icon-btn" onclick="goBack()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div class="top-bar-title">Prijava</div>
        </div>
        <div style="padding:24px 16px 80px;">
            <div style="font-size:22px;font-weight:700;margin-bottom:4px;">Dobrodošli nazad</div>
            <div style="font-size:14px;color:var(--color-text-muted);margin-bottom:24px;">Prijavite se u vaš AgroApp nalog</div>
            <div class="form-group">
                <label class="form-label">Email adresa</label>
                <input id="login-email" type="email" class="form-input" placeholder="email@primjer.com" autocomplete="email">
                <div class="form-error hidden" id="login-email-err"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Lozinka</label>
                <input id="login-password" type="password" class="form-input" placeholder="Vaša lozinka" autocomplete="current-password">
                <div class="form-error hidden" id="login-password-err"></div>
            </div>
            <button class="btn-primary" onclick="submitLogin()">Prijavi se</button>
            <div style="text-align:center;margin-top:16px;font-size:14px;color:var(--color-text-muted);">
                Nemate nalog? <button onclick="showScreen('screen-farmer-signup')" style="background:none;border:none;color:var(--color-primary);font-weight:600;cursor:pointer;font-size:14px;">Registrujte se</button>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: FARMER DASHBOARD                                     -->
    <!-- ============================================================ -->
    <div id="screen-farmer-dashboard" class="screen">
        <div class="top-bar">
            <div class="top-bar-title">Moj nalog</div>
        </div>

        <div style="padding-bottom:80px;" id="dashboard-content">
            <!-- Dynamic content -->
        </div>
    </div>
    <!-- Bottom nav: farmer -->
    <div id="nav-farmer" class="bottom-nav hidden">
        <button class="nav-btn active" onclick="showDashboardTab('profil');setNavActive('nav-farmer',0)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profil
        </button>
        <button class="nav-btn" onclick="showDashboardTab('proizvodi');setNavActive('nav-farmer',1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Proizvodi
        </button>
        <button class="nav-btn" style="font-size:26px;margin-top:-8px;" onclick="openProductEditor(null);setNavActive('nav-farmer',2)">
            <div style="width:48px;height:48px;background:var(--color-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:26px;box-shadow:0 2px 8px rgba(45,106,79,0.4);">+</div>
        </button>
        <button class="nav-btn" onclick="showDashboardTab('podrska');setNavActive('nav-farmer',3)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Podrška
        </button>
        <button class="nav-btn" onclick="doLogout()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Odjava
        </button>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: PRODUCT EDIT                                         -->
    <!-- ============================================================ -->
    <div id="screen-product-edit" class="screen">
        <div class="top-bar">
            <button class="icon-btn" onclick="goBack()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div class="top-bar-title" id="product-edit-title">Novi proizvod</div>
        </div>
        <div style="padding:16px 16px 100px;" id="product-edit-form-wrap">
            <!-- Photo upload -->
            <div style="margin-bottom:20px;">
                <div style="font-size:13px;font-weight:600;color:var(--color-text-secondary);margin-bottom:8px;">Fotografije <span id="product-edit-photo-count" style="color:var(--color-text-muted);">0/5</span></div>
                <input type="file" id="product-photos-input" accept="image/*" multiple style="display:none;" onchange="handleProductPhotosSelected()">
                <div style="display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap;">
                    <div class="product-edit-photo-large" id="product-edit-photo-0" onclick="triggerProductPhotoInput()">
                        <span class="add-icon">+</span>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        <div style="display:flex;gap:8px;">
                            <div class="product-edit-photo-small" id="product-edit-photo-1" onclick="triggerProductPhotoInput()"><span class="add-icon" style="font-size:20px;">+</span></div>
                            <div class="product-edit-photo-small" id="product-edit-photo-2" onclick="triggerProductPhotoInput()"><span class="add-icon" style="font-size:20px;">+</span></div>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <div class="product-edit-photo-small" id="product-edit-photo-3" onclick="triggerProductPhotoInput()"><span class="add-icon" style="font-size:20px;">+</span></div>
                            <div class="product-edit-photo-small" id="product-edit-photo-4" onclick="triggerProductPhotoInput()"><span class="add-icon" style="font-size:20px;">+</span></div>
                        </div>
                    </div>
                </div>
                <!-- Preset images -->
                <div id="pe-presets-section" style="margin-top:12px;display:none;">
                    <div style="font-size:12px;color:var(--color-text-muted);margin-bottom:6px;">Ili odaberite preset sliku:</div>
                    <div id="pe-presets-grid" style="display:flex;gap:8px;flex-wrap:wrap;"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Naziv proizvoda *</label>
                <input id="pe-name" type="text" class="form-input" placeholder="npr. Paradajz organski">
                <div class="form-error hidden" id="pe-name-err"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Kategorija *</label>
                <select id="pe-category" class="select-input" onchange="onPeCategoryChange(this.value)">
                    <option value="">-- Odaberite kategoriju --</option>
                    <option value="povrce">Povrće</option>
                    <option value="voce">Voće</option>
                    <option value="mlijeko">Mlijeko i mliječni</option>
                    <option value="meso">Meso i prerađevine</option>
                    <option value="jaja">Jaja</option>
                    <option value="med">Med i pčelinji</option>
                    <option value="zitarice">Žitarice i brašno</option>
                    <option value="rakija">Rakija i alkohol</option>
                    <option value="zimnica">Zimnica</option>
                    <option value="ostalo">Ostalo</option>
                </select>
                <div class="form-error hidden" id="pe-category-err"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Cijena i jedinica *</label>
                <div style="display:flex;gap:8px;">
                    <input id="pe-price" type="number" class="form-input" placeholder="0.00" step="0.01" min="0" style="flex:1;">
                    <select id="pe-unit" class="select-input" style="width:100px;flex-shrink:0;">
                        <option value="kg">kg</option>
                        <option value="kom">kom</option>
                        <option value="l">l</option>
                        <option value="g">g</option>
                        <option value="pak">pak</option>
                    </select>
                </div>
                <div class="form-error hidden" id="pe-price-err"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Opis (neobavezno)</label>
                <textarea id="pe-description" class="form-input form-textarea" placeholder="Kratki opis proizvoda..."></textarea>
            </div>

            <!-- Fresh until picker -->
            <div id="pe-fresh-section" style="margin-bottom:16px;"></div>

            <button class="btn-primary" onclick="saveProduct()" id="save-product-btn">Sačuvaj proizvod</button>
            <button class="btn-danger" id="delete-product-btn" style="display:none;width:100%;margin-top:12px;text-align:center;" onclick="confirmDeleteProduct()">Obriši proizvod</button>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: FARMER PROFILE EDIT                                -->
    <!-- ============================================================ -->
    <div id="screen-farmer-profile-edit" class="screen">
        <div class="top-bar">
            <button class="icon-btn" onclick="goBack()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div class="top-bar-title">Uredi profil</div>
        </div>

        <div style="padding:16px 16px 100px;">
            <!-- Avatar -->
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
                <div id="fpe-avatar-preview" class="avatar-circle" style="width:80px;height:80px;font-size:32px;cursor:pointer;" onclick="document.getElementById('fpe-avatar-input').click()">
                    🧑‍🌾
                </div>
                <div>
                    <div style="font-size:14px;font-weight:600;color:var(--color-text-primary);margin-bottom:4px;">Profilna slika</div>
                    <button type="button" onclick="document.getElementById('fpe-avatar-input').click()"
                        class="btn-ghost" style="width:auto;padding:8px 16px;font-size:13px;">Promijeni</button>
                </div>
                <input type="file" id="fpe-avatar-input" accept="image/*" style="display:none;" onchange="handleAvatarSelected()">
            </div>

            <div class="form-group">
                <label class="form-label">Naziv farme *</label>
                <input id="fpe-farmname" type="text" class="form-input" placeholder="npr. Organska farma Petrović">
                <div class="form-error hidden" id="fpe-farmname-err"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Grad *</label>
                <select id="fpe-city" class="select-input">
                    <option value="">-- Odaberite grad --</option>
                    <option value="prnjavor">Prnjavor</option>
                    <option value="doboj">Doboj</option>
                    <option value="banja_luka">Banja Luka</option>
                    <option value="bijeljina">Bijeljina</option>
                    <option value="trebinje">Trebinje</option>
                    <option value="prijedor">Prijedor</option>
                    <option value="zvornik">Zvornik</option>
                    <option value="srbac">Srbac</option>
                    <option value="celinac">Čelinac</option>
                    <option value="laktasi">Laktaši</option>
                    <option value="derventa">Derventa</option>
                    <option value="gradiska">Gradiška</option>
                    <option value="modrica">Modriča</option>
                    <option value="kotor_varos">Kotor Varoš</option>
                    <option value="foca">Foča</option>
                    <option value="istocno_sarajevo">Istočno Sarajevo</option>
                    <option value="brcko">Brčko</option>
                    <option value="mrkonjic_grad">Mrkonjić Grad</option>
                </select>
                <div class="form-error hidden" id="fpe-city-err"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Adresa / Selo</label>
                <input id="fpe-address" type="text" class="form-input" placeholder="npr. Lišnja, Ul. Kralja Petra 5">
            </div>

            <div class="form-group">
                <label class="form-label">O farmi (neobavezno)</label>
                <textarea id="fpe-description" class="form-input form-textarea" rows="4"
                    placeholder="Kratki opis vaše farme, šta uzgajate, tradicija..."></textarea>
            </div>

            <button class="btn-primary" onclick="saveProfileEdit()" id="fpe-save-btn">Sačuvaj promjene</button>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- SCREEN: ADMIN                                               -->
    <!-- ============================================================ -->
    <div id="screen-admin" class="screen" style="bottom:0;">
        <!-- Top bar -->
        <div class="top-bar">
            <div class="top-bar-logo" style="font-size:16px;">🔐 Admin Panel</div>
            <button class="btn-danger" style="font-size:13px;padding:6px 12px;" onclick="adminLogout()">Odjava</button>
        </div>

        <!-- Tabs -->
        <div style="display:flex;border-bottom:1px solid var(--color-border);background:#fff;">
            <button id="admin-tab-farmers" onclick="switchAdminTab('farmers')"
                style="flex:1;padding:12px;font-size:13px;font-weight:600;border:none;background:none;cursor:pointer;border-bottom:2px solid var(--color-primary);color:var(--color-primary);">
                Farmeri
            </button>
            <button id="admin-tab-products" onclick="switchAdminTab('products')"
                style="flex:1;padding:12px;font-size:13px;font-weight:600;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:var(--color-text-muted);">
                Proizvodi
            </button>
            <button id="admin-tab-reviews" onclick="switchAdminTab('reviews')"
                style="flex:1;padding:12px;font-size:13px;font-weight:600;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;color:var(--color-text-muted);">
                Recenzije
            </button>
        </div>

        <!-- Farmers tab -->
        <div id="admin-farmers-panel">
            <div id="admin-farmers-list" style="padding-bottom:20px;">
                <div style="color:var(--color-text-muted);font-size:14px;padding:24px 16px;">Učitavam...</div>
            </div>
        </div>

        <!-- Products tab -->
        <div id="admin-products-panel" style="display:none;">
            <div id="admin-products-list" style="padding-bottom:20px;">
                <div style="color:var(--color-text-muted);font-size:14px;padding:24px 16px;">Učitavam...</div>
            </div>
        </div>

        <!-- Reviews tab -->
        <div id="admin-reviews-panel" style="display:none;">
            <div id="admin-reviews-list" style="padding-bottom:20px;">
                <div style="color:var(--color-text-muted);font-size:14px;padding:24px 16px;">Učitavam...</div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- LOADING OVERLAY                                              -->
    <!-- ============================================================ -->
    <div id="loading-overlay" class="spinner-overlay hidden">
        <div class="spinner"></div>
    </div>

</div><!-- #app -->

<script>
// =====================================================================
// STATE
// =====================================================================
const state = {
    auth: null,
    farmers: [],
    farmersMeta: { currentPage: 1, lastPage: 1, total: 0 },
    selectedFarmer: null,
    searchResults: { farmers: [], products: [] },
    selectedProduct: null,
    myProducts: [],
    categories: [],
    searchQuery: '',
    selectedCategory: '',
    freshOnly: false,
    browseAll: false,
    isLoading: false,
    currentScreen: 'screen-home',
    screenHistory: [],
    editingProduct: null,
    pendingFreshHours: null,
    homeProducts: [],
    homeCategory: '',
    homeCity: '',
    homeFreshOnly: false,
    cities: {},
    pendingFarmPhotos: [],
    pendingProductPhotos: [],
    adminFarmers: [],
    adminProducts: [],
    adminTab: 'farmers',
};

const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// =====================================================================
// API HELPER
// =====================================================================
async function api(method, url, body = null) {
    const opts = {
        method,
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        credentials: 'same-origin',
    };
    if (body instanceof FormData) {
        opts.body = body;
    } else if (body) {
        opts.headers['Content-Type'] = 'application/json';
        opts.body = JSON.stringify(body);
    }
    const res = await fetch(url, opts);
    const data = await res.json().catch(() => ({}));
    if (!res.ok) {
        const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Greška na serveru');
        throw { status: res.status, message: msg, errors: data.errors || {} };
    }
    return data;
}

// =====================================================================
// TOAST
// =====================================================================
function showToast(msg, type = 'info') {
    const existing = document.querySelector('.toast');
    if (existing) existing.remove();
    const t = document.createElement('div');
    t.className = 'toast' + (type === 'error' ? ' error' : '');
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
}

// =====================================================================
// LOADING
// =====================================================================
function setLoading(v) {
    state.isLoading = v;
    document.getElementById('loading-overlay').classList.toggle('hidden', !v);
}

// =====================================================================
// SCREEN NAVIGATION
// =====================================================================
function showScreen(name, pushHistory = true) {
    const all = document.querySelectorAll('.screen');
    all.forEach(s => s.classList.remove('active'));
    const target = document.getElementById(name);
    if (target) target.classList.add('active');
    target && target.scrollTo(0, 0);

    if (pushHistory && state.currentScreen !== name) {
        state.screenHistory.push(state.currentScreen);
    }
    state.currentScreen = name;

    // Show correct nav
    const isAdmin  = state.auth && state.auth.role === 'admin';
    const isFarmer = state.auth && state.auth.role === 'farmer' && !state.auth.onboardingStep;
    const farmerScreens = ['screen-farmer-dashboard', 'screen-product-edit', 'screen-farmer-profile-edit'];
    const noNav = ['screen-farmer-signup', 'screen-login', 'screen-admin'];

    document.getElementById('nav-customer').classList.add('hidden');
    document.getElementById('nav-farmer').classList.add('hidden');

    if (noNav.includes(name)) {
        if (target) target.style.bottom = '0';
    } else {
        if (target) target.style.bottom = '64px';
        if (isFarmer && (farmerScreens.includes(name) || name === 'screen-farmer-dashboard')) {
            document.getElementById('nav-farmer').classList.remove('hidden');
        } else {
            document.getElementById('nav-customer').classList.remove('hidden');
        }
    }
}

function goBack() {
    const prev = state.screenHistory.pop();
    if (prev) {
        showScreen(prev, false);
    } else {
        showScreen('screen-home', false);
    }
}

function setNavActive(navId, idx) {
    const nav = document.getElementById(navId);
    nav.querySelectorAll('.nav-btn').forEach((b, i) => b.classList.toggle('active', i === idx));
}

// =====================================================================
// INIT
// =====================================================================
async function init() {
    // Load from localStorage cache
    const cached = localStorage.getItem('agroapp_state');
    if (cached) {
        try {
            const c = JSON.parse(cached);
            state.auth = c.auth || null;
            state.farmers = c.farmers || [];
            state.categories = c.categories || [];
            state.cities = c.cities || {};
        } catch(e) {}
    }

    // Render immediately from cache
    renderHomeFarmers(state.farmers);

    // Fetch fresh state
    try {
        const data = await api('GET', '/api/state');
        state.auth = data.auth || null;
        state.farmers = data.farmers || [];
        state.categories = data.categories || {};
        state.cities = data.cities || {};
        localStorage.setItem('agroapp_state', JSON.stringify({ auth: state.auth, farmers: state.farmers, categories: state.categories, cities: state.cities }));
        renderHomeFarmers(state.farmers);
        renderCityChips();
        updateAuthButton();
        if (state.auth && state.auth.role === 'admin') {
            showAdminScreen();
            return;
        }
    } catch(e) {
        console.warn('State load failed', e);
    }

    // Deep link: open a specific farmer profile if URL was /farmer/{id}
    @isset($openFarmerId)
    loadFarmerProfile({{ $openFarmerId }});
    return;
    @endisset

    // Load products for home
    loadHomeProducts();
    loadFreshCount();
}

function updateAuthButton() {
    const btn = document.getElementById('home-auth-btn');
    if (!btn) return;
    if (state.auth) {
        btn.title = state.auth.name;
        btn.innerHTML = `<svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>`;
        btn.style.color = 'var(--color-primary)';
    } else {
        btn.title = 'Prijava';
        btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>`;
        btn.style.color = '';
    }
}

function onLoginIconTap() {
    if (state.auth) {
        if (state.auth.role === 'farmer' && !state.auth.onboardingStep) {
            showFarmerDashboard();
        } else if (state.auth.onboardingStep) {
            resumeOnboarding();
        } else {
            showScreen('screen-login');
        }
    } else {
        showScreen('screen-login');
    }
}

function onProfileNavTap() {
    if (state.auth) {
        if (state.auth.role === 'farmer' && !state.auth.onboardingStep) {
            showFarmerDashboard();
        } else {
            showScreen('screen-login');
        }
    } else {
        showScreen('screen-login');
    }
}

// =====================================================================
// HOME — FARMERS
// =====================================================================
function renderHomeFarmers(farmers) {
    const el = document.getElementById('home-farmers-list');
    if (!farmers || !farmers.length) {
        el.innerHTML = '<div style="color:var(--color-text-muted);font-size:14px;padding:8px 0;">Nema farmera</div>';
        return;
    }
    el.innerHTML = farmers.map(f => farmerCardHtml(f)).join('');
}

function farmerCardHtml(f) {
    const img = f.coverPhoto
        ? `<img src="${esc(f.coverPhoto.url)}" alt="${esc(f.farmName)}" style="width:100%;height:110px;object-fit:cover;">`
        : `<div style="width:100%;height:110px;background:linear-gradient(145deg,#3d5a3a,#2a3f27);display:flex;align-items:center;justify-content:center;font-size:36px;">🌿</div>`;
    return `<div onclick="loadFarmerProfile(${f.id})" style="display:flex;flex-direction:column;width:160px;flex-shrink:0;background:#fff;border-radius:16px;border:1px solid #e4ddd0;overflow:hidden;cursor:pointer;box-shadow:0 2px 8px rgba(42,34,24,0.07);">
        ${img}
        <div style="padding:10px;">
            <div style="font-family:var(--font-serif);font-size:14px;font-weight:500;color:#2a2218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:3px;">${esc(f.farmName)}</div>
            <div style="display:flex;align-items:center;gap:4px;font-size:11px;color:#7a6f5f;">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                ${esc(formatLocation(f))}
            </div>
            <div style="font-size:11px;color:#a89a85;margin-top:3px;">${f.productCount || 0} proizvoda</div>
        </div>
    </div>`;
}

// =====================================================================
// HOME — PRODUCTS
// =====================================================================
async function loadHomeProducts(category = '', city = '', freshOnly = false) {
    const el = document.getElementById('home-products-list');
    if (!el) return;
    el.innerHTML = '<div style="color:var(--color-text-muted);font-size:14px;padding:8px 0;">Učitavam...</div>';
    try {
        const params = new URLSearchParams();
        if (category)  params.set('category', category);
        if (city)      params.set('city', city);
        if (freshOnly) params.set('freshOnly', '1');
        params.set('per_page', '8');
        const url = '/api/products?' + params.toString();
        const data = await api('GET', url);
        state.homeProducts = data.data || [];
        const total = data.meta ? data.meta.total : null;
        const totalEl = document.getElementById('home-products-total');
        if (totalEl && total !== null) totalEl.textContent = `(${total} ukupno)`;
        renderHomeProducts(state.homeProducts);
    } catch(e) {
        el.innerHTML = '<div style="color:var(--color-danger);font-size:14px;">Greška pri učitavanju</div>';
    }
}

function showSearchScreen() {
    state.browseAll = false;
    showScreen('screen-search');
}

function showAllProducts() {
    showScreen('screen-search');
    setNavActive('nav-customer', 1);
    state.searchQuery = '';
    state.selectedCategory = '';
    state.freshOnly = false;
    state.browseAll = true;
    const input = document.getElementById('search-input');
    if (input) input.value = '';
    const freshToggle = document.getElementById('search-fresh-toggle');
    if (freshToggle) freshToggle.checked = false;
    document.querySelectorAll('#search-chips .chip').forEach((c, i) => {
        i === 0 ? c.classList.add('active') : c.classList.remove('active');
    });
    doSearch();
}

function renderHomeProducts(products) {
    const el = document.getElementById('home-products-list');
    if (!el) return;
    if (!products.length) {
        el.innerHTML = `<div class="empty-state"><div class="empty-state-icon">🛒</div><div class="empty-state-text">Nema proizvoda</div></div>`;
        return;
    }
    el.innerHTML = products.map(p => productCardHtml(p)).join('');
}

function productCardHtml(p) {
    const thumb = p.thumbnailUrl
        ? `<img src="${esc(p.thumbnailUrl)}" style="width:80px;height:80px;border-radius:12px;object-fit:cover;flex-shrink:0;" alt="${esc(p.name)}">`
        : `<div style="width:80px;height:80px;border-radius:12px;background:#e8efe4;display:flex;align-items:center;justify-content:center;font-size:30px;flex-shrink:0;">${productEmoji(p.name, p.category)}</div>`;
    const fresh = p.freshToday ? `<div style="display:inline-flex;align-items:center;gap:3px;background:#fef3c7;color:#92400e;font-size:10px;font-weight:600;padding:2px 8px;border-radius:100px;margin-bottom:4px;">🌞 Svježe danas</div>` : '';
    const farmer = p.farmer ? `<div style="display:inline-flex;align-items:center;gap:4px;margin-top:5px;"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#3d5a3a" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span style="font-size:12px;font-weight:600;color:#3d5a3a;">${esc(p.farmer.farmName)}</span></div>` : '';
    const price = p.price ? `<div style="font-family:var(--font-sans);font-size:15px;font-weight:700;color:#2a2218;margin-top:2px;">${formatPrice(p.price, p.priceUnit)}</div>` : '';
    return `<div onclick="loadProductDetail(${p.id})" style="display:flex;gap:12px;background:#fff;border-radius:16px;border:1px solid #e4ddd0;padding:12px;cursor:pointer;box-shadow:0 1px 4px rgba(42,34,24,0.06);">
        ${thumb}
        <div style="flex:1;min-width:0;">
            ${fresh}
            <div style="font-family:var(--font-serif);font-size:15px;font-weight:500;color:#2a2218;line-height:1.25;margin-bottom:2px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">${esc(p.name)}</div>
            ${price}
            ${farmer}
        </div>
    </div>`;
}

async function loadFreshCount() {
    try {
        const data = await api('GET', '/api/products?freshOnly=1');
        const count = data.meta ? data.meta.total : (data.data || []).length;
        const banner = document.getElementById('fresh-banner');
        const countEl = document.getElementById('fresh-count');
        if (count > 0) {
            banner.style.display = 'flex';
            countEl.textContent = `${count} proizvod${count === 1 ? '' : 'a'} dostupno`;
        }
    } catch(e) {}
}

function showFreshFilter() {
    state.freshOnly = true;
    showScreen('screen-search');
    document.getElementById('search-fresh-toggle').checked = true;
    doSearch();
}

function selectHomeCategory(btn, cat) {
    document.querySelectorAll('#home-category-chips .chip:not(#home-fresh-chip)').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    state.homeCategory = cat;
    loadHomeProducts(cat, state.homeCity, state.homeFreshOnly);
}

function selectHomeCity(btn, city) {
    document.querySelectorAll('#home-city-chips .chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    state.homeCity = city;
    loadHomeProducts(state.homeCategory, city, state.homeFreshOnly);
    loadHomeFarmersByCity(city);
}

function toggleHomeFresh(btn) {
    state.homeFreshOnly = !state.homeFreshOnly;
    btn.style.background     = state.homeFreshOnly ? '#F59E0B' : '#FEF3C7';
    btn.style.color          = state.homeFreshOnly ? '#fff'    : '#92400E';
    btn.style.borderColor    = '#F59E0B';
    loadHomeProducts(state.homeCategory, state.homeCity, state.homeFreshOnly);
}

function renderCityChips() {
    const container = document.getElementById('home-city-chips');
    if (!container || !Object.keys(state.cities).length) return;
    const allBtn = `<button class="chip ${state.homeCity === '' ? 'active' : ''}" data-city="" onclick="selectHomeCity(this,'')">Svi gradovi</button>`;
    const cityBtns = Object.entries(state.cities)
        .map(([slug, label]) => `<button class="chip ${state.homeCity === slug ? 'active' : ''}" data-city="${slug}" onclick="selectHomeCity(this,'${slug}')">${label}</button>`)
        .join('');
    container.innerHTML = allBtn + cityBtns;
}

async function loadHomeFarmersByCity(city) {
    const el = document.getElementById('home-farmers-list');
    if (!el) return;
    try {
        const params = city ? `?city=${city}` : '';
        const data = await api('GET', `/api/farmers${params}`);
        state.farmers = data.data || data;
        renderHomeFarmers(state.farmers);
    } catch(e) {}
}

// =====================================================================
// FARMER PROFILE
// =====================================================================
async function loadFarmerProfile(id) {
    setLoading(true);
    try {
        const data = await api('GET', `/api/farmers/${id}`);
        state.selectedFarmer = data;
        _fpCurrentFarmerId = data.id;
        renderFarmerProfile(data);
        showScreen('screen-farmer-profile');
    } catch(e) {
        showToast('Greška pri učitavanju profila', 'error');
    } finally {
        setLoading(false);
    }
}

function renderFarmerProfile(f) {
    const el = document.getElementById('farmer-profile-content');
    const user = f.user || {};
    const photos = f.photos || [];
    const products = f.products || [];

    const heroBg = photos.length > 1
        ? `<div class="gallery" id="fp-gallery" style="position:absolute;inset:0;">
            <div class="gallery-track" id="fp-gallery-track" style="height:340px;overflow-x:auto;scroll-snap-type:x mandatory;display:flex;">
                ${photos.map(ph => `<div style="min-width:100%;height:340px;scroll-snap-align:start;flex-shrink:0;overflow:hidden;"><img src="${esc(ph.url)}" style="width:100%;height:100%;object-fit:cover;"></div>`).join('')}
            </div>
            <div style="position:absolute;bottom:80px;left:0;right:0;display:flex;justify-content:center;gap:6px;">${photos.map((_, i) => `<div class="gallery-dot${i===0?' active':''}" data-gallery="fp-gallery" data-idx="${i}" style="width:${i===0?18:6}px;height:6px;border-radius:100px;background:${i===0?'#fff':'rgba(255,255,255,0.5)'};transition:width .2s;"></div>`).join('')}</div>
           </div>`
        : photos.length === 1
        ? `<img src="${esc(photos[0].url)}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">`
        : `<div style="position:absolute;inset:0;background:linear-gradient(160deg,#3d5a3a 0%,#2a3f27 60%,#4a6a3a 100%);"></div>`;

    const avatarHtml = f.avatarUrl
        ? `<img src="${esc(f.avatarUrl)}" style="width:86px;height:86px;border-radius:24px;object-fit:cover;border:3px solid #faf6ef;box-shadow:0 10px 24px rgba(26,20,10,0.25);flex-shrink:0;">`
        : `<div style="width:86px;height:86px;border-radius:24px;background:#e8efe4;border:3px solid #faf6ef;box-shadow:0 10px 24px rgba(26,20,10,0.25);flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:36px;">🧑‍🌾</div>`;

    const productsHtml = products.length
        ? `<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            ${products.map(p => productGridCard(p)).join('')}
          </div>`
        : `<div class="empty-state"><div class="empty-state-icon">🌿</div><div class="empty-state-text">Nema proizvoda</div></div>`;

    el.innerHTML = `
        <div style="position:relative;height:340px;overflow:hidden;flex-shrink:0;">
            ${heroBg}
            <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(26,20,16,0.4) 0%,rgba(26,20,16,0) 25%,rgba(26,20,16,0) 45%,rgba(250,246,239,0.95) 95%,rgba(250,246,239,1) 100%);"></div>
            <div style="position:absolute;top:58px;left:0;right:0;display:flex;justify-content:space-between;padding:0 16px;z-index:10;">
                <button onclick="goBack()" style="width:40px;height:40px;border-radius:100px;border:none;background:rgba(26,20,16,0.55);backdrop-filter:blur(8px);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="19" height="19"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button onclick="shareFarmerProfile(${f.id},'${esc(f.farmName)}')" style="width:40px;height:40px;border-radius:100px;border:none;background:rgba(26,20,16,0.55);backdrop-filter:blur(8px);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="19" height="19"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                </button>
            </div>
            <div style="position:absolute;bottom:24px;left:22px;right:22px;display:flex;align-items:flex-end;gap:14px;">
                ${avatarHtml}
                <div style="flex:1;padding-bottom:6px;">
                    <div style="font-family:var(--font-sans);font-size:11.5px;font-weight:600;color:#3d5a3a;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:4px;">${esc(formatLocation(f))}</div>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-family:var(--font-serif);font-size:24px;font-weight:500;color:#2a2218;line-height:1.05;letter-spacing:-0.5px;">${esc(f.farmName)}</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#3d5a3a"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding:20px 22px 0;">
            <div style="display:flex;align-items:center;gap:0;margin-bottom:18px;">
                <div style="flex:1;">
                    <div style="font-family:var(--font-serif);font-size:20px;font-weight:500;color:#2a2218;line-height:1;margin-bottom:4px;">${products.length}</div>
                    <div style="font-family:var(--font-sans);font-size:11px;color:#a89a85;letter-spacing:0.3px;">proizvoda</div>
                </div>
                <div style="width:1px;height:26px;background:#ece5d6;margin:0 18px;"></div>
                <div style="flex:1;">
                    <div style="font-family:var(--font-serif);font-size:20px;font-weight:500;color:#2a2218;line-height:1;margin-bottom:4px;">—</div>
                    <div style="font-family:var(--font-sans);font-size:11px;color:#a89a85;letter-spacing:0.3px;">pratilaca</div>
                </div>
                <div style="width:1px;height:26px;background:#ece5d6;margin:0 18px;"></div>
                <div style="flex:1;">
                    <div id="fp-rating-stat" style="font-family:var(--font-serif);font-size:20px;font-weight:500;color:#2a2218;line-height:1;margin-bottom:4px;">★ —</div>
                    <div style="font-family:var(--font-sans);font-size:11px;color:#a89a85;letter-spacing:0.3px;">recenzija</div>
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-bottom:22px;">
                ${user.phone ? `<button onclick="window.location='tel:${esc(user.phone)}'" style="flex:1;height:46px;border:none;border-radius:100px;background:#3d5a3a;color:#fff;font-family:var(--font-sans);font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.42 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.76a16 16 0 0 0 6.29 6.29l1.83-1.83a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Pozovi
                </button>` : `<div style="flex:1;"></div>`}
                <button onclick="typeof showChatWithFarmer==='function'&&showChatWithFarmer(${f.id})" style="flex:1;height:46px;border:1px solid #e4ddd0;border-radius:100px;background:#fff;color:#1f1a14;font-family:var(--font-sans);font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Poruka
                </button>
            </div>

            ${f.description ? `<p style="font-family:var(--font-serif);font-size:16.5px;line-height:1.5;color:#1f1a14;margin:0 0 8px;letter-spacing:-0.1px;">${esc(f.description)}</p>` : ''}
        </div>

        <div style="display:flex;gap:0;padding:22px 22px 0;border-bottom:1px solid #ece5d6;background:#faf6ef;position:sticky;top:0;z-index:5;" id="fp-tabs">
            <button onclick="fpSwitchTab('products')" id="fp-tab-products" style="flex:1;padding:12px 0;background:none;border:none;border-bottom:2px solid #2a2218;font-family:var(--font-sans);font-size:13.5px;font-weight:600;color:#2a2218;cursor:pointer;">Proizvodi</button>
            <button onclick="fpSwitchTab('story')" id="fp-tab-story" style="flex:1;padding:12px 0;background:none;border:none;border-bottom:2px solid transparent;font-family:var(--font-sans);font-size:13.5px;font-weight:500;color:#7a6f5f;cursor:pointer;">Priča</button>
            <button onclick="fpSwitchTab('reviews')" id="fp-tab-reviews" style="flex:1;padding:12px 0;background:none;border:none;border-bottom:2px solid transparent;font-family:var(--font-sans);font-size:13.5px;font-weight:500;color:#7a6f5f;cursor:pointer;">Recenzije</button>
        </div>
        <div id="fp-tab-content-products" style="padding:18px 22px 100px;">${productsHtml}</div>
        <div id="fp-tab-content-story" style="display:none;padding:28px 22px 100px;">
            <div style="font-family:var(--font-sans);font-size:11.5px;font-weight:600;color:#c06643;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:10px;">Osnovano · ${f.createdAt ? f.createdAt.substring(0,4) : '—'}</div>
            <h2 style="font-family:var(--font-serif);font-size:26px;font-weight:500;margin:0 0 16px;line-height:1.1;color:#2a2218;letter-spacing:-0.5px;">O gazdinstvu</h2>
            <p style="font-family:var(--font-serif);font-size:16px;line-height:1.65;color:#1f1a14;margin:0 0 22px;">${f.description ? esc(f.description) : 'Priča o ovom gazdinstvu uskoro…'}</p>
        </div>
        <div id="fp-tab-content-reviews" style="display:none;padding:22px 22px 100px;">
            <div id="fp-reviews-list"><div class="empty-state"><div class="empty-state-icon">⭐</div><div class="empty-state-text">Učitavanje…</div></div></div>
            <div id="fp-review-form" style="margin-top:24px;">
                <div style="font-family:var(--font-sans);font-size:11.5px;font-weight:700;color:#7a6f5f;letter-spacing:1.4px;text-transform:uppercase;margin-bottom:14px;">Ostavi recenziju</div>
                <div id="fp-star-row" style="display:flex;gap:6px;margin-bottom:14px;" data-rating="5">
                    ${[1,2,3,4,5].map(n => `<button onclick="fpSetStar(${n})" data-star="${n}" style="font-size:26px;background:none;border:none;cursor:pointer;padding:0;color:#b8902a;">★</button>`).join('')}
                </div>
                <input id="fp-review-name" type="text" placeholder="Vaše ime (npr. Marko iz Banjaluke)" maxlength="60" style="width:100%;padding:12px 14px;border:1.5px solid #e4ddd0;border-radius:10px;font-size:15px;color:#1f1a14;background:#fff;outline:none;margin-bottom:10px;font-family:var(--font-sans);">
                <textarea id="fp-review-body" placeholder="Vaše iskustvo s ovim gazdinstvom…" maxlength="500" rows="3" style="width:100%;padding:12px 14px;border:1.5px solid #e4ddd0;border-radius:10px;font-size:15px;color:#1f1a14;background:#fff;outline:none;resize:vertical;font-family:var(--font-sans);"></textarea>
                <div style="text-align:right;font-size:11px;color:#a89a85;margin-bottom:12px;" id="fp-body-count">0 / 500</div>
                <button onclick="fpSubmitReview()" style="width:100%;height:46px;border:none;border-radius:12px;background:#3d5a3a;color:#fff;font-family:var(--font-sans);font-size:15px;font-weight:600;cursor:pointer;">Pošalji recenziju</button>
            </div>
        </div>
    `;

    if (photos.length > 1) setupGallery('fp-gallery');

    // initialise star colours and wire character counter
    fpSetStar(5);
    const bodyEl = document.getElementById('fp-review-body');
    if (bodyEl) bodyEl.addEventListener('input', () => {
        const c = document.getElementById('fp-body-count');
        if (c) c.textContent = bodyEl.value.length + ' / 500';
    });
}

let _fpCurrentFarmerId = null;

function fpSwitchTab(tab) {
    ['products','story','reviews'].forEach(t => {
        const btn = document.getElementById('fp-tab-' + t);
        const content = document.getElementById('fp-tab-content-' + t);
        const active = t === tab;
        if (btn) {
            btn.style.fontWeight = active ? '600' : '500';
            btn.style.color = active ? '#2a2218' : '#7a6f5f';
            btn.style.borderBottomColor = active ? '#2a2218' : 'transparent';
        }
        if (content) content.style.display = active ? '' : 'none';
    });
    if (tab === 'reviews' && _fpCurrentFarmerId) fpLoadReviews(_fpCurrentFarmerId);
}

async function fpLoadReviews(farmerId) {
    const list = document.getElementById('fp-reviews-list');
    if (!list) return;
    try {
        const data = await api('GET', `/api/farmers/${farmerId}/reviews`);
        const reviews = data.reviews || [];
        const ratingStat = document.getElementById('fp-rating-stat');
        if (ratingStat) {
            if (data.avg && data.count) {
                ratingStat.textContent = `★ ${parseFloat(data.avg).toFixed(1)} (${data.count})`;
            } else {
                ratingStat.textContent = '★ —';
            }
        }
        if (!reviews.length) {
            list.innerHTML = `<div class="empty-state"><div class="empty-state-icon">⭐</div><div class="empty-state-text">Još nema recenzija</div><div class="empty-state-sub">Budite prvi koji će ostaviti utisak</div></div>`;
            return;
        }
        list.innerHTML = reviews.map(r => `
            <div style="padding:16px 0;border-bottom:1px solid #ece5d6;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                    <div style="font-family:var(--font-sans);font-size:14px;font-weight:600;color:#2a2218;">${esc(r.reviewer_name)}</div>
                    <div style="font-size:12px;color:#a89a85;">${r.created_at ? r.created_at.substring(0,10) : ''}</div>
                </div>
                <div style="color:#b8902a;margin-bottom:6px;font-size:15px;">${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)}</div>
                <div style="font-family:var(--font-serif);font-size:15px;line-height:1.55;color:#1f1a14;">${esc(r.body)}</div>
            </div>`).join('');
    } catch(e) {
        list.innerHTML = `<div class="empty-state"><div class="empty-state-icon">⭐</div><div class="empty-state-text">Greška pri učitavanju</div></div>`;
    }
}

function fpSetStar(n) {
    document.getElementById('fp-star-row').dataset.rating = n;
    document.querySelectorAll('#fp-star-row button').forEach((btn, i) => {
        btn.style.color = i < n ? '#b8902a' : '#e4ddd0';
    });
}

async function fpSubmitReview() {
    const farmerId = _fpCurrentFarmerId;
    if (!farmerId) return;
    const name = document.getElementById('fp-review-name')?.value.trim();
    const body = document.getElementById('fp-review-body')?.value.trim();
    const rating = parseInt(document.getElementById('fp-star-row')?.dataset.rating || '5');
    if (!name || name.length < 2) { showToast('Unesite ime (min. 2 znaka)', 'error'); return; }
    if (!body || body.length < 10) { showToast('Komentar mora imati min. 10 znakova', 'error'); return; }
    try {
        await api('POST', `/api/farmers/${farmerId}/reviews`, { reviewer_name: name, body, rating });
        document.getElementById('fp-review-name').value = '';
        document.getElementById('fp-review-body').value = '';
        fpSetStar(5);
        showToast('Hvala! Recenzija je objavljena.');
        fpLoadReviews(farmerId);
    } catch(e) {
        if (e.status === 429) {
            showToast('Već ste ostavili recenziju za ovo gazdinstvo danas.', 'error');
        } else if (e.status === 422) {
            showToast(e.message || 'Provjerite unesene podatke.', 'error');
        } else {
            showToast('Greška pri slanju recenzije.', 'error');
        }
    }
}

function productGridCard(p) {
    const thumb = p.thumbnailUrl
        ? `<img src="${esc(p.thumbnailUrl)}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">`
        : `<div style="position:absolute;inset:0;background:#e8efe4;display:flex;align-items:center;justify-content:center;font-size:40px;">${productEmoji(p.name, p.category)}</div>`;
    const tag = p.freshToday ? 'Svježe' : (p.category || '');
    return `<div onclick="loadProductDetail(${p.id})" style="cursor:pointer;">
        <div style="position:relative;border-radius:14px;overflow:hidden;margin-bottom:10px;aspect-ratio:1/1.1;">
            ${thumb}
            ${tag ? `<div style="position:absolute;top:8px;left:8px;padding:3px 8px;border-radius:100px;background:rgba(255,255,255,0.92);backdrop-filter:blur(6px);font-family:var(--font-sans);font-size:10px;font-weight:600;color:#2a2218;letter-spacing:0.3px;text-transform:uppercase;">${esc(tag)}</div>` : ''}
        </div>
        <div style="font-family:var(--font-serif);font-size:15.5px;font-weight:500;color:#2a2218;line-height:1.2;margin-bottom:4px;">${esc(p.name)}</div>
        <div style="display:flex;align-items:baseline;gap:4px;">
            <span style="font-family:var(--font-sans);font-size:13.5px;font-weight:700;color:#2a2218;">${formatPrice(p.price, p.priceUnit)}</span>
        </div>
    </div>`;
}

// =====================================================================
// PRODUCT DETAIL
// =====================================================================
async function loadProductDetail(id) {
    setLoading(true);
    try {
        const data = await api('GET', `/api/products/${id}`);
        state.selectedProduct = data;
        renderProductDetail(data);
        showScreen('screen-product-detail');
    } catch(e) {
        showToast('Greška pri učitavanju proizvoda', 'error');
    } finally {
        setLoading(false);
    }
}

function renderProductDetail(p) {
    const el = document.getElementById('product-detail-content');
    const photos = p.photos || [];
    const farmer = p.farmer || {};
    const user = farmer.user || {};

    const heroContent = photos.length
        ? `<div class="gallery" id="pd-gallery" style="position:relative;">
            <div class="gallery-track" id="pd-gallery-track" style="height:420px;overflow-x:auto;scroll-snap-type:x mandatory;display:flex;">
                ${photos.map(ph => `<div style="min-width:100%;height:420px;scroll-snap-align:start;flex-shrink:0;overflow:hidden;"><img src="${esc(ph.url)}" alt="${esc(p.name)}" style="width:100%;height:100%;object-fit:cover;"></div>`).join('')}
            </div>
            ${photos.length > 1 ? `<div style="position:absolute;bottom:18px;left:0;right:0;display:flex;justify-content:center;gap:6px;">${photos.map((_, i) => `<div class="gallery-dot${i===0?' active':''}" data-gallery="pd-gallery" data-idx="${i}" style="width:${i===0?18:6}px;height:6px;border-radius:100px;background:${i===0?'#fff':'rgba(255,255,255,0.5)'};transition:width .2s;"></div>`).join('')}</div>` : ''}
           </div>`
        : `<div style="height:420px;background:#e8efe4;display:flex;align-items:center;justify-content:center;font-size:80px;">${productEmoji(p.name, p.category)}</div>`;

    const freshBadge = p.freshToday
        ? `<div style="position:absolute;top:120px;left:22px;padding:6px 12px;border-radius:100px;background:#2a2218;color:#fff;font-family:var(--font-sans);font-size:10.5px;font-weight:600;letter-spacing:1px;text-transform:uppercase;display:flex;align-items:center;gap:6px;"><span style="width:6px;height:6px;border-radius:100px;background:#8ac878;display:inline-block;"></span>Svježe danas</div>`
        : '';

    const categoryLabel = p.category
        ? `<div style="font-family:var(--font-sans);font-size:11.5px;font-weight:600;color:#c06643;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px;">${esc(p.category)}</div>`
        : '';

    const farmerCard = farmer.id ? `
        <div style="display:flex;align-items:center;gap:14px;padding:14px;border-radius:16px;background:#fff;border:1px solid #e4ddd0;cursor:pointer;margin-bottom:24px;">
            <div onclick="loadFarmerProfile(${farmer.id})" style="display:flex;align-items:center;gap:14px;flex:1;min-width:0;">
                ${farmer.avatarUrl
                    ? `<img src="${esc(farmer.avatarUrl)}" style="width:52px;height:52px;border-radius:16px;object-fit:cover;flex-shrink:0;">`
                    : `<div style="width:52px;height:52px;border-radius:16px;background:#e8efe4;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">🧑‍🌾</div>`}
                <div style="flex:1;min-width:0;">
                    <div style="font-family:var(--font-sans);font-size:10.5px;color:#7a6f5f;letter-spacing:0.8px;text-transform:uppercase;font-weight:600;margin-bottom:2px;">Sa gazdinstva</div>
                    <div style="font-family:var(--font-serif);font-size:17px;font-weight:500;color:#2a2218;letter-spacing:-0.2px;">${esc(farmer.farmName || '')}</div>
                    <div style="font-size:11.5px;color:#7a6f5f;margin-top:2px;">${esc(farmer.location || 'Prnjavor, BiH')}</div>
                </div>
            </div>
            <button onclick="typeof showChatWithFarmer==='function'&&showChatWithFarmer(${farmer.id})" style="width:40px;height:40px;border-radius:100px;border:1px solid #e4ddd0;background:#faf6ef;color:#1f1a14;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </button>
        </div>` : '';

    el.innerHTML = `
        <div style="position:relative;flex-shrink:0;">
            ${heroContent}
            ${freshBadge}
            <div style="position:absolute;top:58px;left:0;right:0;display:flex;justify-content:space-between;padding:0 16px;z-index:10;">
                <button onclick="goBack()" style="width:40px;height:40px;border-radius:100px;border:none;background:rgba(26,20,16,0.55);backdrop-filter:blur(8px);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="19" height="19"><path d="m15 18-6-6 6-6"/></svg>
                </button>
            </div>
        </div>

        <div style="margin-top:-22px;background:#faf6ef;border-radius:24px 24px 0 0;padding:24px 22px 120px;position:relative;">
            ${categoryLabel}
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:14px;">
                <h1 style="font-family:var(--font-serif);font-size:28px;font-weight:500;line-height:1.1;margin:0;color:#2a2218;letter-spacing:-0.6px;flex:1;">${esc(p.name)}</h1>
                <div style="text-align:right;flex-shrink:0;">
                    <div style="font-family:var(--font-serif);font-size:26px;font-weight:500;color:#2a2218;line-height:1;">${formatPrice(p.price, p.priceUnit)}</div>
                    <div style="font-size:11px;color:#7a6f5f;margin-top:4px;">/ ${esc(p.priceUnit || 'kg')}</div>
                </div>
            </div>

            ${p.freshToday ? `<div style="display:inline-flex;align-items:center;gap:4px;background:#fef3c7;color:#92400e;font-family:var(--font-sans);font-size:11px;font-weight:600;padding:4px 10px;border-radius:100px;margin-bottom:18px;">🌞 Svježe danas</div>` : ''}

            ${farmerCard}

            ${p.description ? `
            <div style="font-family:var(--font-sans);font-size:11.5px;font-weight:700;color:#7a6f5f;letter-spacing:1.4px;text-transform:uppercase;margin-bottom:12px;">Opis</div>
            <p style="font-family:var(--font-serif);font-size:15.5px;line-height:1.6;color:#1f1a14;margin:0 0 22px;">${esc(p.description)}</p>` : ''}

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1px;background:#ece5d6;border-radius:12px;overflow:hidden;border:1px solid #ece5d6;margin-bottom:24px;">
                <div style="padding:14px;background:#fff;">
                    <div style="font-size:10.5px;font-weight:600;color:#7a6f5f;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Dostava</div>
                    <div style="font-family:var(--font-serif);font-size:15px;font-weight:500;color:#2a2218;">2–3 dana</div>
                </div>
                <div style="padding:14px;background:#fff;">
                    <div style="font-size:10.5px;font-weight:600;color:#7a6f5f;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Preuzimanje</div>
                    <div style="font-family:var(--font-serif);font-size:15px;font-weight:500;color:#2a2218;">Moguće</div>
                </div>
            </div>
        </div>

        <div style="position:sticky;bottom:0;left:0;right:0;padding:14px 18px 18px;background:#faf6ef;border-top:1px solid #ece5d6;display:flex;gap:10px;">
            ${buildContactBtns(user.phone, user.viber, user.whatsapp)}
        </div>
    `;

    if (photos.length > 1) setupGallery('pd-gallery');
}

// =====================================================================
// GALLERY SWIPE
// =====================================================================
function setupGallery(galleryId, onSlide) {
    const gallery = document.getElementById(galleryId);
    if (!gallery) return;
    const track = gallery.querySelector('.gallery-track');
    const dots = gallery.querySelectorAll(`.gallery-dot`);
    if (!track) return;

    let startX = 0, isDragging = false;

    track.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
        isDragging = true;
    }, { passive: true });

    track.addEventListener('touchend', e => {
        if (!isDragging) return;
        const diff = startX - e.changedTouches[0].clientX;
        const slides = track.children;
        const slideW = track.offsetWidth;
        const current = Math.round(track.scrollLeft / slideW);
        let next = current;
        if (diff > 40) next = Math.min(current + 1, slides.length - 1);
        else if (diff < -40) next = Math.max(current - 1, 0);
        track.scrollTo({ left: next * slideW, behavior: 'smooth' });
        dots.forEach((d, i) => d.classList.toggle('active', i === next));
        if (onSlide) onSlide(next);
        isDragging = false;
    }, { passive: true });
}

// =====================================================================
// CONTACT BUTTONS
// =====================================================================
function buildContactBtns(phone, viber, whatsapp) {
    let html = '';
    if (phone) html += `<button class="btn-call" onclick="window.location='tel:${esc(phone)}'">📞 Pozovi</button>`;
    if (viber) html += `<button class="btn-viber" onclick="window.location='viber://chat?number=${esc(viber.replace(/\D/g,''))}'">💜 Viber</button>`;
    if (whatsapp) html += `<button class="btn-whatsapp" onclick="window.open('https://wa.me/${esc(whatsapp.replace(/\D/g,''))}','_blank')">💚 WhatsApp</button>`;
    if (!phone && !viber && !whatsapp) html = `<div style="flex:1;text-align:center;color:var(--color-text-muted);font-size:14px;">Nema kontakt podataka</div>`;
    return html;
}

// =====================================================================
// CHAT / CONTACT SHEET
// =====================================================================
function showChatWithFarmer(farmerId) {
    const farmer = state.selectedFarmer?.id === farmerId
        ? state.selectedFarmer
        : state.selectedProduct?.farmer?.id === farmerId
        ? state.selectedProduct.farmer
        : state.farmers.find(f => f.id === farmerId);
    const user = farmer?.user || {};

    const existing = document.getElementById('contact-sheet-overlay');
    if (existing) existing.remove();

    const overlay = document.createElement('div');
    overlay.id = 'contact-sheet-overlay';
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(42,34,24,0.5);z-index:500;display:flex;align-items:flex-end;';
    overlay.addEventListener('click', e => { if (e.target === overlay) overlay.remove(); });

    const farmName = esc(farmer?.farmName || 'farmera');
    const phoneBtn = user.phone
        ? `<a href="tel:${esc(user.phone)}" style="display:flex;align-items:center;gap:14px;padding:16px 20px;text-decoration:none;color:#1f1a14;border-bottom:1px solid #ece5d6;">
            <span style="width:42px;height:42px;border-radius:12px;background:#e8efe4;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">📞</span>
            <div><div style="font-family:var(--font-sans);font-size:15px;font-weight:600;">Pozovi</div><div style="font-size:12px;color:#7a6f5f;">${esc(user.phone)}</div></div>
          </a>` : '';
    const viberBtn = user.viber
        ? `<a href="viber://chat?number=${esc(user.viber.replace(/\D/g,''))}" style="display:flex;align-items:center;gap:14px;padding:16px 20px;text-decoration:none;color:#1f1a14;border-bottom:1px solid #ece5d6;">
            <span style="width:42px;height:42px;border-radius:12px;background:#ede9fc;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">💜</span>
            <div><div style="font-family:var(--font-sans);font-size:15px;font-weight:600;">Viber</div><div style="font-size:12px;color:#7a6f5f;">${esc(user.viber)}</div></div>
          </a>` : '';
    const waBtn = user.whatsapp
        ? `<a href="https://wa.me/${esc(user.whatsapp.replace(/\D/g,''))}" target="_blank" style="display:flex;align-items:center;gap:14px;padding:16px 20px;text-decoration:none;color:#1f1a14;border-bottom:1px solid #ece5d6;">
            <span style="width:42px;height:42px;border-radius:12px;background:#dcf5e7;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">💚</span>
            <div><div style="font-family:var(--font-sans);font-size:15px;font-weight:600;">WhatsApp</div><div style="font-size:12px;color:#7a6f5f;">${esc(user.whatsapp)}</div></div>
          </a>` : '';

    if (!phoneBtn && !viberBtn && !waBtn) {
        showToast('Farmer nema kontakt podataka');
        return;
    }

    overlay.innerHTML = `
        <div style="width:100%;max-width:480px;margin:0 auto;background:#faf6ef;border-radius:24px 24px 0 0;overflow:hidden;padding-bottom:env(safe-area-inset-bottom,0);">
            <div style="padding:20px 20px 4px;border-bottom:1px solid #ece5d6;">
                <div style="width:36px;height:4px;border-radius:2px;background:#e4ddd0;margin:0 auto 16px;"></div>
                <div style="font-family:var(--font-sans);font-size:11.5px;font-weight:600;color:#a89a85;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:4px;">Kontaktiraj</div>
                <div style="font-family:var(--font-serif);font-size:20px;font-weight:500;color:#2a2218;">${farmName}</div>
            </div>
            ${phoneBtn}${viberBtn}${waBtn}
            <button onclick="document.getElementById('contact-sheet-overlay').remove()" style="width:100%;padding:16px;background:none;border:none;font-family:var(--font-sans);font-size:15px;font-weight:600;color:#7a6f5f;cursor:pointer;">Zatvori</button>
        </div>`;

    document.body.appendChild(overlay);
}

// =====================================================================
// SEARCH
// =====================================================================
let searchDebounce = null;

function onSearchInput() {
    const q = document.getElementById('search-input').value;
    state.searchQuery = q;
    state.browseAll = false;
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(doSearch, 300);
}

function onSearchFreshToggle() {
    state.freshOnly = document.getElementById('search-fresh-toggle').checked;
    doSearch();
}

function selectSearchCategory(btn, cat) {
    document.querySelectorAll('#search-chips .chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    state.selectedCategory = cat;
    doSearch();
}

async function doSearch() {
    const q = state.searchQuery;
    const category = state.selectedCategory;
    const freshOnly = state.freshOnly;

    if (!state.browseAll && !q && !category && !freshOnly) {
        document.getElementById('search-results').innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <div class="empty-state-text">Unesite pojam za pretragu</div>
                <div class="empty-state-sub">ili pregledajte po kategoriji</div>
            </div>`;
        return;
    }

    let url = '/api/search?';
    if (q) url += `q=${encodeURIComponent(q)}&`;
    if (category) url += `category=${encodeURIComponent(category)}&`;
    if (freshOnly) url += 'freshOnly=1&';

    try {
        const data = await api('GET', url);
        state.searchResults = data;
        renderSearchResults(data);
    } catch(e) {
        showToast('Greška pri pretrazi', 'error');
    }
}

function renderSearchResults(data) {
    const el = document.getElementById('search-results');
    const farmers = data.farmers || [];
    const products = data.products || [];

    if (!farmers.length && !products.length) {
        el.innerHTML = `<div class="empty-state"><div class="empty-state-icon">😔</div><div class="empty-state-text">Nema rezultata</div><div class="empty-state-sub">Pokušajte s drugim pojmom</div></div>`;
        return;
    }

    let html = '';
    if (farmers.length) {
        html += `<div style="font-size:14px;font-weight:700;color:var(--color-text-muted);margin-bottom:8px;margin-top:4px;">FARMERI (${farmers.length})</div>`;
        html += `<div style="display:flex;gap:10px;overflow-x:auto;-webkit-overflow-scrolling:touch;margin-bottom:16px;padding-bottom:4px;scrollbar-width:none;">`;
        html += farmers.map(f => farmerCardHtml(f)).join('');
        html += '</div>';
    }
    if (products.length) {
        const productTotal = data.productTotal ?? products.length;
        html += `<div style="font-size:14px;font-weight:700;color:var(--color-text-muted);margin-bottom:8px;">PROIZVODI (${productTotal})</div>`;
        html += `<div style="display:flex;flex-direction:column;gap:10px;">`;
        html += products.map(p => productCardHtml(p)).join('');
        html += '</div>';
    }

    el.innerHTML = html;
}

// =====================================================================
// AUTH — LOGIN
// =====================================================================
async function submitLogin() {
    clearErrors(['login-email-err', 'login-password-err']);
    const email = document.getElementById('login-email').value.trim();
    const password = document.getElementById('login-password').value;
    let valid = true;
    if (!email) { showErr('login-email-err', 'Email je obavezan'); valid = false; }
    if (!password) { showErr('login-password-err', 'Lozinka je obavezna'); valid = false; }
    if (!valid) return;

    setLoading(true);
    try {
        const user = await api('POST', '/api/auth/login', { email, password });
        state.auth = user;
        localStorage.setItem('agroapp_state', JSON.stringify({ auth: state.auth, farmers: state.farmers, categories: state.categories }));
        updateAuthButton();
        showToast(`Dobrodošli, ${user.name}!`);
        if (user.role === 'admin') {
            showAdminScreen();
        } else if (user.role === 'farmer' && !user.onboardingStep) {
            showFarmerDashboard();
        } else if (user.onboardingStep) {
            resumeOnboarding();
        } else {
            showScreen('screen-home');
        }
    } catch(e) {
        if (e.status === 401) {
            showErr('login-password-err', 'Neispravni email ili lozinka');
        } else {
            showToast(e.message, 'error');
        }
    } finally {
        setLoading(false);
    }
}

async function doLogout() {
    setLoading(true);
    try {
        await api('POST', '/api/auth/logout');
    } catch(e) {}
    state.auth = null;
    localStorage.removeItem('agroapp_state');
    updateAuthButton();
    document.getElementById('nav-farmer').classList.add('hidden');
    document.getElementById('nav-customer').classList.remove('hidden');
    showScreen('screen-home', false);
    setLoading(false);
    showToast('Odjavljeni ste');
}

// =====================================================================
// AUTH — SIGNUP / ONBOARDING
// =====================================================================
function setSignupStep(step) {
    [1,2,3,4].forEach(s => {
        const el = document.getElementById(`signup-step-${s}`);
        if (el) el.style.display = s === step ? '' : 'none';
        const dot = document.getElementById(`step-dot-${s}`);
        if (dot) {
            dot.className = 'step-dot ' + (s < step ? 'done' : s === step ? 'active' : 'pending');
        }
        if (s < 4) {
            const line = document.getElementById(`step-line-${s}`);
            if (line) line.className = 'step-line ' + (s < step ? 'done' : '');
        }
    });
    const screen = document.getElementById('screen-farmer-signup');
    if (screen) screen.scrollTo(0, 0);
}

async function submitSignupStep1() {
    clearErrors(['reg-name-err','reg-email-err','reg-password-err','reg-password2-err']);
    const name = document.getElementById('reg-name').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    const password = document.getElementById('reg-password').value;
    const password2 = document.getElementById('reg-password2').value;
    let valid = true;
    if (!name) { showErr('reg-name-err','Ime je obavezno'); valid=false; }
    if (!email || !email.includes('@')) { showErr('reg-email-err','Unesite ispravni email'); valid=false; }
    if (!password || password.length < 8) { showErr('reg-password-err','Lozinka mora imati min. 8 znakova'); valid=false; }
    if (password !== password2) { showErr('reg-password2-err','Lozinke se ne poklapaju'); valid=false; }
    if (!valid) return;

    setLoading(true);
    try {
        const user = await api('POST', '/api/auth/register', {
            name, email, password, password_confirmation: password2
        });
        state.auth = user;
        updateAuthButton();
        setSignupStep(2);
    } catch(e) {
        if (e.errors) {
            if (e.errors.email) showErr('reg-email-err', e.errors.email[0]);
            if (e.errors.password) showErr('reg-password-err', e.errors.password[0]);
        } else {
            showToast(e.message, 'error');
        }
    } finally {
        setLoading(false);
    }
}

async function submitSignupStep2() {
    clearErrors(['contact-phone-err']);
    const phone = document.getElementById('contact-phone').value.trim();
    if (!phone) { showErr('contact-phone-err','Telefon je obavezan'); return; }
    const viber = document.getElementById('contact-viber-toggle').checked ? phone : null;
    const whatsapp = document.getElementById('contact-wa-toggle').checked ? phone : null;

    setLoading(true);
    try {
        const user = await api('POST', '/api/onboarding/step/2', { phone, viber, whatsapp });
        state.auth = user;
        setSignupStep(3);
    } catch(e) {
        showToast(e.message, 'error');
    } finally {
        setLoading(false);
    }
}

async function submitSignupStep3() {
    clearErrors(['farm-name-err', 'farm-city-err']);
    const farmName = document.getElementById('farm-name').value.trim();
    const city     = document.getElementById('farm-city').value;
    if (!farmName) { showErr('farm-name-err', 'Naziv gazdinstva je obavezan'); return; }
    if (!city)     { showErr('farm-city-err', 'Odaberite grad'); return; }
    const address     = document.getElementById('farm-address').value.trim();
    const description = document.getElementById('farm-description').value.trim();

    setLoading(true);
    try {
        const user = await api('POST', '/api/onboarding/step/3', { farmName, city, address, description });
        state.auth = user;
        setSignupStep(4);
    } catch(e) {
        showToast(e.message, 'error');
    } finally {
        setLoading(false);
    }
}

function handleFarmPhotosSelected() {
    const input = document.getElementById('farm-photos-input');
    const files = Array.from(input.files);
    state.pendingFarmPhotos = [...state.pendingFarmPhotos, ...files].slice(0, 30);
    renderFarmPhotoGrid();
}

function renderFarmPhotoGrid() {
    const grid = document.getElementById('farm-photos-grid');
    const photos = state.pendingFarmPhotos;
    let html = photos.map((f, i) => {
        const url = URL.createObjectURL(f);
        return `<div class="photo-slot"><img src="${url}" alt="foto"><button onclick="removeFarmPhoto(${i})" style="position:absolute;top:4px;right:4px;width:20px;height:20px;background:rgba(0,0,0,0.6);color:#fff;border:none;border-radius:50%;cursor:pointer;font-size:12px;">×</button></div>`;
    }).join('');
    if (photos.length < 30) html += `<div class="photo-slot" onclick="document.getElementById('farm-photos-input').click()"><span class="add-icon">+</span></div>`;
    grid.innerHTML = html;
}

function removeFarmPhoto(idx) {
    state.pendingFarmPhotos.splice(idx, 1);
    renderFarmPhotoGrid();
}

async function submitSignupComplete() {
    setLoading(true);
    try {
        if (state.pendingFarmPhotos.length > 0) {
            const fd = new FormData();
            state.pendingFarmPhotos.forEach(f => fd.append('photos[]', f));
            await api('POST', '/api/onboarding/step/4', fd);
        }
        const user = await api('POST', '/api/onboarding/complete');
        state.auth = user;
        localStorage.setItem('agroapp_state', JSON.stringify({ auth: state.auth, farmers: state.farmers, categories: state.categories }));
        state.pendingFarmPhotos = [];
        showToast('Profil je objavljen! Dobrodošli na AgroApp!');
        showFarmerDashboard();
    } catch(e) {
        showToast(e.message, 'error');
    } finally {
        setLoading(false);
    }
}

function resumeOnboarding() {
    const step = state.auth.onboardingStep || 1;
    showScreen('screen-farmer-signup');
    setSignupStep(step);
}

// =====================================================================
// FARMER DASHBOARD
// =====================================================================
async function showFarmerDashboard(tab) {
    showScreen('screen-farmer-dashboard');
    document.getElementById('nav-farmer').classList.remove('hidden');
    document.getElementById('nav-customer').classList.add('hidden');

    const user = state.auth;
    if (!user) return;
    const profile = user.farmerProfile || {};

    const avatarHtml = profile.avatarUrl
        ? `<img src="${esc(profile.avatarUrl)}" class="avatar-circle" style="width:72px;height:72px;">`
        : `<div class="avatar-circle" style="width:72px;height:72px;background:var(--color-primary-subtle);font-size:28px;">🧑‍🌾</div>`;

    document.getElementById('dashboard-content').innerHTML = `
        <div id="dash-tab-profil" class="dash-tab-panel">
            <div style="padding:16px;">
                <div class="card" style="padding:16px;display:flex;gap:14px;align-items:center;margin-bottom:16px;">
                    ${avatarHtml}
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:17px;font-weight:700;">${esc(profile.farmName || user.name)}</div>
                        <div style="font-size:13px;color:var(--color-text-muted);">${esc(profile.location || '')}</div>
                        <div style="font-size:12px;color:var(--color-text-muted);">Član od ${profile.createdAt ? profile.createdAt.substring(0,7) : '—'}</div>
                    </div>
                    <button class="btn-ghost" style="width:auto;padding:8px 14px;font-size:13px;" onclick="editFarmerProfile()">Uredi</button>
                </div>

                ${profile.description ? `<div class="card" style="padding:14px;margin-bottom:16px;">
                    <div style="font-size:12px;font-weight:600;color:var(--color-text-muted);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">O farmi</div>
                    <div style="font-size:14px;color:var(--color-text-primary);line-height:1.6;">${esc(profile.description)}</div>
                </div>` : ''}

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;">
                    <div class="card" style="padding:14px;">
                        <div style="font-size:12px;color:var(--color-text-muted);margin-bottom:4px;">Telefon</div>
                        <div style="font-size:14px;font-weight:600;">${user.phone ? esc(user.phone) : '—'}</div>
                    </div>
                    <div class="card" style="padding:14px;">
                        <div style="font-size:12px;color:var(--color-text-muted);margin-bottom:4px;">Viber / WhatsApp</div>
                        <div style="font-size:13px;font-weight:600;">${(user.viber || user.whatsapp) ? 'Aktivno' : '—'}</div>
                    </div>
                </div>

                <button class="btn-ghost" style="width:100%;margin-top:4px;" onclick="editFarmerProfile()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" style="vertical-align:middle;margin-right:6px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Uredi profil farme
                </button>
            </div>
        </div>

        <div id="dash-tab-proizvodi" class="dash-tab-panel" style="display:none;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 16px 8px;">
                <div class="section-title" style="padding:0;">Moji proizvodi</div>
                <button class="btn-primary" style="width:auto;padding:8px 16px;font-size:13px;" onclick="openProductEditor(null)">+ Novi</button>
            </div>
            <div id="my-products-list">
                <div style="padding:16px;color:var(--color-text-muted);font-size:14px;">Učitavam...</div>
            </div>
        </div>

        <div id="dash-tab-podrska" class="dash-tab-panel" style="display:none;">
            <div style="padding:16px;">
                <div class="card" style="padding:20px;margin-bottom:16px;">
                    <div style="font-size:16px;font-weight:700;margin-bottom:8px;">Podrška i kontakt</div>
                    <div style="font-size:14px;color:var(--color-text-muted);line-height:1.6;">Imate pitanje ili problem? Kontaktirajte nas putem jednog od navedenih kanala — odgovaramo radnim danima.</div>
                </div>
                <div class="card" style="padding:16px;margin-bottom:12px;display:flex;align-items:center;gap:14px;cursor:pointer;" onclick="window.location='tel:+38765000001'">
                    <div style="width:42px;height:42px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">📞</div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">Telefon</div>
                        <div style="font-size:13px;color:var(--color-text-muted);">+387 65 000 001</div>
                        <div style="font-size:12px;color:var(--color-text-muted);">Pon–Pet, 8:00–16:00</div>
                    </div>
                </div>
                <div class="card" style="padding:16px;margin-bottom:12px;display:flex;align-items:center;gap:14px;cursor:pointer;" onclick="window.location='mailto:podrska@agroapp.ba'">
                    <div style="width:42px;height:42px;background:#dbeafe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">✉️</div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">E-mail</div>
                        <div style="font-size:13px;color:var(--color-text-muted);">podrska@agroapp.ba</div>
                        <div style="font-size:12px;color:var(--color-text-muted);">Odgovaramo u roku od 24h</div>
                    </div>
                </div>
                <div class="card" style="padding:16px;display:flex;align-items:center;gap:14px;cursor:pointer;" onclick="window.open('https://viber.com/agroapp')">
                    <div style="width:42px;height:42px;background:#f3e8ff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">💬</div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">Viber poruka</div>
                        <div style="font-size:13px;color:var(--color-text-muted);">+387 65 000 001</div>
                        <div style="font-size:12px;color:var(--color-text-muted);">Najbrži odgovor</div>
                    </div>
                </div>
                <div style="margin-top:20px;padding:14px;background:var(--color-surface-alt);border-radius:10px;font-size:13px;color:var(--color-text-muted);text-align:center;line-height:1.5;">
                    Verzija aplikacije: 1.0<br>AgroApp © 2025 — Tržnica domaćih proizvoda RS
                </div>
            </div>
        </div>
    `;

    showDashboardTab(tab || 'profil', false);
    loadMyProducts();
}

function showDashboardTab(tab, navigate) {
    if (navigate !== false) {
        showScreen('screen-farmer-dashboard');
        document.getElementById('nav-farmer').classList.remove('hidden');
        document.getElementById('nav-customer').classList.add('hidden');
        if (!document.getElementById('dash-tab-profil')) {
            showFarmerDashboard(tab);
            return;
        }
    }
    ['profil','proizvodi','podrska'].forEach(t => {
        const el = document.getElementById(`dash-tab-${t}`);
        if (el) el.style.display = t === tab ? '' : 'none';
    });
    const navIdx = { profil: 0, proizvodi: 1, podrska: 3 };
    if (navIdx[tab] !== undefined) setNavActive('nav-farmer', navIdx[tab]);
}

async function loadMyProducts() {
    try {
        const data = await api('GET', '/api/farmer/products');
        state.myProducts = data;
        renderMyProducts(data);
    } catch(e) {
        console.warn(e);
    }
}

function renderMyProducts(products) {
    const el = document.getElementById('my-products-list');
    if (!el) return;
    if (!products.length) {
        el.innerHTML = `<div class="empty-state"><div class="empty-state-icon">🛒</div><div class="empty-state-text">Nema proizvoda</div><div class="empty-state-sub">Dodajte vaš prvi proizvod</div></div>`;
        return;
    }
    el.innerHTML = products.map(p => myProductRowHtml(p)).join('');
}

function myProductRowHtml(p) {
    const thumb = p.photos && p.photos.length
        ? `<img src="${esc(p.photos[0].url)}" class="my-product-thumb">`
        : `<div class="my-product-thumb">${productEmoji(p.name, p.category)}</div>`;
    return `<div class="my-product-row">
        ${thumb}
        <div style="flex:1;min-width:0;">
            <div style="font-size:14px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(p.name)}</div>
            <div style="font-size:13px;color:var(--color-primary);font-weight:600;">${formatPrice(p.price, p.priceUnit)}</div>
        </div>
        <button onclick="showFreshSheet(${p.id})" style="margin-right:6px;flex-shrink:0;border:none;background:none;padding:0;cursor:pointer;" title="Postavi svježinu">
            ${freshStatusBadge(p)}
        </button>
        <button class="icon-btn" onclick="openProductEditor(${p.id})" title="Uredi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
        <button class="icon-btn" data-pid="${p.id}" onclick="quickDeleteProduct(+this.dataset.pid)" title="Obriši" style="color:#dc2626;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </button>
    </div>`;
}

async function showMyProducts() {
    showDashboardTab('proizvodi');
}

// =====================================================================
// PRODUCT EDITOR
// =====================================================================
function openProductEditor(productId) {
    state.editingProduct = productId ? state.myProducts.find(p => p.id === productId) || null : null;
    state.editingProductId = productId || null;
    state.pendingProductPhotos = [];
    state.pendingFreshHours = null;
    state.selectedPresetEmoji = null;
    state.selectedPresetBg = null;

    document.getElementById('product-edit-title').textContent = productId ? 'Uredi proizvod' : 'Novi proizvod';
    document.getElementById('delete-product-btn').style.display = productId ? '' : 'none';

    // Reset form
    document.getElementById('pe-name').value = state.editingProduct?.name || '';
    document.getElementById('pe-category').value = state.editingProduct?.category || '';
    document.getElementById('pe-price').value = state.editingProduct?.price || '';
    document.getElementById('pe-unit').value = state.editingProduct?.priceUnit || 'kg';
    document.getElementById('pe-description').value = state.editingProduct?.description || '';
    renderFreshSection(state.editingProduct);

    // Reset photo slots
    for (let i = 0; i < 5; i++) {
        const slot = document.getElementById(`product-edit-photo-${i}`);
        if (!slot) continue;
        slot.innerHTML = `<span class="add-icon" style="${i>0?'font-size:20px':''}">+</span>`;
    }

    // Fill existing photos
    if (state.editingProduct?.photos) {
        state.editingProduct.photos.slice(0, 5).forEach((photo, i) => {
            const slot = document.getElementById(`product-edit-photo-${i}`);
            if (slot) slot.innerHTML = `<img src="${esc(photo.url)}" style="width:100%;height:100%;object-fit:cover;">`;
        });
    }

    document.getElementById('product-edit-photo-count').textContent = `${state.editingProduct?.photos?.length || 0}/5`;
    clearErrors(['pe-name-err','pe-category-err','pe-price-err']);

    // Show presets for new products without photos
    const hasPhotos = (state.editingProduct?.photos?.length || 0) > 0;
    renderProductPresets(hasPhotos ? null : (state.editingProduct?.category || ''));

    showScreen('screen-product-edit');
}

const PRODUCT_PRESETS = {
    povrce:    ['🥕','🥦','🌽','🍅','🥒','🧅','🥬','🌶️'],
    voce:      ['🍎','🍓','🍇','🍑','🍒','🍋','🍊','🍈'],
    mlijeko:   ['🥛','🧀','🫙','🍶'],
    meso:      ['🥩','🍗','🥚','🌭'],
    jaja:      ['🥚','🍳'],
    med:       ['🍯','🐝'],
    zitarice:  ['🌾','🍞','🥖','🫓'],
    rakija:    ['🫙','🍶','🥃'],
    zimnica:   ['🫙','🥫','🫑','🧄'],
    ostalo:    ['🌿','🫚','🛒','🌱'],
};

function onPeCategoryChange(cat) {
    const hasPhotos = (state.editingProduct?.photos?.length || 0) > 0 || state.pendingProductPhotos?.length > 0;
    if (!hasPhotos && !state.selectedPresetEmoji) renderProductPresets(cat);
}

function renderProductPresets(category) {
    const section = document.getElementById('pe-presets-section');
    const grid = document.getElementById('pe-presets-grid');
    if (!section || !grid) return;

    if (!category) { section.style.display = 'none'; return; }

    const emojis = PRODUCT_PRESETS[category] || PRODUCT_PRESETS.ostalo;
    const bgColors = ['#fef9c3','#dcfce7','#dbeafe','#fce7f3','#ede9fe','#ffedd5','#d1fae5','#fef3c7'];
    grid.innerHTML = emojis.map((em, i) => `
        <div onclick="selectProductPreset('${em}','${bgColors[i % bgColors.length]}')"
             style="width:52px;height:52px;border-radius:10px;background:${bgColors[i % bgColors.length]};display:flex;align-items:center;justify-content:center;font-size:26px;cursor:pointer;border:2px solid transparent;transition:border-color .15s;"
             id="preset-btn-${i}" title="Odaberi preset">
            ${em}
        </div>
    `).join('');
    section.style.display = '';
}

function selectProductPreset(emoji, bg) {
    state.selectedPresetEmoji = emoji;
    state.selectedPresetBg = bg;
    const slot0 = document.getElementById('product-edit-photo-0');
    if (slot0) {
        slot0.innerHTML = `<div style="width:100%;height:100%;background:${bg};display:flex;align-items:center;justify-content:center;font-size:52px;border-radius:8px;">${emoji}</div>`;
    }
    document.getElementById('pe-presets-section').style.display = 'none';
}

function triggerProductPhotoInput() {
    document.getElementById('product-photos-input').click();
}

function handleProductPhotosSelected() {
    const input = document.getElementById('product-photos-input');
    const files = Array.from(input.files);
    const existingCount = state.editingProduct?.photos?.length || 0;
    const available = 5 - existingCount;
    state.pendingProductPhotos = [...state.pendingProductPhotos, ...files].slice(0, available);

    const offset = existingCount;
    state.pendingProductPhotos.forEach((f, i) => {
        const idx = offset + i;
        if (idx >= 5) return;
        const slot = document.getElementById(`product-edit-photo-${idx}`);
        if (slot) {
            const url = URL.createObjectURL(f);
            slot.innerHTML = `<img src="${url}" style="width:100%;height:100%;object-fit:cover;">`;
        }
    });
    const total = existingCount + state.pendingProductPhotos.length;
    document.getElementById('product-edit-photo-count').textContent = `${total}/5`;
    // Hide presets once a real photo is selected
    const ps = document.getElementById('pe-presets-section');
    if (ps) ps.style.display = 'none';
    state.selectedPresetEmoji = null;
}

async function saveProduct() {
    clearErrors(['pe-name-err','pe-category-err','pe-price-err']);
    const name = document.getElementById('pe-name').value.trim();
    const category = document.getElementById('pe-category').value;
    const price = document.getElementById('pe-price').value;
    let valid = true;
    if (!name) { showErr('pe-name-err','Naziv je obavezan'); valid=false; }
    if (!category) { showErr('pe-category-err','Kategorija je obavezna'); valid=false; }
    if (!price || parseFloat(price) < 0) { showErr('pe-price-err','Unesite ispravnu cijenu'); valid=false; }
    if (!valid) return;

    const description = document.getElementById('pe-description').value.trim();
    const priceUnit = document.getElementById('pe-unit').value;

    setLoading(true);
    try {
        let savedProduct = null;
        if (state.pendingProductPhotos.length > 0) {
            const fd = new FormData();
            fd.append('name', name);
            fd.append('category', category);
            fd.append('price', price);
            fd.append('priceUnit', priceUnit);
            fd.append('description', description);
            state.pendingProductPhotos.forEach(f => fd.append('photos[]', f));

            if (state.editingProduct) {
                fd.append('_method', 'PATCH');
                savedProduct = await api('POST', `/api/farmer/products/${state.editingProduct.id}`, fd);
            } else {
                savedProduct = await api('POST', '/api/farmer/products', fd);
            }
        } else {
            const payload = { name, category, price: parseFloat(price), priceUnit, description };
            if (state.editingProduct) {
                savedProduct = await api('PATCH', `/api/farmer/products/${state.editingProduct.id}`, payload);
            } else {
                savedProduct = await api('POST', '/api/farmer/products', payload);
            }
        }

        const wasNew = !state.editingProduct;
        showToast(wasNew ? 'Proizvod dodan' : 'Proizvod ažuriran');
        if (wasNew && state.pendingFreshHours && savedProduct?.id) {
            const fresh = state.pendingFreshHours;
            await api('PATCH', `/api/farmer/products/${savedProduct.id}/fresh`, { hours: fresh });
        }
        state.pendingFreshHours = null;
        state.editingProduct = null;
        state.editingProductId = null;
        state.selectedPresetEmoji = null;
        state.pendingProductPhotos = [];
        goBack();
        setTimeout(loadMyProducts, 300);
    } catch(e) {
        if (e.errors) {
            if (e.errors.name) showErr('pe-name-err', e.errors.name[0]);
            if (e.errors.category) showErr('pe-category-err', e.errors.category[0]);
            if (e.errors.price) showErr('pe-price-err', e.errors.price[0]);
        } else {
            showToast(e.message, 'error');
        }
    } finally {
        setLoading(false);
    }
}

async function confirmDeleteProduct() {
    const product = state.editingProduct;
    const productId = product?.id || state.editingProductId;
    if (!productId) return;
    const name = product?.name || 'ovaj proizvod';
    if (!confirm(`Obrisati "${name}"?`)) return;
    setLoading(true);
    try {
        await api('DELETE', `/api/farmer/products/${productId}`);
        state.myProducts = state.myProducts.filter(p => p.id !== productId);
        state.editingProduct = null;
        state.editingProductId = null;
        showToast('Proizvod obrisan');
        goBack();
        setTimeout(loadMyProducts, 300);
    } catch(e) {
        showToast(e.message, 'error');
    } finally {
        setLoading(false);
    }
}

async function quickDeleteProduct(productId) {
    const product = state.myProducts.find(p => p.id === productId);
    const name = product?.name || 'ovaj proizvod';
    if (!confirm(`Obrisati "${name}"?`)) return;
    setLoading(true);
    try {
        await api('DELETE', `/api/farmer/products/${productId}`);
        state.myProducts = state.myProducts.filter(p => p.id !== productId);
        showToast('Proizvod obrisan');
        renderMyProducts(state.myProducts);
    } catch(e) {
        showToast(e.message, 'error');
    } finally {
        setLoading(false);
    }
}

function freshStatusBadge(p) {
    if (p.freshToday && p.freshUntil) {
        const until = new Date(p.freshUntil);
        const now = new Date();
        const diffHours = (until - now) / 36e5;
        let label;
        if (diffHours <= 24) {
            const hh = until.getHours().toString().padStart(2,'0');
            const mm = until.getMinutes().toString().padStart(2,'0');
            label = `Do ${hh}:${mm}`;
        } else {
            const days = Math.ceil(diffHours / 24);
            label = `Još ${days} dana`;
        }
        return `<div style="display:inline-flex;align-items:center;gap:4px;background:#fef3c7;color:#92400e;font-size:11px;font-weight:600;padding:4px 8px;border-radius:20px;white-space:nowrap;">🌞 ${label}</div>`;
    }
    if (p.freshExpiredRecently) {
        return `<div style="display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;color:#B91C1C;font-size:11px;font-weight:600;padding:4px 8px;border-radius:20px;white-space:nowrap;">⚠️ Isteklo</div>`;
    }
    return `<div style="display:inline-flex;align-items:center;gap:3px;background:#f2ece0;color:#7a6f5f;font-size:11px;font-weight:600;padding:4px 8px;border-radius:20px;white-space:nowrap;">+ Svježe</div>`;
}

function renderFreshSection(product) {
    const el = document.getElementById('pe-fresh-section');
    if (!el) return;
    const productId = product?.id ?? null;
    const isFresh = product?.freshToday || false;
    const freshUntil = product?.freshUntil || null;
    const pending = state.pendingFreshHours;

    let statusLine = '';
    if (pending) {
        const labels = { today:'Danas do 20:00', '24':'Naredna 24 sata', '48':'Naredna 2 dana', '72':'Naredna 3 dana', '96':'Naredna 4 dana', '120':'Naredna 5 dana' };
        statusLine = `<div style="font-size:12px;color:#92400e;margin-top:4px;">✓ Postaviti: ${labels[pending] || pending}</div>`;
    } else if (isFresh && freshUntil) {
        const until = new Date(freshUntil);
        const diffH = (until - new Date()) / 36e5;
        const timeStr = diffH <= 24
            ? `do ${until.getHours().toString().padStart(2,'0')}:${until.getMinutes().toString().padStart(2,'0')}`
            : `još ${Math.ceil(diffH/24)} dana`;
        statusLine = `<div style="font-size:12px;color:#92400e;margin-top:4px;">Aktivno ${timeStr}</div>`;
    } else if (product?.freshExpiredRecently) {
        statusLine = `<div style="font-size:12px;color:#B91C1C;margin-top:4px;">⚠️ Svježina istekla — obnovite ako je još dostupno</div>`;
    }

    const btnLabel = (isFresh || pending) ? 'Promijeni' : 'Označi';

    el.innerHTML = `
        <div style="background:#FFFBEB;border:1.5px solid #FDE68A;border-radius:12px;padding:14px 16px;">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:14px;font-weight:600;color:#92400E;">🌞 Svježe danas</div>
                    <div style="font-size:12px;color:#B45309;">Označite koliko dugo je proizvod svjež</div>
                    ${statusLine}
                </div>
                <button onclick="showFreshSheet(${productId ?? 'null'}, true)" style="background:#F59E0B;color:#fff;border:none;border-radius:10px;padding:8px 14px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;">
                    ${btnLabel}
                </button>
            </div>
        </div>`;
}

function showFreshSheet(productId, fromEditor = false) {
    const overlay = document.createElement('div');
    overlay.id = 'fresh-sheet-overlay';
    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(42,34,24,0.55);z-index:1000;display:flex;align-items:flex-end;justify-content:center;';
    overlay.onclick = e => { if (e.target === overlay) overlay.remove(); };

    const p = fromEditor ? state.editingProduct : state.myProducts.find(p => p.id === productId);

    overlay.innerHTML = `
        <div style="width:100%;max-width:480px;background:#faf6ef;border-radius:24px 24px 0 0;padding:20px 20px calc(20px + env(safe-area-inset-bottom,0));">
            <div style="width:36px;height:4px;background:#e4ddd0;border-radius:2px;margin:0 auto 20px;"></div>
            <div style="font-family:var(--font-serif);font-size:18px;font-weight:500;color:#2a2218;margin-bottom:4px;">Označi kao svježe</div>
            <div style="font-size:13px;color:#7a6f5f;margin-bottom:20px;">Odaberite koliko dugo je ovaj proizvod dostupan kao svjež</div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <button onclick="setFreshUntil(${productId},'today',${fromEditor})" style="padding:14px 16px;background:#fff;border:1.5px solid #e4ddd0;border-radius:12px;font-size:14px;font-weight:600;color:#2a2218;cursor:pointer;text-align:left;display:flex;align-items:center;gap:10px;">
                    🌅 <span>Danas do 20:00</span>
                </button>
                <button onclick="setFreshUntil(${productId},'24',${fromEditor})" style="padding:14px 16px;background:#fff;border:1.5px solid #e4ddd0;border-radius:12px;font-size:14px;font-weight:600;color:#2a2218;cursor:pointer;text-align:left;display:flex;align-items:center;gap:10px;">
                    🕐 <span>Naredna 24 sata</span>
                </button>
                <button onclick="setFreshUntil(${productId},'48',${fromEditor})" style="padding:14px 16px;background:#fff;border:1.5px solid #e4ddd0;border-radius:12px;font-size:14px;font-weight:600;color:#2a2218;cursor:pointer;text-align:left;display:flex;align-items:center;gap:10px;">
                    🕑 <span>Naredna 2 dana</span>
                </button>
                <button onclick="setFreshUntil(${productId},'72',${fromEditor})" style="padding:14px 16px;background:#fff;border:1.5px solid #e4ddd0;border-radius:12px;font-size:14px;font-weight:600;color:#2a2218;cursor:pointer;text-align:left;display:flex;align-items:center;gap:10px;">
                    📅 <span>Naredna 3 dana</span>
                </button>
                <button onclick="setFreshUntil(${productId},'96',${fromEditor})" style="padding:14px 16px;background:#fff;border:1.5px solid #e4ddd0;border-radius:12px;font-size:14px;font-weight:600;color:#2a2218;cursor:pointer;text-align:left;display:flex;align-items:center;gap:10px;">
                    📅 <span>Naredna 4 dana</span>
                </button>
                <button onclick="setFreshUntil(${productId},'120',${fromEditor})" style="padding:14px 16px;background:#fff;border:1.5px solid #e4ddd0;border-radius:12px;font-size:14px;font-weight:600;color:#2a2218;cursor:pointer;text-align:left;display:flex;align-items:center;gap:10px;">
                    📅 <span>Naredna 5 dana</span>
                </button>
                ${p?.freshToday ? `<button onclick="setFreshUntil(${productId},'clear',${fromEditor})" style="padding:14px 16px;background:#FEF2F2;border:1.5px solid #FECACA;border-radius:12px;font-size:14px;font-weight:600;color:#B91C1C;cursor:pointer;text-align:left;display:flex;align-items:center;gap:10px;">
                    ✕ <span>Ukloni oznaku svježine</span>
                </button>` : ''}
            </div>
            <button onclick="document.getElementById('fresh-sheet-overlay').remove()" style="width:100%;padding:14px;background:none;border:none;font-size:15px;font-weight:600;color:#7a6f5f;cursor:pointer;margin-top:12px;">Zatvori</button>
        </div>`;

    document.body.appendChild(overlay);
}

async function setFreshUntil(productId, hours, fromEditor = false) {
    document.getElementById('fresh-sheet-overlay')?.remove();
    if (!productId) {
        // New product — store selection, apply after save
        state.pendingFreshHours = hours === 'clear' ? null : hours;
        if (fromEditor) renderFreshSection(state.editingProduct);
        return;
    }
    try {
        const data = await api('PATCH', `/api/farmer/products/${productId}/fresh`, { hours });
        // Update local state
        const p = state.myProducts.find(p => p.id === productId);
        if (p) {
            p.freshToday = data.freshToday;
            p.freshUntil = data.freshUntil;
            p.freshExpiredRecently = false;
            renderMyProducts(state.myProducts);
        }
        if (fromEditor && state.editingProduct) {
            state.editingProduct.freshToday = data.freshToday;
            state.editingProduct.freshUntil = data.freshUntil;
            state.editingProduct.freshExpiredRecently = false;
            renderFreshSection(state.editingProduct);
        }
        showToast(hours === 'clear' ? 'Svježina uklonjena' : 'Svježina postavljena');
    } catch(e) {
        showToast('Greška', 'error');
    }
}

function editFarmerProfile() {
    const profile = state.auth?.farmerProfile || {};
    const user    = state.auth || {};

    // Pre-fill form
    document.getElementById('fpe-farmname').value    = profile.farmName    || user.name  || '';
    document.getElementById('fpe-city').value        = profile.city        || '';
    document.getElementById('fpe-address').value     = profile.address     || '';
    document.getElementById('fpe-description').value = profile.description || '';

    // Avatar preview
    const avatarEl = document.getElementById('fpe-avatar-preview');
    if (profile.avatarUrl) {
        avatarEl.innerHTML = `<img src="${esc(profile.avatarUrl)}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">`;
    } else {
        avatarEl.textContent = '🧑‍🌾';
    }

    // Clear pending avatar
    state._pendingAvatar = null;
    document.getElementById('fpe-avatar-input').value = '';

    clearErrors(['fpe-farmname-err', 'fpe-city-err']);
    showScreen('screen-farmer-profile-edit');
}

function handleAvatarSelected() {
    const file = document.getElementById('fpe-avatar-input').files[0];
    if (!file) return;
    state._pendingAvatar = file;
    const url = URL.createObjectURL(file);
    document.getElementById('fpe-avatar-preview').innerHTML =
        `<img src="${url}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">`;
}

async function saveProfileEdit() {
    const farmName    = document.getElementById('fpe-farmname').value.trim();
    const city        = document.getElementById('fpe-city').value;
    const address     = document.getElementById('fpe-address').value.trim();
    const description = document.getElementById('fpe-description').value.trim();

    clearErrors(['fpe-farmname-err', 'fpe-city-err']);
    if (!farmName) { showErr('fpe-farmname-err', 'Naziv farme je obavezan'); return; }
    if (!city)     { showErr('fpe-city-err', 'Odaberite grad'); return; }

    const btn = document.getElementById('fpe-save-btn');
    btn.disabled = true;
    setLoading(true);

    try {
        const fd = new FormData();
        fd.append('_method',     'PATCH');
        fd.append('farmName',    farmName);
        fd.append('city',        city);
        fd.append('address',     address);
        fd.append('description', description);
        if (state._pendingAvatar) {
            fd.append('avatar', state._pendingAvatar);
        }

        const profile = await api('POST', '/api/farmer/profile', fd);

        // Update local auth state
        if (state.auth) state.auth.farmerProfile = profile;
        localStorage.setItem('agroapp_state', JSON.stringify({ auth: state.auth, farmers: state.farmers, categories: state.categories }));
        state._pendingAvatar = null;

        showToast('Profil uspješno sačuvan!');
        goBack();
    } catch(e) {
        showToast(e.message || 'Greška pri čuvanju', 'error');
    } finally {
        btn.disabled = false;
        setLoading(false);
    }
}

// =====================================================================
// ADMIN
// =====================================================================
function showAdminScreen() {
    showScreen('screen-admin');
    loadAdminData();
}

async function loadAdminData() {
    try {
        const [farmers, products] = await Promise.all([
            api('GET', '/api/admin/farmers'),
            api('GET', '/api/admin/products'),
        ]);
        state.adminFarmers = farmers;
        state.adminProducts = products;
        renderAdminFarmers();
        renderAdminProducts();
    } catch(e) {
        showToast('Greška pri učitavanju admin podataka', 'error');
    }
}

function switchAdminTab(tab) {
    state.adminTab = tab;
    document.getElementById('admin-farmers-panel').style.display  = tab === 'farmers'  ? 'block' : 'none';
    document.getElementById('admin-products-panel').style.display = tab === 'products' ? 'block' : 'none';
    document.getElementById('admin-reviews-panel').style.display  = tab === 'reviews'  ? 'block' : 'none';
    ['farmers','products','reviews'].forEach(t => {
        const btn = document.getElementById('admin-tab-' + t);
        if (!btn) return;
        btn.style.borderBottomColor = t === tab ? 'var(--color-primary)' : 'transparent';
        btn.style.color             = t === tab ? 'var(--color-primary)' : 'var(--color-text-muted)';
    });
    if (tab === 'reviews') loadAdminReviews();
}

async function loadAdminReviews() {
    const el = document.getElementById('admin-reviews-list');
    if (!el) return;
    try {
        const data = await api('GET', '/api/admin/reviews');
        const reviews = data.reviews || [];
        if (!reviews.length) {
            el.innerHTML = '<div class="empty-state"><div class="empty-state-icon">⭐</div><div class="empty-state-text">Nema recenzija</div></div>';
            return;
        }
        el.innerHTML = reviews.map(r => `
            <div id="admin-review-${r.id}" style="padding:14px 16px;border-bottom:1px solid var(--color-border);background:#fff;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                            <span style="font-size:14px;font-weight:600;color:#2a2218;">${esc(r.reviewerName)}</span>
                            <span style="font-size:11px;color:#a89a85;">${r.createdAt}</span>
                        </div>
                        <div style="font-size:12px;color:#7a6f5f;margin-bottom:6px;">Gazdinstvo: ${esc(r.farmName || '—')}</div>
                        <div style="color:#b8902a;font-size:13px;margin-bottom:4px;">${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)}</div>
                        <div style="font-size:14px;line-height:1.5;color:#1f1a14;">${esc(r.body)}</div>
                    </div>
                    <button onclick="adminDeleteReview(${r.id})" style="padding:6px 10px;background:#fff;color:var(--color-danger);border:1.5px solid var(--color-danger);border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;flex-shrink:0;">Obriši</button>
                </div>
            </div>`).join('');
    } catch(e) {
        el.innerHTML = '<div class="empty-state"><div class="empty-state-icon">⭐</div><div class="empty-state-text">Greška pri učitavanju</div></div>';
    }
}

async function adminDeleteReview(id) {
    if (!confirm('Obrisati ovu recenziju?')) return;
    try {
        await api('DELETE', `/api/admin/reviews/${id}`);
        const row = document.getElementById('admin-review-' + id);
        if (row) row.remove();
        showToast('Recenzija obrisana');
    } catch(e) {
        showToast('Greška pri brisanju', 'error');
    }
}

function renderAdminFarmers() {
    const el = document.getElementById('admin-farmers-list');
    if (!el) return;
    if (!state.adminFarmers.length) {
        el.innerHTML = '<div class="empty-state"><div class="empty-state-icon">👨‍🌾</div><div class="empty-state-text">Nema farmera</div></div>';
        return;
    }
    el.innerHTML = state.adminFarmers.map(f => {
        const status = f.isActive
            ? `<span style="font-size:11px;font-weight:600;color:#065F46;background:#D1FAE5;padding:2px 8px;border-radius:20px;">Aktivan</span>`
            : `<span style="font-size:11px;font-weight:600;color:#92400E;background:#FEF3C7;padding:2px 8px;border-radius:20px;">Neaktivan</span>`;
        const approveBtn = !f.isActive
            ? `<button onclick="adminApproveFarmer(${f.id})" style="padding:6px 14px;background:var(--color-primary);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">✓ Odobri</button>`
            : '';
        const rejectBtn = f.isActive
            ? `<button onclick="adminRejectFarmer(${f.id})" style="padding:6px 14px;background:#fff;color:var(--color-danger);border:1.5px solid var(--color-danger);border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">✗ Deaktiviraj</button>`
            : '';
        return `<div style="padding:14px 16px;border-bottom:1px solid var(--color-border);background:#fff;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                <div>
                    <div style="font-size:15px;font-weight:600;">${esc(f.farmName)}</div>
                    <div style="font-size:12px;color:var(--color-text-muted);">${esc(f.user?.email || '')}</div>
                    <div style="font-size:12px;color:var(--color-text-secondary);">${esc(f.location || 'Bez lokacije')} · ${f.productCount} proizvoda</div>
                </div>
                ${status}
            </div>
            <div style="display:flex;gap:8px;">${approveBtn}${rejectBtn}</div>
        </div>`;
    }).join('');
}

function renderAdminProducts() {
    const el = document.getElementById('admin-products-list');
    if (!el) return;
    if (!state.adminProducts.length) {
        el.innerHTML = '<div class="empty-state"><div class="empty-state-icon">🛒</div><div class="empty-state-text">Nema proizvoda</div></div>';
        return;
    }
    el.innerHTML = state.adminProducts.map(p => {
        const thumb = p.thumbnailUrl
            ? `<img src="${esc(p.thumbnailUrl)}" style="width:48px;height:48px;border-radius:8px;object-fit:cover;flex-shrink:0;">`
            : `<div style="width:48px;height:48px;border-radius:8px;background:var(--color-primary-subtle);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">${productEmoji(p.name, p.category)}</div>`;
        const activeTag = p.isActive
            ? '' : `<span style="font-size:10px;font-weight:600;color:var(--color-danger);background:#FEE2E2;padding:1px 6px;border-radius:20px;margin-left:6px;">Obrisan</span>`;
        return `<div style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid var(--color-border);background:#fff;">
            ${thumb}
            <div style="flex:1;min-width:0;">
                <div style="font-size:14px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(p.name)}${activeTag}</div>
                <div style="font-size:12px;color:var(--color-text-secondary);">${esc(p.farmer?.farmName || '')} · ${formatPrice(p.price, p.priceUnit)}</div>
            </div>
            ${p.isActive ? `<button onclick="adminDeleteProduct(${p.id})" style="padding:6px 10px;background:#fff;color:var(--color-danger);border:1.5px solid var(--color-danger);border-radius:8px;font-size:12px;cursor:pointer;flex-shrink:0;">Obriši</button>` : ''}
        </div>`;
    }).join('');
}

async function adminApproveFarmer(id) {
    try {
        await api('PATCH', `/api/admin/farmers/${id}/approve`);
        const f = state.adminFarmers.find(f => f.id === id);
        if (f) f.isActive = true;
        renderAdminFarmers();
        showToast('Farmer aktiviran');
    } catch(e) { showToast(e.message, 'error'); }
}

async function adminRejectFarmer(id) {
    if (!confirm('Deaktivirati ovog farmera?')) return;
    try {
        await api('PATCH', `/api/admin/farmers/${id}/reject`);
        const f = state.adminFarmers.find(f => f.id === id);
        if (f) f.isActive = false;
        renderAdminFarmers();
        showToast('Farmer deaktiviran');
    } catch(e) { showToast(e.message, 'error'); }
}

async function adminDeleteProduct(id) {
    if (!confirm('Trajno obrisati ovaj proizvod?')) return;
    try {
        await api('DELETE', `/api/admin/products/${id}`);
        state.adminProducts = state.adminProducts.filter(p => p.id !== id);
        renderAdminProducts();
        showToast('Proizvod obrisan');
    } catch(e) { showToast(e.message, 'error'); }
}

async function adminLogout() {
    setLoading(true);
    try {
        await api('POST', '/api/auth/logout');
        state.auth = null;
        localStorage.removeItem('agroapp_state');
        updateAuthButton();
        showScreen('screen-home');
        loadHomeProducts();
        loadFreshCount();
    } catch(e) {
        showToast(e.message, 'error');
    } finally {
        setLoading(false);
    }
}

// =====================================================================
// HELPERS
// =====================================================================
async function shareFarmerProfile(id, farmName) {
    const url = `${window.location.origin}/farmer/${id}`;
    if (navigator.share) {
        try {
            await navigator.share({ title: farmName, text: `Pogledajte ${farmName} na AgroApp-u`, url });
        } catch(e) {}
    } else {
        try {
            await navigator.clipboard.writeText(url);
            showToast('Link kopiran u clipboard!');
        } catch(e) {
            showToast(url);
        }
    }
}

function formatLocation(f) {
    const cityLabels = {
        prnjavor:'Prnjavor', doboj:'Doboj', banja_luka:'Banja Luka', bijeljina:'Bijeljina',
        trebinje:'Trebinje', prijedor:'Prijedor', zvornik:'Zvornik', srbac:'Srbac',
        celinac:'Čelinac', laktasi:'Laktaši', derventa:'Derventa', gradiska:'Gradiška',
        modrica:'Modriča', kotor_varos:'Kotor Varoš', foca:'Foča',
        istocno_sarajevo:'Istočno Sarajevo', brcko:'Brčko', mrkonjic_grad:'Mrkonjić Grad',
    };
    const cityLabel = f.city ? (cityLabels[f.city] || f.city) : '';
    if (f.address && cityLabel) return `${f.address}, ${cityLabel}`;
    return f.address || cityLabel || 'Republika Srpska';
}

function formatPrice(price, unit) {
    const p = parseFloat(price).toFixed(2).replace('.', ',');
    return unit ? `${p} KM/${unit}` : `${p} KM`;
}

function categoryEmoji(cat) {
    const map = { povrce:'🥦', voce:'🍎', mlijeko:'🥛', meso:'🥩', jaja:'🥚', med:'🍯', zitarice:'🌾', rakija:'🥃', zimnica:'🫙', ostalo:'📦' };
    return map[cat] || '🌿';
}

function productEmoji(name, cat) {
    const n = (name || '').toLowerCase();
    if (n.includes('paradajz'))                         return '🍅';
    if (n.includes('paprika') && !n.includes('ajvar'))  return '🫑';
    if (n.includes('crni luk') || (n.includes('luk') && !n.includes('bijeli'))) return '🧅';
    if (n.includes('krompir'))                          return '🥔';
    if (n.includes('kupus'))                            return '🥬';
    if (n.includes('mrkva') || n.includes('šargarepa')) return '🥕';
    if (n.includes('jabuk'))                            return '🍎';
    if (n.includes('šljiv') || n.includes('sljiv'))    return '🫐';
    if (n.includes('kruš') || n.includes('krus'))      return '🍐';
    if (n.includes('trešnj') || n.includes('višnj'))   return '🍒';
    if (n.includes('grož') || n.includes('groz'))      return '🍇';
    if (n.includes('lubenič') || n.includes('dinja'))  return '🍉';
    if (n.includes('sir'))                              return '🧀';
    if (n.includes('jogurt'))                           return '🥛';
    if (n.includes('mlijeko') || n.includes('milk'))   return '🥛';
    if (n.includes('jaja') || n.includes('jaje'))      return '🥚';
    if (n.includes('med'))                              return '🍯';
    if (n.includes('kobasic'))                          return '🌭';
    if (n.includes('slanin'))                           return '🥓';
    if (n.includes('jagnj'))                            return '🐑';
    if (n.includes('piletina') || n.includes('pileć'))  return '🍗';
    if (n.includes('kukuruz') && n.includes('brašno')) return '🌽';
    if (n.includes('brašno') || n.includes('brasno'))  return '🌾';
    if (n.includes('rakij') || n.includes('šljivovic')) return '🥃';
    if (n.includes('ajvar'))                            return '🫙';
    if (n.includes('džem') || n.includes('dzem'))      return '🍓';
    if (n.includes('med') && n.includes('bagrem'))      return '🍯';
    return categoryEmoji(cat);
}

function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

function showErr(id, msg) {
    const el = document.getElementById(id);
    if (el) { el.textContent = msg; el.classList.remove('hidden'); }
    const input = el && el.previousElementSibling;
    if (input && input.tagName === 'INPUT') input.classList.add('error');
}

function clearErrors(ids) {
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.textContent = ''; el.classList.add('hidden'); }
        const input = el && el.previousElementSibling;
        if (input && (input.tagName === 'INPUT' || input.tagName === 'TEXTAREA')) input.classList.remove('error');
    });
}

// =====================================================================
// BOOT
// =====================================================================
document.addEventListener('DOMContentLoaded', () => {
    init();
});
</script>
</body>
</html>
