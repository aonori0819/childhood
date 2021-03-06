<div class="card mt-3">
    <div class="card-body d-flex flex-row">
        @if (isset($memory->user->userDetail->icon_path))
            <img src="{{ $memory->user->userDetail->icon_path }}" width="50" height="50" class="rounded-circle mr-1" alt="アイコン画像">
        @else
            <i class="fas fa-user-circle fa-3x mr-1"></i>
        @endif
        <div>
            <div class="font-weight-bold">
                    {{ $memory->user->name }}
            </div>
            <div class="font-weight-lighter">{{ $memory->created_at->format('Y/m/d H:i') }}</div>
        </div>

      <!-- dropdown -->
        <div class="ml-auto card-text">
          <div class="dropdown">
            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="{{ route("memories.edit", ['memory' => $memory]) }}">
                <i class="fas fa-pen mr-1"></i>思い出を編集する
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $memory->id }}">
                <i class="fas fa-trash-alt mr-1"></i>思い出を削除する
              </a>
            </div>
          </div>
        </div>
        <!-- dropdown -->

        <!-- modal -->
        <div id="modal-delete-{{ $memory->id }}" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form method="POST" action="{{ route('memories.destroy', ['memory' => $memory]) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    思い出を削除します。よろしいですか？
                </div>
                <div class="modal-footer justify-content-between">
                    <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                    <button type="submit" class="btn btn-danger">削除する</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- modal -->
    </div>

    <!-- 思い出本文表示 -->
    <a class="text-dark" href="{{ route('memories.show', ['memory' => $memory]) }}">
        <div class="card-header pt-3 pb-3">
            <div class="d-flex flex-raw">
                @foreach ($memory->children as $child_to_memory)
                    <div class="d-flex flex-column pr-3">
                        <div class="fs-6">
                            {{ $child_to_memory->name}}
                        </div>
                        <div class="px-2 ">
                        @if (isset($child_to_memory->icon_path))
                            <img src="{{ $child_to_memory->icon_path }}" width="50" height="50" class="rounded-circle" alt="アイコン画像">
                        @else
                            <i class="fas fa-user-circle fa-3x mr-1"></i>
                        @endif
                        </div>
                    </div>
                @endforeach
                <div class="d-flex flex-column pr-3">
                    <div class="card-text py-2 px-4 align-self-center">
                            {{ $memory->body }}
                    </div>

                    @if (isset($memory->image_path))
                        <div class="image-upload">
                            <img src="{{ $memory->image_path }}" width="150" alt="思い出の画像">
                        </div>	
                    @endif
                </div>
            </div>
        </div>
    </a>

    <!-- コメント -->
        <ul class="list-group list-group-flush">
            @foreach ($memory->comments()->oldest()->get() as $comment)

                <li class="list-group-item">

                    <!-- コメント投稿ユーザー/日時表示 -->
                    <div class="d-flex flex-row">
                    	 @if (isset($comment->user->userDetail->icon_path))
           			 <img src="{{ $comment->user->userDetail->icon_path }}" width="50" height="50" class="rounded-circle mr-1" alt="アイコン画像">
       			 @else
           			 <i class="fas fa-user-circle fa-3x mr-1"></i>
       			 @endif
                        <div>
                            <div class="font-weight-bold">{{ $comment->user->name }}</div>
                            <div class="font-weight-lighter">{{ $comment->created_at->format('Y/m/d H:i') }}</div>
                        </div>

                    <!-- コメント削除ボタン -->
                        <div class="ml-auto">
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="delete-comment">
                                @method('DELETE')
                                @csrf

                                <button type="submit" class="btn btn-link"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- コメント本文表示 -->
                    {{ $comment->body }}
                </li>
            @endforeach
        </ul>
</div>
