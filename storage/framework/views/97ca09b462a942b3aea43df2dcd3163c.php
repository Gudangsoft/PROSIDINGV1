<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Setup Wizard – Prosiding Conference System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #818cf8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .setup-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        /* Logo & Branding */
        .brand-header {
            text-align: center;
            padding: 30px 0 20px;
            color: white;
        }
        
        .brand-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,.2);
        }
        
        .brand-logo i {
            font-size: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .brand-title {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0,0,0,.2);
        }
        
        .brand-subtitle {
            opacity: 0.9;
            font-size: 14px;
            margin-top: 6px;
        }
        
        /* Step Progress */
        .step-progress {
            display: flex;
            justify-content: center;
            gap: 8px;
            padding: 20px 0;
            flex-wrap: wrap;
        }
        
        .step-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            background: rgba(255,255,255,.15);
            border-radius: 30px;
            color: rgba(255,255,255,.7);
            font-size: 13px;
            font-weight: 500;
            transition: all .3s;
        }
        
        .step-item.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(0,0,0,.15);
        }
        
        .step-item.done {
            background: var(--success);
            color: white;
        }
        
        .step-item .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
        }
        
        .step-item.active .step-num {
            background: var(--primary);
            color: white;
        }
        
        .step-item.done .step-num {
            background: rgba(255,255,255,.3);
        }
        
        /* Main Card */
        .setup-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,.25);
            overflow: hidden;
        }
        
        .card-body-custom {
            padding: 40px;
        }
        
        /* Step Headers */
        .step-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .step-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
        }
        
        .step-icon.purple { background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%); color: white; }
        .step-icon.blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; }
        .step-icon.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
        .step-icon.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }
        .step-icon.pink { background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); color: white; }
        
        .step-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 8px;
        }
        
        .step-desc {
            color: var(--gray-500);
            font-size: 15px;
            margin: 0;
            max-width: 500px;
            margin: 0 auto;
        }
        
        /* Form Sections */
        .form-section {
            background: var(--gray-50);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
        }
        
        .form-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 16px;
            font-size: 15px;
        }
        
        .form-section-title i {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        
        .form-section-title i.app { background: #dbeafe; color: #2563eb; }
        .form-section-title i.db { background: #fef3c7; color: #d97706; }
        .form-section-title i.mail { background: #ede9fe; color: #7c3aed; }
        
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 6px;
        }
        
        .form-control, .form-select {
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            transition: all .2s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
        }
        
        .form-hint {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 4px;
        }
        
        /* Config Table */
        .config-table {
            width: 100%;
        }
        
        .config-table td {
            padding: 8px 6px;
            vertical-align: middle;
        }
        
        .config-table .label-cell {
            width: 100px;
            font-weight: 600;
            font-size: 13px;
            color: var(--gray-700);
            white-space: nowrap;
            padding-right: 12px;
        }
        
        .config-table .input-cell {
            padding-left: 0;
        }
        
        .config-table .form-control,
        .config-table .form-select {
            width: 100%;
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all .3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, .4);
            color: white;
        }
        
        .btn-success-custom {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all .3s;
        }
        
        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, .4);
            color: white;
        }
        
        /* Action Cards */
        .action-card {
            border: 2px solid var(--gray-200);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            transition: all .3s;
            background: white;
        }
        
        .action-card:hover {
            border-color: var(--primary-light);
            background: var(--gray-50);
        }
        
        .action-card.success {
            border-color: var(--success);
            background: #ecfdf5;
        }
        
        .action-card.error {
            border-color: var(--danger);
            background: #fef2f2;
        }
        
        .action-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        
        .action-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        
        .action-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        
        .action-icon.test { background: #dbeafe; color: #2563eb; }
        .action-icon.migrate { background: #fef3c7; color: #d97706; }
        .action-icon.seed { background: #d1fae5; color: #059669; }
        
        .action-title {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 15px;
            margin: 0;
        }
        
        .action-desc {
            color: var(--gray-500);
            font-size: 13px;
            margin: 0;
        }
        
        .badge-optional {
            background: var(--gray-200);
            color: var(--gray-700);
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 8px;
        }
        
        .action-btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        
        .action-result {
            margin-top: 14px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
        }
        
        .action-result.success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .action-result.error {
            background: #fee2e2;
            color: #991b1b;
        }
        
        /* Check Items */
        .check-list {
            background: var(--gray-50);
            border-radius: 16px;
            padding: 8px;
        }
        
        .check-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            transition: background .2s;
        }
        
        .check-item:hover {
            background: white;
        }
        
        .check-item .icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .check-item .icon.pass {
            background: #d1fae5;
            color: #059669;
        }
        
        .check-item .icon.fail {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .check-item .label {
            flex: 1;
            font-size: 14px;
            color: var(--gray-700);
        }
        
        .check-item .status {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }
        
        .check-item .status.pass {
            background: #d1fae5;
            color: #065f46;
        }
        
        .check-item .status.fail {
            background: #fee2e2;
            color: #991b1b;
        }
        
        /* Token Input Special */
        .token-input-wrapper {
            position: relative;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .token-input {
            width: 100%;
            padding: 16px 50px 16px 20px;
            font-size: 16px;
            border: 2px solid var(--gray-200);
            border-radius: 14px;
            text-align: center;
            letter-spacing: 2px;
            font-weight: 500;
        }
        
        .token-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
            outline: none;
        }
        
        .token-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-500);
            cursor: pointer;
            font-size: 18px;
        }
        
        /* Success Animation */
        .success-animation {
            text-align: center;
            padding: 20px 0;
        }
        
        .success-checkmark {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: scaleIn .5s ease;
        }
        
        .success-checkmark i {
            font-size: 50px;
            color: white;
        }
        
        @keyframes scaleIn {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .account-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 16px;
            padding: 24px;
            margin: 24px auto;
            max-width: 400px;
        }
        
        .account-box h6 {
            color: #0369a1;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .account-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(3, 105, 161, .1);
            font-size: 14px;
        }
        
        .account-item:last-child {
            border: none;
        }
        
        .account-item .label {
            color: #64748b;
        }
        
        .account-item .value {
            font-weight: 600;
            color: #0369a1;
            font-family: monospace;
        }
        
        /* Alert Custom */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        
        .alert-custom.warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .alert-custom.danger {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .alert-custom i {
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        
        /* Completed State */
        .completed-state {
            text-align: center;
            padding: 40px 20px;
        }
        
        .completed-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 50px;
            color: white;
        }
        
        /* Spinner */
        .spinner-sm {
            width: 18px;
            height: 18px;
            border-width: 2px;
        }
        
        /* Footer */
        .setup-footer {
            text-align: center;
            padding: 20px;
            color: rgba(255,255,255,.7);
            font-size: 13px;
        }
        
        .setup-footer a {
            color: white;
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .step-progress {
                display: none;
            }
            .card-body-custom {
                padding: 24px;
            }
            .step-title {
                font-size: 20px;
            }
            .action-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .action-btn {
                width: 100%;
                justify-content: center;
                margin-top: 12px;
            }
            .config-table td {
                display: block;
                width: 100% !important;
                padding: 4px 6px;
            }
            .config-table .label-cell {
                padding-top: 12px;
            }
            .config-table .label-cell.text-end {
                text-align: left !important;
            }
        }
    </style>
</head>
<body>

<div class="setup-container">
    
    
    <div class="brand-header">
        <div class="brand-logo">
            <i class="bi bi-journal-richtext"></i>
        </div>
        <h1 class="brand-title">Prosiding Conference</h1>
        <p class="brand-subtitle">Setup Wizard - Instalasi Mudah Tanpa Terminal</p>
    </div>
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($error)): ?>
    <div class="alert alert-danger d-flex align-items-center mb-3" role="alert" style="border-radius: 12px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #dc2626;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div><?php echo e($error); ?></div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$completed): ?>
    <div class="step-progress" id="stepProgress">
        <div class="step-item active" id="progress0">
            <span class="step-num">1</span>
            <span class="d-none d-md-inline">Autentikasi</span>
        </div>
        <div class="step-item" id="progress1">
            <span class="step-num">2</span>
            <span class="d-none d-md-inline">Cek Sistem</span>
        </div>
        <div class="step-item" id="progress2">
            <span class="step-num">3</span>
            <span class="d-none d-md-inline">Konfigurasi</span>
        </div>
        <div class="step-item" id="progress3">
            <span class="step-num">4</span>
            <span class="d-none d-md-inline">Database</span>
        </div>
        <div class="step-item" id="progress4">
            <span class="step-num">5</span>
            <span class="d-none d-md-inline">Selesai</span>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    
    <div class="setup-card">
        <div class="card-body-custom">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completed): ?>
            
            <div class="completed-state">
                <div class="completed-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h2 style="font-weight: 700; color: var(--gray-900); margin-bottom: 12px;">Setup Sudah Selesai!</h2>
                <p style="color: var(--gray-500); max-width: 400px; margin: 0 auto 24px;">
                    Aplikasi sudah dikonfigurasi dan siap digunakan. Halaman setup ini telah dikunci untuk keamanan.
                </p>
                <a href="<?php echo e(url('/')); ?>" class="btn btn-primary-custom">
                    <i class="bi bi-house"></i>
                    Buka Aplikasi
                </a>
                <div class="alert-custom warning mt-4" style="max-width: 500px; margin: 24px auto 0; text-align: left;">
                    <i class="bi bi-shield-exclamation"></i>
                    <div>
                        <strong>Catatan Keamanan:</strong><br>
                        Untuk menjalankan setup ulang, hapus file <code>storage/app/setup_complete.lock</code> melalui File Manager hosting.
                    </div>
                </div>
            </div>
            
            <?php else: ?>
            
            
            <div id="step0">
                <div class="step-header">
                    <div class="step-icon purple">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h2 class="step-title">Selamat Datang!</h2>
                    <p class="step-desc">Masukkan token keamanan untuk memulai proses instalasi. Token ini melindungi halaman setup dari akses tidak sah.</p>
                </div>
                
                <div class="token-input-wrapper">
                    <input type="password" id="inputToken" class="token-input" placeholder="Masukkan Token" autocomplete="off">
                    <button type="button" class="token-toggle" onclick="toggleTokenVisibility()">
                        <i class="bi bi-eye" id="tokenEyeIcon"></i>
                    </button>
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Token default: <code style="background: #f3f4f6; padding: 2px 8px; border-radius: 4px;">setup-prosiding</code>
                        <br><span class="opacity-75">Atau buat file <code>.setup-token</code> untuk token custom</span>
                    </small>
                </div>
                
                <div id="authError" class="alert-custom danger d-none mt-4" style="max-width: 400px; margin: 20px auto 0;">
                    <i class="bi bi-exclamation-circle"></i>
                    <span id="authErrorText"></span>
                </div>
                
                <div class="text-center mt-4">
                    <button class="btn btn-primary-custom" onclick="doAuth()" style="min-width: 200px;">
                        <span id="authSpinner" class="spinner-border spinner-sm d-none"></span>
                        <span id="authBtnText">Lanjutkan</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            
            <div id="step1" class="d-none">
                <div class="step-header">
                    <div class="step-icon blue">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <h2 class="step-title">Cek Persyaratan Sistem</h2>
                    <p class="step-desc">Memastikan server Anda memenuhi semua persyaratan untuk menjalankan aplikasi Laravel.</p>
                </div>
                
                <div id="reqList">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="text-muted mt-3 mb-0">Memeriksa persyaratan sistem...</p>
                    </div>
                </div>
                
                <div id="reqError" class="alert-custom danger d-none mt-3">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span id="reqErrorText"></span>
                </div>
                
                <div class="text-center mt-4">
                    <button id="btnReqNext" class="btn btn-primary-custom d-none" onclick="goStep(2)" style="min-width: 200px;">
                        Lanjut Konfigurasi
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            
            <div id="step2" class="d-none">
                <div class="step-header">
                    <div class="step-icon orange">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h2 class="step-title">Konfigurasi Aplikasi</h2>
                    <p class="step-desc">Isi pengaturan berikut. Data akan disimpan ke file <code>.env</code> secara otomatis.</p>
                </div>
                
                <form id="configForm" autocomplete="off" onsubmit="return false;">
                
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="bi bi-app-indicator app"></i>
                        Informasi Aplikasi
                    </div>
                    <table class="table table-borderless mb-0 config-table">
                        <tbody>
                            <tr>
                                <td class="label-cell">Nama App</td>
                                <td class="input-cell" colspan="3">
                                    <input type="text" id="app_name" class="form-control" value="<?php echo e($envValues['app_name'] ?? 'Prosiding Conference'); ?>" autocomplete="off">
                                    <div class="form-hint">Akan tampil di header dan email</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">URL</td>
                                <td class="input-cell" colspan="3">
                                    <input type="text" id="app_url" class="form-control" value="<?php echo e($envValues['app_url'] ?? ''); ?>" placeholder="https://conference.domain.com" autocomplete="off">
                                    <div class="form-hint">URL lengkap tanpa trailing slash</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">Environment</td>
                                <td class="input-cell">
                                    <select id="app_env" class="form-select">
                                        <option value="production" <?php echo e(($envValues['app_env'] ?? '') == 'production' ? 'selected' : ''); ?>>Production</option>
                                        <option value="local" <?php echo e(($envValues['app_env'] ?? '') == 'local' ? 'selected' : ''); ?>>Local</option>
                                        <option value="staging" <?php echo e(($envValues['app_env'] ?? '') == 'staging' ? 'selected' : ''); ?>>Staging</option>
                                    </select>
                                </td>
                                <td class="label-cell text-end">Debug</td>
                                <td class="input-cell">
                                    <select id="app_debug" class="form-select">
                                        <option value="false" <?php echo e(($envValues['app_debug'] ?? '') == 'false' ? 'selected' : ''); ?>>Off</option>
                                        <option value="true" <?php echo e(($envValues['app_debug'] ?? '') == 'true' ? 'selected' : ''); ?>>On</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">Timezone</td>
                                <td class="input-cell" colspan="3">
                                    <select id="app_timezone" class="form-select">
                                        <option value="Asia/Jakarta" <?php echo e(($envValues['app_timezone'] ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : ''); ?>>WIB (Jakarta)</option>
                                        <option value="Asia/Makassar" <?php echo e(($envValues['app_timezone'] ?? '') == 'Asia/Makassar' ? 'selected' : ''); ?>>WITA (Makassar)</option>
                                        <option value="Asia/Jayapura" <?php echo e(($envValues['app_timezone'] ?? '') == 'Asia/Jayapura' ? 'selected' : ''); ?>>WIT (Jayapura)</option>
                                        <option value="UTC" <?php echo e(($envValues['app_timezone'] ?? '') == 'UTC' ? 'selected' : ''); ?>>UTC</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="bi bi-database db"></i>
                        Koneksi Database (MySQL)
                    </div>
                    <table class="table table-borderless mb-0 config-table">
                        <tbody>
                            <tr>
                                <td class="label-cell">Host</td>
                                <td class="input-cell">
                                    <input type="text" id="db_host" class="form-control" value="<?php echo e($envValues['db_host'] ?? 'localhost'); ?>" autocomplete="off">
                                </td>
                                <td class="label-cell text-end">Port</td>
                                <td class="input-cell" style="width: 100px;">
                                    <input type="text" id="db_port" class="form-control" value="<?php echo e($envValues['db_port'] ?? '3306'); ?>" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">Database</td>
                                <td class="input-cell" colspan="3">
                                    <input type="text" id="db_database" class="form-control" value="<?php echo e($envValues['db_database'] ?? ''); ?>" placeholder="nama_database" autocomplete="off">
                                    <div class="form-hint">Buat database terlebih dahulu di cPanel &gt; MySQL Databases</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">Username</td>
                                <td class="input-cell" colspan="3">
                                    <input type="text" id="db_username" class="form-control" value="<?php echo e($envValues['db_username'] ?? ''); ?>" placeholder="root" autocomplete="new-password" data-lpignore="true">
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">Password</td>
                                <td class="input-cell" colspan="3">
                                    <input type="password" id="db_password" class="form-control" placeholder="Kosongkan jika tidak ada" autocomplete="new-password" data-lpignore="true">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="bi bi-envelope mail"></i>
                        Pengaturan Email (Opsional)
                    </div>
                    <table class="table table-borderless mb-0 config-table">
                        <tbody>
                            <tr>
                                <td class="label-cell">Driver</td>
                                <td class="input-cell" colspan="3">
                                    <select id="mail_mailer" class="form-select" onchange="toggleMailFields()">
                                        <option value="log" <?php echo e(($envValues['mail_mailer'] ?? 'log') == 'log' ? 'selected' : ''); ?>>Log Only (tidak kirim email)</option>
                                        <option value="smtp" <?php echo e(($envValues['mail_mailer'] ?? '') == 'smtp' ? 'selected' : ''); ?>>SMTP</option>
                                        <option value="sendmail" <?php echo e(($envValues['mail_mailer'] ?? '') == 'sendmail' ? 'selected' : ''); ?>>Sendmail</option>
                                    </select>
                                    <div class="form-hint">Pilih "Log Only" jika belum perlu email</div>
                                </td>
                            </tr>
                            <tr id="mailHostRow">
                                <td class="label-cell">SMTP Host</td>
                                <td class="input-cell">
                                    <input type="text" id="mail_host" class="form-control" value="<?php echo e($envValues['mail_host'] ?? ''); ?>" placeholder="mail.domain.com" autocomplete="off">
                                </td>
                                <td class="label-cell text-end">Port</td>
                                <td class="input-cell" style="width: 100px;">
                                    <input type="text" id="mail_port" class="form-control" value="<?php echo e($envValues['mail_port'] ?? '587'); ?>" autocomplete="off">
                                </td>
                            </tr>
                            <tr id="mailUserRow">
                                <td class="label-cell">Username</td>
                                <td class="input-cell" colspan="3">
                                    <input type="text" id="mail_username" class="form-control" value="<?php echo e($envValues['mail_username'] ?? ''); ?>" placeholder="email@domain.com" autocomplete="new-password" data-lpignore="true">
                                </td>
                            </tr>
                            <tr id="mailPassRow">
                                <td class="label-cell">Password</td>
                                <td class="input-cell" colspan="3">
                                    <input type="password" id="mail_password" class="form-control" autocomplete="new-password" data-lpignore="true">
                                </td>
                            </tr>
                            <tr id="mailFromRow">
                                <td class="label-cell">From Email</td>
                                <td class="input-cell" colspan="3">
                                    <input type="email" id="mail_from_address" class="form-control" value="<?php echo e($envValues['mail_from_address'] ?? ''); ?>" placeholder="noreply@domain.com" autocomplete="off">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </form>
                
                <div id="envError" class="alert-custom danger d-none">
                    <i class="bi bi-exclamation-circle"></i>
                    <span id="envErrorText"></span>
                </div>
                
                <div class="text-center mt-4">
                    <button class="btn btn-primary-custom" onclick="doSaveEnv()" style="min-width: 220px;">
                        <span id="envSpinner" class="spinner-border spinner-sm d-none"></span>
                        <i class="bi bi-save"></i>
                        <span id="envBtnText">Simpan & Lanjutkan</span>
                    </button>
                </div>
            </div>
            
            
            <div id="step3" class="d-none">
                <div class="step-header">
                    <div class="step-icon green">
                        <i class="bi bi-database-gear"></i>
                    </div>
                    <h2 class="step-title">Setup Database</h2>
                    <p class="step-desc">Jalankan langkah-langkah berikut secara berurutan untuk menyiapkan database.</p>
                </div>
                
                
                <div class="action-card" id="cardTestDb">
                    <div class="action-header">
                        <div class="action-info">
                            <div class="action-icon test">
                                <i class="bi bi-plug"></i>
                            </div>
                            <div>
                                <h5 class="action-title">1. Test Koneksi Database</h5>
                                <p class="action-desc">Pastikan kredensial database yang dimasukkan benar</p>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary action-btn" id="btnTestDb" onclick="doTestDb()">
                            <span id="testDbSpinner" class="spinner-border spinner-sm d-none"></span>
                            <i class="bi bi-play-fill" id="testDbIcon"></i>
                            Test
                        </button>
                    </div>
                    <div id="testDbResult" class="action-result d-none"></div>
                </div>
                
                
                <div class="action-card" id="cardMigrate">
                    <div class="action-header">
                        <div class="action-info">
                            <div class="action-icon migrate">
                                <i class="bi bi-table"></i>
                            </div>
                            <div>
                                <h5 class="action-title">2. Jalankan Migrasi</h5>
                                <p class="action-desc">Buat semua tabel yang diperlukan di database</p>
                            </div>
                        </div>
                        <button class="btn btn-outline-warning action-btn" id="btnMigrate" onclick="doMigrate()">
                            <span id="migrateSpinner" class="spinner-border spinner-sm d-none"></span>
                            <i class="bi bi-play-fill" id="migrateIcon"></i>
                            Migrate
                        </button>
                    </div>
                    <div id="migrateResult" class="action-result d-none"></div>
                </div>
                
                
                <div class="action-card" id="cardSeed">
                    <div class="action-header">
                        <div class="action-info">
                            <div class="action-icon seed">
                                <i class="bi bi-bookmark-star"></i>
                            </div>
                            <div>
                                <h5 class="action-title">
                                    3. Seed Data Awal
                                    <span class="badge-optional">Opsional</span>
                                </h5>
                                <p class="action-desc">Isi data awal seperti user admin, role, dan pengaturan default</p>
                            </div>
                        </div>
                        <button class="btn btn-outline-success action-btn" id="btnSeed" onclick="doSeed()">
                            <span id="seedSpinner" class="spinner-border spinner-sm d-none"></span>
                            <i class="bi bi-play-fill" id="seedIcon"></i>
                            Seed
                        </button>
                    </div>
                    <div id="seedResult" class="action-result d-none"></div>
                </div>
                
                
                <div class="form-section mt-4">
                    <div class="form-section-title">
                        <i class="bi bi-person-gear app"></i>
                        Buat Admin Custom <span class="badge-optional">Opsional</span>
                    </div>
                    <p class="text-muted small mb-3">Buat akun admin dengan kredensial Anda sendiri. Jika kosong, gunakan akun default dari seeder.</p>
                    <table class="table table-borderless mb-0 config-table">
                        <tbody>
                            <tr>
                                <td class="label-cell">Nama</td>
                                <td class="input-cell" colspan="3">
                                    <input type="text" id="admin_name" class="form-control" placeholder="Administrator" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">Email</td>
                                <td class="input-cell" colspan="3">
                                    <input type="email" id="admin_email" class="form-control" placeholder="admin@domain.com" autocomplete="new-password" data-lpignore="true">
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell">Password</td>
                                <td class="input-cell" colspan="3">
                                    <input type="password" id="admin_password" class="form-control" placeholder="Minimal 8 karakter" autocomplete="new-password" data-lpignore="true">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-end mt-3">
                        <button class="btn btn-outline-primary action-btn" id="btnCreateAdmin" onclick="doCreateAdmin()">
                            <span id="adminSpinner" class="spinner-border spinner-sm d-none"></span>
                            <i class="bi bi-person-plus" id="adminIcon"></i>
                            Buat Admin
                        </button>
                    </div>
                    <div id="adminResult" class="action-result d-none mt-3"></div>
                </div>
                
                <div class="text-center mt-4">
                    <button id="btnDbNext" class="btn btn-primary-custom" onclick="goStep(4)" style="min-width: 200px;">
                        Lanjut Finalisasi
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
            
            
            <div id="step4" class="d-none">
                <div class="step-header">
                    <div class="step-icon pink">
                        <i class="bi bi-rocket-takeoff"></i>
                    </div>
                    <h2 class="step-title">Finalisasi</h2>
                    <p class="step-desc">Langkah terakhir! Klik tombol di bawah untuk membuat storage link dan membersihkan cache.</p>
                </div>
                
                <div id="finalizeResult" class="d-none"></div>
                
                <div class="text-center mt-4">
                    <button class="btn btn-success-custom" id="btnFinalize" onclick="doFinalize()" style="min-width: 250px;">
                        <span id="finalizeSpinner" class="spinner-border spinner-sm d-none"></span>
                        <i class="bi bi-rocket-takeoff"></i>
                        Selesaikan Instalasi
                    </button>
                </div>
            </div>
            
            
            <div id="step5" class="d-none">
                <div class="success-animation">
                    <div class="success-checkmark">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h2 style="font-weight: 700; color: var(--success); margin-bottom: 12px;">Instalasi Berhasil!</h2>
                    <p style="color: var(--gray-500); max-width: 450px; margin: 0 auto;">
                        Selamat! Aplikasi Prosiding Conference System sudah siap digunakan.
                    </p>
                    
                    <div class="account-box">
                        <h6><i class="bi bi-person-badge"></i> Akun Admin Default</h6>
                        <div class="account-item">
                            <span class="label">Email</span>
                            <span class="value">admin@prosiding.test</span>
                        </div>
                        <div class="account-item">
                            <span class="label">Password</span>
                            <span class="value">password</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-primary-custom" style="min-width: 200px;">
                        <i class="bi bi-house"></i>
                        Buka Aplikasi
                    </a>
                    
                    <div class="alert-custom warning mt-4" style="max-width: 500px; margin: 24px auto 0; text-align: left;">
                        <i class="bi bi-shield-exclamation"></i>
                        <div>
                            <strong>Penting:</strong> Segera ubah password admin setelah login! Halaman setup ini sudah dikunci secara otomatis.
                        </div>
                    </div>
                </div>
            </div>
            
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
        </div>
    </div>
    
    
    <div class="setup-footer">
        Laravel <?php echo e(app()->version()); ?> &bull; PHP <?php echo e(PHP_VERSION); ?> &bull; 
        <a href="https://laravel.com/docs" target="_blank">Documentation</a>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
let currentStep = 0;

// Toggle token visibility
function toggleTokenVisibility() {
    const input = document.getElementById('inputToken');
    const icon = document.getElementById('tokenEyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

// Toggle mail fields based on driver
function toggleMailFields() {
    const driver = document.getElementById('mail_mailer').value;
    const rows = ['mailHostRow', 'mailUserRow', 'mailPassRow', 'mailFromRow'];
    rows.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = driver === 'log' ? 'none' : 'table-row';
    });
}

// Navigation
function goStep(n) {
    document.querySelectorAll('[id^="step"]').forEach(el => {
        if (el.id.match(/^step\d$/)) el.classList.add('d-none');
    });
    document.getElementById('step' + n).classList.remove('d-none');
    currentStep = n;
    updateProgress();
}

function updateProgress() {
    for (let i = 0; i <= 4; i++) {
        const el = document.getElementById('progress' + i);
        if (!el) continue;
        el.classList.remove('active', 'done');
        if (i < currentStep) el.classList.add('done');
        else if (i === currentStep) el.classList.add('active');
    }
}

// API helper
async function post(url, body = {}) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(body),
    });
    return res.json();
}

