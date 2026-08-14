<?php

namespace Database\Seeders;

use App\Models\Audience;
use App\Models\Benefit;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Testimonial;
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
                'title'   => 'NDIS, Aged Care and Community Services',
                'slug'    => 'ndis-aged-care-community-services',
                'summary' => 'Support that understands the responsibility behind care.',
                'body'    => "Dedicated offshore professionals prepared for participant confidentiality, accurate documentation, workforce coordination and the operational standards expected across care-based services.\\n\\nNDIS providers, aged care organisations and community service businesses carry administrative responsibilities that directly affect service quality, participant safety and organisational compliance. A missing service agreement, an incomplete incident record or an expired workforce document is not simply an administrative oversight — it can create operational, financial and regulatory risk.\\n\\nIsla prepares professionals around the environment they will be supporting. Before accessing live systems, they receive role-appropriate briefing on relevant sector expectations, participant and client confidentiality, documentation standards, professional communication and the provider's internal procedures.\\n\\nThe result is structured operational support that helps protect service delivery rather than creating another layer of risk for management.",
                'points'  => [
                    'Role-appropriate briefing on relevant NDIS and care-sector requirements',
                    'Participant and client confidentiality embedded into onboarding',
                    'Accurate service agreements, records, registers and supporting documentation',
                    'Professional communication with participants, families, workers and stakeholders',
                ],
            ],
            [
                'icon'    => 'i-clipboard',
                'title'   => 'Healthcare and Allied Health',
                'slug'    => 'healthcare-allied-health',
                'summary' => 'Reliable practice support built around patient care.',
                'body'    => "Dedicated professionals prepared for confidential information handling, patient communication, referrals, appointments and the administrative processes that keep healthcare practices operating effectively.\\n\\nHealthcare and allied health providers need more than general administration. Patient records, referrals, billing information, appointments and practitioner schedules must be handled accurately, respectfully and with appropriate privacy controls.\\n\\nIsla helps practices strengthen the operational work surrounding patient care. Your dedicated professional is prepared around your systems, communication standards, privacy expectations and practice workflows before taking responsibility for live tasks.\\n\\nThis gives practitioners and internal teams greater capacity to focus on clinical work, patient outcomes and practice growth while essential administration continues in the background. Health information is treated as sensitive information under Australian privacy requirements, making structured information-handling processes particularly important.",
                'points'  => [
                    'Confidential handling of patient and client information',
                    'Consistent appointment, referral and intake coordination',
                    'Accurate records, billing support and administrative follow-up',
                    'Professional communication aligned with your practice standards',
                ],
            ],
            [
                'icon'    => 'i-hardhat',
                'title'   => 'Construction',
                'slug'    => 'construction',
                'summary' => 'Keep projects moving between the office and the site.',
                'body'    => "Dedicated professionals who understand the documentation, coordination and commercial follow-up required to support construction businesses.\\n\\nConstruction leaders often manage projects, clients, subcontractors, suppliers, quotations and compliance requirements simultaneously. When administrative work falls behind, the impact can quickly reach project schedules, cash flow and client relationships.\\n\\nIsla builds offshore support around your construction workflows. Your professional is prepared around your project stages, software, document requirements, reporting expectations and communication processes so they can contribute meaningfully to the business.\\n\\nFrom estimating and procurement support to project administration and financial follow-up, Isla helps reduce the operational pressure placed on directors, project managers and site teams.",
                'points'  => [
                    'Project documentation organised and kept current',
                    'Quotations, estimates and outstanding actions followed up consistently',
                    'Better coordination between clients, suppliers, subcontractors and internal teams',
                    'Administrative capacity that allows project leaders to remain focused on delivery',
                ],
            ],
            [
                'icon'    => 'i-calculator',
                'title'   => 'Engineering',
                'slug'    => 'engineering',
                'summary' => 'Technical support that respects accuracy and project discipline.',
                'body'    => "Dedicated professionals prepared to support engineering documentation, drafting workflows, drawing control and project coordination.\\n\\nEngineering businesses rely on accuracy, version control and disciplined communication. Technical documents, drawings, revisions and project records must remain organised so teams can work from reliable information.\\n\\nIsla supports engineering firms by building dedicated capacity around their technical and operational workflows. Professionals are matched according to the software, project environment and technical capability required by the business.\\n\\nThis helps engineering teams increase production capacity, improve document coordination and reduce the time senior technical staff spend managing recurring administrative work.",
                'points'  => [
                    'Technical drawings and documentation managed through clear workflows',
                    'Drawing registers, revisions and project records maintained accurately',
                    'Administrative support aligned with engineering and project teams',
                    'Additional production capacity without overloading internal specialists',
                ],
            ],
            [
                'icon'    => 'i-pin',
                'title'   => 'Real Estate and Property Management',
                'slug'    => 'real-estate-property-management',
                'summary' => 'More capacity across listings, leasing and portfolio support.',
                'body'    => "Dedicated professionals who understand the pace, communication and administrative follow-through required across real estate and property management.\\n\\nReal estate agencies and property management businesses operate across constant client communication, inspections, listings, lease documentation, tenant enquiries, maintenance requests and database updates. When these activities are not followed through consistently, service quality and business growth can suffer.\\n\\nIsla helps agencies build dependable offshore support around their existing sales and property management systems. Your professional is prepared around your portfolio, communication standards, CRM, property software and escalation processes.\\n\\nThe result is stronger administrative continuity for property managers, sales agents and business owners — with fewer routine tasks competing for their attention.",
                'points'  => [
                    'Listings, property records and databases kept current',
                    'Tenant, landlord, buyer and vendor enquiries followed up professionally',
                    'Leasing, inspection and maintenance administration coordinated consistently',
                    'Greater capacity for agents and property managers to focus on relationships and growth',
                ],
            ],
            [
                'icon'    => 'i-receipt',
                'title'   => 'Finance and Accounting',
                'slug'    => 'finance-accounting',
                'summary' => 'Structured support for accurate financial operations.',
                'body'    => "Dedicated professionals prepared to support bookkeeping, payroll, invoicing, reconciliations and client administration.\\n\\nFinance and accounting businesses depend on accuracy, consistency and timely processing. Unreconciled transactions, delayed invoices, incomplete records and missed client follow-ups can create pressure across reporting deadlines and cash flow.\\n\\nIsla builds offshore capacity around your established accounting systems and internal controls. Your dedicated professional works within clearly defined responsibilities, approval pathways and confidentiality expectations.\\n\\nThis allows accountants, finance leaders and business owners to delegate recurring processing and administration while retaining oversight of financial decisions and professional advice.",
                'points'  => [
                    'Transactions, invoices and reconciliations kept current',
                    'Clear approval and escalation processes',
                    'Confidential handling of client and financial information',
                    'More time for internal professionals to focus on analysis, advice and decision-making',
                ],
            ],
            [
                'icon'    => 'i-check',
                'title'   => 'Insurance',
                'slug'    => 'insurance',
                'summary' => 'Dependable support across the policy and claims lifecycle.',
                'body'    => "Dedicated professionals who can support insurance administration, documentation, customer communication and operational follow-up.\\n\\nInsurance businesses manage high volumes of client information, policy documents, renewals, claims records and time-sensitive communication. Delays or incomplete information can affect customer experience and internal processing.\\n\\nIsla helps insurance businesses build additional capacity around their existing systems and procedures. Professionals are prepared around the type of administration they will manage, the information they may access and the escalation pathways they must follow.\\n\\nThis provides consistent back-office and customer support while licensed and authorised professionals retain responsibility for regulated advice and decisions.",
                'points'  => [
                    'Policy, renewal and claims documentation kept organised',
                    'Client enquiries and outstanding information followed up consistently',
                    'Clear boundaries between administration and regulated advice',
                    'Structured support across customer service and back-office processing',
                ],
            ],
            [
                'icon'    => 'i-star',
                'title'   => 'eCommerce and Retail',
                'slug'    => 'ecommerce-retail',
                'summary' => 'Keep customers, products and orders moving.',
                'body'    => "Dedicated professionals who support online storefronts, customer communication, product information and everyday retail operations.\\n\\neCommerce and retail businesses manage a continuous flow of orders, customer enquiries, product updates, stock information, returns and promotional activity. As sales grow, these recurring tasks can place significant pressure on founders and internal teams.\\n\\nIsla builds offshore support around your platforms, products, fulfilment processes and customer service standards. Your professional is prepared around the systems and workflows they will manage before taking ownership of recurring tasks.\\n\\nThis creates greater operational consistency while your internal team focuses on products, commercial strategy and customer growth.",
                'points'  => [
                    'Product and inventory information maintained accurately',
                    'Orders, returns and customer enquiries managed consistently',
                    'Online marketplaces and storefront administration kept current',
                    'Additional capacity during campaigns, launches and periods of growth',
                ],
            ],
            [
                'icon'    => 'i-globe',
                'title'   => 'Technology and IT',
                'slug'    => 'technology-it',
                'summary' => 'Scalable support for technical and digital operations.',
                'body'    => "Dedicated professionals matched to the systems, platforms and technical requirements of your business.\\n\\nTechnology businesses need people who can work within established systems, communicate technical information clearly and respond to issues without disrupting broader delivery.\\n\\nIsla helps businesses build offshore capacity across user support, software, systems administration, digital projects and customer success. Candidates are assessed according to the specific technology stack, tools and level of technical responsibility required.\\n\\nWhether you need recurring helpdesk coverage or specialised project support, Isla provides a managed staffing structure around the professional — not simply an introduction to a freelancer.",
                'points'  => [
                    'Candidates matched against specific systems and technical requirements',
                    'Clear access, security and escalation processes',
                    'Reliable support for users, customers and internal teams',
                    'Additional technical capacity that can grow with the business',
                ],
            ],
            [
                'icon'    => 'i-calendar-heart',
                'title'   => 'Fitness, Health and Wellness',
                'slug'    => 'fitness-health-wellness',
                'summary' => 'Client support that keeps your community engaged.',
                'body'    => "Dedicated professionals who support memberships, bookings, enquiries, client engagement and business administration.\\n\\nGyms, coaches, fitness centres and wellness businesses grow through strong client experiences and consistent communication. However, membership enquiries, bookings, follow-ups and administration can consume the time needed to deliver services and build the business.\\n\\nIsla helps health and wellness businesses create dependable offshore support around their client journey. Your professional is prepared around your brand voice, booking platforms, membership processes and service expectations.\\n\\nThis gives owners, coaches and practitioners greater capacity to focus on their clients while everyday communication and administration remain organised.",
                'points'  => [
                    'Membership and client enquiries responded to consistently',
                    'Bookings, reminders and follow-ups kept organised',
                    'Communication aligned with your brand and client experience',
                    'More capacity for owners and practitioners to focus on service delivery',
                ],
            ],
            [
                'icon'    => 'i-sparkles',
                'title'   => 'Renewable Energy',
                'slug'    => 'renewable-energy',
                'summary' => 'Operational support for a growing and fast-moving sector.',
                'body'    => "Dedicated professionals who support customer enquiries, project administration, documentation, procurement and commercial growth.\\n\\nRenewable energy businesses coordinate customers, technical teams, suppliers, documentation, approvals and installation schedules across multiple stages of delivery. Growth can create significant administrative pressure if these activities are not supported by structured systems and consistent follow-through.\\n\\nIsla helps renewable energy businesses build additional operational capacity around their existing workflows. Your professional is prepared around your customer journey, project stages, systems and internal reporting requirements.\\n\\nThis helps technical and commercial teams remain focused on project delivery, customer outcomes and business development.",
                'points'  => [
                    'Customer and project information kept organised',
                    'Documentation and outstanding actions followed up consistently',
                    'Better coordination between customers, suppliers and internal teams',
                    'Additional administrative capacity to support business growth',
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
                'title'   => 'Administration and Executive Support',
                'slug'    => 'administration-executive-support',
                'summary' => 'Reliable administrative professionals who keep your calendar, communication, records and everyday priorities organised.',
                'body'    => 'Your dedicated administrative professional is recruited around your role and prepared on your systems, tools and working style before taking ownership of live tasks. Diaries, inboxes, records and follow-ups stay organised while Isla supports the engagement with account management, payroll administration and ongoing oversight.',
                'deliverables' => [
                    'Diary and calendar management',
                    'Email and inbox management',
                    'Appointment scheduling',
                    'Document preparation',
                    'Data entry and database updates',
                    'Meeting coordination',
                    'Travel and itinerary support',
                    'Reporting and administrative follow-ups',
                    'Customer and stakeholder communication',
                ],
                'roles' => [
                    'Virtual Assistant',
                    'Executive Assistant',
                    'Personal Assistant',
                    'Administration Assistant',
                    'Office Administrator',
                    'Data Entry Specialist',
                    'Document Controller',
                    'Records Administrator',
                    'Email and Calendar Coordinator',
                    'Appointment Setter',
                    'Virtual Receptionist',
                ],
            ],
            [
                'icon'    => 'i-headset',
                'title'   => 'Client and Intake Support',
                'slug'    => 'client-intake-support',
                'summary' => 'Dedicated professionals who help manage enquiries, referrals, onboarding and ongoing client communication.',
                'body'    => 'From first enquiry through to service commencement, your professional keeps referrals, intake documentation and client records moving. They are prepared around your systems, communication standards and confidentiality expectations, with Isla supporting the engagement throughout.',
                'deliverables' => [
                    'Responding to client and participant enquiries',
                    'Managing referrals and intake forms',
                    'Preparing onboarding documentation',
                    'Coordinating service agreements',
                    'Updating client records',
                    'Following up outstanding information',
                    'Supporting stakeholder communication',
                    'Maintaining accurate client files',
                    'Coordinating appointments and service commencement',
                ],
                'roles' => [
                    'Client Support Officer',
                    'Participant Intake Coordinator',
                    'Referral Coordinator',
                    'Client Care Coordinator',
                    'NDIS Administration Assistant',
                    'Support Coordination Administrator',
                    'Service Agreement Administrator',
                    'Patient Intake Coordinator',
                    'Membership Support Officer',
                    'Customer Onboarding Specialist',
                ],
            ],
            [
                'icon'    => 'i-receipt',
                'title'   => 'Finance, Bookkeeping and Payroll',
                'slug'    => 'finance-bookkeeping-payroll',
                'summary' => 'Finance support professionals who help keep transactions, payroll, invoicing and reporting accurate and current.',
                'body'    => 'Your finance professional works within your established accounting systems, approval pathways and confidentiality expectations — keeping invoicing, reconciliations, payroll preparation and follow-ups current so internal teams can focus on analysis and decisions.',
                'deliverables' => [
                    'Preparing and issuing invoices',
                    'Accounts payable and receivable processing',
                    'Bank and account reconciliation',
                    'Payroll and timesheet preparation',
                    'Following up outstanding payments',
                    'Expense and transaction recording',
                    'Financial data entry',
                    'Supporting management reports',
                    'Maintaining finance registers and records',
                ],
                'roles' => [
                    'Bookkeeper',
                    'Finance Administrator',
                    'Accounts Payable Officer',
                    'Accounts Receivable Officer',
                    'Payroll Administrator',
                    'Billing Officer',
                    'Invoicing Administrator',
                    'Reconciliation Assistant',
                    'Timesheet Administrator',
                    'Debt Collection Officer',
                ],
            ],
            [
                'icon'    => 'i-users',
                'title'   => 'Human Resources and Workforce Administration',
                'slug'    => 'hr-workforce-administration',
                'summary' => 'HR professionals who support recruitment, onboarding, employee records and everyday workforce coordination.',
                'body'    => 'From candidate sourcing to onboarding documentation and workforce registers, your HR professional keeps people processes organised and current. They work within your procedures and compliance requirements, supported by Isla\'s account management and workforce infrastructure.',
                'deliverables' => [
                    'Candidate sourcing and screening',
                    'Interview coordination',
                    'Preparing onboarding documentation',
                    'Maintaining employee and contractor files',
                    'Monitoring employment and compliance documents',
                    'Coordinating inductions and training',
                    'Supporting performance review processes',
                    'Preparing HR correspondence',
                    'Updating workforce registers',
                    'Managing recruitment pipelines',
                ],
                'roles' => [
                    'HR Administrator',
                    'HR Manager',
                    'HR Coordinator',
                    'Recruitment Coordinator',
                    'Talent Sourcing Specialist',
                    'Onboarding Administrator',
                    'Workforce Administrator',
                    'Employee Records Officer',
                    'Training and Induction Coordinator',
                    'Payroll and HR Assistant',
                    'Compliance Recruitment Officer',
                ],
            ],
            [
                'icon'    => 'i-shield',
                'title'   => 'Compliance, Quality and Documentation',
                'slug'    => 'compliance-quality-documentation',
                'summary' => 'Professionals who help maintain structured records, registers, policies and evidence required for operational compliance and audit readiness.',
                'body'    => 'Registers, policies, incident documentation and audit evidence stay structured and current. Your professional is prepared around your quality framework and internal procedures, so compliance work strengthens the business instead of consuming leadership time.',
                'deliverables' => [
                    'Reviewing compliance documents',
                    'Maintaining registers and trackers',
                    'Monitoring document expiry dates',
                    'Preparing audit evidence',
                    'Supporting internal audits',
                    'Updating policies and procedures',
                    'Managing incident documentation',
                    'Maintaining participant, client and employee records',
                    'Conducting file checks',
                    'Supporting corrective action tracking',
                ],
                'roles' => [
                    'Compliance Administrator',
                    'Quality and Compliance Officer',
                    'Audit Support Assistant',
                    'Documentation Specialist',
                    'Policy and Procedure Administrator',
                    'Incident Management Administrator',
                    'Risk and Compliance Assistant',
                    'Quality Management System Administrator',
                    'Workforce Compliance Officer',
                    'Records and Register Coordinator',
                ],
            ],
            [
                'icon'    => 'i-phone',
                'title'   => 'Customer Service and Virtual Reception',
                'slug'    => 'customer-service-virtual-reception',
                'summary' => 'Customer support professionals who help keep enquiries, calls and service requests moving during agreed business hours.',
                'body'    => 'Calls, emails and live-chat enquiries are answered professionally during your agreed Australian-aligned schedule. Your professional is prepared around your brand voice, systems and escalation processes, with Isla managing the engagement behind them.',
                'deliverables' => [
                    'Answering inbound calls',
                    'Managing email and live-chat enquiries',
                    'Booking appointments',
                    'Responding to customer questions',
                    'Escalating complaints and concerns',
                    'Updating customer records',
                    'Following up service requests',
                    'Providing order or booking updates',
                    'Supporting customer retention activities',
                ],
                'roles' => [
                    'Customer Service Representative',
                    'Virtual Receptionist',
                    'Phone Support Officer',
                    'Live Chat Agent',
                    'Email Support Representative',
                    'Customer Care Specialist',
                    'Helpdesk Support Officer',
                    'Complaints Administration Officer',
                    'Booking Coordinator',
                    'Service Support Officer',
                ],
            ],
            [
                'icon'    => 'i-hardhat',
                'title'   => 'Construction Administration and Estimating',
                'slug'    => 'construction-administration-estimating',
                'summary' => 'Construction professionals who support project administration, estimating, documentation and coordination between the office, suppliers and site teams.',
                'body'    => 'From quantity take-offs and tender support to purchase orders and project registers, your professional keeps the commercial and administrative side of your projects moving. They are prepared around your project stages, software and reporting expectations.',
                'deliverables' => [
                    'Preparing estimates and quantity take-offs',
                    'Reviewing plans and project documentation',
                    'Supporting tender preparation',
                    'Following up quotations',
                    'Coordinating subcontractor documentation',
                    'Maintaining project registers',
                    'Managing purchase orders',
                    'Supporting procurement activities',
                    'Updating project schedules',
                    'Preparing progress reports',
                    'Managing compliance and safety documentation',
                ],
                'roles' => [
                    'Construction Administrator',
                    'Project Administrator',
                    'Residential Construction Estimator',
                    'Cost Estimator',
                    'Estimating Assistant',
                    'Quantity Take-Off Specialist',
                    'Contract Administrator',
                    'Document Controller',
                    'Procurement Administrator',
                    'Project Scheduler',
                    'Construction Bookkeeper',
                    'Accounts and Payroll Administrator',
                ],
            ],
            [
                'icon'    => 'i-calculator',
                'title'   => 'Engineering, CAD and Technical Support',
                'slug'    => 'engineering-cad-technical-support',
                'summary' => 'Technical professionals who help engineering, construction and property businesses manage drafting, design support and project documentation.',
                'body'    => 'Drafting, drawing control and technical documentation handled by professionals matched to your software, project environment and technical requirements — adding production capacity without overloading your internal specialists.',
                'deliverables' => [
                    'Preparing and updating technical drawings',
                    'Drafting using AutoCAD or Revit',
                    'Maintaining drawing registers',
                    'Supporting design documentation',
                    'Updating plans and revisions',
                    'Coordinating technical files',
                    'Preparing project documentation',
                    'Assisting with estimating and take-offs',
                    'Supporting engineering and project teams',
                ],
                'roles' => [
                    'AutoCAD Draftsperson',
                    'CAD Draftsperson',
                    'Revit Technician',
                    'Architectural Drafting Assistant',
                    'Engineering Administrator',
                    'Technical Documentation Officer',
                    'Project Support Engineer',
                    'Estimating Technician',
                    'Drawing Register Coordinator',
                    'Technical Project Coordinator',
                ],
            ],
            [
                'icon'    => 'i-pin',
                'title'   => 'Real Estate and Property Support',
                'slug'    => 'real-estate-property-support',
                'summary' => 'Property professionals who support sales, listings, leasing, tenant communication and everyday portfolio administration.',
                'body'    => 'Listings, CRM updates, inspections, maintenance requests and tenant communication kept moving consistently. Your professional is prepared around your portfolio, property software and escalation processes, supported by Isla throughout the engagement.',
                'deliverables' => [
                    'Preparing property listings',
                    'Updating CRM and property databases',
                    'Coordinating inspections and appointments',
                    'Supporting tenant communication',
                    'Managing maintenance requests',
                    'Preparing sales and leasing documentation',
                    'Following up leads and enquiries',
                    'Supporting prospecting activities',
                    'Coordinating marketing materials',
                    'Assisting with arrears follow-up',
                    'Supporting property managers and sales agents',
                ],
                'roles' => [
                    'Real Estate Virtual Assistant',
                    'Property Management Assistant',
                    'Sales Administrator',
                    'Listing Coordinator',
                    'Leasing Administrator',
                    'Transaction Coordinator',
                    'Tenant Support Officer',
                    'Maintenance Coordinator',
                    'Prospecting Assistant',
                    'Property Database Administrator',
                    'Arrears Support Officer',
                    'Real Estate Marketing Assistant',
                ],
            ],
            [
                'icon'    => 'i-target',
                'title'   => 'Sales and Business Development',
                'slug'    => 'sales-business-development',
                'summary' => 'Dedicated sales professionals who help create opportunities, maintain prospecting activity and support your client acquisition pipeline.',
                'body'    => 'Lead lists, outreach, appointment setting and CRM hygiene handled consistently so your pipeline keeps moving. Your professional works your agreed schedule and follows your sales process, with Isla managing the workforce infrastructure behind them.',
                'deliverables' => [
                    'Building and qualifying lead lists',
                    'Conducting outbound calls',
                    'Email and LinkedIn outreach',
                    'Booking appointments',
                    'Updating CRM records',
                    'Following up prospects',
                    'Conducting market research',
                    'Preparing sales reports',
                    'Supporting proposals and presentations',
                    'Maintaining the business development pipeline',
                ],
                'roles' => [
                    'Business Development Representative',
                    'Sales Development Representative',
                    'Appointment Setter',
                    'Lead Generation Specialist',
                    'Outbound Sales Representative',
                    'Prospecting Assistant',
                    'CRM Administrator',
                    'Sales Support Coordinator',
                    'Client Relationship Assistant',
                    'Market Research Assistant',
                ],
            ],
            [
                'icon'    => 'i-megaphone',
                'title'   => 'Marketing and Creative Support',
                'slug'    => 'marketing-creative-support',
                'summary' => 'Marketing professionals who help maintain consistent campaigns, content and brand visibility.',
                'body'    => 'Content calendars, social accounts, campaigns and creative assets maintained consistently in your brand voice. Your professional is prepared around your tools, channels and approval processes before taking ownership of live activity.',
                'deliverables' => [
                    'Planning and scheduling content',
                    'Managing social media accounts',
                    'Writing website, email and campaign content',
                    'Preparing graphics and marketing materials',
                    'Supporting email campaigns',
                    'Updating website content',
                    'Assisting with search engine optimisation',
                    'Preparing newsletters',
                    'Editing short-form videos',
                    'Monitoring campaign activity',
                    'Maintaining content calendars',
                ],
                'roles' => [
                    'Marketing Coordinator',
                    'Digital Marketing Specialist',
                    'Social Media Manager',
                    'Content Writer',
                    'Copywriter',
                    'Graphic Designer',
                    'Video Editor',
                    'Email Marketing Assistant',
                    'SEO Assistant',
                    'Website Content Administrator',
                    'Marketing Automation Assistant',
                    'Brand and Communications Assistant',
                ],
            ],
            [
                'icon'    => 'i-star',
                'title'   => 'eCommerce and Retail Operations',
                'slug'    => 'ecommerce-retail-operations',
                'summary' => 'eCommerce professionals who support customer service, product management, order processing and digital storefront operations.',
                'body'    => 'Product listings, orders, returns and customer enquiries managed consistently across your platforms. Your professional is prepared around your storefront, fulfilment processes and customer service standards before taking ownership of recurring tasks.',
                'deliverables' => [
                    'Uploading and updating product listings',
                    'Processing orders',
                    'Managing customer enquiries',
                    'Coordinating returns and refunds',
                    'Updating inventory records',
                    'Supporting Shopify and marketplace platforms',
                    'Maintaining product information',
                    'Preparing sales and stock reports',
                    'Monitoring order fulfilment',
                    'Supporting promotions and campaigns',
                ],
                'roles' => [
                    'eCommerce Virtual Assistant',
                    'Shopify Assistant',
                    'Marketplace Administrator',
                    'Product Listing Specialist',
                    'Order Processing Officer',
                    'Inventory Administrator',
                    'Customer Service Representative',
                    'Returns and Refunds Administrator',
                    'Product Data Specialist',
                    'eCommerce Operations Assistant',
                ],
            ],
            [
                'icon'    => 'i-globe',
                'title'   => 'Technology and IT Support',
                'slug'    => 'technology-it-support',
                'summary' => 'Technical professionals who help businesses manage systems, user support, software and digital projects.',
                'body'    => 'Helpdesk coverage, systems administration, testing and technical documentation delivered by candidates assessed against your specific technology stack and level of technical responsibility — with clear access, security and escalation processes.',
                'deliverables' => [
                    'Providing user and technical support',
                    'Managing helpdesk requests',
                    'Troubleshooting systems and software',
                    'Supporting website maintenance',
                    'Assisting with software development',
                    'Testing platforms and applications',
                    'Preparing technical documentation',
                    'Managing user access and system records',
                    'Supporting implementation projects',
                    'Assisting customers with technical products',
                ],
                'roles' => [
                    'IT Support Specialist',
                    'Helpdesk Support Officer',
                    'Technical Support Representative',
                    'Web Developer',
                    'Software Developer',
                    'Quality Assurance Tester',
                    'Systems Administrator',
                    'Data Administrator',
                    'Technical Project Coordinator',
                    'Customer Success Specialist',
                ],
            ],
            [
                'icon'    => 'i-clipboard',
                'title'   => 'Operations and Project Coordination',
                'slug'    => 'operations-project-coordination',
                'summary' => 'Operational professionals who help coordinate workflows, projects, reporting and cross-functional priorities.',
                'body'    => 'Projects, trackers, reports and outstanding actions coordinated across your teams and suppliers. Your professional is prepared around your workflows and reporting requirements, giving managers and leadership teams dependable operational support.',
                'deliverables' => [
                    'Coordinating projects and action items',
                    'Monitoring workflows and deadlines',
                    'Preparing operational reports',
                    'Maintaining trackers and dashboards',
                    'Coordinating suppliers and stakeholders',
                    'Supporting process improvement',
                    'Documenting procedures',
                    'Managing task allocation',
                    'Following up outstanding actions',
                    'Supporting managers and leadership teams',
                ],
                'roles' => [
                    'Operations Assistant',
                    'Operations Coordinator',
                    'Project Coordinator',
                    'Project Administrator',
                    'Service Delivery Administrator',
                    'Workflow Coordinator',
                    'Procurement Assistant',
                    'Reporting Administrator',
                    'Executive Operations Assistant',
                    'Business Support Officer',
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
                'body'        => "Starter is built for solo practitioners and businesses taking their first step into outsourcing. You get one dedicated assistant for 20 hours a week — enough to lift the most draining admin off your plate without committing to full-time coverage.\n\nLike every Isla engagement, Starter runs on one inclusive hourly rate with ongoing replacement and continuity support and a named point of contact. Your exact quote is scoped to your hours and sector on the discovery call.",
                'features'    => [
                    '20 hours per week',
                    'One dedicated virtual assistant',
                    'One inclusive hourly rate — no hidden markup',
                    'Ongoing replacement and continuity support',
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
                'body'        => "Growth is our most popular plan for a reason — full-time, consistent coverage with a backup so a leave day never means a stalled inbox. Your dedicated assistant works 40 hours a week and is supported by backup cover for continuity.\n\nIt suits growing practices and small teams that have moved past 'nice to have' and need admin, support, or intake handled reliably every day. One inclusive hourly rate, ongoing replacement and continuity support, and a named point of contact are included.",
                'features'    => [
                    '40 hours per week',
                    'Dedicated virtual assistant plus backup cover',
                    'One inclusive hourly rate — no hidden markup',
                    'Ongoing replacement and continuity support',
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
                'body'        => "Dedicated is for established businesses scaling a function rather than filling a role. You get multiple assistants coordinated by a team lead, with rostered coverage so support, intake, or admin operations run through business hours without gaps.\n\nEverything is scoped to your operation on the discovery call — the number of assistants, the roster, and the workflows. The inclusive hourly rate, ongoing replacement and continuity support, and named point of contact scale with you.",
                'features'    => [
                    'Multiple dedicated assistants',
                    'A team lead coordinating the roster',
                    'Rostered coverage across business hours',
                    'One inclusive hourly rate — no hidden markup',
                    'Ongoing replacement and continuity support',
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
            ['number' => '01', 'title' => 'Understand the requirement', 'summary' => 'A discovery discussion to understand your operational pressure points, required outcomes, systems, working hours and preferred experience level.'],
            ['number' => '02', 'title' => 'Build the role',             'summary' => 'We define the position, responsibilities and candidate profile before sourcing professionals who match the practical needs of your business.'],
            ['number' => '03', 'title' => 'Select and onboard',         'summary' => 'You meet suitable shortlisted candidates and select the professional who best fits. Isla then coordinates the engagement, onboarding and commencement process.'],
            ['number' => '04', 'title' => 'Manage and strengthen',      'summary' => 'Isla continues to support the relationship through account management, HR assistance, performance oversight, payroll administration and operational support.'],
            ['number' => '05', 'title' => 'Scale when required',        'summary' => 'As your workload changes, we can help expand hours, introduce additional capabilities or build a wider offshore team around your operations.'],
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
            ['title' => 'Dedicated professionals',            'summary' => 'Candidates are selected around your role, systems, industry and working requirements — not placed through a generic talent pool.'],
            ['title' => 'One inclusive hourly rate',          'summary' => 'Your agreed hourly rate includes recruitment, sourcing, onboarding, payroll administration, HR support, account management, performance support, standard equipment and IT assistance.'],
            ['title' => 'Australian-aligned working hours',   'summary' => 'Your professional works an agreed schedule aligned with your Australian operations, team availability and business requirements.'],
            ['title' => 'Ongoing account management',         'summary' => 'A named Isla Account Manager supports communication, performance, workforce concerns and the ongoing development of the engagement.'],
            ['title' => 'Supported offshore operations',      'summary' => 'Isla assists with equipment, IT coordination, productivity monitoring and clear working expectations so your professional can stay focused on your business.'],
            ['title' => 'Continuity and replacement support', 'summary' => 'Where a placement is no longer suitable or becomes unavailable, Isla supports the transition and sourcing of a suitable replacement in accordance with your service agreement.'],
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
                'question' => 'How quickly can we get started?',
                'slug'     => 'getting-started',
                'answer'   => "Most clients have a shortlist of qualified candidates within 3–5 business days. Once you've selected your preferred candidate, onboarding can be completed in as little as 3 business days, depending on your systems and access requirements.",
            ],
            [
                'question' => 'What does Isla manage for us?',
                'slug'     => 'what-isla-manages',
                'answer'   => "Isla provides a fully managed staffing solution, taking care of recruitment and candidate sourcing, HR onboarding and ongoing support, payroll administration, performance and KPI management, productivity monitoring, dedicated account management, IT support and secure workstations, and workforce retention and employee engagement. You manage the day-to-day work, while we manage everything behind the scenes.",
            ],
            [
                'question' => 'Is my team member dedicated exclusively to my business?',
                'slug'     => 'dedicated-assistant',
                'answer'   => "Yes. Your dedicated professional works exclusively for your business during their agreed working hours. They are never shared across multiple clients, allowing them to become a genuine extension of your team.",
            ],
            [
                'question' => "What if the person isn't the right fit?",
                'slug'     => 'replacement-guarantee',
                'answer'   => "Finding the right long-term fit is important. If your team member isn't the right match, we'll work closely with you to understand your feedback and source a replacement at no additional recruitment cost, helping minimise disruption to your operations.",
            ],
            [
                'question' => 'Am I locked into a long-term contract?',
                'slug'     => 'contract-terms',
                'answer'   => "No. We don't believe in locking clients into lengthy agreements. If you decide to end your engagement, we simply ask for 30 days' written notice to ensure a smooth transition for both your business and your dedicated professional.",
            ],
            [
                'question' => 'Is my security deposit refundable?',
                'slug'     => 'security-deposit',
                'answer'   => "Yes. Your one-month security deposit is fully refundable once your account has been finalised and all outstanding invoices have been settled in accordance with your Service Agreement.",
            ],
            [
                'question' => 'How secure is my business data?',
                'slug'     => 'business-data-security',
                'answer'   => "Protecting your information is one of our highest priorities. Every Isla professional signs a Confidentiality Agreement, Non-Disclosure Agreement (NDA), and Data Privacy Agreement before commencing work. Our workforce operates using secure equipment and monitored environments, supported by productivity monitoring software with SOC 2 Type II compliance. Access to your systems is controlled entirely by your business, ensuring your data remains within your existing platforms and security policies.",
            ],
            [
                'question' => 'Who manages my dedicated professional?',
                'slug'     => 'day-to-day-management',
                'answer'   => "You remain responsible for allocating work, setting priorities, and managing day-to-day tasks. Isla manages everything else, including recruitment, onboarding, HR support, payroll administration, performance management, employee engagement, and ongoing workforce support.",
            ],
            [
                'question' => 'What happens if there are internet or power interruptions?',
                'slug'     => 'continuity-outages',
                'answer'   => "Business continuity is important. Our professionals have access to backup connectivity solutions where available, and our Account Management team monitors attendance and productivity closely. Should an unexpected interruption occur, we'll communicate with you promptly and work to minimise any disruption.",
            ],
            [
                'question' => 'Why hire professionals from the Philippines?',
                'slug'     => 'why-philippines',
                'answer'   => "The Philippines has become one of the world's leading destinations for professional outsourcing. Businesses benefit from highly educated, English-speaking professionals with strong experience supporting Australian organisations across construction, healthcare, finance, real estate, customer service, and administration. The close time zone alignment with Australia also enables real-time collaboration throughout the business day.",
            ],
            [
                'question' => 'Are your professionals paid fairly?',
                'slug'     => 'fair-pay',
                'answer'   => "Absolutely. At Isla, we're committed to building sustainable careers—not simply filling positions. We offer competitive compensation based on experience and role, together with benefits designed to support long-term retention. As our business grows, we're continuing to invest in our people through initiatives such as healthcare benefits, paid leave, professional development, and employee recognition programs. We believe that when our people are supported, our clients receive better service, stronger continuity, and higher-performing teams.",
            ],
            [
                'question' => 'How much can outsourcing save my business?',
                'slug'     => 'cost-savings',
                'answer'   => "Every business is different, but many of our clients reduce employment-related costs by up to 70% compared with hiring equivalent local positions. Beyond cost savings, outsourcing allows businesses to scale more efficiently, improve productivity, reduce recruitment challenges, and access highly skilled professionals without the overheads associated with local employment.",
            ],
            [
                'question' => 'Why choose Isla instead of a recruitment agency?',
                'slug'     => 'isla-vs-recruitment-agency',
                'answer'   => "Recruitment agencies help you hire. Isla helps you build and manage a dedicated offshore team. From sourcing and onboarding to payroll, HR, performance management, productivity monitoring, and ongoing workforce support, we provide a fully managed staffing solution that allows your team to focus on business growth while we take care of the people behind the scenes.",
            ],
        ];

        foreach ($faqs as $i => $row) {
            Faq::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }

        // ---------------------------------------------------------------
        // TESTIMONIALS
        // ---------------------------------------------------------------
        $testimonials = [
            [
                'author' => 'Chris J.',
                'role'   => 'Operations Manager',
                'quote'  => "Hiring virtual professionals through Isla has significantly improved the way we manage our workload. Our team has become more efficient and productive, allowing us to focus on higher-priority responsibilities while knowing that our day-to-day tasks are being handled with professionalism, reliability and care.",
            ],
            [
                'author' => 'Ruth C.',
                'role'   => 'Founder',
                'quote'  => "Working with Joanna has given me valuable time back in my day. I no longer have to constantly worry about whether the books are accurate, accounts are up to date or important financial tasks have been missed. Her support has brought greater structure, clarity and confidence to our business, allowing me to focus more on growth and our clients.",
            ],
            [
                'author' => 'Kevin C.',
                'role'   => 'Managing Director',
                'quote'  => "We are incredibly grateful for Andrea and for the professional appointment-setting team provided by Isla. They took the time to understand our needs, services and internal processes, and quickly applied the training and systems we provided. Our appointment setters communicate with clients professionally, explain our services clearly and consistently secure new opportunities for the business. Their contribution has increased our sales and service demand to the point where we have needed to hire additional on-site workers. The team has become a valuable extension of our company.",
            ],
            [
                'author' => 'Grace B.',
                'role'   => 'Director',
                'quote'  => "I was initially hesitant about outsourcing, particularly because the role required specific industry knowledge and experience. However, I was genuinely impressed when Isla presented more than three qualified candidates who already had relevant experience in the position. I never imagined that what I initially considered a simple support role would make such a meaningful contribution to our business.",
            ],
        ];

        foreach ($testimonials as $i => $row) {
            Testimonial::updateOrCreate(
                ['author' => $row['author']],
                array_merge($row, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }
        // ---------------------------------------------------------------
        // CLEANUP — remove rows no longer in the seed lists
        // ---------------------------------------------------------------
        Audience::whereNotIn('slug', ['ndis-aged-care-community-services', 'healthcare-allied-health', 'construction', 'engineering', 'real-estate-property-management', 'finance-accounting', 'insurance', 'ecommerce-retail', 'technology-it', 'fitness-health-wellness', 'renewable-energy'])->delete();
        Service::whereNotIn('slug', ['administration-executive-support', 'client-intake-support', 'finance-bookkeeping-payroll', 'hr-workforce-administration', 'compliance-quality-documentation', 'customer-service-virtual-reception', 'construction-administration-estimating', 'engineering-cad-technical-support', 'real-estate-property-support', 'sales-business-development', 'marketing-creative-support', 'ecommerce-retail-operations', 'technology-it-support', 'operations-project-coordination'])->delete();
        Benefit::whereNotIn('title', ['Dedicated professionals', 'One inclusive hourly rate', 'Australian-aligned working hours', 'Ongoing account management', 'Supported offshore operations', 'Continuity and replacement support'])->delete();
        ProcessStep::whereNotIn('number', ['01', '02', '03', '04', '05'])->delete();
        Faq::whereNotIn('slug', ['getting-started', 'what-isla-manages', 'dedicated-assistant', 'replacement-guarantee', 'contract-terms', 'security-deposit', 'business-data-security', 'day-to-day-management', 'continuity-outages', 'why-philippines', 'fair-pay', 'cost-savings', 'isla-vs-recruitment-agency'])->delete();

    }
}
