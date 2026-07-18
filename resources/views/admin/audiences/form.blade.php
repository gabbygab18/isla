{{-- expects: $model (nullable), $action, $method --}}
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
        <input type="text" id="icon" name="icon" value="{{ old('icon', $model->icon ?? 'i-users') }}">
        <span class="hint">e.g. i-shield, i-clipboard, i-users, i-calendar</span>
      </div>
    </div>
    <div class="form-split">
      <div class="form-row">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $model->slug ?? '') }}">
        <span class="hint">Leave blank to auto-generate from the title.</span>
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
      <label for="points_text">Detail bullet points</label>
      <textarea id="points_text" name="points_text">{{ old('points_text', isset($model) ? collect($model->points ?? [])->implode("\n") : '') }}</textarea>
      <span class="hint">One point per line.</span>
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (visible on the site)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.audiences') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>
