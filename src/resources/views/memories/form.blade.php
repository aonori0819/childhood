@csrf
<div class="form-group">
    <textarea name="body" required class="form-control" rows="16" placeholder="ひとこと・できごと・おもいを入力">{{ $memory->body ?? old('body') }}
    </textarea>
    {{-- お子さまを登録済の場合、お子さまを選ぶボタン（任意選択）を表示 --}}
    @if (isset($child_list))
        @foreach($child_list as $id => $name)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="children[]" value="{{ $id }}" {{ $memory->children->contains($id) ? 'checked' : '' }}>
                <label class="form-check-label" for="inlineRadio1">{{ $name }}</label>
            </div>
        @endforeach
    @endif
</div>
