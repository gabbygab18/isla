<form method="POST" action="{{ $action }}">
  @csrf
  @if($method === 'PUT') @method('PUT') @endif
  <div class="form-grid">
    <div class="form-row">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" value="{{ old('title', $model->title ?? '') }}" required>
      @error('title')<span class="field-error">{{ $message }}</span>@enderror
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
    <div class="form-split">
      <div class="form-row">
        <label for="author">Author</label>
        <input type="text" id="author" name="author" value="{{ old('author', $model->author ?? '') }}">
      </div>
      <div class="form-row">
        <label for="published_at">Published date</label>
        <input type="date" id="published_at" name="published_at" value="{{ old('published_at', optional($model->published_at ?? null)->format('Y-m-d')) }}">
      </div>
    </div>
    <div class="form-row">
      <label for="cover_image">Cover image URL</label>
      <input type="text" id="cover_image" name="cover_image" value="{{ old('cover_image', $model->cover_image ?? '') }}" placeholder="https://...">
      @error('cover_image')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-row">
      <label for="excerpt">Excerpt</label>
      <textarea id="excerpt" name="excerpt">{{ old('excerpt', $model->excerpt ?? '') }}</textarea>
      <span class="hint">Short summary shown on the blog listing.</span>
      @error('excerpt')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-row">
      <label for="body">Body</label>
      <textarea id="body" name="body" style="min-height:260px;">{{ old('body', $model->body ?? '') }}</textarea>
      <span class="hint">Insert images by URL only (stock photo links) — no file upload.</span>
      @error('body')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-check">
      <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $model->is_active ?? true) ? 'checked' : '' }}>
      <label for="is_active">Active (visible on the site)</label>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save</button>
      <a href="{{ route('admin.blogs') }}" class="btn btn-outline">Cancel</a>
    </div>
  </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#body'), {
      toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', 'blockQuote', '|', 'link', 'insertImage', '|', 'undo', 'redo'],
    })
    .then(function (editor) {
      document.querySelector('form').addEventListener('submit', function () {
        editor.updateSourceElement();
      });
    })
    .catch(function (error) {
      console.error(error);
    });
</script>
