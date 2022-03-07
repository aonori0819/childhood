<div class="card mt-3">
    <div class="card-body d-flex flex-row">
        <i class="fas fa-user-circle fa-3x mr-1"></i>
        <div>
            <div class="font-weight-bold">{{ $memory->user->name }}</div>
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
        <div class="card-header pt-3 pb-3">
            <div class="card-text pt-1 pb-3">
                <a class="text-dark" href="{{ route('memories.show', ['memory' => $memory]) }}">
                    {{ $memory->body }}
                </a>
            </div>
        </div>

    <!-- コメント -->
        <ul class="list-group list-group-flush">
            @foreach ($memory->comment()->oldest()->get() as $comment)

                <li class="list-group-item">

                    <!-- コメント投稿ユーザー/日時表示 -->
                    <div class="d-flex flex-row">
                        <i class="fas fa-user-circle fa-3x mr-1"></i>
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
