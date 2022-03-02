@csrf
<div class="form-group">
  <textarea name="body" required class="form-control" rows="16" placeholder="ひとこと・できごと・おもいを入力">{{ $memory->body ?? old('body') }}</textarea>
</div>
