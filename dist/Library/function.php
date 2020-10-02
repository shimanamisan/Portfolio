<?php

/****************************************
 ログの取得
*****************************************/
//ログを取るか
ini_set('log_errors', 'on');
//ログの出力ファイルを指定
ini_set('error_log', 'logs/php.log');

/****************************************
 デバッグ
*****************************************/
//デバッグフラグ
$debug_flg = true;

//デバッグログ関数
function debug($str)
{
    global $debug_flg;
    if (!empty($debug_flg)) {
        error_log($str);
    }
}

/****************************************
 セッション準備・セッション有効期限を延ばす
*****************************************/
// セッションファイルの置き場を変更する（/var/tmp/以下に置くと30日は削除されない）
// session_save_path();
// ガーベージコレクションが削除するセッションの有効期限を設定（30日以上経っているものに対してだけ１００分の１の確率で削除）
ini_set('session.gc_maxlifetime', 60*60*24*30);
// ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60*60*24*30);
// セッションを使う
session_start();
// 現在のセッションIDを新しく生成したものと置き換える（なりすましのセキュリティ対策）
session_regenerate_id();

debug('セッションの中身を確認。function.php：'. print_r($_SESSION, true));
debug('   ');

/****************************************
 クリックジャッキング対策
*****************************************/
header('X-FRAME-OPTIONS: SAMEORIGIN');

/****************************************
 エラーメッセージ用の定数
*****************************************/
define('MSG01', '入力必須です。');
define('MSG02', 'Emailの形式で入力してください。');
define('MSG03', '50文字以内で入力してください。');
define('MSG04', '100文字以内で入力してください。');
define('MSG05', '500文字以内で入力してください。');
define('MSG06', '全角で入力してください。');

// エラーメッセージ格納用の配列
$err_msg = [];

/****************************************
バリデーションチェック関数
*****************************************/
// 未入力チェック
function validRequire($str, $key)
{
    if ($str === '') {
        global $err_msg;
        $err_msg[$key] = MSG01;
    }
}
// バリデーション関数（Email形式チェック）
function validEmail($str, $key)
{
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)) {
        global $err_msg;
        $err_msg[$key] = MSG02;
    }
}
// 最大文字数チェック（名前、メールアドレス用）
function validMaxLen($str, $key, $max = 100)
{
    global $err_msg;
    if (mb_strlen($str) > $max) {
        // mb_strlen：文字数を取得するための関数
        if ($key === 'name') {
            debug('名前の文字数のエラーメッセージを格納しています。');
            debug('   ');
            $err_msg[$key] = MSG03;
        } elseif ($key === 'email') {
            debug('emailの文字数のエラーメッセージを格納しています。');
            debug('   ');
            $err_msg[$key] = MSG04;
        }
    }
}
// 最大文字数チェック（お問い合わせ内容用）
function validContactMaxLen($str, $key, $max = 500)
{
    if (mb_strlen($str) > $max) {
        // mb_strlen：文字数を取得するための関数
        global $err_msg;
        $err_msg[$key] = MSG05;
    }
}
// 全角チェック（お問い合わせ内容用）
function validNameText($str, $key)
{
    if (!preg_match("/^[ぁ-んァ-ヶー一-龠]+$/u", $str)) {
        global $err_msg;
        $err_msg[$key] = MSG06;
    }
}

/****************************************
 メール送信
*****************************************/
// ユーザーにメールを送信する
function sendMail($from, $to, $subject, $comment)
{
    if (!empty($to) && !empty($subject) && !empty($comment)) {
        // 文字化けしないように設定
        mb_language("Japanese"); // 現在使っている言語を設定する
        mb_internal_encoding("UTF-8"); // 内部の日本語をどうエンコーディング（機械が分かる言葉へ変換）するかを設定
        
        // メールを送信（送信結果はtrueかfalseで返ってくる）
        $result = mb_send_mail($to, $subject, $comment, "From: ". $from);
        // 送信結果を判定
        if ($result) {
            debug('メールを送信しました。sendMailメソッド');
        } else {
            debug('【エラー発生】メールの送信に失敗しました。sendMailメソッド');
        }
    }
}

// サイト管理者にメールを送信する
function sendMailAdmin($to, $subject, $comment)
{
    if (!empty($to) && !empty($subject) && !empty($comment)) {
        // 文字化けしないように設定
        mb_language("Japanese"); // 現在使っている言語を設定する
        mb_internal_encoding("UTF-8"); // 内部の日本語をどうエンコーディング（機械が分かる言葉へ変換）するかを設定
        
        // メールを送信（送信結果はtrueかfalseで返ってくる）
        $result = mb_send_mail($to, $subject, $comment);
        // 送信結果を判定
        if ($result) {
            debug('メールを送信しました。sendMailAdminメソッド');
        } else {
            debug('【エラー発生】メールの送信に失敗しました。sendMailAdminメソッド');
        }
    }
}

/****************************************
その他
*****************************************/
// サニタイズ
function sanitize($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 入力フォーム保持
function getFormData($key)
{
    if (!empty($_POST[$key])) {
        debug('フォーム保持でPOSTされていた時の値です。'. print_r($_POST, true));
        debug('   ');
        return $_POST[$key];
    } elseif (!empty($_SESSION[$key])) {
        debug('フォーム保持でSESSIONの値が出力されています。'. print_r($_POST, true));
        debug('   ');
        return $_SESSION[$key];
    }
}

// セッションをクリアする（値を空にするだけ）
function clearSession($key)
{
    debug('SESSIONの値を空にしています。clearSessionメソッド');
    debug('   ');
    $_SESSION[$key] = "";
}

// ユーザーのIPアドレスを取得
function getIP()
{
    debug("ユーザーのIPアドレスを取得しています。" . $_SERVER["REMOTE_ADDR"]);
    debug('   ');
}
