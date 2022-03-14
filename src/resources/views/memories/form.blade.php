@csrf
<div class="form-group">
    <textarea name="body" required class="form-control" rows="16" placeholder="ひとこと・できごと・おもいを入力">{{ $memory->body ?? old('body') }}
    </textarea>
    {{-- お子さまを登録済の場合、お子さまを選ぶボタンを表示（任意） --}}
    @if (!is_null($children))
        @foreach($children as $child)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="children[]" value="{{ $child->id }}">
                <label class="form-check-label" for="inlineRadio1">{{ $child->name }}</label>
            </div>
        @endforeach
    @endif
</div>
