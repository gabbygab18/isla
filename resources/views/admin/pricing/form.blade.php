<form method="POST" action="{{ $action }}">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <div class="form-grid">
    <div class="form-split">
      <div class="form-row">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $model->name ?? '') }}" required>
        @error('name')<span class="field-error">{{ $message }}</span>@enderror
      </div>
      <div class="form-row">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $model->slug ?? '') }}">
        <span class="hint">Leave blank to auto-generate.</span>
      </div>
    </div>
    <div class="form-split">
      <div class="form-row">
        <label for="tag">Tag</label>
        <input type="text" id="tag" name="tag" value="{{ old('tag', $model->tag ?? '') }}">
        <span class="hint">e.g. Part-time support</span>
      </div>
      <div class="form-row">
        <label for="detail">Detail line</label>
        <input type="text" id="detail" name="detail" value="{{ old('detail', $model->detail ?? '') }}">
        <span class="hint">e.g. 20 hrs / week · one dedicated VA</span>
      </div>
    </div>
    <div class="form-split">
      <div class="form-row">
        <label for="ribbon">Ribbon</label>
        <input type="text" id="ribbon" name="ribbon" value="{{ old('ribbon', $model->ribbon ?? '') }}">
        <span class="hint">e.g. Most popular (leave blank for none)</span>
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
      <textarea id="body" name="body" style="min-height:150px;">{{ old('body', $model->body ?? '') }}</textarea>
      <span class="hint">Separate paragraphs with a blank line.</span>
    </div>
    <div class="form-row">
      <label for="features_text">Features list</label>
      <textarea id="features_text" name="features_text">{{ old('features_text', isset($model) ? collect($model->features ?? [])->implode("\n") : '') }}</textarea>
      <span class="hint">One feature per line.</span>
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $model->is_featured ?? false) ? 'checked' : '' }}>
      <label for="is_featured">Featured (highlighted card)</label>
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (visible on the site)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.pricing-plans') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>
