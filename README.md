# アプリ概要

## Comenion (コメ二オン)

#### URL:**[https://comenion.com/](https://comenion.com/)**  
レスポンシブ化(iPhone5の横幅320pxまで対応)

## サービス概要
お笑いに特化したSNSです。お笑いに関する情報の共有や相方の募集、コンビの結成ができるサービスです。  
<img src="https://user-images.githubusercontent.com/67299659/114543595-5d56e200-9c94-11eb-8cf4-27647505a031.png" width="750">

## 制作背景
私の趣味はお笑い観賞であり、劇場に足を運ぶほどお笑いが好きです。
好きになった経緯は、落ち込んでいる時にお笑いで勇気づけられたからです。
お笑いは誰でも気軽に始める事ができます。
**お笑いへの挑戦を後押し、少しでも多くの人にお笑いを身近に感じて欲しい**と思い、作成いたしました。

## このWEBサービスの強み
お笑いの相方募集に特化したサービスは掲示板形式のものが多く、メールアドレスや、LINEのIDなどを書き込まないといけないが、
このサービスは**相方申請からコンビ結成までサービス上で完結**するので、安心して利用できます。  
掲示板だと相手が見えないが、プロフィール設定、タイムライン機能で**相手がどういう人物か知った上**で相方申請ができます。

# 画面一覧
## タイムライン
<img src="https://github.com/r-sugimoto/readme-folder/blob/master/gif/post.gif">  

## 相方募集投稿
<img src="https://github.com/r-sugimoto/readme-folder/blob/master/gif/recruit.gif">  

## マイページ
<img src="https://github.com/r-sugimoto/readme-folder/blob/master/gif/mypage.gif">  

## 相方申請管理
<img src="https://github.com/r-sugimoto/readme-folder/blob/master/gif/partner.gif">  

## チャット
<img src="https://github.com/r-sugimoto/readme-folder/blob/master/gif/chat.gif">  

## 設定
<img src="https://github.com/r-sugimoto/readme-folder/blob/master/gif/setting.gif">  

# 機能一覧
 - ユーザー登録関連機能
 - 新規登録、SNSログイン機能(Twitter)
 - ユーザー設定、退会機能   
- 投稿機能
   - 相方募集の投稿、通常投稿(タイムライン)
     - 画像、動画アップロード(AWS S3バケット)
     - Youtube動画の埋め込み
- 相方申請機能
  - 相方申請の承認、否認
- 結成コンビ管理機能
  - コンビ名変更
  - コンビ解散
- 無限スクロール
  - 相方募集投稿、タイムライン一覧など 
- タグ機能
  - プロフィール、各種投稿に設定可能
- 検索機能
  - フリーワード検索 
  - タグ検索
  - 相方募集投稿検索(募集エリア、地域、世代検索)
- 通知機能(サイト内通知)
  - 相方申請、申請結果、コメント、DMの通知
- フラッシュメッセージ(投稿完了など)
- DM機能
- フォロー機能
- いいね機能

# 使用技術
- フロントエンド
  - Javascript / Vue.js 2.6.12 
  - HTML / CSS / Sass / Vuetify
  - VeeValidate(バリデーション)
  - vue-infinite-loading(無限スクロール)
- バックエンド
　- PHP 7.4.13 / Laravel 6.20.22 
- インフラ
  - AWS(VPC、EC2、RDS、ACM、EBS、IAM、S3)
- その他使用ツール
  - Amazon SES (会員登録メール送信用)
  - circleci
  - Docker / docker-compose  

# インフラ構成図
<img src="https://github.com/r-sugimoto/readme-folder/blob/master/Untitled%20Diagram.png">

# 工夫した点
- SNSから集客する想定だったので、Twitterログインの実装しました。
- 当初、ページング機能で一覧ページを実装していましたが、ストレス無くご利用いただけるよう無限スクロールに変更しました。
- 自分の募集条件にあったユーザー、気の合うユーザーを見逃さないように検索機能の充実化させました。
  - フリーワード、タグ、募集条件（エリア、都道府県、年代）での絞り込み
- 動画アップロード機能、Youtubeの埋め込みができるようにしました。
  - 動画などを通してその人をより深く知る事ができ、コンビの結成に繋がりやすくなると思います。
- フラッシュメッセージ、ローディングのくるくるをVueXで管理
  - 毎回記述するのでは無く、VueXで管理する事でコード量の削減する事ができました。

# 苦労した点
- 相方申請

# 今後の展望
- 通知機能の強化
  - 現状、ログインしないと通知に気づけない状況です。
    - SMS、メールで通知を知らせるよう実装する。
- スマホアプリにしたい
  - アナリティクスで分析したところ、スマホユーザーが多く、アプリ化したいと考えています。
    - Flutterなどで作り変えるのもアリかなと思っています(プッシュ通知により、通知問題の解決に繋がる)
- 登録ユーザーを増やしたい
  - 現状、相方募集投稿を確認し、離脱していくユーザーが多いです。
    - 大喜利機能など、登録しないと使えないコンテンツを増やしていき、解決したいと考えています。 　  






