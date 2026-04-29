<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letter of Acceptance - {{ $loaNumber }}</title>
    <style>
        @page {
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
        }
        
        .header {
            text-align: center;
            padding: 1.5cm 2cm 0 2cm;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .header.full-banner {
            padding: 0;
            margin-bottom: 20px;
            border: none;
        }

        .main-content {
            padding: 0 2cm 1.5cm 2cm;
        }

        .header-logos {
            margin-bottom: 5px;
        }
        
        .header img.logo {
            width: 100%;
            height: auto;
            max-width: 100%;
            display: block;
            margin: 0;
        }
        
        .header .title {
            font-size: 13pt;
            font-weight: bold;
            margin: 5px 0 3px 0;
            color: #1a3c7a;
            text-transform: uppercase;
        }
        
        .header .subtitle {
            font-size: 10pt;
            font-style: italic;
            margin: 2px 0;
            color: #333;
        }

        .header .address {
            font-size: 8pt;
            color: #555;
            margin: 3px 0 0 0;
            font-style: italic;
        }

        .header .contact-row {
            font-size: 8pt;
            color: #555;
            margin: 2px 0;
        }
        
        .title-doc {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0 15px 0;
            text-decoration: underline;
        }
        
        .content {
            text-align: justify;
            margin: 10px 0;
        }

        .content p {
            margin: 6px 0;
        }

        .paper-info {
            text-align: center;
            margin: 15px 20px;
            padding: 8px;
            border-bottom: 1px dotted #666;
        }
        
        .paper-title {
            font-style: italic;
            font-weight: bold;
            font-size: 11pt;
        }

        .paper-meta {
            text-align: center;
            font-size: 10pt;
            margin: 5px 0;
        }

        .important-dates {
            margin: 12px 0;
        }

        .important-dates table {
            width: 100%;
        }

        .important-dates td {
            padding: 2px 0;
            font-size: 10pt;
        }

        .important-dates td:first-child {
            padding-left: 10px;
        }

        .important-dates td:last-child {
            text-align: right;
            white-space: nowrap;
        }

        .payment-info {
            margin: 10px 0;
        }

        .contact-info {
            margin: 10px 0;
        }
        
        .signature-section {
            margin-top: 30px;
            text-align: right;
            padding-right: 30px;
        }
        
        .signature-image {
            height: 60px;
            margin: 5px 0;
        }
        
        .qr-section {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        
        .qr-section img {
            width: 80px;
            height: 80px;
        }
        
        .qr-text {
            font-size: 8pt;
            color: #888;
            margin-top: 3px;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 9pt;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    {{-- ═══ HEADER ═══ --}}
    @php
        $headerLogo = $conference->loa_header_logo ?? $conference->logo ?? null;
    @endphp
    <div class="header {{ $headerLogo ? 'full-banner' : '' }}">
        {{-- Logo --}}
        @if($headerLogo)
            <div class="header-logos">
                <img src="{{ public_path('storage/' . $headerLogo) }}" class="logo" alt="Logo">
            </div>
        @endif

        @if(!$conference->loa_header_logo)
            {{-- Title --}}
            @if($conference->loa_header_title)
                <div class="title">{{ $conference->loa_header_title }}</div>
            @else
                <div class="title">{{ $conference->name }}</div>
            @endif

            {{-- Subtitle --}}
            @if($conference->loa_header_subtitle)
                @foreach(explode("\n", $conference->loa_header_subtitle) as $line)
                    <div class="subtitle">{{ trim($line) }}</div>
                @endforeach
            @elseif($conference->theme)
                <div class="subtitle">{{ $conference->theme }}</div>
            @endif

            {{-- Address --}}
            @if($conference->loa_header_address)
                <div class="address">{{ $conference->loa_header_address }}</div>
            @elseif($conference->venue || $conference->city)
                <div class="address">{{ $conference->venue }}@if($conference->city), {{ $conference->city }}@endif</div>
            @endif

            {{-- Contact Row --}}
            @if($conference->loa_header_phone || $conference->loa_header_fax || $conference->loa_header_email)
            <div class="contact-row">
                @if($conference->loa_header_phone)Phone : {{ $conference->loa_header_phone }}@endif
                @if($conference->loa_header_fax) &nbsp;&nbsp; Fax : {{ $conference->loa_header_fax }}@endif
                @if($conference->loa_header_email) &nbsp;&nbsp; Email : {{ $conference->loa_header_email }}@endif
            </div>
            @endif
        @endif
    </div>
    
    <div class="main-content">
        {{-- ═══ DOCUMENT TITLE ═══ --}}
        <div class="title-doc">
            Letter of Acceptance (LoA)
        </div>
    
    {{-- ═══ BODY CONTENT ═══ --}}
    <div class="content">
        {{-- Intro Text --}}
        @if($conference->loa_body_intro)
            @foreach(explode("\n", $conference->loa_body_intro) as $line)
                <p>{{ str_replace(['{author_name}', '{paper_id}'], [$author->name, $paper->id], trim($line)) }}</p>
            @endforeach
        @else
            <p>Dear Author(s),</p>
            <p>We are pleased to inform you that your paper entitled</p>
        @endif

        {{-- Paper Title --}}
        <div class="paper-info">
            <div class="paper-title">{{ str_replace('{paper_title}', $paper->title, $paper->title) }}</div>
        </div>

        {{-- Paper Meta --}}
        <div class="paper-meta">
            Paper ID: {{ $paper->id }}
            &nbsp;&nbsp;&nbsp; Author(s): {{ $author->name }}@if($paper->authors_meta && is_array($paper->authors_meta) && count($paper->authors_meta) > 0), @foreach($paper->authors_meta as $authorMeta){{ $authorMeta['name'] ?? '' }}@if(!$loop->last), @endif@endforeach@endif
        </div>

        {{-- Acceptance Text --}}
        @if($conference->loa_body_acceptance)
            <p>{{ str_replace(
                ['{conference_name}', '{conference_date}'],
                [$conference->name, $conference->start_date ? $conference->start_date->format('F d, Y') : ''],
                $conference->loa_body_acceptance
            ) }}</p>
        @else
            <p>has been <strong>accepted for oral presentation</strong> at the <strong>{{ $conference->name }}</strong>
            @if($conference->start_date)
                , which scheduled to be held on {{ $conference->start_date->format('F d, Y') }}.
            @endif
            </p>
        @endif

        {{-- Important Dates --}}
        @php
            $importantDates = $conference->loa_important_dates ?? [];
        @endphp
        @if(count($importantDates) > 0)
        <div class="important-dates">
            <p><strong>Important Dates:</strong></p>
            <table>
                @foreach($importantDates as $dateItem)
                    @if(!empty($dateItem['label']) || !empty($dateItem['date']))
                    <tr>
                        <td>* {{ $dateItem['label'] ?? '' }}</td>
                        <td>: {{ $dateItem['date'] ?? '' }}</td>
                    </tr>
                    @endif
                @endforeach
            </table>
        </div>
        @endif

        {{-- Submission Info --}}
        @if($conference->loa_body_submission_info)
            @foreach(explode("\n", $conference->loa_body_submission_info) as $line)
                <p>{{ trim($line) }}</p>
            @endforeach
        @endif

        {{-- Payment Info --}}
        @if($conference->loa_payment_info)
        <div class="payment-info">
            @foreach(explode("\n", $conference->loa_payment_info) as $line)
                @php $trimmed = trim($line); @endphp
                @if(preg_match('/^(.+?)\s*:\s*(.+)$/', $trimmed, $m) && strlen($m[1]) < 30)
                    <p><strong>{{ $m[1] }}</strong> : {{ $m[2] }}</p>
                @else
                    <p>{{ $trimmed }}</p>
                @endif
            @endforeach
        </div>
        @endif

        {{-- Contact Info --}}
        @if($conference->loa_contact_info)
        <div class="contact-info">
            @foreach(explode("\n", $conference->loa_contact_info) as $line)
                <p>{{ trim($line) }}</p>
            @endforeach
        </div>
        @endif

        {{-- Closing Text --}}
        @if($conference->loa_closing_text)
            <p>{{ $conference->loa_closing_text }}</p>
        @else
            <p>We look forward to your valuable contribution and participation in the conference.</p>
        @endif
    </div>
    
    {{-- ═══ SIGNATURE ═══ --}}
    <div class="signature-section">
        <p>{{ $conference->city ?? 'Semarang' }}, {{ $generatedDate->format('d F Y') ?? '.....................' }}</p>
        <p>Sincerely,</p>
        
        {{-- Signature Image / Stamp --}}
        @php
            $sigImage = $conference->loa_signature_image ?? null;
        @endphp
        @if($sigImage && file_exists(public_path('storage/' . $sigImage)))
            <img src="{{ public_path('storage/' . $sigImage) }}" class="signature-image" alt="Signature">
        @elseif(file_exists(public_path('storage/signatures/chairman.png')))
            <img src="{{ public_path('storage/signatures/chairman.png') }}" class="signature-image" alt="Signature">
        @else
            <div style="height: 60px;"></div>
        @endif
        
        @if($conference->loa_signatory_name)
            <p style="font-weight: bold; text-decoration: underline; margin-top: 3px;">
                {{ $conference->loa_signatory_name }}
            </p>
        @else
            <p style="font-weight: bold; text-decoration: underline; margin-top: 3px;">
                {{ $conference->organizer ?? 'Ketua Panitia' }}
            </p>
        @endif

        @if($conference->loa_signatory_title)
            <p style="font-size: 10pt;">{{ $conference->loa_signatory_title }}</p>
        @else
            <p style="font-size: 10pt;">{{ $conference->name }}</p>
        @endif
    </div>
    
    {{-- ═══ QR CODE ═══ --}}
    <div class="qr-section">
        <img src="{{ $qrCode }}" alt="QR Code Verification">
        <p class="qr-text">Scan QR Code untuk verifikasi keaslian dokumen<br>{{ $loaNumber }}</p>
    </div><!-- /.main-content -->
    
    {{-- ═══ FOOTER ═══ --}}
    @if($conference->loa_footer_text)
    <div class="footer">
        <p>{{ $conference->loa_footer_text }}</p>
    </div>
    @else
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem dan sah tanpa tanda tangan basah</p>
    </div>
    @endif
</body>
</html>
