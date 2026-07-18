@extends('layouts.admin')
@section('title', 'Settings')
@section('heading', 'Site settings')

@php
  // key => [label, type]  (type: text | textarea)
  $groups = [
    'Brand' => [
      'brand_word'     => ['Brand word', 'text'],
      'footer_tagline' => ['Footer tagline', 'text'],
      'marquee_items'  => ['Marquee phrases (one per line)', 'textarea'],
    ],
    'Hero' => [
      'hero_eyebrow'      => ['Eyebrow', 'text'],
      'hero_title'        => ['Title (line breaks allowed)', 'textarea'],
      'hero_subtitle'     => ['Subtitle', 'textarea'],
      'hero_image'        => ['Image URL', 'text'],
      'hero_badge_strong' => ['Badge — bold text', 'text'],
      'hero_badge_text'   => ['Badge — small text', 'text'],
      'hero_cta_label'    => ['Primary CTA label', 'text'],
    ],
    'Who we work with' => [
      'audiences_eyebrow' => ['Eyebrow', 'text'],
      'audiences_heading' => ['Heading', 'text'],
      'audiences_intro'   => ['Intro', 'textarea'],
    ],
    'Services' => [
      'services_eyebrow' => ['Eyebrow', 'text'],
      'services_heading' => ['Heading', 'text'],
    ],
    'How it works' => [
      'process_eyebrow' => ['Eyebrow', 'text'],
      'process_heading' => ['Heading', 'text'],
      'process_intro'   => ['Intro', 'textarea'],
    ],
    'Why Isla' => [
      'why_eyebrow' => ['Eyebrow', 'text'],
      'why_heading' => ['Heading', 'text'],
      'why_intro'   => ['Intro', 'textarea'],
      'why_image'   => ['Image URL', 'text'],
    ],
    'Pricing' => [
      'pricing_eyebrow' => ['Eyebrow', 'text'],
      'pricing_heading' => ['Heading', 'text'],
      'pricing_intro'   => ['Intro', 'textarea'],
    ],
    'FAQ' => [
      'faq_eyebrow' => ['Eyebrow', 'text'],
      'faq_heading' => ['Heading', 'text'],
    ],
    'Contact' => [
      'contact_eyebrow'  => ['Eyebrow', 'text'],
      'contact_heading'  => ['Heading', 'text'],
      'contact_intro'    => ['Intro', 'textarea'],
      'contact_email'    => ['Email', 'text'],
      'contact_phone'    => ['Phone', 'text'],
      'contact_location' => ['Location line', 'text'],
    ],
    'Trust bar (shared strip)' => [
      'trust_location'   => ['Item 1 — location', 'text'],
      'trust_response'   => ['Item 2 — response time', 'text'],
      'trust_industries' => ['Item 3 — industries', 'text'],
      'trust_managed'    => ['Item 4 — managed line', 'text'],
    ],
    'About page' => [
      'about_eyebrow'            => ['Hero eyebrow', 'text'],
      'about_heading'            => ['Hero heading', 'text'],
      'about_intro'              => ['Hero intro', 'textarea'],
      'about_image'              => ['Story image URL', 'text'],
      'about_story_eyebrow'      => ['Story eyebrow', 'text'],
      'about_story_heading'      => ['Story heading', 'text'],
      'about_story_body_1'       => ['Story paragraph 1', 'textarea'],
      'about_story_body_2'       => ['Story paragraph 2', 'textarea'],
      'about_stats_eyebrow'      => ['Stats eyebrow', 'text'],
      'about_stats_heading'      => ['Stats heading', 'text'],
      'about_stat_1_value'       => ['Stat 1 — value', 'text'],
      'about_stat_1_label'       => ['Stat 1 — label', 'text'],
      'about_stat_2_value'       => ['Stat 2 — value', 'text'],
      'about_stat_2_label'       => ['Stat 2 — label', 'text'],
      'about_stat_3_value'       => ['Stat 3 — value', 'text'],
      'about_stat_3_label'       => ['Stat 3 — label', 'text'],
      'about_stat_4_value'       => ['Stat 4 — value', 'text'],
      'about_stat_4_label'       => ['Stat 4 — label', 'text'],
      'about_values_eyebrow'     => ['Values eyebrow', 'text'],
      'about_values_heading'     => ['Values heading', 'text'],
      'about_values_intro'       => ['Values intro', 'textarea'],
      'about_industries_heading' => ['Industries section heading', 'text'],
    ],
    'Team We Build page' => [
      'team_eyebrow'              => ['Hero eyebrow', 'text'],
      'team_heading'              => ['Hero heading', 'text'],
      'team_intro'                => ['Hero intro', 'textarea'],
      'team_construction_title'   => ['Construction card — title', 'text'],
      'team_construction_summary' => ['Construction card — summary', 'textarea'],
      'team_process_eyebrow'      => ['Process eyebrow', 'text'],
      'team_process_heading'      => ['Process heading', 'text'],
      'team_process_intro'        => ['Process intro', 'textarea'],
    ],
    'Book a Discovery Call page' => [
      'book_eyebrow'         => ['Hero eyebrow', 'text'],
      'book_heading'         => ['Hero heading', 'text'],
      'book_intro'           => ['Hero intro', 'textarea'],
      'book_form_eyebrow'    => ['Form eyebrow', 'text'],
      'book_form_heading'    => ['Form heading', 'text'],
      'book_form_intro'      => ['Form intro', 'textarea'],
      'book_next_eyebrow'    => ['What happens next — eyebrow', 'text'],
      'book_next_heading'    => ['What happens next — heading', 'text'],
      'book_lighter_eyebrow' => ['Lighter options — eyebrow', 'text'],
      'book_lighter_heading' => ['Lighter options — heading', 'text'],
      'book_lighter_intro'   => ['Lighter options — intro', 'textarea'],
      'book_faq_eyebrow'     => ['Call FAQ eyebrow', 'text'],
      'book_faq_heading'     => ['Call FAQ heading', 'text'],
    ],
    'Cost estimator page' => [
      'calc_eyebrow'                => ['Hero eyebrow', 'text'],
      'calc_heading'                => ['Hero heading', 'text'],
      'calc_intro'                  => ['Hero intro', 'textarea'],
      'calc_disclaimer'             => ['Disclaimer text', 'textarea'],
      'calc_rate_general_low'       => ['General rate — low (A$/hr)', 'text'],
      'calc_rate_general_high'      => ['General rate — high (A$/hr)', 'text'],
      'calc_rate_ndis_low'          => ['NDIS rate — low (A$/hr)', 'text'],
      'calc_rate_ndis_high'         => ['NDIS rate — high (A$/hr)', 'text'],
      'calc_rate_healthcare_low'    => ['Healthcare rate — low (A$/hr)', 'text'],
      'calc_rate_healthcare_high'   => ['Healthcare rate — high (A$/hr)', 'text'],
      'calc_rate_construction_low'  => ['Construction rate — low (A$/hr)', 'text'],
      'calc_rate_construction_high' => ['Construction rate — high (A$/hr)', 'text'],
      'calc_management_fee'         => ['Flat management fee (A$/mo per VA)', 'text'],
      'calc_local_rate'             => ['Local hire equivalent (A$/hr)', 'text'],
    ],
  ];
@endphp

@section('content')
  <form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @foreach ($groups as $groupName => $fields)
      <div class="card-box">
        <h3 style="margin:0 0 16px; font-size:16px;">{{ $groupName }}</h3>
        <div class="form-grid" style="max-width:none;">
          @foreach ($fields as $key => [$label, $type])
            <div class="form-row">
              <label for="s_{{ $key }}">{{ $label }}</label>
              @if ($type === 'textarea')
                <textarea id="s_{{ $key }}" name="settings[{{ $key }}]">{{ $settings[$key] ?? '' }}</textarea>
              @else
                <input type="text" id="s_{{ $key }}" name="settings[{{ $key }}]" value="{{ $settings[$key] ?? '' }}">
              @endif
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
    <div class="form-actions" style="position:sticky; bottom:0; background:var(--cream); padding:14px 0;">
      <button type="submit" class="btn btn-primary">Save all settings</button>
    </div>
  </form>
@endsection
