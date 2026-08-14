<form method="POST" action="{{ $action }}">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <div class="form-grid">
    <div class="form-split">
      <div class="form-row">
        <label for="author">Name</label>
        <input type="text" id="author" name="author" value="{{ old('author', $model->author ?? '') }}" required>
        @error('author')<span class="field-error">{{ $message }}</span>@enderror
      </div>
      <div class="form-row">
        <label for="role">Role / Title</label>
        <input type="text" id="role" name="role" value="{{ old('role', $model->role ?? '') }}" placeholder="e.g. Operations Manager">
        @error('role')<span class="field-error">{{ $message }}</span>@enderror
      </div>
    </div>
    <div class="form-row">
      <label for="quote">Quote</label>
      <textarea id="quote" name="quote" style="min-height:150px;" required>{{ old('quote', $model->quote ?? '') }}</textarea>
      <span class="hint">The client's words only — quotation marks are added automatically on the site.</span>
      @error('quote')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-row" style="max-width:200px;">
      <label for="sort_order">Sort order</label>
      <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $model->sort_order ?? 0) }}">
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (visible on the site)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.testimonials') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>