// STEP 0: Auth
async function doAuth() {
    const btn = document.querySelector('#step0 .btn-primary-custom');
    const spinner = document.getElementById('authSpinner');
    const error = document.getElementById('authError');
    
    error.classList.add('d-none');
    spinner.classList.remove('d-none');
    btn.disabled = true;
    
    const token = document.getElementById('inputToken').value;
    const data = await post('<?php echo e(route("setup.auth")); ?>', { token });
    
    spinner.classList.add('d-none');
    btn.disabled = false;
    
    if (data.success) {
        goStep(1);
        loadRequirements();
    } else {
        error.classList.remove('d-none');
        document.getElementById('authErrorText').textContent = data.message || 'Token tidak valid';
    }
}

document.getElementById('inputToken')?.addEventListener('keydown', e => { 
    if (e.key === 'Enter') doAuth(); 
});

// STEP 1: Requirements
async function loadRequirements() {
    const data = await post('<?php echo e(route("setup.requirements")); ?>');
    const list = document.getElementById('reqList');
    
    if (!data.success) {
        list.innerHTML = `<div class="alert-custom danger"><i class="bi bi-exclamation-circle"></i>${data.message}</div>`;
        return;
    }
    
    let html = '<div class="check-list">';
    data.checks.forEach(c => {
        html += `
            <div class="check-item">
                <div class="icon ${c.pass ? 'pass' : 'fail'}">
                    <i class="bi bi-${c.pass ? 'check' : 'x'}"></i>
                </div>
                <span class="label">${c.label}</span>
                <span class="status ${c.pass ? 'pass' : 'fail'}">${c.pass ? 'OK' : 'GAGAL'}</span>
            </div>
        `;
    });
    html += '</div>';
    list.innerHTML = html;
    
    const btnNext = document.getElementById('btnReqNext');
    btnNext.classList.remove('d-none');
    
    if (!data.allPass) {
        document.getElementById('reqError').classList.remove('d-none');
        document.getElementById('reqErrorText').textContent = 'Beberapa persyaratan tidak terpenuhi. Anda masih bisa melanjutkan, tapi mungkin ada masalah.';
        btnNext.classList.remove('btn-primary-custom');
        btnNext.style.background = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
        btnNext.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Lanjut dengan Peringatan';
    }
}

