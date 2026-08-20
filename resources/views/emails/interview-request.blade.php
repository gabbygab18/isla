<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f4f1ec;font-family:Arial,Helvetica,sans-serif;color:#2b2b2b;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f1ec;padding:24px 0;"><tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e7e2d8;">
<tr><td style="background:#2b2b2b;padding:20px 28px;"><span style="color:#fff;font-size:18px;font-weight:bold;">New interview request</span></td></tr>
<tr><td style="padding:28px;">

<p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#555;">
    A client shortlisted candidates from a talent bench link and asked to interview them. Hit reply to respond to them directly.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;line-height:1.6;">
<tr><td style="padding:8px 0;width:150px;color:#888;vertical-align:top;">Client</td><td style="padding:8px 0;font-weight:bold;">{{ $shortlist->client_name ?: '—' }}</td></tr>
@if ($shortlist->client_company)<tr><td style="padding:8px 0;color:#888;">Business</td><td style="padding:8px 0;">{{ $shortlist->client_company }}</td></tr>@endif
<tr><td style="padding:8px 0;color:#888;">Email</td><td style="padding:8px 0;"><a href="mailto:{{ $shortlist->client_email }}" style="color:#b5555a;text-decoration:none;">{{ $shortlist->client_email }}</a></td></tr>
<tr><td style="padding:8px 0;color:#888;">Industry</td><td style="padding:8px 0;">{{ $shortlist->role?->name ?? '—' }}</td></tr>
@if ($shortlist->subRole)<tr><td style="padding:8px 0;color:#888;">Role</td><td style="padding:8px 0;">{{ $shortlist->subRole->name }}</td></tr>@endif
</table>

<div style="margin:24px 0 0;">
<div style="font-size:12px;text-transform:uppercase;letter-spacing:0.6px;color:#888;font-weight:bold;">Requested interviews</div>

@forelse ($schedule as $i => $slot)
    @php $who = $candidates->get($slot['profile_id'] ?? null); @endphp
    <div style="margin-top:10px;padding:14px 16px;background:#f7f5f0;border-radius:8px;">
        <div style="font-size:15px;font-weight:bold;">{{ $i + 1 }}. {{ $who?->name ?? 'Candidate' }}</div>
        @if ($who?->role_title)<div style="font-size:13px;color:#888;margin-top:2px;">{{ $who->role_title }}</div>@endif
        <div style="font-size:14px;margin-top:8px;">
            <strong>{{ isset($slot['date']) ? \Carbon\Carbon::parse($slot['date'])->format('l, j F Y') : 'Date to confirm' }}</strong>
            @if (!empty($slot['times']))<span style="color:#555;"> · {{ $slot['times'] }}</span>@endif
        </div>
        @if (!empty($slot['note']))<div style="margin-top:8px;font-size:13px;color:#555;font-style:italic;">“{{ $slot['note'] }}”</div>@endif
        @if ($who?->rate)<div style="margin-top:6px;font-size:12px;color:#888;">Rate: {{ $who->rate }}@if ($who->availability) · Available: {{ $who->availability }}@endif</div>@endif
    </div>
@empty
    <div style="margin-top:10px;padding:14px 16px;background:#f7f5f0;border-radius:8px;font-size:14px;color:#555;">No per-candidate slots were captured.</div>
@endforelse
</div>

@if ($shortlist->notes)
<div style="margin:20px 0 0;">
<div style="font-size:12px;text-transform:uppercase;letter-spacing:0.6px;color:#888;font-weight:bold;">Notes from the client</div>
<div style="margin-top:8px;padding:14px 16px;background:#f7f5f0;border-radius:8px;font-size:14px;line-height:1.6;white-space:pre-wrap;">{{ $shortlist->notes }}</div>
</div>
@endif

<p style="margin:24px 0 0;font-size:12px;color:#aaa;">
    Submitted {{ $shortlist->created_at?->format('D, j M Y · g:i a') }} · logged under admin › Shortlists.
</p>

</td></tr></table></td></tr></table></body></html>
