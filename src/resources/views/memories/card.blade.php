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
    <div class="card-body pt-0">
      <div class="card-text">
        <a class="text-dark" href="{{ route('memories.show', ['memory' => $memory]) }}">
        {{ $memory->body }}
        </a>
      </div>
    </div>
  </div>
