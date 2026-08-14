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
            'marquee_items'     => "Sector-aware onboarding\nOne inclusive hourly rate\nOngoing replacement support\nAustralian-aligned working hours",

            // Hero
            'hero_eyebrow'      => 'Managed virtual staffing for Australian businesses',
            'hero_title'        => "Delegate the admin.\nProtect the care.",
            'hero_subtitle'     => 'Isla places dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses — supported by structured, sector-aware onboarding and ongoing workforce management.',
            'hero_image'        => 'https://images.unsplash.com/photo-1766066014237-00645c74e9c6?w=1200&q=80&auto=format&fit=crop',
            'hero_badge_strong' => 'Dedicated',
            'hero_badge_text'   => 'to your business during agreed working hours',
            'hero_cta_label'    => 'Book a Discovery Call',

            // Section intros
            'audiences_eyebrow'  => 'Industries',
            'audiences_heading'  => 'Industries We Support',
            'audiences_intro'    => 'Dedicated offshore professionals prepared around the systems, standards and pace of your industry.',

            'services_eyebrow'   => 'Services',
            'services_heading'   => 'What your assistant can take off your plate',

            'process_eyebrow'    => 'How it works',
            'process_heading'    => 'How the partnership works',
            'process_intro'      => 'A structured path from first conversation to a managed, ongoing engagement — with no ambiguity about what happens next.',

            'why_eyebrow'        => 'Why Isla',
            'why_heading'        => 'Straightforward, on purpose',
            'why_intro'          => 'The staffing industry is full of hidden markups and vague replacement policies. We built Isla around managed staffing through one inclusive hourly rate.',
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
            'contact_phone'      => '+61 2 4093 0535',
            'contact_location'   => "Teresa Avenue corner Plaridel Street, Nepo Center, Sto. Rosario, Angeles City 2009, Philippines",

            // Trust bar (shared)
            'trust_location'   => 'Location: Across Australia',
            'trust_response'   => 'Most clients get a response same business day',
            'trust_industries' => 'Trusted by Australian businesses across multiple industries',
            'trust_managed'    => 'Australian-managed, Philippines-based',

            // About page
            'about_eyebrow'          => 'About Isla',
            'about_heading'          => 'Built by people who understand the work behind business growth',
            'about_intro'            => 'Isla was built from hands-on experience supporting Australian businesses where administration, compliance, workforce coordination, documentation and client communication could not be treated as simple back-office tasks.',
            'about_image'            => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1000&q=80&auto=format&fit=crop',
            'about_story_eyebrow'    => 'Our story',
            'about_story_heading'    => 'A managed staffing partner, not a freelancer marketplace',
            'about_story_body_1'     => "We saw capable business owners and leaders spending too much time managing recruitment, onboarding, payroll, systems, follow-ups and everyday operational work. Traditional outsourcing models often provided a candidate but left the client responsible for everything that came afterwards. Isla was created to provide a more accountable solution: capable offshore professionals supported by structured recruitment, onboarding, workforce management and ongoing operational oversight.",
            'about_story_body_2'     => "With a freelancer marketplace, the service often ends after an introduction. With Isla, that is where the partnership begins. Your dedicated professional works an agreed schedule aligned with your Australian operating hours, while Isla provides the workforce infrastructure behind them — payroll administration, HR support, account management, IT assistance, productivity oversight and performance management. Our purpose is not simply to fill seats: it is to help businesses build dependable capacity and create more room for sustainable growth.",
            'about_values_eyebrow'   => 'What we hold ourselves to',
            'about_values_heading'   => 'What working with Isla gives you',
            'about_values_intro'     => 'The same commitments show up in every engagement, regardless of sector or size.',
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
            'calc_disclaimer'             => 'Indicative only, based on one inclusive hourly rate determined by role, experience level, working hours and service requirements. Exchange rate and figures are illustrative — your discovery call confirms an exact, written quote for your hours and sector.',
            'calc_rate_general_low'       => '10',
            'calc_rate_general_high'      => '13',
            'calc_rate_ndis_low'          => '13',
            'calc_rate_ndis_high'         => '17',
            'calc_rate_healthcare_low'    => '13',
            'calc_rate_healthcare_high'   => '17',
            'calc_rate_construction_low'  => '12',
            'calc_rate_construction_high' => '16',
            'calc_local_rate'             => '42',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
