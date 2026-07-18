<?php

namespace Database\Seeders;

use App\Models\NavItem;
use Illuminate\Database\Seeder;

class NavItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'About Us',          'url' => '/about'],
            ['label' => 'Team We Build',     'url' => '/team-we-build'],
            ['label' => 'Industries',        'url' => '/who-we-work-with'],
            ['label' => 'How it Works',      'url' => '/how-it-works'],
            ['label' => 'Cost Estimator',    'url' => '/cost-estimator'],
            ['label' => 'Pricing',           'url' => '/pricing'],
            ['label' => 'FAQ',               'url' => '/faq'],
            ['label' => 'Contact',           'url' => '/contact'],
        ];

        foreach ($items as $i => $item) {
            NavItem::updateOrCreate(
                ['label' => $item['label']],
                ['url' => $item['url'], 'sort_order' => $i + 1, 'is_active' => true]
            );
        }
    }
}
