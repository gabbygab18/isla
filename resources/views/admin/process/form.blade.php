<form method="POST" action="{{ $action }}">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <div class="form-grid">
    <div class="form-split">
      <div class="form-row">
        <label for="number">Number</label>
        <input type="text" id="number" name="number" value="{{ old('number', $model->number ?? '') }}" required>
        <span class="hint">e.g. 01</span>
        @error('number')<span class="field-error">{{ $message }}</span>@enderror
      </div>
      <div class="form-row">
        <label for="sort_order">Sort order</label>
        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $model->sort_order ?? 0) }}">
      </div>
    </div>
    <div class="form-row">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" value="{{ old('title', $model->title ?? '') }}" required>
      @error('title')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-row">
      <label for="summary">Summary</label>
      <textarea id="summary" name="summary">{{ old('summary', $model->summary ?? '') }}</textarea>
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (visible on the site)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.process-steps') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>