// STEP 2: Save ENV
async function doSaveEnv() {
    const spinner = document.getElementById('envSpinner');
    const error = document.getElementById('envError');
    const btn = document.querySelector('#step2 .btn-primary-custom');
    
    error.classList.add('d-none');
    spinner.classList.remove('d-none');
    btn.disabled = true;
    
    const body = {
        app_name: document.getElementById('app_name').value,
        app_url: document.getElementById('app_url').value,
        app_env: document.getElementById('app_env').value,
        app_debug: document.getElementById('app_debug').value,
        app_timezone: document.getElementById('app_timezone').value,
        db_host: document.getElementById('db_host').value,
        db_port: document.getElementById('db_port').value,
        db_database: document.getElementById('db_database').value,
        db_username: document.getElementById('db_username').value,
        db_password: document.getElementById('db_password').value,
        mail_mailer: document.getElementById('mail_mailer').value,
        mail_host: document.getElementById('mail_host').value,
        mail_port: document.getElementById('mail_port').value,
        mail_username: document.getElementById('mail_username').value,
        mail_password: document.getElementById('mail_password').value,
        mail_from_address: document.getElementById('mail_from_address').value,
        mail_from_name: document.getElementById('app_name').value,
    };
    
    const data = await post('<?php echo e(route("setup.save-env")); ?>', body);
    
    if (data.success) {
        const keyData = await post('<?php echo e(route("setup.generate-key")); ?>');
        spinner.classList.add('d-none');
        btn.disabled = false;
        
        if (!keyData.success) {
            error.classList.remove('d-none');
            document.getElementById('envErrorText').textContent = 'ENV tersimpan, tapi gagal generate key: ' + keyData.message;
            return;
        }
        goStep(3);
    } else {
        spinner.classList.add('d-none');
        btn.disabled = false;
        error.classList.remove('d-none');
        document.getElementById('envErrorText').textContent = data.message || 'Gagal menyimpan konfigurasi';
    }
}

