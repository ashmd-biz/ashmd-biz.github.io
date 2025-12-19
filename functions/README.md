# Basic認証設定

`functions/develop` 配下のファイルにBasic認証を設定しています。

## セットアップ

1. 依存関係をインストール:
```bash
cd functions
npm install
```

2. 認証情報を設定（Google Cloud ConsoleまたはFirebase CLIで）:
```bash
firebase functions:config:set auth.username="your-username" auth.password="your-password"
```

認証情報を設定しない場合、デフォルト値（username: `admin`, password: `password`）が使用されます。

## デプロイ

```bash
cd functions
firebase deploy --only functions
```

または、`npm run deploy`を使用：
```bash
cd functions
npm run deploy
```

## 使用方法

`/develop/*` パスにアクセスすると、Basic認証が要求されます。
認証が成功すると、静的ファイルが表示されます。

## ディレクトリ構成

- `functions/develop/` - Basic認証で保護される静的ファイル（Git管理対象）

## ファイルの編集

`functions/develop/` 配下のファイルを直接編集してください。
編集後は、`firebase deploy --only functions`でデプロイしてください。

## 注意事項

- GitHub ActionsではFunctionsのデプロイは行いません
- 認証情報の変更はGoogle Cloud ConsoleまたはFirebase CLIで直接行ってください
- `functions/develop/`はGit管理対象です（`.gitignore`で除外されていません）

