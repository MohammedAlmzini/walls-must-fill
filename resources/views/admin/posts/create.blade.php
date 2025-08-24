@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <h2>تدوينة جديدة</h2>
    <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>العنوان *</label>
            <input type="text" name="title" required value="{{ old('title') }}" 
                   placeholder="أدخل عنوان التدوينة">
        </div>

        <div class="form-group">
            <label>وصف مختصر (Excerpt)</label>
            <textarea name="excerpt" rows="3" maxlength="500" 
                      placeholder="وصف مختصر للتدوينة يظهر في صفحة التدوينات ومحركات البحث">{{ old('excerpt') }}</textarea>
            <small class="text-muted">الحد الأقصى: 500 حرف</small>
        </div>

        <div class="form-group">
            <label>المحتوى *</label>
            <div id="editor-container">
                <div id="toolbar">
                    <!-- Toolbar will be inserted here -->
                </div>
                <div id="editor" style="min-height: 400px;">
                    {!! old('body') !!}
                </div>
            </div>
            <input type="hidden" name="body" id="body-input">
        </div>

        <div class="form-group">
            <label>صورة مميزة</label>
            <input type="file" name="image" accept="image/*" id="featured-image">
            <small class="text-muted">الحد الأقصى: 2MB، الأنواع المدعومة: JPG, PNG, GIF</small>
            <div id="image-preview" style="display: none;">
                <img id="preview-img" style="max-width: 200px; margin-top: 10px; border-radius: 8px;">
            </div>
        </div>

        <div class="form-group">
            <label>رابط فيديو يوتيوب (اختياري)</label>
            <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" 
                   placeholder="https://www.youtube.com/watch?v=... أو https://youtu.be/...">
            <small class="text-muted">سيتم تحويله تلقائياً إلى رابط embed</small>
        </div>

        <div class="form-group">
            <label>Meta Description (لمحركات البحث)</label>
            <textarea name="meta_description" rows="2" maxlength="160" 
                      placeholder="وصف التدوينة لمحركات البحث">{{ old('meta_description') }}</textarea>
            <small class="text-muted">الحد الأقصى: 160 حرف (مُوصى به: 120-150 حرف)</small>
        </div>

        <div class="form-group">
            <label>تاريخ النشر</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_published" value="1" checked> 
                نشر التدوينة فوراً
            </label>
        </div>

        <div class="actions" style="margin-top: 20px;">
            <button class="btn" type="submit">حفظ التدوينة</button>
            <button class="btn secondary" type="button" onclick="saveDraft()">حفظ كمسودة</button>
            <a class="btn tertiary" href="{{ route('admin.posts.index') }}">إلغاء</a>
        </div>
    </form>
</div>

<!-- Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<style>
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: var(--black);
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    font-size: 14px;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.text-muted {
    font-size: 12px;
    color: var(--muted);
    margin-top: 5px;
    display: block;
}

.checkbox-label {
    display: flex !important;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: auto !important;
    margin: 0;
}

#editor-container {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
}

#editor {
    background: white;
}

.ql-toolbar {
    border-bottom: 1px solid var(--border) !important;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
}

.ql-container {
    border: none !important;
    font-family: inherit;
    font-size: 14px;
}

.actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn.secondary {
    background: var(--gray);
}

.btn.tertiary {
    background: transparent;
    color: var(--muted);
    border: 1px solid var(--border);
}

.btn.tertiary:hover {
    background: var(--surface);
    color: var(--ink);
}
</style>

<script>
// Initialize Quill editor
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            ['clean']
        ]
    },
    placeholder: 'اكتب محتوى التدوينة هنا...'
});

// Save content to hidden input on form submit
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('body-input').value = quill.root.innerHTML;
});

// Image preview functionality
document.getElementById('featured-image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Auto-save functionality
function saveDraft() {
    document.querySelector('input[name="is_published"]').checked = false;
    document.getElementById('body-input').value = quill.root.innerHTML;
    document.querySelector('form').submit();
}

// Auto-save every 2 minutes
setInterval(function() {
    if (quill.getText().trim().length > 10) {
        const formData = new FormData();
        formData.append('title', document.querySelector('input[name="title"]').value);
        formData.append('body', quill.root.innerHTML);
        formData.append('excerpt', document.querySelector('textarea[name="excerpt"]').value);
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        
        // Save to localStorage as backup
        localStorage.setItem('draft_post', JSON.stringify({
            title: document.querySelector('input[name="title"]').value,
            body: quill.root.innerHTML,
            excerpt: document.querySelector('textarea[name="excerpt"]').value,
            timestamp: new Date().toISOString()
        }));
    }
}, 120000); // 2 minutes

// Restore from localStorage if available
window.addEventListener('load', function() {
    const draft = localStorage.getItem('draft_post');
    if (draft) {
        const draftData = JSON.parse(draft);
        if (confirm('تم العثور على مسودة محفوظة. هل تريد استعادتها؟')) {
            document.querySelector('input[name="title"]').value = draftData.title || '';
            quill.root.innerHTML = draftData.body || '';
            document.querySelector('textarea[name="excerpt"]').value = draftData.excerpt || '';
        }
    }
});

// Clear draft after successful save
document.querySelector('form').addEventListener('submit', function() {
    localStorage.removeItem('draft_post');
});
</script>
@endsection