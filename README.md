# 導入
1. Webサーバ(apache / nginx) + PHP(5.6以上) + postgresql(9.x以上)の環境を準備
2. このリポジトリ全体をWebRootに配置します
3. <webroot> で ```$ composer update``` を実行します。
4. <webroot>/system/configs/config.development.php 内のDBの接続設定を環境に合わせて設定します。database名には、新規作成した空のデータベースを指定してください。
5. sql/init.sql を 3. で指定したdatabaseで実行します。
6. 端末から <webroot> で ```php index.php AreaImportBatch``` を実行します。
7. Webブラウザでターゲットにアクセスするとでもページが表示されるはずです

# 構成

## /system/config
データベース接続情報等が記載された環境設定ファイルが格納されたディレクトリ
ファイル名は、config.<環境名称>.php
このディレクトリに、.environment というファイルを置き、参照する環境名称を記載すると、そのファイルが参照される。
例えば、以下のように記載すると、config.stage.php がロードされる

```
stage
```

## /system/framework/
フレームワークの本体

## /system/module/
実装コードの配置場所
Autoloaderによるクラスロードに対応。namespaceには未対応。

## データベース接続について
データベースへの接続は、Serviceクラスの派生クラス、もしくはフレームワーク内で定義されている DataService(/framework/service/DataService.php) を通じて行います。
PDOのオブジェクトは Serviceクラスの派生クラスから、Service::$db として参照可能です。

# 利用可能なテンプレートエンジン
Controller の getDeaultRendererで、出力に使用するRendererを指定可能。
twig, json, dump の３種類が利用可能
twig を選択した場合の template の配置場所は、/system/templates/twig/templates/twig/(pc|sp|common) 配下に格納すること。
pc/sp/common のどのディレクトリが参照されるかは、アクセス元のUser-Agentにより決定される。
PC : pc -> common -> sp から順にファイルを検索
Mobile : sp -> common -> pc から順にファイルを検索

出力に利用するテンプレートファイル名は Controller::createModel() の戻り値として指定する(/system/templates/twig/templates/twig/(pc|sp|common)) 空の相対パス、拡張子は不要。

# batchの作成と実行
/module/batch/　直下に、Batchクラスを継承したクラス作成し、同名の.phpファイルとして格納すれば、端末からバッチプログラムとして実行することが可能
```
$ cd <webroot>
$ php index.php <Batch class name>
```
