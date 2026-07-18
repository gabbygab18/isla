<?php

namespace Database\Seeders;

use App\Models\Audience;
use App\Models\Benefit;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\ProcessStep;
use App\Models\Service;
use Illuminate\Database\Seeder;

class IslaSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------------
        // WHO WE WORK WITH (audiences)
        // ---------------------------------------------------------------
        $audiences = [
            [
                'icon'    => 'i-shield',
                'title'   => 'NDIS & Disability Support',
                'slug'    => 'ndis-disability-support',
                'summary' => 'Assistants briefed on NDIS Practice Standards, participant-data confidentiality, and the audit trail your funding body expects.',
                'body'    => "NDIS providers carry paperwork that isn't just admin — it's compliance. A misfiled service agreement or a gap in an incident log can put funding and audits at risk. Isla places assistants who understand that from the first day, not after months of training on your dime.\n\nEvery assistant working with an NDIS provider is briefed on the NDIS Practice Standards, participant-data confidentiality, and the tone expected when speaking with participants and their families — before they ever touch a live account. The result is admin support that protects the care rather than adding risk to it.",
                'points'  => [
                    'Briefed on NDIS Practice Standards before going live',
                    'Participant-data confidentiality built into onboarding',
                    'Service agreements, incident logs, and audit-ready records',
                    'A tone of voice appropriate for participants and their families',
                ],
            ],
            [
                'icon'    => 'i-clipboard',
                'title'   => 'Healthcare & Allied Health',
                'slug'    => 'healthcare-allied-health',
                'summary' => 'Scheduling, billing codes, and patient-facing admin handled by someone who already speaks the language of your clinic.',
                'body'    => "Clinics lose hours to scheduling churn, billing codes, and the patient-facing admin that never quite fits into a clinical day. Isla places assistants who already speak the language of allied health, so you're not translating your workflow to a generalist.\n\nFrom appointment bookings and recalls to invoicing and claims, your assistant keeps the front-of-house running while your practitioners stay with patients. Sensitive patient information stays inside the systems you already use, under a confidentiality agreement signed during onboarding.",
                'points'  => [
                    'Appointment scheduling, recalls, and reminders',
                    'Billing codes, invoicing, and claims support',
                    'Patient-facing enquiries handled with care',
                    'Works inside the practice-management tools you already run',
                ],
            ],
            [
                'icon'    => 'i-users',
                'title'   => 'Growing Australian Businesses',
                'slug'    => 'growing-australian-businesses',
                'summary' => "From solo founders to ten-person teams, an assistant who scales with the parts of the business you don't have time for.",
                'body'    => "Growth creates admin faster than it creates time. The inbox fills, the invoicing slips, and the founder ends up doing the work only they can do at 9pm because there was no room for it at 9am. Isla places an assistant who takes the repeatable work off your plate so the business can keep moving.\n\nWhether you're a solo founder or a ten-person team, your assistant scales with you — starting with the tasks draining the most hours and expanding as trust builds. One flat management fee, a named point of contact, and no long procurement process to get there.",
                'points'  => [
                    'Inbox, scheduling, and follow-ups kept under control',
                    'Bookkeeping and invoicing kept current week to week',
                    'Scales from part-time support to a full-time VA',
                    'A named point of contact — never a ticket number',
                ],
            ],
            [
                'icon'    => 'i-hardhat',
                'title'   => 'Construction & Trades',
                'slug'    => 'construction-trades',
                'summary' => 'Quoting follow-ups, subcontractor scheduling, and procurement paperwork kept moving between site and office.',
                'body'    => "Construction and trades businesses lose momentum in the gap between the site and the office — quotes that stall, subcontractors chasing confirmations, and procurement paperwork nobody has time to chase. Isla places assistants who keep that admin moving so quotes go out, schedules stay current, and jobs don't stall on paperwork.\n\nYour assistant works from the systems you already use — job management software, supplier portals, and shared drives — handling the back-office side of a job so your site and project teams can stay focused on the build.",
                'points'  => [
                    'Quote and tender follow-ups kept on schedule',
                    'Subcontractor and trade scheduling coordination',
                    'Procurement paperwork and supplier follow-ups',
                    'Compliance documentation kept audit-ready',
                ],
            ],
        ];

        foreach ($audiences as $i => $row) {
            Audience::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }

        // ---------------------------------------------------------------
        // SERVICES
        // ---------------------------------------------------------------
        $services = [
            [
                'icon'    => 'i-calendar',
                'title'   => 'Admin & Scheduling',
                'slug'    => 'admin-scheduling',
                'summary' => 'Diary management, appointment bookings, and the follow-ups that fall through the cracks.',
                'body'    => "The everyday admin that keeps a business moving is exactly the work that gets pushed aside when the day gets busy. Your assistant owns your diary, books and confirms appointments, and chases the follow-ups that quietly fall through the cracks — so nothing important slips because there wasn't time.",
                'deliverables' => [
                    'Calendar and diary management',
                    'Appointment booking and confirmations',
                    'Reminders and follow-up sequences',
                    'Inbox triage and routing',
                ],
                'roles' => [
                    'Virtual Assistant',
                    'Executive Assistant',
                    'Appointment Setter',
                    'Scheduling Coordinator',
                    'Data Entry Specialist',
                    'Office Administrator',
                ],
            ],
            [
                'icon'    => 'i-headset',
                'title'   => 'Client & Participant Support',
                'slug'    => 'client-participant-support',
                'summary' => 'First point of contact for enquiries, intake forms, and day-to-day check-ins.',
                'body'    => "Your assistant becomes a reliable first point of contact — answering enquiries, guiding people through intake forms, and handling the day-to-day check-ins that keep clients and participants feeling looked after. For NDIS and healthcare clients, this is handled with the confidentiality and tone your sector requires.",
                'deliverables' => [
                    'First-response to enquiries',
                    'Intake form guidance and collection',
                    'Day-to-day client and participant check-ins',
                    'Escalation of anything that needs your attention',
                ],
                'roles' => [
                    'Client Support Officer',
                    'Intake Coordinator',
                    'NDIS Support Administrator',
                    'Participant Liaison',
                    'Reception & Enquiries VA',
                    'Case Note Assistant',
                ],
            ],
            [
                'icon'    => 'i-receipt',
                'title'   => 'Bookkeeping & Invoicing',
                'slug'    => 'bookkeeping-invoicing',
                'summary' => 'Reconciliation, invoicing, and expense tracking kept current, week to week.',
                'body'    => "Cash flow gets murky when the books are always a month behind. Your assistant keeps reconciliation, invoicing, and expense tracking current week to week, so you always know where things stand — and the end-of-month scramble stops being a scramble.",
                'deliverables' => [
                    'Weekly reconciliation',
                    'Invoice creation and follow-up',
                    'Expense tracking and categorisation',
                    'Reports ready for your accountant',
                ],
                'roles' => [
                    'Bookkeeper',
                    'Accounts Receivable Officer',
                    'Accounts Payable Officer',
                    'Payroll Assistant',
                    'Xero / MYOB Specialist',
                    'Billing Coordinator',
                ],
            ],
            [
                'icon'    => 'i-shield',
                'title'   => 'Compliance & Documentation',
                'slug'    => 'compliance-documentation',
                'summary' => 'Service agreements, incident logs, and the paperwork your sector requires.',
                'body'    => "For NDIS and healthcare providers especially, documentation is where risk hides. Your assistant keeps service agreements, incident logs, and sector-specific paperwork accurate and up to date — so an audit is a formality, not a fire drill.",
                'deliverables' => [
                    'Service agreements kept current',
                    'Incident logging and record-keeping',
                    'Audit-ready documentation',
                    'Policy and template upkeep',
                ],
                'roles' => [
                    'Compliance Administrator',
                    'Documentation Specialist',
                    'Quality & Audit Assistant',
                    'Policy & Template Officer',
                    'Records Management VA',
                    'Incident Register Coordinator',
                ],
            ],
            [
                'icon'    => 'i-megaphone',
                'title'   => 'Marketing & Social',
                'slug'    => 'marketing-social',
                'summary' => 'Content calendars, social scheduling, and newsletters that actually go out on time.',
                'body'    => "Marketing is usually the first thing to slip when the calendar is full. Your assistant keeps the content calendar moving — scheduling social posts, sending the newsletter, and keeping your presence consistent so the pipeline stays warm without you living in the scheduler.",
                'deliverables' => [
                    'Content calendar management',
                    'Social post scheduling',
                    'Newsletter drafting and send',
                    'Basic performance reporting',
                ],
                'roles' => [
                    'Social Media Manager',
                    'Content Writer',
                    'Graphic Designer',
                    'SEO Specialist',
                    'Email Marketing Assistant',
                    'Video Editor',
                ],
            ],
            [
                'icon'    => 'i-chat',
                'title'   => 'Customer Service',
                'slug'    => 'customer-service',
                'summary' => 'Inbox, live chat, and phone support covered during Australian business hours.',
                'body'    => "Responsive support builds trust, but staffing it in-house is expensive. Your assistant covers the inbox, live chat, and phone during Australian business hours — so enquiries get a fast, human answer without pulling your team off their core work.",
                'deliverables' => [
                    'Inbox and email support',
                    'Live chat coverage',
                    'Phone support during AU business hours',
                    'Consistent, on-brand responses',
                ],
                'roles' => [
                    'Customer Service Representative',
                    'Live Chat Agent',
                    'Phone Support Officer',
                    'Help Desk Assistant',
                    'Order & Enquiry Coordinator',
                    'Retention Support VA',
                ],
            ],
        ];

        foreach ($services as $i => $row) {
            Service::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }

        // ---------------------------------------------------------------
        // PRICING PLANS
        // ---------------------------------------------------------------
        $plans = [
            [
                'name'        => 'Starter',
                'slug'        => 'starter',
                'tag'         => 'Part-time support',
                'detail'      => '20 hrs / week · one dedicated VA',
                'summary'     => 'Great for solo practitioners and businesses just starting to outsource.',
                'body'        => "Starter is built for solo practitioners and businesses taking their first step into outsourcing. You get one dedicated assistant for 20 hours a week — enough to lift the most draining admin off your plate without committing to full-time coverage.\n\nLike every Isla engagement, Starter runs on one flat management fee with a lifetime replacement guarantee and a named point of contact. Your exact quote is scoped to your hours and sector on the discovery call.",
                'features'    => [
                    '20 hours per week',
                    'One dedicated virtual assistant',
                    'One flat management fee — no hidden markup',
                    'Lifetime replacement guarantee',
                    'A named point of contact',
                ],
                'ribbon'      => null,
                'is_featured' => false,
            ],
            [
                'name'        => 'Growth',
                'slug'        => 'growth',
                'tag'         => 'Full-time support',
                'detail'      => '40 hrs / week · dedicated VA + backup cover',
                'summary'     => 'Best for growing practices and small teams that need consistent coverage.',
                'body'        => "Growth is our most popular plan for a reason — full-time, consistent coverage with a backup so a leave day never means a stalled inbox. Your dedicated assistant works 40 hours a week and is supported by backup cover for continuity.\n\nIt suits growing practices and small teams that have moved past 'nice to have' and need admin, support, or intake handled reliably every day. One flat management fee, lifetime replacement guarantee, and a named point of contact are included.",
                'features'    => [
                    '40 hours per week',
                    'Dedicated virtual assistant plus backup cover',
                    'One flat management fee — no hidden markup',
                    'Lifetime replacement guarantee',
                    'Priority onboarding and 30-day check-in',
                ],
                'ribbon'      => 'Most popular',
                'is_featured' => true,
            ],
            [
                'name'        => 'Dedicated',
                'slug'        => 'dedicated',
                'tag'         => 'Team coverage',
                'detail'      => 'Multiple VAs · team lead · rostered coverage',
                'summary'     => 'For established businesses scaling admin, support, or intake operations.',
                'body'        => "Dedicated is for established businesses scaling a function rather than filling a role. You get multiple assistants coordinated by a team lead, with rostered coverage so support, intake, or admin operations run through business hours without gaps.\n\nEverything is scoped to your operation on the discovery call — the number of assistants, the roster, and the workflows. The flat-fee model, lifetime replacement guarantee, and named point of contact scale with you.",
                'features'    => [
                    'Multiple dedicated assistants',
                    'A team lead coordinating the roster',
                    'Rostered coverage across business hours',
                    'One flat management fee — no hidden markup',
                    'Lifetime replacement guarantee',
                ],
                'ribbon'      => null,
                'is_featured' => false,
            ],
        ];

        foreach ($plans as $i => $row) {
            PricingPlan::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }

        // ---------------------------------------------------------------
        // HOW IT WORKS (process steps)
        // ---------------------------------------------------------------
        $steps = [
            ['number' => '01', 'title' => 'Discover', 'summary' => 'A short call to understand your workload, your sector, and where the hours are actually going.'],
            ['number' => '02', 'title' => 'Match',    'summary' => 'We pair you with an assistant whose background fits your sector and the tools you already use.'],
            ['number' => '03', 'title' => 'Onboard',  'summary' => 'Structured onboarding in week one, with a check-in at 30 days to fine-tune the fit.'],
        ];

        foreach ($steps as $i => $row) {
            ProcessStep::updateOrCreate(
                ['number' => $row['number']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }

        // ---------------------------------------------------------------
        // WHY ISLA (benefits / checklist)
        // ---------------------------------------------------------------
        $benefits = [
            ['title' => 'One flat management fee',        'summary' => "No hidden markup layered on top of your assistant's pay."],
            ['title' => 'Lifetime replacement guarantee', 'summary' => "If the fit isn't right, we rematch at no extra cost — no cap on timing."],
            ['title' => 'NDIS-literate from day one',     'summary' => 'Practice Standards and participant confidentiality built into onboarding.'],
            ['title' => 'A named point of contact',       'summary' => "You'll always know exactly who to call — never a ticket number."],
        ];

        foreach ($benefits as $i => $row) {
            Benefit::updateOrCreate(
                ['title' => $row['title']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }

        // ---------------------------------------------------------------
        // FAQ
        // ---------------------------------------------------------------
        $faqs = [
            [
                'question' => 'Can a virtual assistant handle participant-facing admin?',
                'slug'     => 'participant-facing-admin',
                'answer'   => 'Yes. Assistants working with NDIS and healthcare clients are briefed on participant confidentiality, service agreements, and the tone expected when speaking with participants and their families — before they touch a live account.',
            ],
            [
                'question' => 'How is participant and patient data handled?',
                'slug'     => 'data-handling',
                'answer'   => 'Data stays inside the systems you already use. Assistants sign confidentiality agreements and are briefed on your specific privacy obligations during onboarding.',
            ],
            [
                'question' => "What if the assistant isn't the right fit?",
                'slug'     => 'replacement-guarantee',
                'answer'   => "We rematch at no extra cost. There's no cap on timing — the lifetime replacement guarantee holds for as long as you're working with us.",
            ],
            [
                'question' => 'What are the fees, exactly?',
                'slug'     => 'fees',
                'answer'   => "One flat management fee sits on top of your assistant's salary — nothing hidden, nothing bundled in later.",
            ],
            [
                'question' => 'How long does onboarding take?',
                'slug'     => 'onboarding-time',
                'answer'   => 'Most clients have their assistant live within one to two weeks of the discovery call.',
            ],
            [
                'question' => 'Why the Philippines, specifically?',
                'slug'     => 'why-philippines',
                'answer'   => "High English proficiency, a strong cultural fit with Australian workplaces, and a time zone close enough to overlap comfortably with a normal AU business day — without the graveyard-shift hours some other offshore markets require.",
            ],
            [
                'question' => 'Is my assistant dedicated only to me?',
                'slug'     => 'dedicated-assistant',
                'answer'   => "Yes. From day one, your assistant works for your business only — never split across multiple clients. Think of them as an extension of your team, working the hours you set.",
            ],
            [
                'question' => 'Am I locked into a long-term contract?',
                'slug'     => 'contract-terms',
                'answer'   => "No. There's no lock-in contract — if you ever need to end the engagement, we ask for reasonable notice so your assistant has a fair transition, and that's it.",
            ],
            [
                'question' => 'How is my business data kept secure?',
                'slug'     => 'business-data-security',
                'answer'   => "Assistants work inside the systems and accounts you already control, sign confidentiality agreements before onboarding, and are briefed on your specific data-handling requirements. You decide exactly what access they're given.",
            ],
            [
                'question' => "Who manages my assistant day to day?",
                'slug'     => 'day-to-day-management',
                'answer'   => "You do — just as you would an onshore team member. Isla handles onboarding, HR, and backup support behind the scenes, but the scope of work and daily direction is yours.",
            ],
            [
                'question' => 'What if there are internet or power issues on their end?',
                'slug'     => 'continuity-outages',
                'answer'   => "It's rare, but assistants working from managed facilities have backup power and redundant internet in place precisely for this. If it ever affects your coverage, your point of contact will let you know straight away.",
            ],
        ];

        foreach ($faqs as $i => $row) {
            Faq::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }
}
