# childhood


## 1. 「childhood」とは
 子どものちょっとしたひとこと、できごとを書き留めておくwebアプリケーションです。  
 URL:https://www.mychildhood.link

## 2. 使用技術
  * フロントエンド
    * HTML
    * CSS
    * MDBootstrap
  
  * バックエンド
    * PHP 8.1.4
    * Laravel 9.6.0
    * MySQL 8.0.28
    * composer
    * PHPUnit
  
  * インフラ
    * nginx 1.20.2
    * 開発環境：Docker 20.10.12
    * 本番環境：AWS ( EC2, ALB, ACM, S3, RDS, Route53, VPC, IAM ) 
   
  * その他
    * GitHub
    * PHPMyAdmin
    * VScode 

## 3. インフラ構成図
![childhood_infra](https://user-images.githubusercontent.com/98136753/162660792-e97ba8d5-2e4e-4236-ae64-977085fa87f9.png)  



## 4. ER図
![childhood_erd_03](https://user-images.githubusercontent.com/98136753/162660896-b1afc3ca-4e54-4c88-92b0-fa0f3b8686a8.svg)  



## 5. アプリの特徴
  招待された家族のみで思い出を共有することを目的としたアプリです。  
  思い出の投稿、閲覧、コメントはすべて同じ家族内でのみ可能です。  
  

## 6. アプリの機能一覧
  * 認証機能
    * ユーザー登録
    * ログイン、ログアウト
    * パスワード再設定

  * メイン機能
    * 思い出の投稿（CRUD機能）
    * 思い出の画像のアップロード
    * 思い出に対するコメントの投稿、削除

  * ふりかえり
    * PickUp思い出の表示（過去の思い出をランダムに選んで表示）
    * お子さまごとの思い出の表示
    * 年月ごとの思い出の表示

  * ユーザー設定
    * ユーザーネーム、アイコン画像の登録
    * お子さまの名前、アイコン画像、生年月日の登録
    * ファミリーネームの設定
    * 家族招待メールの送信（SendGrid）
