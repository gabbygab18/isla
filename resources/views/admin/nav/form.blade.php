<form method="POST" action="{{ $action }}">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <div class="form-grid">
    <div class="form-split">
      <div class="form-row">
        <label for="label">Label</label>
        <input type="text" id="label" name="label" value="{{ old('label', $model->label ?? '') }}" required>
        @error('label')<span class="field-error">{{ $message }}</span>@enderror
      </div>
      <div class="form-row">
        <label for="sort_order">Sort order</label>
        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $model->sort_order ?? 0) }}">
      </div>
    </div>
    <div class="form-row">
      <label for="url">URL</label>
      <input type="text" id="url" name="url" value="{{ old('url', $model->url ?? '') }}" required>
      <span class="hint">e.g. /services, /pricing, /contact, or an anchor like /#contact</span>
      @error('url')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (shown in the menu)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.nav-items') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>
