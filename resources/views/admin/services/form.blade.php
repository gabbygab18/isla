<form method="POST" action="{{ $action }}">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <div class="form-grid">
    <div class="form-split">
      <div class="form-row">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="{{ old('title', $model->title ?? '') }}" required>
        @error('title')<span class="field-error">{{ $message }}</span>@enderror
      </div>
      <div class="form-row">
        <label for="icon">Icon (SVG symbol id)</label>
        <input type="text" id="icon" name="icon" value="{{ old('icon', $model->icon ?? 'i-calendar') }}">
        <span class="hint">e.g. i-calendar, i-headset, i-receipt, i-shield, i-megaphone, i-chat</span>
      </div>
    </div>
    <div class="form-split">
      <div class="form-row">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $model->slug ?? '') }}">
        <span class="hint">Leave blank to auto-generate.</span>
      </div>
      <div class="form-row">
        <label for="sort_order">Sort order</label>
        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $model->sort_order ?? 0) }}">
      </div>
    </div>
    <div class="form-row">
      <label for="summary">Card summary</label>
      <textarea id="summary" name="summary">{{ old('summary', $model->summary ?? '') }}</textarea>
    </div>
    <div class="form-row">
      <label for="body">Detail page body</label>
      <textarea id="body" name="body" style="min-height:160px;">{{ old('body', $model->body ?? '') }}</textarea>
      <span class="hint">Separate paragraphs with a blank line.</span>
    </div>
    <div class="form-row">
      <label for="deliverables_text">"What's included" list</label>
      <textarea id="deliverables_text" name="deliverables_text">{{ old('deliverables_text', isset($model) ? collect($model->deliverables ?? [])->implode("\n") : '') }}</textarea>
    </div>

    <div class="form-row">
      <label for="roles_text">"Roles we support" list <small style="opacity:.6;">(one per line — shown on the service detail page)</small></label>
      <textarea id="roles_text" name="roles_text">{{ old('roles_text', isset($model) ? collect($model->roles ?? [])->implode("\n") : '') }}</textarea>
      <span class="hint">One item per line.</span>
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (visible on the site)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.services') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>
