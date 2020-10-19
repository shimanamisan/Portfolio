<?php
/****************************************
 共通関数読み込み
*****************************************/
require('Library/function.php');

// head.php 読み込み
require('head.php');

// トップへ戻るのボタンが押された際の処理
if (isset($_POST['top']) && $_POST['top']) {
    header("Location:index.php");
    exit();
}

if (empty($_SESSION['transition'])) {
    debug('不正に画面遷移してきました。お問い合わせページへ戻ります。finish.php ');
    debug('   ');
    header("Location:contact.php");
    exit();
}

// csrf対策
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    debug('トークンが一致していません。お問い合わせページへ戻ります。finish.php ');
    debug('   ');
    $_SESSION = [];
    session_destroy();
    header("Location:contact.php");
}

// セッションのユーザー情報を格納
if ($_SESSION['mode'] === 'contact') {
    /****************************************
 メンバー募集から遷移してきた時の処理
*****************************************/
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $userSubject = $_SESSION['subject'];
    $contact = $_SESSION['contact'];

    $from = 'itsup-info@shimanamisan.com';
    $to = $email;
    $subject = 'お問い合わせ内容を受け付けました。';
    $comment = <<<EOT
{$name}　様
お問い合わせありがとうございます。
以下のお問合せ内容を、メールにて確認させて頂きました。
===================================================
【 お名前 】 
{$name}

【 メールアドレス 】 
{$email}

【 タイトル 】 
{$userSubject}

【 お問い合わせ内容 】 
{$contact}
===================================================
内容を確認の上、回答させて頂きます。
しばらくお待ちください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
　※本メールにご返信いただいてもお答えできませんのでご了承ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Copyright (C) Hisafumi Nishihara All Right Reserved.
EOT;

    /****************************************
     管理者へ通知する内容
    *****************************************/
    $toAdmin = 'itsup-info@shimanamisan.com';
    $subjectAdmin = 'メッセージを受信しました｜MyPortfolio';
    $commentAdmin = <<<EOT
ウェブサイトより下記のお問い合わせが有りました。
===================================================
【 お名前 】 
{$name}

【 メールアドレス 】 
{$email}

【 タイトル 】 
{$userSubject}

【 お問い合わせ内容 】 
{$contact}
===================================================
ユーザーへ返信してください。
EOT;
}

// 問い合わせたユーザーへ送信
sendMail($from, $to, $subject, $comment);

// 管理者へ送信
sendMailAdmin($toAdmin, $subjectAdmin, $commentAdmin);

// セッション変数の中身を空にする
$_SESSION = [];
// セッションを削除
session_destroy();
debug('メールを送信したので、セッションを削除しました。finish.php：'. print_r($_SESSION, true));
debug('   ');

?>


<div class="l-main">
<section class="">
        <div class="l-container l-container__contact">
            <h2 class="p-contents__title p-finish__title">Complete</h2>
            <div class="p-contact p-contact__group__wrapp">
                <p class="p-finish__text">
                    お問い合わせいただきありがとうございました。

                    折り返しご連絡いたしますので、
                    恐れ入りますがしばらくお待ちください。
                </p>
                <p class="p-finish__text">
                自動にトップページへ戻らない場合は、トップページへ戻るボタンをクリックしてください。
                </p>
            </div>
            <form action="">
                <div class="p-finish__btn p-finish__btn__wrapp">
                    <button class="c-btn p-confirm__btn" type="submit" name="top" value="top" id="js-top-redirect">
                        <span class="c-btn__text">トップへ戻る</span>
                    </button>
                </div>
            </form>
        </div>
      </section>
      <!-- end Contact -->
</div>

<?php

// footer.php 読み込み
require('footer.php');

?>