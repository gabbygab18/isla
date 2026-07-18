<form method="POST" action="{{ $action }}">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <div class="form-grid">
    <div class="form-row">
      <label for="question">Question</label>
      <input type="text" id="question" name="question" value="{{ old('question', $model->question ?? '') }}" required>
      @error('question')<span class="field-error">{{ $message }}</span>@enderror
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
      <label for="answer">Answer</label>
      <textarea id="answer" name="answer" style="min-height:150px;" required>{{ old('answer', $model->answer ?? '') }}</textarea>
      <span class="hint">Separate paragraphs with a blank line.</span>
      @error('answer')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (visible on the site)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.faqs') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>
