<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'        => "Why Direct Hiring to the Philippines Isn't as Simple as It Seems",
                'slug'         => 'why-direct-hiring-to-the-philippines-isnt-as-simple-as-it-seems',
                'cover_image'  => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80',
                'author'       => 'Isla Team',
                'published_at' => '2025-10-30',
                'excerpt'      => 'Direct hiring to the Philippines appears cost-effective initially, but it presents substantial legal, security, and operational complexities that often become expensive and risky over time.',
                'body'         => <<<'BODY'
<p>On the surface, hiring directly in the Philippines feels like a smart move. Wages are lower, English fluency is high, and the talent pool is deep.</p>

<p>So, many Australian businesses bypass outsourcing providers entirely — choosing to hire freelancers or contractors directly via platforms or referrals.</p>

<p>But what looks simple on day one often turns <strong>complex, risky, and expensive</strong> over time.</p>

<h3>Legal Grey Zones and Employment Classification</h3>

<p>In the Philippines, employment law is <em>highly protective</em> of workers. That's a good thing — but only if you understand it.</p>

<p>Direct hires often start as "contractors." But if you assign set hours, provide tools or systems, supervise their output regularly, or require exclusivity or ongoing work, then legally, they may be considered <strong>employees under local law</strong>.</p>

<p>Misclassification can lead to claims for back pay, benefits, and leave; legal disputes you're not set up to manage; and exposure to penalties under DOLE (Department of Labor and Employment). Worse, if you're not registered as an employer in the Philippines, <strong>you're not compliant to begin with</strong>.</p>

<h3>Device, Data &amp; Security Risks</h3>

<p>When you hire direct, your offshore staff typically work from home using personal laptops, unsecured internet connections, and shared household devices.</p>

<p>That means company data may live on unprotected drives; access to systems can't be properly controlled; and there's no way to enforce offboarding or data wipeouts if they leave. In regulated industries (finance, health, legal), this creates a <em>massive risk footprint</em> — and no formal recourse if things go wrong.</p>

<h3>Lack of Oversight and Performance Structure</h3>

<p>Unlike managed outsourcing, direct hires don't come with productivity tracking tools, structured onboarding, HR support, or formal feedback or escalation channels.</p>

<p>That puts all responsibility on you — to manage time, output, discipline, and motivation remotely. If something slips, <strong>there's no system to catch it</strong>.</p>

<figure>
<img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1400&q=80" alt="Laptop screen showing code, representing an unmanaged personal device">
<figcaption>Personal laptops, unsecured networks — the device risk behind most direct hires.</figcaption>
</figure>

<h3>Lower Loyalty: Contractors Aren't Built to Stay</h3>

<p>The best Filipino professionals don't want to be contractors.</p>

<p>They want stability, payslips, access to statutory benefits (SSS, PhilHealth, Pag-IBIG), and <em>legitimate career pathways</em>.</p>

<p>When you hire directly, you may only attract candidates who've been rejected elsewhere, short-term freelancers juggling multiple clients, or staff with no real loyalty to your brand. That's not just a hiring risk — it's a <strong>long-term quality issue</strong>.</p>

<h3>Payment Channels = Compliance Headaches</h3>

<p>Many businesses pay direct hires via Wise, Payoneer, PayPal, or crypto wallets. These are <em>not payroll systems</em>. They're money transfer tools.</p>

<p>They offer no payslip history, no taxation record, and no employment contract linkage. And in many cases, no audit trail. That creates serious issues if staff dispute payment, regulators audit your transactions, or you're asked to prove employment legitimacy.</p>

<h3>Final Thought: Cheap Up Front, Costly Over Time</h3>

<p>Direct hiring may save you money on the first invoice. But what about lost IP, data breaches, staff walking out mid-project, legal action for misclassification, or losing top candidates to more legitimate employers?</p>

<p>If you're serious about offshoring — and building a team that sticks — <strong>the structure behind the hire matters as much as the hire itself</strong>. Offshoring should simplify your business, not expose it.</p>
BODY,
                'sort_order' => 1,
                'is_active'  => true,
            ],
        ];

        foreach ($posts as $post) {
            Blog::updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
