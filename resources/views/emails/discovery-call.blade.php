@php
    $isCall = str_contains((string) $enquiry->message, 'Preferred call time:');
    $time = null;
    $body = (string) $enquiry->message;
    if ($isCall && preg_match('/Preferred call time:\s*(.+?)(\n|$)/', $body, $m)) {
        $time = trim($m[1]);
        $body = trim(preg_replace('/Preferred call time:.*?(\n\n|\n|$)/s', '', $body, 1));
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f4f1ec;font-family:Arial,Helvetica,sans-serif;color:#2b2b2b;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f1ec;padding:24px 0;"><tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e7e2d8;">
<tr><td style="background:#2b2b2b;padding:20px 28px;"><span style="color:#fff;font-size:18px;font-weight:bold;">{{ $isCall ? 'New discovery call request' : 'New website enquiry' }}</span></td></tr>
<tr><td style="padding:28px;">
<p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#555;">Someone just submitted the {{ $isCall ? 'discovery call booking' : 'enquiry' }} form. Hit reply to respond to them directly.</p>
@if ($time)<div style="margin:0 0 20px;padding:14px 16px;background:#eef3ec;border-radius:8px;"><div style="font-size:12px;text-transform:uppercase;letter-spacing:0.6px;color:#5a7052;font-weight:bold;">Preferred call time</div><div style="font-size:16px;font-weight:bold;margin-top:4px;">{{ $time }}</div></div>@endif
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;line-height:1.6;">
<tr><td style="padding:8px 0;width:150px;color:#888;vertical-align:top;">Name</td><td style="padding:8px 0;font-weight:bold;">{{ $enquiry->full_name ?: '—' }}</td></tr>
@if ($enquiry->business_name)<tr><td style="padding:8px 0;color:#888;">Business</td><td style="padding:8px 0;">{{ $enquiry->business_name }}</td></tr>@endif
<tr><td style="padding:8px 0;color:#888;">Email</td><td style="padding:8px 0;"><a href="mailto:{{ $enquiry->email }}" style="color:#b5555a;text-decoration:none;">{{ $enquiry->email }}</a></td></tr>
@if ($enquiry->phone)<tr><td style="padding:8px 0;color:#888;">Phone</td><td style="padding:8px 0;">{{ $enquiry->phone }}</td></tr>@endif
@if ($enquiry->sector)<tr><td style="padding:8px 0;color:#888;">Industry</td><td style="padding:8px 0;">{{ $enquiry->sector }}</td></tr>@endif
</table>
<div style="margin:20px 0 0;"><div style="font-size:12px;text-transform:uppercase;letter-spacing:0.6px;color:#888;font-weight:bold;">{{ $isCall ? "What's eating their week" : 'Message' }}</div>
<div style="margin-top:8px;padding:14px 16px;background:#f7f5f0;border-radius:8px;font-size:14px;line-height:1.6;white-space:pre-wrap;">{{ $body ?: '—' }}</div></div>
<p style="margin:24px 0 0;font-size:12px;color:#aaa;">Submitted {{ $enquiry->created_at?->format('D, j M Y · g:i a') }} · logged under admin › Messages.</p>
</td></tr></table></td></tr></table></body></html>
