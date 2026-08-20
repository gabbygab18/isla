<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TalentRole;
use App\Models\TalentSubRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TalentTaxonomyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/TalentTaxonomy/Index', [
            'roles' => TalentRole::with('subRoles')
                ->withCount('profiles')
                ->orderBy('sort_order')
                ->get(),
            'categories' => TalentRole::whereNotNull('category')
                ->distinct()->orderBy('category')->pluck('category'),
        ]);
    }

    /* ---------------- roles ---------------- */

    public function storeRole(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'category'   => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $data['slug'] = $this->uniqueSlug(TalentRole::class, $data['name']);
        $data['sort_order'] = $data['sort_order'] ?? (TalentRole::max('sort_order') + 1);
        $data['is_active'] = $request->boolean('is_active', true);

        TalentRole::create($data);

        return back()->with('success', 'Role added.');
    }

    public function updateRole(Request $request, TalentRole $role)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'category'   => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        if ($data['name'] !== $role->name) {
            $data['slug'] = $this->uniqueSlug(TalentRole::class, $data['name'], $role->id);
        }
        $data['is_active'] = $request->boolean('is_active', true);

        $role->update($data);

        return back()->with('success', 'Role updated.');
    }

    public function destroyRole(TalentRole $role)
    {
        $role->delete();

        return back()->with('success', 'Role deleted.');
    }

    /** Invalidates any link already shared for this role. */
    public function regenerateRoleToken(TalentRole $role)
    {
        $role->update(['share_token' => TalentRole::newShareToken()]);

        return back()->with('success', 'Role link regenerated — the previous link no longer works.');
    }

    /* ---------------- sub-roles ---------------- */

    public function storeSubRole(Request $request, TalentRole $role)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $data['talent_role_id'] = $role->id;
        $data['slug'] = $this->uniqueSubRoleSlug($role->id, $data['name']);
        $data['sort_order'] = $data['sort_order'] ?? (TalentSubRole::where('talent_role_id', $role->id)->max('sort_order') + 1);
        $data['is_active'] = $request->boolean('is_active', true);

        TalentSubRole::create($data);

        return back()->with('success', 'Sub-role added.');
    }

    public function updateSubRole(Request $request, TalentSubRole $subRole)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($data['name'] !== $subRole->name) {
            $data['slug'] = $this->uniqueSubRoleSlug($subRole->talent_role_id, $data['name'], $subRole->id);
        }
        $data['is_active'] = $request->boolean('is_active', true);

        $subRole->update($data);

        return back()->with('success', 'Sub-role updated.');
    }

    public function destroySubRole(TalentSubRole $subRole)
    {
        $subRole->delete();

        return back()->with('success', 'Sub-role deleted.');
    }

    public function regenerateSubRoleToken(TalentSubRole $subRole)
    {
        $subRole->update(['share_token' => TalentSubRole::newShareToken()]);

        return back()->with('success', 'Sub-role link regenerated — the previous link no longer works.');
    }

    /* ---------------- helpers ---------------- */

    private function uniqueSlug(string $model, string $source, ?int $ignoreId = null): string
    {
        $slug = Str::slug($source) ?: Str::random(8);
        $base = $slug;
        $i = 2;

        while ($model::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function uniqueSubRoleSlug(int $roleId, string $source, ?int $ignoreId = null): string
    {
        $slug = Str::slug($source) ?: Str::random(8);
        $base = $slug;
        $i = 2;

        while (TalentSubRole::where('talent_role_id', $roleId)->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
