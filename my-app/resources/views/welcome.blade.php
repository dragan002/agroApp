<!DOCTYPE html>
<html lang="sr-Latn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgroApp Prnjavor</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html, body { height: 100%; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; background: #FAFAF8; color: #1A2E1A; -webkit-tap-highlight-color: transparent; }
            :root {
                --color-primary: #2D6A4F;
                --color-primary-light: #40916C;
                --color-primary-subtle: #D8F3DC;
                --color-accent: #E9C46A;
                --color-accent-deep: #F4A261;
                --color-surface: #FAFAF8;
                --color-card: #FFFFFF;
                --color-border: #E4E8E0;
                --color-text-primary: #1A2E1A;
                --color-text-secondary: #5A6B5A;
                --color-text-muted: #9AA89A;
                --color-danger: #C0392B;
                --color-viber: #7360F2;
                --color-whatsapp: #25D366;
            }
            .screen { display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 64px; overflow-y: auto; -webkit-overflow-scrolling: touch; background: var(--color-surface); }
            .screen.active { display: block; }
            #app { position: relative; height: 100vh; overflow: hidden; max-width: 480px; margin: 0 auto; }
            .bottom-nav { position: absolute; bottom: 0; left: 0; right: 0; height: 64px; background: #fff; border-top: 1px solid var(--color-border); display: flex; align-items: center; padding-bottom: env(safe-area-inset-bottom, 0); z-index: 50; }
            .nav-btn { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2px; font-size: 10px; color: var(--color-text-muted); cursor: pointer; padding: 8px 4px; border: none; background: none; transition: color 0.15s; }
            .nav-btn.active { color: var(--color-primary); }
            .nav-btn svg { width: 22px; height: 22px; }
            .top-bar { position: sticky; top: 0; z-index: 10; background: #fff; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; padding: 0 16px; height: 56px; gap: 12px; }
            .top-bar-title { font-size: 17px; font-weight: 600; color: var(--color-text-primary); flex: 1; }
            .top-bar-logo { font-size: 20px; font-weight: 700; color: var(--color-primary); flex: 1; }
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
            .toast { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: #1A2E1A; color: #fff; padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 500; z-index: 9999; max-width: 320px; text-align: center; animation: fadeIn 0.2s; pointer-events: none; }
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
</head>
<body>
<div id="app">

    <!-- ============================================================ -->
    <!-- SCREEN: HOME                                                  -->
    <!-- ============================================================ -->
    <div id="screen-home" class="screen active">
        <!-- Top bar -->
        <div class="top-bar">
            <div class="top-bar-logo">🌿 AgroApp</div>
            <button class="icon-btn" onclick="onLoginIconTap()" id="home-auth-btn" title="Prijava">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            </button>
        </div>

        <!-- Search bar (tappable, navigates to search) -->
        <div style="padding:12px 16px 0;">
            <div onclick="showScreen('screen-search')" style="display:flex;align-items:center;gap:10px;background:#fff;border:1.5px solid var(--color-border);border-radius:12px;padding:10px 14px;cursor:pointer;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-text-muted)" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <span style="color:var(--color-text-muted);font-size:15px;">Pretraži farmere i proizvode...</span>
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
            <button class="chip" data-cat="zimnica" onclick="selectHomeCategory(this,'zimnica')">Zimnica</button>
            <button class="chip" data-cat="ostalo" onclick="selectHomeCategory(this,'ostalo')">Ostalo</button>
        </div>

        <!-- Fresh today banner -->
        <div id="fresh-banner" onclick="showFreshFilter()" style="display:none;margin:0 16px 4px;background:#FEF3C7;border-radius:12px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;cursor:pointer;">
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
        <div class="section-title">Proizvodi</div>
        <div id="home-products-list" style="padding:0 16px 80px;display:flex;flex-direction:column;gap:10px;">
            <div style="color:var(--color-text-muted);font-size:14px;padding:8px 0;">Učitavam...</div>
        </div>
    </div>
    <!-- Bottom nav: customer -->
    <div id="nav-customer" class="bottom-nav">
        <button class="nav-btn active" onclick="showScreen('screen-home');setNavActive('nav-customer',0)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Farmeri
        </button>
        <button class="nav-btn" onclick="showScreen('screen-search');setNavActive('nav-customer',1)">
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
                <label class="form-label">Lokacija</label>
                <input id="farm-location" type="text" class="form-input" placeholder="Prnjavor, selo...">
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
            <div class="top-bar-title">Moj profil</div>
            <button class="icon-btn" onclick="showScreen('screen-farmer-settings')" title="Postavke">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            </button>
        </div>

        <div style="padding-bottom:80px;" id="dashboard-content">
            <!-- Dynamic content -->
        </div>
    </div>
    <!-- Bottom nav: farmer -->
    <div id="nav-farmer" class="bottom-nav hidden">
        <button class="nav-btn active" onclick="showFarmerDashboard();setNavActive('nav-farmer',0)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profil
        </button>
        <button class="nav-btn" onclick="showMyProducts();setNavActive('nav-farmer',1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            Proizvodi
        </button>
        <button class="nav-btn" style="font-size:26px;margin-top:-8px;" onclick="openProductEditor(null);setNavActive('nav-farmer',2)">
            <div style="width:48px;height:48px;background:var(--color-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:26px;box-shadow:0 2px 8px rgba(45,106,79,0.4);">+</div>
        </button>
        <button class="nav-btn" onclick="">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
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
            </div>

            <div class="form-group">
                <label class="form-label">Naziv proizvoda *</label>
                <input id="pe-name" type="text" class="form-input" placeholder="npr. Paradajz organski">
                <div class="form-error hidden" id="pe-name-err"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Kategorija *</label>
                <select id="pe-category" class="select-input">
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

            <!-- Fresh today toggle -->
            <div class="fresh-toggle-card">
                <div>
                    <div style="font-size:14px;font-weight:600;color:#92400E;">🌞 Svježe danas</div>
                    <div style="font-size:12px;color:#B45309;">Označite ako je proizvod ubran/spreman danas</div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="pe-fresh">
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <button class="btn-primary" onclick="saveProduct()" id="save-product-btn">Sačuvaj proizvod</button>
            <button class="btn-danger" id="delete-product-btn" style="display:none;width:100%;margin-top:12px;text-align:center;" onclick="confirmDeleteProduct()">Obriši proizvod</button>
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
    isLoading: false,
    currentScreen: 'screen-home',
    screenHistory: [],
    editingProduct: null,
    homeProducts: [],
    homeCategory: '',
    pendingFarmPhotos: [],
    pendingProductPhotos: [],
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
    const isFarmer = state.auth && state.auth.role === 'farmer' && !state.auth.onboardingStep;
    const farmerScreens = ['screen-farmer-dashboard', 'screen-product-edit', 'screen-farmer-settings'];
    const noNav = ['screen-farmer-signup', 'screen-login'];

    document.getElementById('nav-customer').classList.add('hidden');
    document.getElementById('nav-farmer').classList.add('hidden');

    if (noNav.includes(name)) {
        // no nav — screen occupies full height
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
        localStorage.setItem('agroapp_state', JSON.stringify({ auth: state.auth, farmers: state.farmers, categories: state.categories }));
        renderHomeFarmers(state.farmers);
        updateAuthButton();
    } catch(e) {
        console.warn('State load failed', e);
    }

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
            showScreen('screen-farmer-dashboard');
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
    const img = f.coverPhoto ? `<img src="${esc(f.coverPhoto.url)}" alt="${esc(f.farmName)}" style="width:100%;height:100px;object-fit:cover;">`
        : `<div style="width:100%;height:100px;background:var(--color-primary-subtle);display:flex;align-items:center;justify-content:center;font-size:32px;">🌿</div>`;
    return `<div class="farmer-card-h" onclick="loadFarmerProfile(${f.id})">
        ${img}
        <div style="padding:8px;">
            <div style="font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(f.farmName)}</div>
            <div style="font-size:11px;color:var(--color-text-muted);">${esc(f.location || 'Prnjavor')}</div>
            <div style="font-size:11px;color:var(--color-text-secondary);margin-top:2px;">${f.productCount || 0} proizvoda</div>
        </div>
    </div>`;
}

// =====================================================================
// HOME — PRODUCTS
// =====================================================================
async function loadHomeProducts(category = '') {
    const el = document.getElementById('home-products-list');
    el.innerHTML = '<div style="color:var(--color-text-muted);font-size:14px;padding:8px 0;">Učitavam...</div>';
    try {
        let url = '/api/products?';
        if (category) url += `category=${category}&`;
        const data = await api('GET', url);
        state.homeProducts = data.data || [];
        renderHomeProducts(state.homeProducts);
    } catch(e) {
        el.innerHTML = '<div style="color:var(--color-danger);font-size:14px;">Greška pri učitavanju</div>';
    }
}

function renderHomeProducts(products) {
    const el = document.getElementById('home-products-list');
    if (!products.length) {
        el.innerHTML = `<div class="empty-state"><div class="empty-state-icon">🛒</div><div class="empty-state-text">Nema proizvoda</div></div>`;
        return;
    }
    el.innerHTML = products.map(p => productCardHtml(p)).join('');
}

function productCardHtml(p) {
    const thumb = p.thumbnailUrl
        ? `<img src="${esc(p.thumbnailUrl)}" class="product-card-thumb" alt="${esc(p.name)}">`
        : `<div class="product-card-thumb">${categoryEmoji(p.category)}</div>`;
    const fresh = p.freshToday ? `<span class="fresh-badge">🌞 Svježe</span>` : '';
    const farmer = p.farmer ? `<div style="font-size:11px;color:var(--color-text-muted);">${esc(p.farmer.farmName)}</div>` : '';
    return `<div class="product-card" onclick="loadProductDetail(${p.id})">
        ${thumb}
        <div style="flex:1;min-width:0;">
            ${fresh}
            <div style="font-size:15px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(p.name)}</div>
            <div style="font-size:16px;font-weight:700;color:var(--color-primary);">${formatPrice(p.price, p.priceUnit)}</div>
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
    document.querySelectorAll('#home-category-chips .chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    state.homeCategory = cat;
    loadHomeProducts(cat);
}

// =====================================================================
// FARMER PROFILE
// =====================================================================
async function loadFarmerProfile(id) {
    setLoading(true);
    try {
        const data = await api('GET', `/api/farmers/${id}`);
        state.selectedFarmer = data;
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

    const galleryHtml = photos.length
        ? `<div class="gallery" id="fp-gallery">
            <div class="gallery-track" id="fp-gallery-track">
                ${photos.map(p => `<div class="gallery-slide"><img src="${esc(p.url)}" alt="Foto"></div>`).join('')}
            </div>
            ${photos.length > 1 ? `<div class="gallery-dots">${photos.map((_, i) => `<div class="gallery-dot${i===0?' active':''}" data-gallery="fp-gallery" data-idx="${i}"></div>`).join('')}</div>` : ''}
           </div>`
        : `<div style="width:100%;aspect-ratio:16/9;background:var(--color-primary-subtle);display:flex;align-items:center;justify-content:center;font-size:56px;">🌿</div>`;

    const avatarHtml = f.avatarUrl
        ? `<img src="${esc(f.avatarUrl)}" class="farmer-avatar-overlap avatar-circle" style="width:64px;height:64px;">`
        : `<div class="farmer-avatar-overlap avatar-circle" style="width:64px;height:64px;background:var(--color-primary-subtle);">🧑‍🌾</div>`;

    const contactBtns = buildContactBtns(user.phone, user.viber, user.whatsapp);

    const productsHtml = products.length
        ? `<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:0 16px 16px;">
            ${products.map(p => productGridCard(p)).join('')}
          </div>`
        : `<div class="empty-state"><div class="empty-state-icon">🛒</div><div class="empty-state-text">Nema proizvoda</div></div>`;

    el.innerHTML = `
        <div style="position:sticky;top:0;z-index:10;background:#fff;border-bottom:1px solid var(--color-border);display:flex;align-items:center;padding:0 16px;height:56px;gap:12px;">
            <button class="icon-btn" onclick="goBack()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div style="font-size:17px;font-weight:600;flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(f.farmName)}</div>
        </div>
        <div class="farmer-profile-hero">
            ${galleryHtml}
            ${avatarHtml}
        </div>
        <div style="padding:40px 16px 8px;">
            <div style="font-size:22px;font-weight:700;">${esc(f.farmName)}</div>
            <div style="display:flex;align-items:center;gap:6px;margin-top:4px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--color-text-muted)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span style="font-size:13px;color:var(--color-text-muted);">${esc(f.location || 'Prnjavor')}</span>
                <span style="font-size:12px;color:var(--color-text-muted);margin-left:8px;">Član od ${f.createdAt ? f.createdAt.substring(0,7) : '—'}</span>
            </div>
        </div>
        <div style="padding:0 16px 16px;display:flex;gap:10px;">
            ${contactBtns}
        </div>
        ${f.description ? `<div style="padding:0 16px 16px;font-size:14px;line-height:1.6;color:var(--color-text-secondary);">${esc(f.description)}</div>` : ''}
        <div class="section-title">Proizvodi (${products.length})</div>
        ${productsHtml}
        <div style="height:80px;"></div>
    `;

    // Sticky contact bar
    const stickyBar = document.createElement('div');
    stickyBar.className = 'contact-bar';
    stickyBar.innerHTML = user.phone
        ? `<button class="btn-call" onclick="window.location='tel:${esc(user.phone)}'">📞 Pozovi ${esc(user.phone)}</button>`
        : `<div style="flex:1;text-align:center;color:var(--color-text-muted);font-size:14px;">Nema broja</div>`;
    el.appendChild(stickyBar);

    // Setup gallery swipe
    if (photos.length > 1) {
        setupGallery('fp-gallery');
    }
}

function productGridCard(p) {
    const thumb = p.thumbnailUrl
        ? `<img src="${esc(p.thumbnailUrl)}" style="width:100%;height:100px;object-fit:cover;border-radius:10px;">`
        : `<div style="width:100%;height:100px;border-radius:10px;background:var(--color-primary-subtle);display:flex;align-items:center;justify-content:center;font-size:32px;">${categoryEmoji(p.category)}</div>`;
    const fresh = p.freshToday ? `<span class="fresh-badge" style="font-size:10px;">🌞 Svježe</span>` : '';
    return `<div onclick="loadProductDetail(${p.id})" style="background:#fff;border:1px solid var(--color-border);border-radius:12px;overflow:hidden;cursor:pointer;">
        ${thumb}
        <div style="padding:8px;">
            ${fresh}
            <div style="font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(p.name)}</div>
            <div style="font-size:14px;font-weight:700;color:var(--color-primary);">${formatPrice(p.price, p.priceUnit)}</div>
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

    const galleryHtml = photos.length
        ? `<div class="gallery" id="pd-gallery">
            <div class="gallery-track" id="pd-gallery-track" style="aspect-ratio:1;">
                ${photos.map(ph => `<div class="gallery-slide" style="aspect-ratio:1;"><img src="${esc(ph.url)}" alt="${esc(p.name)}"></div>`).join('')}
            </div>
            ${photos.length > 1 ? `<div style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.5);color:#fff;font-size:12px;font-weight:600;padding:4px 10px;border-radius:20px;" id="pd-photo-counter">1/${photos.length}</div>
            <div class="gallery-dots">${photos.map((_, i) => `<div class="gallery-dot${i===0?' active':''}" data-gallery="pd-gallery" data-idx="${i}"></div>`).join('')}</div>` : ''}
           </div>`
        : `<div style="width:100%;aspect-ratio:1;background:var(--color-primary-subtle);display:flex;align-items:center;justify-content:center;font-size:64px;">${categoryEmoji(p.category)}</div>`;

    const freshBadge = p.freshToday ? `<span class="fresh-badge" style="margin-bottom:8px;">🌞 Svježe danas</span>` : '';

    const farmerCard = farmer.id ? `
        <div onclick="loadFarmerProfile(${farmer.id})" style="display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--color-border);border-radius:12px;padding:12px;cursor:pointer;">
            ${farmer.avatarUrl ? `<img src="${esc(farmer.avatarUrl)}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">` : `<div class="avatar-circle" style="width:48px;height:48px;background:var(--color-primary-subtle);">🧑‍🌾</div>`}
            <div>
                <div style="font-size:14px;font-weight:600;">${esc(farmer.farmName || '')}</div>
                <div style="font-size:12px;color:var(--color-text-muted);">${esc(farmer.location || 'Prnjavor')}</div>
            </div>
            <svg style="margin-left:auto;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--color-text-muted)" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </div>` : '';

    el.innerHTML = `
        <div style="position:sticky;top:0;z-index:10;background:#fff;border-bottom:1px solid var(--color-border);display:flex;align-items:center;padding:0 16px;height:56px;gap:12px;">
            <button class="icon-btn" onclick="goBack()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="22" height="22"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div style="font-size:17px;font-weight:600;flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(p.name)}</div>
        </div>
        <div style="position:relative;">${galleryHtml}</div>
        <div style="padding:16px;">
            ${freshBadge}
            <div style="font-size:22px;font-weight:700;">${esc(p.name)}</div>
            <div style="font-size:24px;font-weight:800;color:var(--color-primary);margin:4px 0 8px;">${formatPrice(p.price, p.priceUnit)}</div>
            ${p.description ? `<div style="font-size:14px;line-height:1.6;color:var(--color-text-secondary);margin-bottom:16px;">${esc(p.description)}</div>` : ''}
            <div style="font-size:13px;font-weight:600;color:var(--color-text-muted);margin-bottom:8px;">Farmer</div>
            ${farmerCard}
        </div>
        <div style="height:80px;"></div>
        <div class="contact-bar">
            ${buildContactBtns(user.phone, user.viber, user.whatsapp)}
        </div>
    `;

    if (photos.length > 1) {
        setupGallery('pd-gallery', () => {
            const counter = document.getElementById('pd-photo-counter');
            if (counter) {
                const track = document.getElementById('pd-gallery-track');
                const idx = Math.round(track.scrollLeft / track.offsetWidth);
                counter.textContent = `${idx+1}/${photos.length}`;
            }
        });
    }
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
// SEARCH
// =====================================================================
let searchDebounce = null;

function onSearchInput() {
    const q = document.getElementById('search-input').value;
    state.searchQuery = q;
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

    if (!q && !category && !freshOnly) {
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
        html += `<div style="font-size:14px;font-weight:700;color:var(--color-text-muted);margin-bottom:8px;">PROIZVODI (${products.length})</div>`;
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
        if (user.role === 'farmer' && !user.onboardingStep) {
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
    clearErrors(['farm-name-err']);
    const farmName = document.getElementById('farm-name').value.trim();
    if (!farmName) { showErr('farm-name-err','Naziv gazdinstva je obavezan'); return; }
    const location = document.getElementById('farm-location').value.trim();
    const description = document.getElementById('farm-description').value.trim();

    setLoading(true);
    try {
        const user = await api('POST', '/api/onboarding/step/3', { farmName, location, description });
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
async function showFarmerDashboard() {
    showScreen('screen-farmer-dashboard');
    document.getElementById('nav-farmer').classList.remove('hidden');
    document.getElementById('nav-customer').classList.add('hidden');
    setNavActive('nav-farmer', 0);

    const user = state.auth;
    if (!user) return;
    const profile = user.farmerProfile || {};

    const avatarHtml = profile.avatarUrl
        ? `<img src="${esc(profile.avatarUrl)}" class="avatar-circle" style="width:72px;height:72px;">`
        : `<div class="avatar-circle" style="width:72px;height:72px;background:var(--color-primary-subtle);font-size:28px;">🧑‍🌾</div>`;

    document.getElementById('dashboard-content').innerHTML = `
        <div style="padding:16px;">
            <div class="card" style="padding:16px;display:flex;gap:14px;align-items:center;margin-bottom:16px;">
                ${avatarHtml}
                <div style="flex:1;min-width:0;">
                    <div style="font-size:17px;font-weight:700;">${esc(profile.farmName || user.name)}</div>
                    <div style="font-size:13px;color:var(--color-text-muted);">${esc(profile.location || 'Prnjavor')}</div>
                    <div style="font-size:12px;color:var(--color-text-muted);">Član od ${profile.createdAt ? profile.createdAt.substring(0,7) : '—'}</div>
                </div>
                <button class="btn-ghost" style="width:auto;padding:8px 14px;font-size:13px;" onclick="editFarmerProfile()">Uredi</button>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:16px;">
                <div class="card" style="padding:12px;text-align:center;">
                    <div style="font-size:24px;font-weight:700;color:var(--color-primary);">0</div>
                    <div style="font-size:11px;color:var(--color-text-muted);">Pregledi</div>
                </div>
                <div class="card" style="padding:12px;text-align:center;">
                    <div style="font-size:24px;font-weight:700;color:var(--color-primary);">0</div>
                    <div style="font-size:11px;color:var(--color-text-muted);">Kontakti</div>
                </div>
                <div class="card" id="dash-product-count" style="padding:12px;text-align:center;">
                    <div style="font-size:24px;font-weight:700;color:var(--color-primary);">—</div>
                    <div style="font-size:11px;color:var(--color-text-muted);">Proizvodi</div>
                </div>
            </div>
        </div>

        <div id="my-products-section">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:0 16px 8px;">
                <div class="section-title" style="padding:0;">Moji proizvodi</div>
                <button class="btn-primary" style="width:auto;padding:8px 16px;font-size:13px;" onclick="openProductEditor(null)">+ Novi</button>
            </div>
            <div id="my-products-list">
                <div style="padding:16px;color:var(--color-text-muted);font-size:14px;">Učitavam...</div>
            </div>
        </div>
    `;

    loadMyProducts();
}

async function loadMyProducts() {
    try {
        const data = await api('GET', '/api/farmer/products');
        state.myProducts = data;
        renderMyProducts(data);
        const countEl = document.querySelector('#dash-product-count div:first-child');
        if (countEl) countEl.textContent = data.filter(p => p.isActive !== false).length;
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
        : `<div class="my-product-thumb">${categoryEmoji(p.category)}</div>`;
    return `<div class="my-product-row">
        ${thumb}
        <div style="flex:1;min-width:0;">
            <div style="font-size:14px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${esc(p.name)}</div>
            <div style="font-size:13px;color:var(--color-primary);font-weight:600;">${formatPrice(p.price, p.priceUnit)}</div>
        </div>
        <label class="toggle-switch" style="margin-right:12px;" title="Svježe danas">
            <input type="checkbox" ${p.freshToday ? 'checked' : ''} onchange="toggleFresh(${p.id}, this.checked)">
            <span class="toggle-slider"></span>
        </label>
        <button class="icon-btn" onclick="openProductEditor(${p.id})">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
    </div>`;
}

async function showMyProducts() {
    showScreen('screen-farmer-dashboard');
    await showFarmerDashboard();
    const el = document.getElementById('my-products-section');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
}

// =====================================================================
// PRODUCT EDITOR
// =====================================================================
function openProductEditor(productId) {
    state.editingProduct = productId ? state.myProducts.find(p => p.id === productId) || null : null;
    state.pendingProductPhotos = [];

    document.getElementById('product-edit-title').textContent = productId ? 'Uredi proizvod' : 'Novi proizvod';
    document.getElementById('delete-product-btn').style.display = productId ? '' : 'none';

    // Reset form
    document.getElementById('pe-name').value = state.editingProduct?.name || '';
    document.getElementById('pe-category').value = state.editingProduct?.category || '';
    document.getElementById('pe-price').value = state.editingProduct?.price || '';
    document.getElementById('pe-unit').value = state.editingProduct?.priceUnit || 'kg';
    document.getElementById('pe-description').value = state.editingProduct?.description || '';
    document.getElementById('pe-fresh').checked = state.editingProduct?.freshToday || false;

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

    showScreen('screen-product-edit');
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
    const freshToday = document.getElementById('pe-fresh').checked;

    setLoading(true);
    try {
        if (state.pendingProductPhotos.length > 0) {
            const fd = new FormData();
            fd.append('name', name);
            fd.append('category', category);
            fd.append('price', price);
            fd.append('priceUnit', priceUnit);
            fd.append('description', description);
            fd.append('freshToday', freshToday ? '1' : '0');
            state.pendingProductPhotos.forEach(f => fd.append('photos[]', f));

            if (state.editingProduct) {
                fd.append('_method', 'PATCH');
                await api('POST', `/api/farmer/products/${state.editingProduct.id}`, fd);
            } else {
                await api('POST', '/api/farmer/products', fd);
            }
        } else {
            const payload = { name, category, price: parseFloat(price), priceUnit, description, freshToday };
            if (state.editingProduct) {
                await api('PATCH', `/api/farmer/products/${state.editingProduct.id}`, payload);
            } else {
                await api('POST', '/api/farmer/products', payload);
            }
        }

        showToast(state.editingProduct ? 'Proizvod ažuriran' : 'Proizvod dodan');
        state.editingProduct = null;
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
    if (!state.editingProduct) return;
    if (!confirm(`Obrisati "${state.editingProduct.name}"?`)) return;
    setLoading(true);
    try {
        await api('DELETE', `/api/farmer/products/${state.editingProduct.id}`);
        // Optimistic remove
        state.myProducts = state.myProducts.filter(p => p.id !== state.editingProduct.id);
        showToast('Proizvod obrisan');
        state.editingProduct = null;
        goBack();
        setTimeout(loadMyProducts, 300);
    } catch(e) {
        showToast(e.message, 'error');
    } finally {
        setLoading(false);
    }
}

async function toggleFresh(productId, value) {
    // Optimistic update
    const p = state.myProducts.find(p => p.id === productId);
    if (p) p.freshToday = value;
    try {
        await api('PATCH', `/api/farmer/products/${productId}/fresh`);
    } catch(e) {
        // Revert on failure
        if (p) p.freshToday = !value;
        renderMyProducts(state.myProducts);
        showToast('Greška', 'error');
    }
}

function editFarmerProfile() {
    showToast('Uređivanje profila — uskoro dostupno');
}

// =====================================================================
// HELPERS
// =====================================================================
function formatPrice(price, unit) {
    const p = parseFloat(price).toFixed(2).replace('.', ',');
    return unit ? `${p} KM/${unit}` : `${p} KM`;
}

function categoryEmoji(cat) {
    const map = { povrce:'🥦', voce:'🍎', mlijeko:'🥛', meso:'🥩', jaja:'🥚', med:'🍯', zitarice:'🌾', rakija:'🥃', zimnica:'🫙', ostalo:'📦' };
    return map[cat] || '🌿';
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