// STEP 3: Database actions
async function doTestDb() {
    const spinner = document.getElementById('testDbSpinner');
    const icon = document.getElementById('testDbIcon');
    const result = document.getElementById('testDbResult');
    const card = document.getElementById('cardTestDb');
    const btn = document.getElementById('btnTestDb');
    
    spinner.classList.remove('d-none');
    icon.classList.add('d-none');
    btn.disabled = true;
    
    const data = await post('<?php echo e(route("setup.test-db")); ?>');
    
    spinner.classList.add('d-none');
    icon.classList.remove('d-none');
    btn.disabled = false;
    
    result.classList.remove('d-none', 'success', 'error');
    result.classList.add(data.success ? 'success' : 'error');
    result.innerHTML = `<i class="bi bi-${data.success ? 'check-circle' : 'x-circle'} me-2"></i>${data.message}`;
    
    card.classList.remove('success', 'error');
    if (data.success) card.classList.add('success');
    else card.classList.add('error');
}

async function doMigrate() {
    const spinner = document.getElementById('migrateSpinner');
    const icon = document.getElementById('migrateIcon');
    const result = document.getElementById('migrateResult');
    const card = document.getElementById('cardMigrate');
    const btn = document.getElementById('btnMigrate');
    
    spinner.classList.remove('d-none');
    icon.classList.add('d-none');
    btn.disabled = true;
    
    const data = await post('<?php echo e(route("setup.migrate")); ?>');
    
    spinner.classList.add('d-none');
    icon.classList.remove('d-none');
    btn.disabled = false;
    
    result.classList.remove('d-none', 'success', 'error');
    result.classList.add(data.success ? 'success' : 'error');
    let msg = data.message;
    if (data.output) msg += '<br><small style="opacity:.8">' + data.output.substring(0, 200) + '</small>';
    result.innerHTML = `<i class="bi bi-${data.success ? 'check-circle' : 'x-circle'} me-2"></i>${msg}`;
    
    card.classList.remove('success', 'error');
    if (data.success) card.classList.add('success');
    else card.classList.add('error');
}

