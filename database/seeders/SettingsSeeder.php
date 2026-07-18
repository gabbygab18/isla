<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Brand
            'brand_word'        => 'Isla',
            'footer_tagline'    => 'Managed virtual staffing for growing Australian businesses.',

            // Marquee (one phrase per line)
            'marquee_items'     => "NDIS-aware onboarding\nFlat management fee\nLifetime replacement guarantee\nAU business-hours overlap",

            // Hero
            'hero_eyebrow'      => 'Managed virtual staffing for Australian businesses',
            'hero_title'        => "Delegate the admin.\nProtect the care.",
            'hero_subtitle'     => 'Isla places dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses — people who understand participant confidentiality and compliance paperwork from day one.',
            'hero_image'        => 'https://images.unsplash.com/photo-1766066014237-00645c74e9c6?w=1200&q=80&auto=format&fit=crop',
            'hero_badge_strong' => '20+ hrs',
            'hero_badge_text'   => 'given back to your team, most weeks',
            'hero_cta_label'    => 'Book a Discovery Call',

            // Section intros
            'audiences_eyebrow'  => 'Who we work with',
            'audiences_heading'  => "Built for the work that can't be generic",
            'audiences_intro'    => 'Most virtual staffing agencies are horizontal generalists. Isla is built around three groups whose paperwork actually carries risk.',

            'services_eyebrow'   => 'Services',
            'services_heading'   => 'What your assistant can take off your plate',

            'process_eyebrow'    => 'How it works',
            'process_heading'    => 'From discovery call to onboarded, in about two weeks',
            'process_intro'      => 'A short, structured path — no lengthy procurement process, no ambiguity about what happens next.',

            'why_eyebrow'        => 'Why Isla',
            'why_heading'        => 'Straightforward, on purpose',
            'why_intro'          => 'The staffing industry is full of hidden markups and vague replacement policies. We built Isla around the opposite.',
            'why_image'          => 'https://images.unsplash.com/photo-1762955911431-4c44c7c3f408?w=1000&q=80&auto=format&fit=crop',

            'pricing_eyebrow'    => 'Pricing',
            'pricing_heading'    => 'Pay for hours, not for guesswork',
            'pricing_intro'      => 'Every engagement is scoped around your hours and sector — your discovery call gets you an exact quote.',

            'faq_eyebrow'        => 'FAQ',
            'faq_heading'        => 'Questions we get on almost every discovery call',

            // Contact
            'contact_eyebrow'    => 'Get started',
            'contact_heading'    => 'Tell us about your business',
            'contact_intro'      => "Send a few details and we'll come back with next steps within one business day.",
            'contact_email'      => 'hello@isla.com.au',
            'contact_phone'      => '+61 00 0000 0000',
            'contact_location'   => 'Supporting clients across Australia',

            // Trust bar (shared)
            'trust_location'   => 'Location: Across Australia',
            'trust_response'   => 'Most clients get a response same business day',
            'trust_industries' => 'Trusted by Australian businesses across multiple industries',
            'trust_managed'    => 'Australian-managed, Philippines-based',

            // About page
            'about_eyebrow'          => 'About Isla',
            'about_heading'          => "Built by people who've done the admin themselves",
            'about_intro'            => "Isla started with a simple observation: the businesses that need the most careful admin support were being served by agencies built for generic inboxes. We built something narrower, on purpose.",
            'about_image'            => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1000&q=80&auto=format&fit=crop',
            'about_story_eyebrow'    => 'Our story',
            'about_story_heading'    => 'A managed team, not a marketplace',
            'about_story_body_1'     => "Isla is a managed virtual staffing partner for Australian businesses, run by a Philippines-based team with an Australian-facing operating model. We're not a marketplace of freelancers and we're not a call-centre with a slick landing page — we place one dedicated assistant with your business, brief them on your sector before they ever touch a live account, and manage the relationship for as long as you need us to.",
            'about_story_body_2'     => "Every assistant we place works within Australian business hours, is briefed on the compliance and confidentiality standards your sector expects, and comes with Isla's lifetime replacement guarantee — because the fit mattering more than the contract is the whole point.",
            'about_stats_eyebrow'    => 'At a glance',
            'about_stats_heading'    => 'What working with Isla actually looks like',
            'about_stat_1_value'     => '20+ hrs',
            'about_stat_1_label'     => 'given back to a typical team, most weeks',
            'about_stat_2_value'     => '1–2 wks',
            'about_stat_2_label'     => 'from discovery call to onboarded',
            'about_stat_3_value'     => '4',
            'about_stat_3_label'     => 'sectors we build dedicated assistants around',
            'about_stat_4_value'     => 'Lifetime',
            'about_stat_4_label'     => 'replacement guarantee — no cap on timing',
            'about_values_eyebrow'   => 'What we hold ourselves to',
            'about_values_heading'   => 'Straightforward, on purpose',
            'about_values_intro'     => 'The same four commitments show up in every engagement, regardless of sector or size.',
            'about_industries_heading' => 'The industries we build assistants around',

            // Team We Build page
            'team_eyebrow'              => 'Team we build',
            'team_heading'              => 'The team we build around your business',
            'team_intro'                => "Start with one dedicated assistant covering the roles below, or scope a small rostered team on the Dedicated plan — either way, every role is matched, briefed, and managed by Isla.",
            'team_construction_title'   => 'Construction & Trades Admin',
            'team_construction_summary' => 'Quoting follow-ups, subcontractor scheduling, procurement paperwork, and compliance documentation kept moving between site and office.',
            'team_process_eyebrow'      => 'How we build your team',
            'team_process_heading'      => 'Matched to your sector, not assigned from a queue',
            'team_process_intro'        => 'The same discovery-to-onboarded path applies whether you need one assistant or a small rostered team.',

            // Book a Discovery Call page
            'book_eyebrow'         => 'Book a discovery call',
            'book_heading'         => 'A real conversation about where your hours are going',
            'book_intro'           => "Tell us what's taking up your time. We'll tell you what an assistant can take off your plate, roughly what it costs, and whether it's the right fit — including if it isn't.",
            'book_form_eyebrow'    => 'Get started',
            'book_form_heading'    => 'Tell us about your business',
            'book_form_intro'      => "Send a few details and we'll come back with a time to talk within one business day.",
            'book_next_eyebrow'    => 'What happens next',
            'book_next_heading'    => 'No pitch deck, no lock-in on the call itself',
            'book_lighter_eyebrow' => 'Not ready for a call?',
            'book_lighter_heading' => 'Two lighter ways to start',
            'book_lighter_intro'   => 'No pressure to book. Get a feel for the numbers first, or read the FAQ.',
            'book_faq_eyebrow'     => 'Questions about the call',
            'book_faq_heading'     => 'What to expect before you book',

            // Cost estimator page
            'calc_eyebrow'                => 'Cost estimator',
            'calc_heading'                => 'What would a dedicated assistant cost you?',
            'calc_intro'                  => 'Adjust the hours and sector below for an indicative monthly range — no email required. Your discovery call gets you an exact, written quote.',
            'calc_disclaimer'             => 'Indicative only, based on typical Isla rates and a flat monthly management fee per assistant. Exchange rate and figures are illustrative — your discovery call confirms an exact, written quote for your hours and sector.',
            'calc_rate_general_low'       => '10',
            'calc_rate_general_high'      => '13',
            'calc_rate_ndis_low'          => '13',
            'calc_rate_ndis_high'         => '17',
            'calc_rate_healthcare_low'    => '13',
            'calc_rate_healthcare_high'   => '17',
            'calc_rate_construction_low'  => '12',
            'calc_rate_construction_high' => '16',
            'calc_management_fee'         => '650',
            'calc_local_rate'             => '42',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
