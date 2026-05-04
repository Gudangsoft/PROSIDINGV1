<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate – {{ $certNumber }}</title>
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
        .full-width-banner {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            z-index: 10;
        }
        .full-width-banner img {
            width: 100%;
            height: auto;
            max-height: 45mm;
            object-fit: cover;
            display: block;
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
        @if($conference && $conference->start_date && $conference->end_date)
        .body-text .conf-date-loc {
            font-size: 8.5pt;
            color: #888;
        }
        @endif

        /* ── Footer: signatures + cert number + QR ── */
        .cert-footer {
            width: 100%;
            border-top: 0.5mm solid #c9a227;
            padding-top: 3mm;
            margin-top: 5mm;
        }
        table.footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.footer-table td {
            vertical-align: bottom;
            text-align: center;
        }

        /* Cert number (center under QR) */
        .cert-number-block {
            text-align: center;
            margin-top: 2mm;
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

        /* Signatures */
        .sig-box {
            text-align: center;
            width: 100%;
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

    @php
        $headerLogo = $conference->loa_header_logo ?? $conference->logo ?? null;
        $isBanner = $conference && $conference->loa_header_logo;
    @endphp

    {{-- Full Width Banner --}}
    @if($isBanner && $headerLogo)
        <div class="full-width-banner">
            <img src="{{ public_path('storage/' . $headerLogo) }}" alt="Banner">
        </div>
    @endif

    {{-- Background panels --}}
    <div class="bg-left"></div>
    <div class="bg-right"></div>
    @if(!$isBanner) <div class="bg-top"></div> @endif
    <div class="bg-bottom"></div>

    {{-- Gold lines --}}
    <div class="gold-line-v-left"></div>
    <div class="gold-line-v-right"></div>
    @if(!$isBanner) <div class="gold-line-h-top"></div> @endif
    <div class="gold-line-h-bottom"></div>

    {{-- Corner diamonds --}}
    @if(!$isBanner)
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    @endif
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    {{-- Side labels --}}
    <div class="side-text-left">{{ $conference->acronym ?? config('app.name') }} &bull; {{ now()->year }}</div>
    <div class="side-text-right">{{ $conference->acronym ?? config('app.name') }} &bull; {{ now()->year }}</div>

    {{-- ── Main content ── --}}
    <div class="content-area" @if($isBanner) style="top: 60mm;" @endif>

        {{-- Header (Standard Logo & Text) --}}
        @if(!$isBanner)
        <div class="header">
            @if($headerLogo)
                <img class="logo" src="{{ public_path('storage/' . $headerLogo) }}" alt="Logo">
            @endif
            <div class="header-text">
                <div class="org-name">
                    @if($conference){{ $conference->name }}@else{{ config('app.name') }}@endif
                </div>
                @if($conference && $conference->theme)
                    <div class="conf-theme">{{ $conference->theme }}</div>
                @endif
                @if($conference && $conference->start_date)
                    <div class="conf-date">
                        {{ $conference->start_date->format('d') }}
                        @if($conference->end_date && $conference->end_date->ne($conference->start_date))
                            –{{ $conference->end_date->format('d') }}
                        @endif
                        {{ $conference->start_date->format('F Y') }}
                        @if($conference->city) &bull; {{ $conference->city }}@endif
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Certificate title --}}
        <div class="cert-label">
            <div class="word-certificate">Certificate</div>
            <span class="word-of">of</span>
            <div class="cert-type">
                @if($type === 'author')Presenter
                @elseif($type === 'participant')Participation
                @elseif($type === 'reviewer')Reviewing
                @elseif($type === 'committee')Committee Member
                @else{{ ucfirst($type) }}@endif
            </div>
        </div>

        {{-- Body --}}
        <div class="body-text">
            <div class="presented-to">This certificate is proudly presented to</div>
            <div class="recipient">{{ $user->name }}</div>
            <div class="divider"></div>
            @if($user->institution)
                <div class="institution">{{ $user->institution }}</div>
            @endif

            @if($type === 'author' && $paper)
                <div class="description">
                    for presenting the paper entitled:
                </div>
                <div class="paper-title">&ldquo;{{ $paper->title }}&rdquo;</div>
                <div class="conf-ref">at <strong>{{ $conference ? $conference->name : 'the conference' }}</strong></div>
            @elseif($type === 'participant')
                <div class="description">
                    for active participation in<br>
                    <strong>{{ $conference ? $conference->name : 'the conference' }}</strong>
                </div>
            @elseif($type === 'reviewer')
                <div class="description">
                    for valuable contribution as a peer reviewer for<br>
                    <strong>{{ $conference ? $conference->name : 'the conference' }}</strong>
                </div>
            @elseif($type === 'committee')
                <div class="description">
                    for dedicated service as a committee member of<br>
                    <strong>{{ $conference ? $conference->name : 'the conference' }}</strong>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        @php
            $showChairman       = $conference->show_chairman ?? true;
            $showSecretary      = $conference->show_secretary ?? true;
            $showInstChairman   = $conference->show_institute_chairman ?? false;
            $sigCount = ($showChairman ? 1 : 0) + ($showSecretary ? 1 : 0) + ($showInstChairman ? 1 : 0);
            // total cols = sigs + 1 QR col
            $totalCols = $sigCount + 1;
            $colPct = floor(100 / $totalCols) . '%';
        @endphp
        <div class="cert-footer">
            <table class="footer-table">
                <tr>
                    {{-- Chairman Signature --}}
                    @if($showChairman)
                    <td style="width: {{ $colPct }};">
                        <div class="sig-box">
                            <div class="sig-title">Chairperson</div>
                            @if($conference && $conference->chairman_signature && file_exists(public_path('storage/' . $conference->chairman_signature)))
                                <img src="{{ public_path('storage/' . $conference->chairman_signature) }}" class="sig-img" alt="Signature">
                            @else
                                <div class="sig-spacer"></div>
                            @endif
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $conference->chairman_name ?? $conference->organizer ?? 'Chairperson' }}</div>
                            <div class="sig-role">{{ $conference->chairman_title ?? 'Conference Chair' }}</div>
                        </div>
                    </td>
                    @endif

                    {{-- Institute Chairman Signature --}}
                    @if($showInstChairman)
                    <td style="width: {{ $colPct }};">
                        <div class="sig-box">
                            <div class="sig-title">Head of Institution</div>
                            @if($conference && $conference->institute_chairman_signature && file_exists(public_path('storage/' . $conference->institute_chairman_signature)))
                                <img src="{{ public_path('storage/' . $conference->institute_chairman_signature) }}" class="sig-img" alt="Signature">
                            @else
                                <div class="sig-spacer"></div>
                            @endif
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $conference->institute_chairman_name ?? 'Head of Institution' }}</div>
                            <div class="sig-role">{{ $conference->institute_chairman_title ?? '' }}</div>
                        </div>
                    </td>
                    @endif

                    {{-- Center QR Code & Cert Number --}}
                    <td style="width: {{ $colPct }};">
                        <div class="qr-block">
                            <img src="{{ $qrCode }}" alt="QR Verify">
                            <div class="qr-label">Scan to verify</div>
                        </div>
                        <div class="cert-number-block">
                            <div class="label">Certificate No.</div>
                            <div class="number">{{ $certNumber }}</div>
                            <div class="label" style="margin-top:1mm;">Issued: {{ $generatedDate->format('d F Y') }}</div>
                        </div>
                    </td>

                    {{-- Secretary Signature --}}
                    @if($showSecretary)
                    <td style="width: {{ $colPct }};">
                        <div class="sig-box">
                            <div class="sig-title">Secretary</div>
                            @if($conference && $conference->secretary_signature && file_exists(public_path('storage/' . $conference->secretary_signature)))
                                <img src="{{ public_path('storage/' . $conference->secretary_signature) }}" class="sig-img" alt="Signature">
                            @else
                                <div class="sig-spacer"></div>
                            @endif
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $conference->secretary_name ?? 'Conference Secretary' }}</div>
                            <div class="sig-role">{{ $conference->secretary_title ?? ($conference ? $conference->name : 'Conference') }}</div>
                        </div>
                    </td>
                    @endif
                </tr>
            </table>
        </div>
    </div><!-- /.content-area -->
</div><!-- /.page -->
</body>
</html>
