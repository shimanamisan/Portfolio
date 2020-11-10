<?php
/****************************************
 共通関数読み込み
*****************************************/
require 'Library/function.php';

// head.php 読み込み
require 'head.php';

if (empty($_SESSION['transition'])) {
  debug(
    '不正に画面遷移してきました。お問い合わせページへ戻ります。confirm.php '
  );
  debug('   ');
  header("Location:index.php");
  exit();
}

debug('POSTの中身を確認しています。confirm.php：' . print_r($_POST, true));
debug('   ');

if (isset($_POST['back']) && $_POST['back']) {
  debug('前のページへ戻る処理です。confirm.php ');
  debug('   ');
  switch (true) {
    case $_SESSION['mode'] === 'contact':
      debug('お問い合わせページへ戻ります。confirm.php ');
      debug('   ');
      unset($_SESSION['csrf_token']);
      header("Location:index.php");
      exit();
      break;
    default:
      debug('エラーが発生しました。トップページへ戻ります。confirm.php ');
      debug('   ');
      unset($_SESSION['csrf_token']);
      header("Location:index.php");
      exit();
  }
}

// セッションに値が入っていたら処理を行う
if (isset($_SESSION)) {
  debug(
    'お問いわせ内容がSESSIONに格納されています。confirm.php ' .
      print_r($_SESSION, true)
  );
  debug('   ');

  if ($_SESSION['mode'] === 'contact') {
    // セッションの値を配列に格納
    $confirm_content = [
      'お名前' => $_SESSION['name'],
      'メールアドレス' => $_SESSION['email'],
      'タイトル' => $_SESSION['subject'],
      'お問い合わせ内容' => $_SESSION['contact'],
    ];
  }

  // トークンがSESSIONにセットされていなければセットする
  if (!isset($_SESSION['csrf_token'])) {
    // CSRF対策用のトークン
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }

  // isset($_POST['send'])で'send'というキーが存在しているかを判定し、存在していれば$_POST['send']の値をチェックする
  // $_POST['send']だけだと、POST送信した際にキーが存在していなかった場合にNoticeエラーになる
  if (isset($_POST['send']) && $_POST['send']) {
    debug(
      'isset($_POST[send]) の判定を見ています。confirm.php ' .
        isset($_POST['send'])
    );
    debug('   ');
    debug(
      'メールを送信する処理です。次の画面へ遷移します。confirm.php ' .
        print_r($_POST, true)
    );
    debug('   ');
    header("Location:finish.php");
    exit();
  }
} else {
  debug('セッションが空だったので前のページへ戻ります。。confirm.php ');
  debug('   ');
  header("Location:contact.php");
  exit();
}
?>


<div class="l-main">
<section class="p-contents p-contents__contact" id="contact">
        <div class="l-container l-container__contact">
          <h2 class="p-contents__title">Confirm</h2>
          <div class="p-contact p-contact__group__wrapp">
            <form method="post" action="./finish.php">
            <input type="hidden" name="csrf_token" value="<?php echo sanitize(
              $_SESSION['csrf_token']
            ); ?>">
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お名前</span>
                  
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm">
                    <p class="p-confirm__text"><?php echo getFormData(
                      'name'
                    ); ?></p>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">メールアドレス</span>
               
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm">
                      <p class="p-confirm__text"><?php echo getFormData(
                        'email'
                      ); ?></p>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">タイトル</span>
              
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm">
                    <p class="p-confirm__text"><?php echo getFormData(
                      'subject'
                    ); ?></p>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お問い合わせ内容</span>
                  
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm p-confirm__textarea">
                      <p class="p-confirm__text"><?php echo getFormData(
                        'contact'
                      ); ?></p>
                  </div>
                </div>
              </div>
                <div class="c-btn__wrapp">
                  <button class="c-btn p-confirm__btn" type="submit" name="send" value="send">
                    <span class="c-btn__text">送信する</span>
                  </button>
                  </form>
                  <form method="post" action="">
                      <button class="c-btn c-btn__back" type="submit" name="back" value="back">
                        <span class="c-btn__text">戻る</span>
                      </button>
                  </form>
                </div>
          </div>
        </div>
      </section>
      <!-- end Contact -->
</div>

<?php
// footer.php 読み込み
// footer.php 読み込み
?>require 'footer.php';

?>
