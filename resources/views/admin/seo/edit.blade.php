@extends('admin.layouts.admin')

@section('title', 'تعديل إعدادات SEO')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تعديل إعدادات SEO</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> العودة للقائمة
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.seo.update', $seoSetting) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="page_key">الصفحة <span class="text-danger">*</span></label>
                                    <select name="page_key" id="page_key" class="form-control @error('page_key') is-invalid @enderror" required>
                                        <option value="">اختر الصفحة</option>
                                        @foreach($availablePages as $key => $name)
                                            <option value="{{ $key }}" {{ old('page_key', $seoSetting->page_key) == $key ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('page_key')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="locale">اللغة <span class="text-danger">*</span></label>
                                    <select name="locale" id="locale" class="form-control @error('locale') is-invalid @enderror" required>
                                        <option value="">اختر اللغة</option>
                                        @foreach($availableLocales as $key => $name)
                                            <option value="{{ $key }}" {{ old('locale', $seoSetting->locale) == $key ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('locale')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">العنوان <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title', $seoSetting->title) }}" required maxlength="255">
                                    <small class="form-text text-muted">العنوان الذي سيظهر في نتائج البحث</small>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keywords">الكلمات المفتاحية</label>
                                    <input type="text" name="keywords" id="keywords" class="form-control @error('keywords') is-invalid @enderror" 
                                           value="{{ old('keywords', $seoSetting->keywords) }}" maxlength="500">
                                    <small class="form-text text-muted">افصل بين الكلمات بفاصلة</small>
                                    @error('keywords')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">الوصف <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                      required maxlength="500">{{ old('description', $seoSetting->description) }}</textarea>
                            <small class="form-text text-muted">وصف مختصر للصفحة (أقل من 160 حرف)</small>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        <h5>إعدادات Open Graph (Facebook)</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="og_title">عنوان Open Graph</label>
                                    <input type="text" name="og_title" id="og_title" class="form-control @error('og_title') is-invalid @enderror" 
                                           value="{{ old('og_title', $seoSetting->og_title) }}" maxlength="255">
                                    <small class="form-text text-muted">اتركه فارغاً لاستخدام العنوان الأساسي</small>
                                    @error('og_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="og_description">وصف Open Graph</label>
                                    <textarea name="og_description" id="og_description" rows="2" class="form-control @error('og_description') is-invalid @enderror" 
                                              maxlength="500">{{ old('og_description', $seoSetting->og_description) }}</textarea>
                                    <small class="form-text text-muted">اتركه فارغاً لاستخدام الوصف الأساسي</small>
                                    @error('og_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="og_image">صورة Open Graph</label>
                            @if($seoSetting->og_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $seoSetting->og_image) }}" alt="صورة Open Graph الحالية" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                    <br>
                                    <small class="text-muted">الصورة الحالية</small>
                                </div>
                            @endif
                            <input type="file" name="og_image" id="og_image" class="form-control-file @error('og_image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="form-text text-muted">صورة مناسبة لمشاركة على وسائل التواصل الاجتماعي (1200×630 بكسل)</small>
                            @error('og_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        <h5>إعدادات Twitter Card</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter_title">عنوان Twitter</label>
                                    <input type="text" name="twitter_title" id="twitter_title" class="form-control @error('twitter_title') is-invalid @enderror" 
                                           value="{{ old('twitter_title', $seoSetting->twitter_title) }}" maxlength="255">
                                    <small class="form-text text-muted">اتركه فارغاً لاستخدام العنوان الأساسي</small>
                                    @error('twitter_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter_description">وصف Twitter</label>
                                    <textarea name="twitter_description" id="twitter_description" rows="2" class="form-control @error('twitter_description') is-invalid @enderror" 
                                              maxlength="500">{{ old('twitter_description', $seoSetting->twitter_description) }}</textarea>
                                    <small class="form-text text-muted">اتركه فارغاً لاستخدام الوصف الأساسي</small>
                                    @error('twitter_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="twitter_image">صورة Twitter</label>
                            @if($seoSetting->twitter_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $seoSetting->twitter_image) }}" alt="صورة Twitter الحالية" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                    <br>
                                    <small class="text-muted">الصورة الحالية</small>
                                </div>
                            @endif
                            <input type="file" name="twitter_image" id="twitter_image" class="form-control-file @error('twitter_image') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="form-text text-muted">صورة مناسبة لمشاركة على Twitter (1200×600 بكسل)</small>
                            @error('twitter_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                       {{ old('is_active', $seoSetting->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">تفعيل هذه الإعدادات</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> تحديث الإعدادات
                        </button>
                        <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// نسخ العنوان والوصف إلى حقول Open Graph إذا كانت فارغة
document.getElementById('title').addEventListener('input', function() {
    if (!document.getElementById('og_title').value) {
        document.getElementById('og_title').value = this.value;
    }
});

document.getElementById('description').addEventListener('input', function() {
    if (!document.getElementById('og_description').value) {
        document.getElementById('og_description').value = this.value;
    }
    if (!document.getElementById('twitter_description').value) {
        document.getElementById('twitter_description').value = this.value;
    }
});

document.getElementById('og_title').addEventListener('input', function() {
    if (!document.getElementById('twitter_title').value) {
        document.getElementById('twitter_title').value = this.value;
    }
});
</script>
@endsection