async function doSeed() {
    if (!confirm('Jalankan seeder? Ini akan mengisi data awal ke database termasuk user admin.')) return;
    
    const spinner = document.getElementById('seedSpinner');
    const icon = document.getElementById('seedIcon');
    const result = document.getElementById('seedResult');
    const card = document.getElementById('cardSeed');
    const btn = document.getElementById('btnSeed');
    
    spinner.classList.remove('d-none');
    icon.classList.add('d-none');
    btn.disabled = true;
    
    const data = await post('<?php echo e(route("setup.seed")); ?>');
    
    spinner.classList.add('d-none');
    icon.classList.remove('d-none');
    btn.disabled = false;
    
    result.classList.remove('d-none', 'success', 'error');
    result.classList.add(data.success ? 'success' : 'error');
    let msg = data.message;
    if (data.output) msg += '<br><small style="opacity:.8">' + data.output.substring(0, 200) + '</small>';
    result.innerHTML = `<i class="bi bi-${data.success ? 'check-circle' : 'x-circle'} me-2"></i>${msg}`;
    
    card.classList.remove('success', 'error');
    if (data.success) card.classList.add('success');
    else card.classList.add('error');
}

// Create Custom Admin
async function doCreateAdmin() {
    const name = document.getElementById('admin_name').value.trim();
    const email = document.getElementById('admin_email').value.trim();
    const password = document.getElementById('admin_password').value;
    
    if (!name || !email || !password) {
        alert('Lengkapi semua field admin (nama, email, password).');
        return;
    }
    
    if (password.length < 8) {
        alert('Password minimal 8 karakter.');
        return;
    }
    
    const spinner = document.getElementById('adminSpinner');
    const icon = document.getElementById('adminIcon');
    const result = document.getElementById('adminResult');
    const btn = document.getElementById('btnCreateAdmin');
    
    spinner.classList.remove('d-none');
    icon.classList.add('d-none');
    btn.disabled = true;
    
    const data = await post('<?php echo e(route("setup.create-admin")); ?>', { name, email, password });
    
    spinner.classList.add('d-none');
    icon.classList.remove('d-none');
    btn.disabled = false;
    
    result.classList.remove('d-none', 'success', 'error');
    result.classList.add(data.success ? 'success' : 'error');
    result.innerHTML = `<i class="bi bi-${data.success ? 'check-circle' : 'x-circle'} me-2"></i>${data.message}`;
}

// STEP 4: Finalize
async function doFinalize() {
    const spinner = document.getElementById('finalizeSpinner');
    const btn = document.getElementById('btnFinalize');
    const result = document.getElementById('finalizeResult');
    
    spinner.classList.remove('d-none');
    btn.disabled = true;
    
    const data = await post('<?php echo e(route("setup.finalize")); ?>');
    
    spinner.classList.add('d-none');
    
    if (data.success) {
        let html = '<div class="mb-4">';
        data.results.forEach(r => {
            html += `
                <div class="action-result ${r.success ? 'success' : 'error'} mb-2">
                    <i class="bi bi-${r.success ? 'check-circle' : 'x-circle'} me-2"></i>
                    <strong>${r.label}:</strong> ${r.success ? 'Berhasil' : r.msg}
                </div>
            `;
        });
        html += '</div>';
        result.innerHTML = html;
        result.classList.remove('d-none');
        
        setTimeout(() => goStep(5), 1500);
    } else {
        btn.disabled = false;
        alert('Gagal: ' + data.message);
    }
}

// Init
updateProgress();
toggleMailFields();
</script>
</body>
</html>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\setup\index.blade.php ENDPATH**/ ?>