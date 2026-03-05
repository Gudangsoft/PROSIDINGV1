<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate – <?php echo e($certNumber); ?></title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #fff;
            width: 297mm;
            height: 210mm;
        }

        /* ── Outer wrapper ── */
        .page {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: #fff;
            overflow: hidden;
        }

        /* ── Background decorative strips ── */
        .bg-left {
            position: absolute;
            top: 0; left: 0;
            width: 22mm;
            height: 100%;
            background: linear-gradient(180deg, #1a3a6b 0%, #0f2447 100%);
        }
        .bg-right {
            position: absolute;
            top: 0; right: 0;
            width: 22mm;
            height: 100%;
            background: linear-gradient(180deg, #1a3a6b 0%, #0f2447 100%);
        }
        .bg-top {
            position: absolute;
            top: 0; left: 22mm; right: 22mm;
            height: 10mm;
            background: linear-gradient(90deg, #1a3a6b 0%, #0f2447 50%, #1a3a6b 100%);
        }
        .bg-bottom {
            position: absolute;
            bottom: 0; left: 22mm; right: 22mm;
            height: 10mm;
            background: linear-gradient(90deg, #1a3a6b 0%, #0f2447 50%, #1a3a6b 100%);
        }

        /* ── Gold accent lines ── */
        .gold-line-v-left {
            position: absolute;
            top: 0; left: 22mm;
            width: 1.2mm; height: 100%;
            background: linear-gradient(180deg, #c9a227, #f0d060, #c9a227);
        }
        .gold-line-v-right {
            position: absolute;
            top: 0; right: 22mm;
            width: 1.2mm; height: 100%;
            background: linear-gradient(180deg, #c9a227, #f0d060, #c9a227);
        }
        .gold-line-h-top {
            position: absolute;
            top: 10mm; left: 22mm; right: 22mm;
            height: 1.2mm;
            background: linear-gradient(90deg, #c9a227, #f0d060, #c9a227);
        }
        .gold-line-h-bottom {
            position: absolute;
            bottom: 10mm; left: 22mm; right: 22mm;
            height: 1.2mm;
            background: linear-gradient(90deg, #c9a227, #f0d060, #c9a227);
        }

        /* ── Corner ornaments (pure CSS diamonds) ── */
        .corner {
            position: absolute;
            width: 8mm; height: 8mm;
            background: #c9a227;
            transform: rotate(45deg);
        }
        .corner-tl { top: 7mm; left: 19mm; }
        .corner-tr { top: 7mm; right: 19mm; }
        .corner-bl { bottom: 7mm; left: 19mm; }
        .corner-br { bottom: 7mm; right: 19mm; }

        /* ── Inner content area ── */
        .content-area {
            position: absolute;
            top: 12mm; bottom: 12mm;
            left: 25mm; right: 25mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        /* ── Header: logo + org ── */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            border-bottom: 0.5mm solid #c9a227;
            padding-bottom: 3mm;
        }
        .header img.logo {
            height: 14mm;
            object-fit: contain;
        }
        .header-text {
            text-align: center;
        }
        .header-text .org-name {
            font-size: 8.5pt;
            font-weight: bold;
            color: #0f2447;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.3;
        }
        .header-text .conf-theme {
            font-size: 7pt;
            color: #555;
            font-style: italic;
            margin-top: 1mm;
        }
        .header-text .conf-date {
            font-size: 7pt;
            color: #777;
        }

        /* ── Certificate label ribbon ── */
        .cert-label {
            text-align: center;
            margin-top: 1mm;
        }
        .cert-label .word-certificate {
            font-size: 32pt;
            font-weight: bold;
            color: #0f2447;
            letter-spacing: 6px;
            text-transform: uppercase;
            line-height: 1;
        }
        .cert-label .word-of {
            font-size: 10pt;
            color: #c9a227;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 1mm;
            display: block;
        }
        .cert-label .cert-type {
            font-size: 13pt;
            color: #1a3a6b;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* ── Body text ── */
        .body-text {
            text-align: center;
            width: 100%;
        }
        .body-text .presented-to {
            font-size: 10pt;
            color: #555;
            font-style: italic;
            letter-spacing: 1px;
        }
        .body-text .recipient {
            font-size: 24pt;
            font-weight: bold;
            color: #0f2447;
            margin: 2mm 0 1mm;
            font-style: italic;
            letter-spacing: 1px;
        }
        .body-text .divider {
            width: 60mm;
            height: 0.5mm;
            background: linear-gradient(90deg, transparent, #c9a227, transparent);
            margin: 1mm auto;
        }
        .body-text .institution {
            font-size: 9pt;
            color: #666;
            margin-bottom: 2mm;
        }
        .body-text .description {
            font-size: 10pt;
            color: #333;
            line-height: 1.6;
            max-width: 200mm;
            margin: 0 auto;
        }
        .body-text .paper-title {
            font-size: 9.5pt;
            font-style: italic;
            color: #1a3a6b;
            margin: 1.5mm 20mm;
            line-height: 1.4;
        }
        .body-text .conf-ref {
            font-size: 9pt;
            color: #555;
            margin-top: 1mm;
        }
        <?php if($conference && $conference->start_date && $conference->end_date): ?>
        .body-text .conf-date-loc {
            font-size: 8.5pt;
            color: #888;
        }
        <?php endif; ?>

        /* ── Footer: signatures + cert number + QR ── */
        .cert-footer {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            width: 100%;
            border-top: 0.5mm solid #c9a227;
            padding-top: 3mm;
        }

        /* Cert number (left) */
        .cert-number-block {
            text-align: left;
            min-width: 55mm;
        }
        .cert-number-block .label {
            font-size: 6.5pt;
            color: #999;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .cert-number-block .number {
            font-size: 8pt;
            font-weight: bold;
            color: #0f2447;
            font-family: 'Courier New', monospace;
        }

        /* Signatures (center) */
        .signatures {
            display: flex;
            gap: 20mm;
            justify-content: center;
            flex: 1;
        }
        .sig-box {
            text-align: center;
            width: 45mm;
        }
        .sig-box .sig-title {
            font-size: 8pt;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sig-box .sig-img {
            height: 12mm;
            margin: 1.5mm 0;
            object-fit: contain;
        }
        .sig-box .sig-spacer {
            height: 12mm;
        }
        .sig-box .sig-line {
            border-top: 0.5mm solid #0f2447;
            margin: 0 5mm 1.5mm;
        }
        .sig-box .sig-name {
            font-size: 8.5pt;
            font-weight: bold;
            color: #0f2447;
        }
        .sig-box .sig-role {
            font-size: 7.5pt;
            color: #666;
        }

        /* QR code (right) */
        .qr-block {
            text-align: center;
            min-width: 20mm;
        }
        .qr-block img {
            width: 18mm;
            height: 18mm;
        }
        .qr-block .qr-label {
            font-size: 5.5pt;
            color: #aaa;
            margin-top: 0.5mm;
            letter-spacing: 0.5px;
        }

        /* ── Side vertical text ── */
        .side-text-left {
            position: absolute;
            left: 5mm;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            font-size: 6pt;
            color: #c9a227;
            letter-spacing: 2px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .side-text-right {
            position: absolute;
            right: 5mm;
            top: 50%;
            transform: translateY(-50%) rotate(90deg);
            font-size: 6pt;
            color: #c9a227;
            letter-spacing: 2px;
            text-transform: uppercase;
            white-space: nowrap;
        }
    </style>
</head>
<body>
<div class="page">

    
    <div class="bg-left"></div>
    <div class="bg-right"></div>
    <div class="bg-top"></div>
    <div class="bg-bottom"></div>

    
    <div class="gold-line-v-left"></div>
    <div class="gold-line-v-right"></div>
    <div class="gold-line-h-top"></div>
    <div class="gold-line-h-bottom"></div>

    
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    
    <div class="side-text-left"><?php echo e($conference->acronym ?? config('app.name')); ?> &bull; <?php echo e(now()->year); ?></div>
    <div class="side-text-right"><?php echo e($conference->acronym ?? config('app.name')); ?> &bull; <?php echo e(now()->year); ?></div>

    
    <div class="content-area">

        
        <div class="header">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference && $conference->logo): ?>
                <img class="logo" src="<?php echo e(public_path('storage/' . $conference->logo)); ?>" alt="Logo">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="header-text">
                <div class="org-name">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference): ?><?php echo e($conference->name); ?><?php else: ?><?php echo e(config('app.name')); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference && $conference->theme): ?>
                    <div class="conf-theme"><?php echo e($conference->theme); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference && $conference->start_date): ?>
                    <div class="conf-date">
                        <?php echo e($conference->start_date->format('d')); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference->end_date && $conference->end_date->ne($conference->start_date)): ?>
                            –<?php echo e($conference->end_date->format('d')); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php echo e($conference->start_date->format('F Y')); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference->city): ?> &bull; <?php echo e($conference->city); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="cert-label">
            <div class="word-certificate">Certificate</div>
            <span class="word-of">of</span>
            <div class="cert-type">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'author'): ?>Presenter
                <?php elseif($type === 'participant'): ?>Participation
                <?php elseif($type === 'reviewer'): ?>Reviewing
                <?php elseif($type === 'committee'): ?>Committee Member
                <?php else: ?><?php echo e(ucfirst($type)); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="body-text">
            <div class="presented-to">This certificate is proudly presented to</div>
            <div class="recipient"><?php echo e($user->name); ?></div>
            <div class="divider"></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->institution): ?>
                <div class="institution"><?php echo e($user->institution); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'author' && $paper): ?>
                <div class="description">
                    for presenting the paper entitled:
                </div>
                <div class="paper-title">&ldquo;<?php echo e($paper->title); ?>&rdquo;</div>
                <div class="conf-ref">at <strong><?php echo e($conference ? $conference->name : 'the conference'); ?></strong></div>
            <?php elseif($type === 'participant'): ?>
                <div class="description">
                    for active participation in<br>
                    <strong><?php echo e($conference ? $conference->name : 'the conference'); ?></strong>
                </div>
            <?php elseif($type === 'reviewer'): ?>
                <div class="description">
                    for valuable contribution as a peer reviewer for<br>
                    <strong><?php echo e($conference ? $conference->name : 'the conference'); ?></strong>
                </div>
            <?php elseif($type === 'committee'): ?>
                <div class="description">
                    for dedicated service as a committee member of<br>
                    <strong><?php echo e($conference ? $conference->name : 'the conference'); ?></strong>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="cert-footer">

            
            <div class="cert-number-block">
                <div class="label">Certificate No.</div>
                <div class="number"><?php echo e($certNumber); ?></div>
                <div class="label" style="margin-top:1mm;">Issued: <?php echo e($generatedDate->format('d F Y')); ?></div>
            </div>

            
            <div class="signatures">
                <div class="sig-box">
                    <div class="sig-title">Chairperson</div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference && $conference->chairman_signature && file_exists(public_path('storage/' . $conference->chairman_signature))): ?>
                        <img src="<?php echo e(public_path('storage/' . $conference->chairman_signature)); ?>" class="sig-img" alt="Signature">
                    <?php elseif(file_exists(public_path('storage/signatures/chairman.png'))): ?>
                        <img src="<?php echo e(public_path('storage/signatures/chairman.png')); ?>" class="sig-img" alt="Signature">
                    <?php else: ?>
                        <div class="sig-spacer"></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="sig-line"></div>
                    <div class="sig-name"><?php echo e($conference->chairman_name ?? $conference->organizer ?? 'Chairperson'); ?></div>
                    <div class="sig-role"><?php echo e($conference->chairman_title ?? 'Conference Chair'); ?></div>
                </div>

                <div class="sig-box">
                    <div class="sig-title">Secretary</div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conference && $conference->secretary_signature && file_exists(public_path('storage/' . $conference->secretary_signature))): ?>
                        <img src="<?php echo e(public_path('storage/' . $conference->secretary_signature)); ?>" class="sig-img" alt="Signature">
                    <?php elseif(file_exists(public_path('storage/signatures/secretary.png'))): ?>
                        <img src="<?php echo e(public_path('storage/signatures/secretary.png')); ?>" class="sig-img" alt="Signature">
                    <?php else: ?>
                        <div class="sig-spacer"></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="sig-line"></div>
                    <div class="sig-name"><?php echo e($conference->secretary_name ?? 'Conference Secretary'); ?></div>
                    <div class="sig-role"><?php echo e($conference->secretary_title ?? ($conference ? $conference->name : 'Conference')); ?></div>
                </div>
            </div>

            
            <div class="qr-block">
                <img src="<?php echo e($qrCode); ?>" alt="QR Verify">
                <div class="qr-label">Scan to verify</div>
            </div>

        </div>
    </div><!-- /.content-area -->
</div><!-- /.page -->
</body>
</html>
<?php /**PATH D:\LPKD-APJI\PROSIDINGV1\resources\views\pdf\certificate-template.blade.php ENDPATH**/ ?>