<?php

namespace Database\Seeders;

use App\Models\StaffProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Isla's talent bench — candidate/staff profiles admin can browse to match
 * against client requirements. Sourced from the "ISLA Staff Profile" PDF set.
 * Not public: shown only behind /admin (see StaffProfileController).
 */
class StaffProfileSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->profiles() as $i => $profile) {
            $profile['slug']       = Str::slug($profile['name'] . '-' . $profile['role_title']);
            $profile['sort_order'] = $i + 1;
            $profile['is_active']  = true;

            StaffProfile::updateOrCreate(['slug' => $profile['slug']], $profile);
        }
    }

    private function profiles(): array
    {
        return [
            [
                'name'       => 'Gabriel',
                'role_title' => 'Construction Cost Estimator',
                'category'   => 'Construction',
                'about_me'   => "Detail-oriented Construction Cost Estimator with experience supporting residential, commercial, renovation, and fit-out projects across Australia, the United States, and the Philippines. Skilled in quantity takeoffs, cost estimation, BOQ preparation, tender support, scheduling, and project coordination, with hands-on site engineering experience and proficiency in PlanSwift, Bluebeam Revu, Buildxact, Procore, Primavera P6, MS Project, AutoCAD, and Excel.",
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Build One Construction (AU)', 'title' => 'Residential Construction Estimator', 'period' => 'Dec 2025 - Jul 2026', 'bullets' => [
                        'Review architectural drawings, specifications, engineering plans, and client selections.',
                        'Prepare detailed quantity takeoffs and cost estimates for residential construction projects.',
                        'Measure materials and labour requirements using PlanSwift and Excel.',
                        'Prepare Bills of Quantities and trade breakdowns.',
                        'Request and review supplier and subcontractor quotations.',
                        'Update pricing databases and estimate templates.',
                        'Identify drawing discrepancies, missing information, and potential cost variations.',
                        'Coordinate with project managers, suppliers, and other team members to finalise estimates.',
                        'Assist with improving the estimating process by introducing PlanSwift to replace manual Excel-based takeoffs.',
                    ]],
                    ['company' => 'Titan Development (US)', 'title' => 'Construction Estimator & Project Scheduler', 'period' => 'Jan 2024 - Dec 2025', 'bullets' => [
                        'Reviewed construction drawings, specifications, and project scopes.',
                        'Prepared quantity takeoffs, cost estimates, and bid proposals.',
                        'Coordinated with suppliers and subcontractors to obtain pricing.',
                        'Developed and maintained project schedules, task lists, and construction timelines.',
                        'Monitored project progress based on daily site updates and field reports.',
                        'Updated project trackers and dashboards to reflect completed, ongoing, and delayed activities.',
                        'Coordinated with project managers and site teams regarding schedules, materials, and project requirements.',
                        'Identified potential scheduling conflicts and helped adjust timelines accordingly.',
                        'Prepared progress reports and communicated project updates to management.',
                    ]],
                    ['company' => 'Jakboa Builders', 'title' => 'Site Engineer', 'period' => 'Jul 2022 - Dec 2023', 'bullets' => [
                        'Supervised daily site activities and monitored the work of foremen, subcontractors, and workers.',
                        'Reviewed construction drawings and ensured that site work followed approved plans and specifications.',
                        'Conducted site inspections and monitored workmanship, quality, and safety compliance.',
                        'Prepared material quantity estimates and coordinated material requests and deliveries.',
                        'Monitored daily accomplishments, manpower, equipment, and material usage.',
                        'Prepared daily and weekly progress reports.',
                        'Coordinated with architects, engineers, suppliers, and subcontractors regarding site concerns.',
                        'Assisted in resolving drawing discrepancies and construction issues.',
                        'Monitored project schedules and helped ensure that activities were completed on time.',
                        'Assisted with documentation, permits, billings, and other project records.',
                    ]],
                    ['company' => 'Department of Public Works and Highways (DPWH)', 'title' => 'Assistant Engineer', 'period' => 'Jan 2021 - Jul 2022', 'bullets' => [
                        'Assisted engineers with the planning and implementation of government infrastructure projects.',
                        'Conducted regular site inspections and prepared inspection reports.',
                        'Monitored project progress and checked compliance with approved plans and specifications.',
                        'Assisted in verifying quantities, measurements, and completed work on-site.',
                        'Prepared and organised project documents, reports, and supporting records.',
                        'Coordinated with contractors and project personnel regarding site activities and requirements.',
                        'Documented construction issues, delays, and progress updates.',
                        'Assisted in reviewing plans, estimates, and other technical documents.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Mapua University', 'degree' => 'BS Construction Engineering Management', 'period' => null],
                ],
                'core_skills' => [
                    'Construction Project Management', 'Quantity Takeoff & Cost Estimation', 'Budgeting, Cost Control & Cost Forecasting',
                    'Bidding, Tendering & Proposal Preparation', 'Procurement & Subcontractor Pricing', 'Coordination', 'Project Cost Tracking & Estimate Validation',
                ],
                'software_expertise' => ['PlanSwift', 'Buildxact', 'Procore', 'Wunderbuild', 'Primavera P6', 'MS Project', 'AutoCAD', 'Excel'],
            ],
            [
                'name'       => 'Elijah',
                'role_title' => 'Construction Cost Estimator | Quantity Surveyor',
                'category'   => 'Construction',
                'about_me'   => 'Detail-oriented Construction Cost Estimator and Quantity Surveying Specialist with nearly two years of remote experience supporting construction teams across Australia, the United States, and New Zealand. Experienced in preparing accurate quantity takeoffs, BOQs, cost estimates, and bid documentation for residential and commercial projects.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'BuilderDuty Inc. (US)', 'title' => 'Estimator / Quantity Surveyor', 'period' => 'Mar 2026 - Jul 2026', 'bullets' => [
                        'Prepares detailed quantity takeoffs and cost estimates from architectural drawings and specifications.',
                        'Develops BOQs and trade-specific breakdowns for drywall, metal framing, ceilings, and insulation.',
                        'Delivered estimating outputs for more than 50 residential and commercial projects.',
                        'Reviews estimates for accuracy, quality, and timely submission.',
                        'Developed an Excel-based estimation tool to improve estimating efficiency.',
                    ]],
                    ['company' => 'Titan Development (NZ)', 'title' => 'Construction Estimator & Project Scheduler', 'period' => 'Nov 2024 - Feb 2026', 'bullets' => [
                        'Prepared partition and reflected ceiling plan takeoffs for residential and commercial projects.',
                        'Supported approximately 15 projects per month with accurate quantities and pricing documentation.',
                        'Coordinated with Sales and Engineering teams to align estimates with project specifications.',
                        'Reviewed drawings and prepared technical and construction documentation.',
                        'Progressed to a Delivery Team Engineer role and led a two-member offshore team.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Mapua University', 'degree' => 'Bachelor of Science in Civil Engineering — Specialisation in Construction Engineering and Management', 'period' => '2019 – 2023'],
                    ['school' => 'Philippine Institute of Certified Quantity Surveyors Academy', 'degree' => 'Pearson BTEC Higher National Certificate and Higher National Diploma in Quantity Surveying', 'period' => '2025 – Present'],
                ],
                'core_skills' => [
                    'Quantity Takeoffs and Cost Estimation', 'BOQ Preparation', 'Architectural Drawing Review', 'Trade Scope Breakdown',
                    'Bid and Tender Management', 'Estimation Quality Checking', 'RFIs, Submittals, and Drawing Registers', 'Construction Administration', 'Sales and Engineering Coordination',
                ],
                'software_expertise' => ['Bluebeam Revu', 'PlanSwift', 'StackCT', 'Microsoft Excel', 'Buildertrend', 'JobTread', 'Procore', 'BuildingConnected', 'AutoCAD', 'ChatGPT', 'Claude'],
                'certifications' => [
                    'Capricho Ansay — Construction Admin Assistant Training Program with Specialization in Buildertrend Management (11 June 2026)',
                    'Procore Technologies — Construction Bootcamp Program (28 May 2026)',
                    'Procore Certification: Estimator (12 May 2026)',
                    'Procore Certification: Project Manager — Project Management, General Contractor (13 May 2026)',
                    'Construct-VA — Cost Estimation for Australian Residential Projects (8 September 2025)',
                    'Xstructures Engineering Consultants — Construction Project Management (17 May 2025)',
                    'Xstructures Engineering Consultants — Residential Building Estimate with the Aid of Microsoft Excel and AutoCAD (20 June 2024)',
                ],
            ],
            [
                'name'       => 'Melinda',
                'role_title' => 'Construction Cost Estimator | Quantity Surveyor',
                'category'   => 'Construction',
                'about_me'   => 'Dedicated Construction Estimator and Quantity Surveyor with over six years of experience supporting Australian, American, and Philippine construction projects. Skilled in quantity takeoffs, BOQ preparation, cost planning, tendering, supplier coordination, and constructability reviews across residential renovations, commercial fit-outs, and mixed-use developments.',
                'rate'             => '17 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Australian Residential Renovation (AU)', 'title' => 'Estimator', 'period' => 'Mar 2022 - Apr 2026', 'bullets' => [
                        'Reviewed architectural, structural, demolition, and survey plans to determine project scope.',
                        'Prepared detailed BOQs, quantity takeoffs, unit rates, and residential construction quotations.',
                        'Completed estimates across demolition, excavation, concrete, structural steel, carpentry, roofing, finishes, plumbing, electrical, masonry, joinery, and tiling works.',
                        'Prepared and coordinated RFIs with designers and project managers.',
                        'Issued RFQs and reviewed supplier and subcontractor quotations against project budgets.',
                        'Prepared purchase orders, variation quotations, and revised cost comparison reports.',
                        'Supported offshore project managers with cost reporting and budget presentations.',
                    ]],
                    ['company' => 'Crimson Group Inc', 'title' => 'Quantity Surveyor', 'period' => 'Oct 2019 – Mar 2022', 'bullets' => [
                        'Prepared quantity takeoffs and costing for commercial and mixed-use fit-out projects.',
                        'Attended pre-bid meetings and site inspections to capture key project requirements.',
                        'Conducted constructability reviews and coordinated RFIs and RFQs.',
                        'Reviewed supplier quotations and calculated project unit rates.',
                        'Prepared variation quotations and presented final bid costing to the Estimating Manager.',
                        'Reviewed team outputs to ensure estimating accuracy and completeness.',
                    ]],
                    ['company' => 'ViaTechnik Inc.', 'title' => 'Estimating Specialist', 'period' => 'Feb 2019 – Jun 2019', 'bullets' => [
                        'Completed quantity takeoffs for American residential and mixed-use projects.',
                        'Reviewed plans and specifications to assess project scope and constructability.',
                        'Prepared estimates for architectural finishes, landscaping, hardscapes, MEPF, and countertop works.',
                        'Supported labour budgeting for BIM drafting projects.',
                    ]],
                    ['company' => 'WB Builders', 'title' => 'Site Engineer', 'period' => 'Jan 2018 – Feb 2019', 'bullets' => [
                        'Managed on-site activities for commercial fit-out projects, including restaurants and boutiques.',
                        'Ensured construction works followed approved plans, schedules, and safety requirements.',
                        'Coordinated contractors, permits, testing certifications, and stakeholder meetings.',
                        'Supported pre-bid discussions and project delivery requirements.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Bataan Peninsula State University', 'degree' => 'Bachelor of Science in Civil Engineering', 'period' => null],
                ],
                'core_skills' => [
                    'Quantity Takeoffs and Cost Estimation', 'BOQ Preparation', 'Cost Analysis and Budgeting', 'Tender and Bid Preparation',
                    'Supplier and Subcontractor Coordination', 'RFIs, RFQs, and Purchase Orders', 'Constructability Review',
                    'Variation and Quotation Management', 'Architectural and Engineering Plan Review', 'Residential Renovation and Commercial Fit-Out Estimating',
                ],
                'software_expertise' => ['Bluebeam Revu', 'PlanSwift', 'On-Screen Takeoff', 'Utecture', 'Cordell Estimator Platinum', 'CoConstruct', 'Microsoft Office', 'Google Workspace', 'Microsoft Teams'],
            ],
            [
                'name'       => 'John',
                'role_title' => 'Construction Cost Estimator | Quantity Surveyor',
                'category'   => 'Construction',
                'about_me'   => 'Licensed Civil Engineer with experience in quantity surveying, construction estimating, structural design, and BIM/CAD modelling for Australian and US construction projects. Skilled in preparing detailed takeoffs, BOQs, cost estimates, bid documentation, and technical drawings across commercial, residential, infrastructure, and civil works.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'HR Marc Company (US)', 'title' => 'Estimator / Quantity Surveyor', 'period' => 'June 2026 – Present', 'bullets' => [
                        'Reviews architectural, structural, civil, site, and specification documents for commercial tenders.',
                        'Prepares detailed quantity takeoffs, scope reviews, BOQs, and BOMs for pricing and bid submissions.',
                        'Identifies scope gaps, drawing conflicts, assumptions, exclusions, and required RFIs.',
                        'Estimates concrete, excavation, backfill, slabs, footings, paving, curbs, equipment pads, and related site works.',
                        'Produces Bluebeam and On-Screen Takeoff markups aligned with US construction standards and company templates.',
                    ]],
                    ['company' => 'Department of Public Works and Highways', 'title' => 'Project Development Officer / Civil Engineer', 'period' => 'Aug 2024 – May 2026', 'bullets' => [
                        'Prepared detailed designs, material quantities, and cost estimates for public infrastructure projects.',
                        'Designed a box culvert bridge and achieved approximately 10% project cost savings through design optimisation.',
                        'Developed estimates for a ₱23 million flood-control and slope-protection project.',
                        'Conducted inspections and coordinated road maintenance, rehabilitation, manpower, and materials.',
                        'Prepared structural detailing, project documentation, and 3D visualisations.',
                    ]],
                    ['company' => 'Crystal Blue Enterprises Inc.', 'title' => 'Project Manager', 'period' => 'Jan 2024 – Jul 2024', 'bullets' => [
                        'Managed the end-to-end delivery of resort and swimming pool projects valued between ₱3 million and ₱15 million.',
                        'Prepared architectural, structural, civil, plumbing, and electrical designs.',
                        'Developed project estimates and aligned construction scopes with client budgets.',
                        "Coordinated project delivery, documentation, and client requirements as the company's sole engineer.",
                    ]],
                ],
                'education' => [
                    ['school' => 'Don Honorio Ventura State University', 'degree' => 'Bachelor of Science in Civil Engineering — Specialisation in Structural Engineering', 'period' => '2019–2023'],
                ],
                'core_skills' => [
                    'Quantity Takeoffs and Cost Estimation', 'BOQ and BOM Preparation', 'Bid and Tender Documentation', 'Architectural and Structural Drawing Review',
                    'Concrete and Civil Works Estimating', 'Scope Review and RFI Identification', 'Structural Design and Analysis', 'BIM and CAD Modelling',
                    'Project Cost Optimisation', 'Construction Project Coordination',
                ],
                'software_expertise' => ['Bluebeam Revu', 'PlanSwift', 'On-Screen Takeoff', 'CostX', 'Microsoft Excel', 'AutoCAD', 'Revit', 'ETABS', 'SAP2000', 'Civil 3D', 'SketchUp', 'Enscape', 'V-Ray', 'SpaceGass', 'BuildingConnected', 'Microsoft Project', 'Primavera P6', 'Monday.com'],
            ],
            [
                'name'       => 'Glenadine',
                'role_title' => 'Construction Cost Estimator | Quantity Surveyor',
                'category'   => 'Construction',
                'about_me'   => 'Licensed Civil Engineer and detail-oriented Quantity Surveyor with experience in material takeoffs, BOQ preparation, cost monitoring, procurement support, and construction coordination. Skilled in supporting project delivery through accurate estimates, organised documentation, technical issue resolution, and effective communication with suppliers, subcontractors, and internal teams.',
                'rate'             => '15 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'RICJAY Builders', 'title' => 'Office Engineer / Design Engineer', 'period' => 'Aug 2025 – Jan 2026', 'bullets' => [
                        'Prepares detailed quantity takeoffs and cost estimates from architectural drawings and specifications.',
                        'Develops BOQs and trade-specific breakdowns for drywall, metal framing, ceilings, and insulation.',
                        'Delivered estimating outputs for more than 50 residential and commercial projects.',
                        'Reviews estimates for accuracy, quality, and timely submission.',
                        'Developed an Excel-based estimation tool to improve estimating efficiency.',
                    ]],
                    ['company' => 'ED1SON Construction and Development Inc.', 'title' => 'Technical Support Engineer', 'period' => 'May 2024 – July 2025', 'bullets' => [
                        'Supported construction coordination across civil, electrical, and plumbing works.',
                        'Prepared S-curves and Gantt charts for project schedule monitoring.',
                        'Assisted in resolving technical site issues and reducing workflow disruptions.',
                        'Coordinated regulatory requirements, permits, and material testing documentation.',
                        'Prepared project accomplishment reports and management updates.',
                    ]],
                    ['company' => 'Vashner Construction and Surveying Services', 'title' => 'Quantity Surveyor', 'period' => 'Aug 2023 – Feb 2024', 'bullets' => [
                        'Prepared detailed material takeoffs and BOQ estimates.',
                        'Monitored project costs and material usage against approved BOQs.',
                        'Maintained material tracking systems to improve inventory accuracy.',
                        'Coordinated deliveries to support site readiness and project timelines.',
                        'Assisted procurement teams with scope, budget, and supplier coordination.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Cavite State University', 'degree' => 'Bachelor of Science in Civil Engineering — Major in Construction Engineering and Management', 'period' => '2019–2023'],
                ],
                'core_skills' => [
                    'Quantity Takeoffs and Cost Estimation', 'BOQ Preparation', 'Cost Control and Budget Monitoring', 'Material and Inventory Tracking', 'Procurement Support',
                    'Construction Documentation', 'Project Planning and Scheduling', 'RFIs and Compliance Reporting', 'Supplier and Subcontractor Coordination', 'Project and Workflow Management',
                ],
                'software_expertise' => ['Bluebeam Revu', 'PlanSwift', 'Microsoft Excel', 'AutoCAD'],
            ],
            [
                'name'       => 'Shekinah',
                'role_title' => 'Construction Cost Estimator | Quantity Surveyor',
                'category'   => 'Construction',
                'about_me'   => 'Licensed Civil Engineer with more than two years of experience in construction cost estimation, quantity takeoffs, BOQ preparation, scope development, and plan analysis. Experienced across site development, structural works, and architectural finishes, with training in both Australian and US construction estimating practices.',
                'rate'             => '15 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'GW Fortune Builders, Inc.', 'title' => 'Cost Estimate Engineer', 'period' => 'Feb 2024 – May 2026', 'bullets' => [
                        'Reviewed architectural and engineering plans and issued RFIs for missing or unclear details.',
                        'Developed detailed scopes of work for construction projects.',
                        'Prepared quantity takeoffs, cost estimates, budgets, and BOQs across multiple construction trades.',
                        'Estimated site development, earthworks, structural works, and architectural finishes.',
                        'Prepared structural cutting lists for reinforced concrete and steel works.',
                        'Used PlanSwift and spreadsheets to produce accurate and competitive tender estimates.',
                    ]],
                    ['company' => 'SPEC-G Construction Services', 'title' => 'Site Engineer / Quantity Surveyor', 'period' => 'Jul 2023 – Jan 2024', 'bullets' => [
                        'Forecasted and estimated materials required for upcoming construction activities.',
                        'Managed site operations and supervised workers against approved plans and schedules.',
                        'Revised construction drawings using AutoCAD to reflect site and as-built changes.',
                        'Coordinated with clients, suppliers, and subcontractors.',
                        'Prepared daily documentation, progress reports, and project monitoring records.',
                        'Supported the successful completion of residential and commercial projects.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Colegio San Agustin', 'degree' => 'Bachelor of Science in Civil Engineering — Major in Construction Management', 'period' => null],
                ],
                'core_skills' => [
                    'Quantity Takeoffs and Cost Estimation', 'BOQ Preparation', 'Plan Review and Scope Analysis', 'RFIs, RFPs, and RFQs', 'Tender and Bid Preparation',
                    'Supplier and Subcontractor Coordination', 'Reinforced Concrete Estimating', 'Masonry, Roofing, and Carpentry Estimating', 'Interior Finishes Estimating', 'Structural Cutting Lists',
                ],
                'software_expertise' => ['PlanSwift', 'Bluebeam Revu', 'AutoCAD', 'Microsoft Excel', 'Google Sheets', 'Google Workspace', 'Primavera P6', 'Trello', 'Slack', 'Xero', 'Zoom Phone'],
            ],
            [
                'name'       => 'Jus',
                'role_title' => 'Construction Cost Estimator | Quantity Surveyor',
                'category'   => 'Construction',
                'about_me'   => 'Licensed Civil Engineer and Construction Estimator with eight years of experience preparing quantity takeoffs, BOQs, cost estimates, rate build-ups, and tender pricing for Australian residential and commercial construction, as well as infrastructure projects. Known for accurate measurement, clear documentation, and dependable delivery within deadline-driven environments.',
                'rate'             => '17 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Corium Projects', 'title' => 'Construction Estimator', 'period' => '2023 – April 2026', 'bullets' => [
                        'Prepared quantity takeoffs, BOQs, and cost estimates for Australian residential and commercial projects.',
                        'Used Bluebeam for measurements, mark-ups, quantity checking, and estimating documentation.',
                        'Reviewed architectural, structural, and project drawings to confirm quantities and trade scopes.',
                        'Prepared rate build-ups, cost analyses, pricing summaries, and tender support documents.',
                        'Coordinated with contractors to clarify scope, drawings, and estimating requirements.',
                        'Estimated architectural, structural, civil, MEP, fit-out, and external works.',
                    ]],
                    ['company' => 'Department of Public Works and Highways', 'title' => 'Engineer II – Planning and Design / Quantity Surveyor', 'period' => '2018 – 2023', 'bullets' => [
                        'Prepared detailed quantity and material takeoffs for residential, commercial, and public infrastructure projects.',
                        'Developed BOQs, structured cost estimates, rate build-ups, and pricing summaries.',
                        'Reviewed architectural, structural, and MEP drawings against project requirements.',
                        'Updated labour and material pricing databases to reflect market conditions.',
                        'Coordinated with project teams to validate site conditions and clarify technical requirements.',
                        'Conducted quality checks to ensure estimating outputs met specifications and industry standards.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Lyceum of the Philippines University', 'degree' => 'Bachelor of Science in Civil Engineering', 'period' => '2017'],
                ],
                'core_skills' => [
                    'Quantity and Material Takeoffs', 'BOQ Preparation', 'Construction Cost Estimation', 'Rate Build-Ups and Pricing Summaries', 'Residential and Commercial Tender Support',
                    'Architectural, Structural, and MEP Estimating', 'Cost Database Management', 'Scope Review and Documentation Control', 'Infrastructure and Site Development Estimating', 'Remote Project Coordination',
                ],
                'software_expertise' => ['Bluebeam Revu', 'PlanSwift', 'Microsoft Excel', 'Microsoft Project', 'Primavera P6', 'AutoCAD', 'Civil 3D', 'Revit', 'SketchUp', 'SolidWorks', 'Fusion 360', 'Speckle', 'GIS'],
            ],
            [
                'name'       => 'Lance',
                'role_title' => 'Business Development & Client Acquisition Specialist',
                'category'   => 'Marketing',
                'about_me'   => 'Results-driven Business Development Specialist with experience in client sourcing, lead generation, relationship management, discovery calls, proposal preparation, and sales conversion. Skilled in identifying new market opportunities, developing tailored outreach strategies, and building client pipelines to support sustainable business growth.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Reworks Solutions', 'title' => 'Business Development Representative', 'period' => 'Jun 2022 – Mar 2026', 'bullets' => [
                        'Researched potential clients, target markets, and partnership opportunities.',
                        'Developed strategies to attract new clients and retain existing accounts.',
                        'Conducted discovery calls and regular client meetings.',
                        'Managed email outreach, follow-ups, proposals, and account communications.',
                        'Led negotiations and supported the closing of new service contracts.',
                        'Monitored client accounts for retention and upselling opportunities.',
                        'Consistently worked towards sales and business growth targets.',
                    ]],
                    ['company' => 'Support Shepherd', 'title' => 'Senior Recruitment Specialist', 'period' => 'Feb 2020 – Apr 2022', 'bullets' => [
                        'Communicated with clients to understand their workforce requirements.',
                        'Developed sourcing strategies aligned with client needs.',
                        'Conducted candidate outreach through LinkedIn, job platforms, social media, and referrals.',
                        'Managed candidate databases and recruitment pipelines.',
                        'Supported external clients with IT and non-IT staffing requirements.',
                        'Maintained professional relationships with clients, candidates, and stakeholders.',
                    ]],
                ],
                'education' => [
                    ['school' => 'San Beda University', 'degree' => 'Bachelor of Science in Marketing Management and Communications', 'period' => '2016–2020'],
                ],
                'core_skills' => [
                    'Business Development', 'Client Sourcing and Lead Generation', 'Sales Outreach and Follow-Up', 'Discovery Calls', 'Proposal Preparation',
                    'Client Relationship Management', 'Market and Competitor Research', 'Account Management', 'Negotiation and Closing', 'Social Media Outreach',
                ],
                'software_expertise' => ['HubSpot', 'Apollo.io', 'LinkedIn', 'Canva', 'Airtable', 'Google Workspace', 'Microsoft Office', 'Slack', 'Oracle', 'NetSuite', 'Workable', 'RCRM'],
            ],
            [
                'name'       => 'Angelica',
                'role_title' => 'Email Marketing | Lead Generation Specialist',
                'category'   => 'Marketing',
                'about_me'   => 'Detail-oriented Email Marketing and Lead Generation Specialist experienced in prospect research, database development, high-volume outreach, social media management, and campaign administration. Brings additional experience in building-material procurement, providing practical exposure to supplier coordination, documentation, and operations relevant to the construction sector.',
                'rate'             => '15 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Maternal Wellness E-commerce Brand', 'title' => 'Email Marketing & Lead Generation Specialist', 'period' => 'May 2024 – May 2026', 'bullets' => [
                        'Conducted market research and lead mining to identify qualified prospects.',
                        'Executed high-volume email and direct-message outreach campaigns.',
                        'Contributed to a 15% increase in brand partnership enquiries.',
                        'Maintained and cleaned prospect databases to improve deliverability.',
                        'Verified contact information and reduced campaign bounce rates.',
                        'Supported targeted digital outreach to international prospects.',
                    ]],
                    ['company' => 'Outrex Building Materials Trading L.L.C. – UAE', 'title' => 'Procurement Officer', 'period' => 'Mar 2023 – Apr 2024', 'bullets' => [
                        'Managed purchase orders, shipment tracking, and supplier coordination.',
                        'Worked with warehouse and operations teams to optimise inventory levels.',
                        'Maintained accurate records of invoices, contracts, receipts, and procurement documents.',
                        'Coordinated delivery requirements to support quantity accuracy and timely fulfilment.',
                        'Provided administrative and stakeholder support within the building-materials sector.',
                    ]],
                    ['company' => 'Padyak City & Pontelo.ph', 'title' => 'Freelance Social Media Manager', 'period' => '2020 – 2023', 'bullets' => [
                        'Increased organic reach across Facebook, Instagram, and TikTok.',
                        'Created short-form marketing content using Canva and CapCut.',
                        'Managed comments, direct messages, and community engagement.',
                        'Developed and maintained consistent social media posting schedules.',
                        'Used AI tools to support content ideation, scripting, and campaign planning.',
                    ]],
                ],
                'education' => [
                    ['school' => 'San Beda College Alabang', 'degree' => 'Bachelor of Science in Psychology', 'period' => '2014–2018'],
                ],
                'core_skills' => [
                    'Email Marketing', 'Lead Generation and Prospect Research', 'Database Building and Verification', 'Social Media Management', 'Content Creation',
                    'Digital Outreach', 'CRM Administration', 'Supplier and Stakeholder Coordination', 'Campaign Reporting', 'Customer Engagement',
                ],
                'software_expertise' => ['GoHighLevel', 'Salesforce', 'Meta Business Suite', 'Canva Magic Studio', 'CapCut', 'ChatGPT', 'Gemini AI', 'Microsoft Office', 'CRM Platforms'],
            ],
            [
                'name'       => 'Shelley',
                'role_title' => 'Client Intake Officer',
                'category'   => 'NDIS',
                'about_me'   => 'Registered Nurse and experienced NDIS Client Intake and Care Administration professional with a strong background in participant onboarding, service agreements, stakeholder coordination, compliance documentation, rostering, recruitment support, and medical record review. Detail-oriented and highly organised, with a strong understanding of confidentiality, documentation accuracy, and participant-centred service delivery.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'ISLA Outsourcing Solution (NDIS Client)', 'title' => 'Client Intake Officer & Care Administrator', 'period' => 'Jul 2024 – Jul 2026', 'bullets' => [
                        'Coordinated participant intake and onboarding processes.',
                        'Prepared service agreements and supporting intake documentation.',
                        'Liaised with participants, families, support coordinators, and other NDIS stakeholders.',
                        'Maintained accurate participant records and daily service documentation.',
                        'Managed support worker rosters and verified timesheets.',
                        'Supported recruitment, staff onboarding, and employee record maintenance.',
                        'Monitored compliance documentation and administrative requirements.',
                        'Maintained client information using Visual Care and other digital systems.',
                    ]],
                    ['company' => 'Grupo NOA', 'title' => 'Medical Chart Auditor', 'period' => 'Apr 2023– Dec 2025', 'bullets' => [
                        'Audited behavioural health and substance-use treatment records.',
                        'Reviewed documentation for completeness, accuracy, and regulatory compliance.',
                        'Identified documentation gaps, discrepancies, and potential risk areas.',
                        'Maintained audit trackers and strict confidentiality standards.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Silliman University', 'degree' => 'Bachelor of Science in Nursing', 'period' => '2011'],
                ],
                'core_skills' => [
                    'NDIS Participant Intake', 'Service Agreement Preparation', 'Participant Onboarding', 'Compliance Documentation Review', 'Client and Stakeholder Coordination',
                    'Participant and Staff Record Management', 'Rostering and Timesheet Verification', 'Recruitment and Staff Onboarding Support', 'Medical Record Auditing', 'Confidential Information Management',
                ],
                'software_expertise' => ['Visual Care', 'Kipu EMR', 'Moodle', 'Synthesia', 'Canva', 'Microsoft Office', 'Google Workspace', 'CRM Systems'],
            ],
            [
                'name'       => 'Abigail',
                'role_title' => 'Client Intake Officer',
                'category'   => 'NDIS',
                'about_me'   => 'Experienced NDIS Intake Coordinator and Rostering Officer with extensive expertise in participant onboarding, referral coordination, workforce scheduling, stakeholder communication, and service delivery administration. Brings more than a decade of experience across workforce management and customer operations, with strong capability in maintaining accurate records, resolving scheduling issues, and supporting participant-centred service delivery.',
                'rate'             => '18 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Astute Living Care', 'title' => 'NDIS Intake Coordinator & Rostering Officer', 'period' => 'Aug 2025 – May 2026', 'bullets' => [
                        'Served as the primary contact for participant referrals and intake enquiries.',
                        'Managed participant onboarding documentation and internal referral processes.',
                        'Coordinated staff rosters based on participant needs, availability, and care-plan goals.',
                        'Liaised with participants, support workers, management, and claims advisers.',
                        'Responded to funding enquiries, roster changes, and service-delivery concerns.',
                        'Maintained accurate information across scheduling systems.',
                        'Supported compliance with NDIS service-delivery and documentation requirements.',
                    ]],
                    ['company' => 'Neta Care Holistic Health Services', 'title' => 'Service Delivery Manager Assistant', 'period' => 'Nov 2022 – June 2025', 'bullets' => [
                        'Managed daily rostering and scheduling for participant supports.',
                        'Matched workers with participant preferences and care requirements.',
                        'Coordinated last-minute cancellations, shift swaps, and roster changes.',
                        'Communicated directly with clients and staff to maintain continuity of care.',
                        "Managed enquiries received through the organisation's support line.",
                        'Published master rosters and monitored staff availability.',
                        'Supported compliance training coordination and workforce communication.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Centro Escolar University', 'degree' => 'Bachelor of Arts in Mass Communication — Major in Broadcasting', 'period' => '1999'],
                ],
                'core_skills' => [
                    'NDIS Participant Intake', 'Referral and Onboarding Coordination', 'Participant Documentation', 'Rostering and Workforce Scheduling', 'Participant and Support Worker Matching',
                    'Funding and Service Enquiry Management', 'NDIS Compliance Support', 'Stakeholder Communication', 'Data Integrity and Reporting', 'Conflict Resolution and Service Continuity',
                ],
                'software_expertise' => ['Akuety', 'Follow Up Boss', 'Pipedrive', 'Opcity', 'Zillow Premier Agent', 'Canva', 'Microsoft Office', 'Google Workspace', 'CRM and Scheduling Systems'],
            ],
            [
                'name'       => 'Reham',
                'role_title' => 'Client Services & HR Coordinator',
                'category'   => 'NDIS',
                'about_me'   => 'Dedicated NDIS administration professional with experience across participant intake, client services, HR coordination, compliance monitoring, documentation, and stakeholder communication. Skilled in maintaining accurate participant and staff records, supporting recruitment and onboarding, preparing reports and employment documents, and following up outstanding compliance and training requirements.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'The Cassidy Crew', 'title' => 'Client Services & HR Coordinator', 'period' => 'June 2025 – Jul 2026', 'bullets' => [
                        'Provides administrative support across participant intake, client services, HR, and compliance.',
                        'Coordinates with participants, families, support coordinators, health professionals, and internal teams.',
                        'Maintains accurate participant and staff records.',
                        'Prepares reports, employment documents, and supporting administrative records.',
                        'Supports recruitment and onboarding processes.',
                        'Monitors outstanding compliance documentation and training requirements.',
                        'Handles confidential and sensitive information in line with organisational and NDIS standards.',
                        'Supports day-to-day client service and stakeholder enquiries.',
                    ]],
                    ['company' => 'International Academy of Marawi', 'title' => 'School Guidance Counsellor', 'period' => '2018 - 2025', 'bullets' => [
                        'Coordinated with students, families, and internal stakeholders.',
                        'Maintained confidential records and supported individual planning.',
                        'Organised workshops, meetings, and development activities.',
                        'Provided structured administrative and communication support.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Muslim Mindanao Integrated College Academy', 'degree' => 'Master of Arts in Education — Major in Guidance and Counselling', 'period' => '2023–2024'],
                    ['school' => 'RC-Al Khwarizmi International College Foundation', 'degree' => 'Bachelor of Elementary Education — Major in General Education', 'period' => '2013–2017'],
                ],
                'core_skills' => [
                    'Participant Intake and Referral Coordination', 'NDIS Administration', 'Compliance Monitoring', 'Participant and Staff Record Management', 'Recruitment and Onboarding Support',
                    'Document Preparation', 'Training and Credential Tracking', 'Client and Stakeholder Communication', 'Confidential Information Management', 'HR Administration Support',
                ],
                'software_expertise' => ['Brevity', 'Microsoft Office', 'Google Workspace', 'SharePoint', 'Dropbox', 'Notion', 'Motion', 'TimeTree', 'Flowsavvy', '3CX', 'Ausmed', 'Etrainu', 'Xero', 'Slack', 'WhatsApp'],
            ],
            [
                'name'       => 'Kamille',
                'role_title' => 'Administrative Support & Rostering Coordinator',
                'category'   => 'NDIS',
                'about_me'   => 'Dedicated NDIS Administration Specialist with proven experience in participant enquiry management, staff compliance tracking, and support worker rostering. Proficient in maintaining NDIS quality and safety standards, managing shift logistics, and coordinating client and staff communication. Skilled at leveraging ShiftCare and digital tools to optimize scheduling, streamline record-keeping, and support smooth daily operations for disability service providers.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'NDIS', 'title' => 'Admin Assistant / Compliance & Payroll Support', 'period' => 'Dec 2025 – June 2026', 'bullets' => [
                        'Managed staff compliance records and monitored document expiry dates in line with NDIS Quality and Safeguards standards.',
                        'Supported payroll processes by auditing timesheets and verifying shift accuracy.',
                        'Maintained centralized digital record systems, ensuring staff credential compliance prior to shift allocation.',
                    ]],
                    ['company' => 'NDIS', 'title' => 'Marketing & Intake Support', 'period' => 'April 2025 - April 2026', 'bullets' => [
                        'Monitored participant inquiries and ensured timely responses to prospective clients and families.',
                        'Managed social media platforms (Facebook/Instagram) and created promotional/awareness materials for NDIS services.',
                    ]],
                    ['company' => 'SuperCareAU', 'title' => 'Admin Assistant / Compliance / Payroll & Rostering', 'period' => 'April 2025 - April 2026', 'bullets' => [
                        'Created and managed support staff rosters, dynamically handling shift changes, cancellations, and emergency coverage.',
                        'Handled daily email communications, organized participant/staff documentation, and generated payroll reports.',
                    ]],
                ],
                'education' => [
                    ['school' => 'First City Providential College', 'degree' => 'Bachelor of Science in Office Management', 'period' => null],
                ],
                'core_skills' => [
                    'Participant Intake & Enquiry Management', 'Record Keeping & Data Privacy', 'Shift Cancellation & Emergency Coverage Logistics', 'Stakeholder Communication',
                    'Compliance & Document Tracking', 'Support Worker Rostering & Schedule Management', 'Staff Credential Audit & Expiry Monitoring', 'Timesheet & Payroll Support',
                ],
                'software_expertise' => ['ShiftCare', 'Microsoft Office', 'Google Workspace', 'SharePoint', '3CX', 'Notion', 'Etrainu', 'Xero', 'Slack', 'WhatsApp'],
            ],
            [
                'name'       => 'Ria',
                'role_title' => 'Administrative Support & Client Relations Specialist',
                'category'   => 'NDIS',
                'about_me'   => 'Detail-oriented Administrative & Client Relations Specialist with extensive background in compliance management, confidential record keeping, multi-channel client support, and financial reporting. Experienced in managing complex documentation systems, vendor coordination, and CRM maintenance. Brings exceptional organizational skills and administrative precision to support NDIS participant onboarding, document compliance, and daily operations for disability service providers.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Beepo', 'title' => 'Admin Specialist', 'period' => 'April 2025 – Feb 2026', 'bullets' => [
                        'Managed confidential records, documentation systems, and compliance reporting.',
                        'Coordinated procurement, travel logistics, and client communication workflows.',
                        'Developed internal training materials and analyzed operational data trends to improve efficiency.',
                    ]],
                    ['company' => 'Beepo', 'title' => 'Wealth Support Associate', 'period' => 'Nov 2022 - Feb 2025', 'bullets' => [
                        'Provided multi-channel client support and managed dynamic ticketing systems.',
                        'Maintained accurate record-keeping systems and generated operational reports.',
                    ]],
                    ['company' => 'OnAirParking.com', 'title' => 'Customer Support Specialist', 'period' => 'Oct 2022 - Oct 2024', 'bullets' => [
                        'Managed customer reservations, inquiries, and dispute resolution across multiple channels.',
                        'Coordinated inventory listings and collaborated with teams to streamline service delivery.',
                    ]],
                    ['company' => 'East West Ageas', 'title' => 'Licensed Financial Advisor', 'period' => 'Oct 2022 - Oct 2024', 'bullets' => [
                        'Conducted financial assessments, managed client portfolios, and built long-term client relationships.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Angeles University Foundation', 'degree' => 'Bachelor of Science in Business Administration', 'period' => '2019'],
                ],
                'core_skills' => [
                    'Compliance Management & Documentation', 'Participant & Client Support (Multi-channel)', 'Record Management & Confidential File Handling',
                    'Data Analysis & Operational Reporting', 'Stakeholder & Vendor Coordination', 'Process Optimization & Training Development',
                ],
                'software_expertise' => ['Salesforce', 'Microsoft Office', 'Google Workspace', 'SharePoint', 'Zendesk', 'QuickBooks', 'Redtail', 'Trello', 'Morningstar', 'Addepar', 'SAP'],
            ],
            [
                'name'       => 'Janiza',
                'role_title' => 'Compliance & Audit Support Specialist',
                'category'   => 'NDIS',
                'about_me'   => 'Results-driven NDIS Compliance and Finance Virtual Assistant with a strong foundation in accounting, documentation auditing, and regulatory readiness. Experienced in reviewing and structuring NDIS compliance documents, participant Service Agreements, progress notes, and consent forms to ensure full audit readiness. Combines detailed administrative expertise with advanced skills in financial reconciliations and ERP software to ensure complete operational accuracy for NDIS service providers.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Vertex Consulting & Compliance Group', 'title' => 'Virtual Assistant Consultant', 'period' => 'Dec 2024 – Present', 'bullets' => [
                        'Review and structure NDIS compliance documents and organizational policies to ensure audit readiness.',
                        'Audit participant files for complete documentation, including Service Agreements, progress notes, and consent forms.',
                        'Assist in compiling, organizing, and verifying evidence documents required for NDIS Quality & Safeguards audits.',
                    ]],
                    ['company' => 'Mercedes-Benz Group Service Philippines Inc.', 'title' => 'AP Junior Financial Analyst', 'period' => 'Feb 2024 - Feb 2025', 'bullets' => [
                        'Verified and processed invoices using SAP and OneERP systems, ensuring accurate general ledger recording.',
                        'Reconciled vendor statements, prepared AP reports, and supported month-end and year-end audit/closing routines.',
                    ]],
                    ['company' => 'Central Country Estate Inc.', 'title' => 'Accounting Assistant / Bookkeeper', 'period' => 'Aug 2022 – Jan 2024', 'bullets' => [
                        'Managed daily financial transactions, bank reconciliations, inventory audits, and documentation control for management review.',
                    ]],
                    ['company' => 'Consumer Reach Inc.', 'title' => 'Accounts Receivable Accountant', 'period' => 'Jun 2021 – Jul 2022', 'bullets' => [
                        'Managed invoicing, client payment reconciliations, aging reports, and record keeping for internal audit verification.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Angeles University Foundation', 'degree' => 'Bachelor of Science in Business Administration', 'period' => '2019'],
                ],
                'core_skills' => [
                    'Compliance Management & Documentation', 'Participant & Client Support (Multi-channel)', 'Record Management & Confidential File Handling',
                    'Data Analysis & Operational Reporting', 'Stakeholder & Vendor Coordination', 'Process Optimization & Training Development',
                ],
                'software_expertise' => ['Salesforce', 'Microsoft Office', 'Google Workspace', 'SharePoint', 'Zendesk', 'QuickBooks', 'Redtail', 'Trello', 'Morningstar', 'Addepar', 'SAP'],
            ],
            [
                'name'       => 'Bianca',
                'role_title' => 'Compliance & Administrative Support',
                'category'   => 'NDIS',
                'about_me'   => 'Detail-oriented NDIS Compliance and Administrative Specialist with a strong foundation in Accounting Information Systems. Experienced in supporting NDIS service providers and support coordinators through accurate compliance documentation maintenance, incident management tracking, and audit preparation. Skilled in data entry, CRM and NDIS portal updates, and maintaining strict confidentiality and data privacy standards to support efficient daily operational workflows.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Isla VA Solution', 'title' => 'Compliance and Admin Assistant', 'period' => 'Jun 2025 – Jul 2026', 'bullets' => [
                        'Maintained organized compliance documentation and assisted with NDIS audits, compliance tracking, and reporting.',
                        'Managed incident reporting systems, ensuring accurate record-keeping, escalation of discrepancies, and prompt follow-up.',
                        'Delivered general administrative and operational support for NDIS providers and support coordinators to optimize day-to-day workflows.',
                        'Performed high-accuracy data entry and system updates across CRMs, NDIS portals, and internal tracking tools while maintaining strict data privacy.',
                    ]],
                    ['company' => 'Hausland Development Corp.', 'title' => 'Billing & Collection Officer', 'period' => 'Feb 2024 – Dec 2024', 'bullets' => [
                        'Generated and distributed customer invoices, ensuring contract compliance, accurate pricing, and billing terms.',
                        'Managed accounts receivable, cash reconciliations, and financial record-keeping to minimize outstanding balances.',
                        'Monitored collections and conducted direct client communications to facilitate payment resolution.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Angeles City College', 'degree' => 'Bachelor of Science in Accounting Information Systems', 'period' => '2020–2024'],
                ],
                'affiliations' => [
                    'Member, Junior Philippine Institute of Chartered Accountants (JPICA) | 2024–2025',
                    'Member, Junior Philippine Institute of Accountants (JPIA) | 2021–2024',
                ],
                'core_skills' => [
                    'NDIS Compliance Tracking & Audit Support', 'Incident Management & Reporting Systems', 'Support Coordinator & Provider Administrative Support',
                    'Confidentiality & Data Privacy Management', 'NDIS Portal & CRM Data Maintenance', 'Billing, Collections & Accounts Receivable', 'Governance & Process Follow-Up',
                ],
                'software_expertise' => ['ShiftCare', 'Microsoft Office', 'Google Workspace', 'SharePoint', 'NDIS Portals', 'Cognito Forms', 'eTrainu', 'Xero', 'Internal Tracking Systems & Databases', 'Bookkeeping & Billing Systems', 'Canva', 'Employment Hero', 'MYP', 'BrightHR', 'PandaDoc'],
            ],
            [
                'name'       => 'Almira',
                'role_title' => 'NDIS Administrative Support',
                'category'   => 'NDIS',
                'about_me'   => 'Detail-oriented NDIS Administration Officer experienced in supporting Australian NDIS providers with participant intake and onboarding, Service Agreements, timesheet review, payroll support, compliance documentation and participant record management. Reliable and highly organised, with strong experience managing confidential information and supporting efficient day-to-day NDIS operations.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week) or Part Time (20hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Isla VA Solution', 'title' => 'HR & NDIS Administration Officer', 'period' => 'Dec 2024– Jul 2026', 'bullets' => [
                        'Managed participant intake and onboarding administration, ensuring required participant information and documentation were accurately collected and maintained.',
                        'Supported the preparation, administration and maintenance of NDIS Service Agreements and participant records.',
                        'Maintained participant files, service documentation and compliance records to support accurate and organised service delivery.',
                        'Reviewed and processed staff timesheets, identifying discrepancies and ensuring hours were accurately recorded prior to payroll processing.',
                        'Supported payroll preparation and payroll administration, including timekeeping, leave and employee data verification.',
                        'Assisted with recruitment and onboarding of Disability Support Workers and other NDIS operational staff.',
                        'Maintained worker compliance documentation including qualifications, checks, licences, certifications and employment records.',
                        'Supported HRIS and workforce management systems, ensuring employee and operational records remained current and accurate.',
                        'Assisted with WHS, incident management and incident documentation, including record keeping and follow-up requirements.',
                        'Supported internal audits, compliance reviews and preparation of documentation required for organisational reporting.',
                        'Assisted with policy and procedure implementation across workforce and operational processes.',
                        'Coordinated training and development activities and maintained associated employee records.',
                        'Supported employee relations, workforce enquiries and general HR administration.',
                        'Prepared reports and maintained accurate operational, HR and compliance data.',
                    ]],
                    ['company' => 'Nestlé Business Services', 'title' => 'Payroll | Talent Acquisition Specialist', 'period' => '2019 - 2024', 'bullets' => [
                        'Maintained organized compliance documentation and assisted with NDIS audits, compliance tracking, and reporting.',
                        'Managed incident reporting systems, ensuring accurate record-keeping, escalation of discrepancies, and prompt follow-up.',
                        'Delivered general administrative and operational support for NDIS providers and support coordinators to optimize day-to-day workflows.',
                        'Performed high-accuracy data entry and system updates across CRMs, NDIS portals, and internal tracking tools while maintaining strict data privacy.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Polytechnic University of the Philippines', 'degree' => 'Bachelor of Science in Human Resource Development Management', 'period' => null],
                ],
                'core_skills' => [
                    'NDIS Participant Intake & Onboarding', 'Service Agreement Administration', 'Participant Records & Documentation', 'Timesheet Review & Approval', 'Payroll & Timekeeping Support',
                    'Incident & Compliance Documentation', 'Audit & Record-Keeping Support', 'HR & Workforce Administration', 'Confidential Data Management', 'Worker Onboarding & Compliance',
                ],
                'software_expertise' => ['ShiftCare', 'Brevity', 'Employment Hero', 'SAP', 'SAP SuccessFactors', 'Oracle', 'Kronos', 'HRIS Platforms', 'Microsoft Excel', 'Microsoft Office', 'Power BI', 'Microsoft Teams', 'Slack', 'Canva', 'Applicant Tracking Systems', 'Payroll & Timekeeping Systems'],
            ],
            [
                'name'       => 'Jhanna',
                'role_title' => 'NDIS Rostering Coordinator',
                'category'   => 'NDIS',
                'about_me'   => 'Dedicated and results-driven NDIS Scheduling Coordinator experience in disability, and community service environments. Proven expertise in staff rostering, client coordination, service delivery, and compliance under NDIS standards. Adept at managing high-volume schedules, responding to last-minute roster changes, and ensuring consistent service coverage across multidisciplinary teams. Recognised for fostering strong client relationships, supporting operational efficiency, and delivering participant-centred care.',
                'rate'             => '16 AUD per hour',
                'work_preference'  => 'Full Time (40hrs per week)',
                'availability'     => 'Immediately',
                'experience' => [
                    ['company' => 'Isla VA Solution', 'title' => 'Scheduling Coordinator', 'period' => 'June 2024 - Jul 2026', 'bullets' => [
                        'Strategically prepare, allocate, and manage staff rosters aligned with participant support needs, service requirements, and workforce availability.',
                        'Coordinate end-to-end roster management, including shift changes, cancellations, backfills, and urgent coverage requests, ensuring service continuity and minimal disruption.',
                        'Communicate roster updates promptly and professionally to all stakeholders, including staff, participants, families, and external agencies.',
                        'Match Support Workers to participants based on skills, experience, compatibility, and operational suitability to ensure high-quality service delivery.',
                        'Provide comprehensive administrative and operational support, including participant onboarding, data entry, documentation management, and system updates.',
                        'Serve as the primary point of contact for Support Workers, participants, coordinators, and external partners regarding scheduling, attendance, and service delivery matters.',
                        'Work collaboratively with Team Leaders, Managers, and multidisciplinary internal teams to forecast staffing needs, maintain compliance, and optimise operational efficiency.',
                        'Develop, maintain, and optimise rosters to ensure appropriate coverage levels, alignment with participant plans, and adherence to organisational and NDIS requirements.',
                        'Action and process all roster changes, leave requests, cancellations, and service adjustments with urgency, accuracy, and clear communication across stakeholders.',
                        'Approve shifts for employees and participants by validating hours, attendance, and accuracy against the run sheet and internal guidelines.',
                        'Support onboarding and ongoing training of new staff in rostering systems, processes, and best-practice workforce coordination standards.',
                    ]],
                    ['company' => 'First Business Solutions', 'title' => 'Rostering Coordinator', 'period' => 'May 2021 - June 2024', 'bullets' => [
                        'Maintained organized compliance documentation and assisted with NDIS audits, compliance tracking, and reporting.',
                        'Managed incident reporting systems, ensuring accurate record-keeping, escalation of discrepancies, and prompt follow-up.',
                        'Delivered general administrative and operational support for NDIS providers and support coordinators to optimize day-to-day workflows.',
                        'Performed high-accuracy data entry and system updates across CRMs, NDIS portals, and internal tracking tools while maintaining strict data privacy.',
                    ]],
                ],
                'education' => [
                    ['school' => 'Trinity University of Asia', 'degree' => 'Bachelor of Science in Psychology', 'period' => null],
                ],
                'core_skills' => ['NDIS Scheduling & Rostering', 'Problem-Solving', 'Data Accuracy', 'Documentation', 'Client Liaison', 'Referral Management', 'Microsoft Office', 'Conflict Resolution'],
                'software_expertise' => ['Microsoft Office Suite', 'Employment Hero', 'ShiftCare', 'EtrainU', 'VisualCare', 'FlowLogic', 'Zoom', 'WhatsApp', 'Slack'],
            ],
            [
                'name'       => 'Victoria',
                'role_title' => 'NDIS Rostering Coordinator',
                'category'   => 'NDIS',
                'about_me'   => 'Experienced NDIS Rostering and Workforce Coordinator with hands-on experience managing staff rosters, shift allocations, cancellations, leave requests, timesheets, and daily scheduling in NDIS environments. Has used Visual Care and other care systems to coordinate support workers and respond to staffing changes, participant enquiries, and operational needs. With experience as a Staffing Team Lead, brings strong coordination, communication, and problem-solving skills suited to NDIS rostering and operational support roles.',
                'rate'             => null,
                'work_preference'  => null,
                'availability'     => null,
                'experience' => [
                    ['company' => 'Isla VA Solution', 'title' => 'Admin and Rostering Coordinator', 'period' => 'Oct 2024 - Aug 2026', 'bullets' => [
                        '(Admin) Coordinated participant appointments and support worker schedules to support efficient service delivery.',
                        '(Admin) Managed staff rostering, shift allocations, timesheets and general scheduling processes.',
                        '(Admin) Responded to participant, family and stakeholder enquiries via phone and email.',
                        '(Admin) Maintained participant records, case notes and administrative documentation.',
                        '(Admin) Assisted with preparation and management of Service Agreements, care plans, onboarding documentation and other NDIS-related paperwork.',
                        '(Admin) Monitored worker compliance documentation, including qualifications, certifications and screening requirements.',
                        '(Admin) Supported day-to-day administrative and operational requirements of the provider.',
                        '(Rostering) Managed staff rostering and scheduling to ensure shifts were appropriately allocated according to service requirements.',
                        '(Rostering) Used Visual Care to manage and review staff rosters.',
                        '(Rostering) Regularly monitored scheduling messages, roster conflicts, availability and leave requests.',
                        '(Rostering) Responded promptly to last-minute staffing requirements, including shift cancellations, staff no-shows, emergency fill-ins, and roster changes.',
                        '(Rostering) Updated timesheets to ensure accurate recording of support worker hours, kilometres travelled, and shift notes.',
                        '(Rostering) Maintained confidentiality of participant, staff and Home Care information in line with organisational and NDIS requirements.',
                        '(Rostering) Assisted with capturing and documenting information relating to participant and family concerns.',
                        '(Rostering) Collaborated with the Care Team to address operational and service-related concerns.',
                        '(Rostering) Supported consistent communication between workers, participants, families and the broader care team.',
                    ]],
                ],
                'education' => [],
                'core_skills' => ['NDIS Rostering & Scheduling', 'Staff Allocation & Shift Management', 'Participant & Stakeholder Communication', 'Compliance Documentation', 'Care Team Coordination'],
                'software_expertise' => ['Visual Care'],
            ],
        ];
    }
}
