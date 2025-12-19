const functions = require('firebase-functions');
const admin = require('firebase-admin');
const fs = require('fs');
const path = require('path');

admin.initializeApp();

// 環境変数から認証情報を取得（デフォルト値も設定可能）
const getAuthConfig = () => {
  const config = functions.config().auth || {};
  return {
    username: config.username || 'ashmd-design-user',
    password: config.password || 'password1234'
  };
};

/**
 * Basic認証を実装したミドルウェア
 * /develop/* パスへのアクセスを保護
 * 
 * 注意: デプロイ前に public/develop を functions/public/develop にコピーする必要があります
 */
exports.authDevelop = functions.https.onRequest((req, res) => {
  const authConfig = getAuthConfig();
  const authHeader = req.headers.authorization;

  // Basic認証のヘッダーを取得
  if (!authHeader || !authHeader.startsWith('Basic ')) {
    res.set('WWW-Authenticate', 'Basic realm="Develop Area"');
    res.status(401).send('Authentication required');
    return;
  }

  // Base64でエンコードされた認証情報をデコード
  const base64Credentials = authHeader.split(' ')[1];
  const credentials = Buffer.from(base64Credentials, 'base64').toString('ascii');
  const [user, pass] = credentials.split(':');

  // 認証情報を検証
  if (user !== authConfig.username || pass !== authConfig.password) {
    res.set('WWW-Authenticate', 'Basic realm="Develop Area"');
    res.status(401).send('Authentication failed');
    return;
  }

  // 認証成功：静的ファイルを提供
  const requestPath = req.path;
  // /develop 以降のパスを取得
  let filePath = requestPath;
  
  // パスが /develop で終わる場合、index.htmlを探す
  if (filePath.endsWith('/')) {
    filePath += 'index.html';
  }
  
  // 拡張子がない場合、.htmlを追加
  if (!path.extname(filePath)) {
    filePath += '.html';
  }

  // 静的ファイルのパスを構築（functions/developディレクトリからの相対パス）
  // デプロイ時に public/develop が functions/develop にコピーされる想定
  // filePathは /develop/ul/wf/top.html のような形式なので、/develop を削除
  let relativePath = filePath.startsWith('/develop') ? filePath.substring('/develop'.length) : filePath;
  // 先頭の / を削除（path.joinで正しく動作するように）
  if (relativePath.startsWith('/')) {
    relativePath = relativePath.substring(1);
  }
  const staticFilePath = path.join(__dirname, 'develop', relativePath);

  // デバッグ用：利用可能なディレクトリを確認
  const debugInfo = {
    __dirname: __dirname,
    filePath: filePath,
    relativePath: relativePath,
    staticFilePath: staticFilePath,
    exists: fs.existsSync(staticFilePath),
    developDirExists: fs.existsSync(path.join(__dirname, 'develop'))
  };

  // ファイルが存在するか確認
  if (fs.existsSync(staticFilePath)) {
    const ext = path.extname(filePath).toLowerCase();
    
    // Content-Typeを設定
    const contentTypeMap = {
      '.html': 'text/html',
      '.css': 'text/css',
      '.js': 'application/javascript',
      '.json': 'application/json',
      '.png': 'image/png',
      '.jpg': 'image/jpeg',
      '.jpeg': 'image/jpeg',
      '.gif': 'image/gif',
      '.svg': 'image/svg+xml',
      '.ico': 'image/x-icon'
    };
    
    const contentType = contentTypeMap[ext] || 'text/plain';
    res.set('Content-Type', contentType);
    
    // テキストファイルとバイナリファイルを区別
    const isTextFile = ['.html', '.css', '.js', '.json', '.svg'].includes(ext);
    
    if (isTextFile) {
      // テキストファイルはUTF-8で読み込む
      const fileContent = fs.readFileSync(staticFilePath, 'utf8');
      res.status(200).send(fileContent);
    } else {
      // バイナリファイル（画像など）はバイナリで読み込む
      const fileContent = fs.readFileSync(staticFilePath);
      res.status(200).send(fileContent);
    }
  } else {
    // デバッグ情報を含めて404を返す（本番環境では削除推奨）
    res.status(404).send(`File not found. Debug: ${JSON.stringify(debugInfo, null, 2)}`);
  }
});

