<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Icon;


class IconTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function アイコン画像ファイルを取得し一意なファイル名をつけて保存に成功する()
    {
        $request = new Request;
        $request->icon_path = UploadedFile::fake()->image('test.jpeg', 50, 50)->size(100);
        $file_name = Icon::saveFile($request);
        $this->assertFileExists('storage/app/public/icon/' . $file_name);
    }
}
