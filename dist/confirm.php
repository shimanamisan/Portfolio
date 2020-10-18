<?php
/****************************************
 共通関数読み込み
*****************************************/
require('Library/function.php');

// head.php 読み込み
require('head.php');


if (empty($_SESSION['transition'])) {
    debug('不正に画面遷移してきました。お問い合わせページへ戻ります。confirm.php ');
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

?>


<div class="l-main">
<section class="p-contents p-contents__contact" id="contact">
        <div class="l-container l-container__contact">
          <h2 class="p-contents__title">Confirm</h2>
          <div class="p-contact p-contact__group__wrapp">
            <form action="./finish.php" method="post">
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お名前</span>
                  
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm">
                    <p class="p-confirm__text"><?php echo getFormData('name');?></p>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">メールアドレス</span>
               
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm">
                      <p class="p-confirm__text"><?php echo getFormData('email');?></p>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">タイトル</span>
              
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm">
                    <p class="p-confirm__text"><?php echo getFormData('subject');?></p>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お問い合わせ内容</span>
                  
                </label>
                <div class="p-contact__form">
                  <div class="p-confirm p-confirm__textarea">
                      <p class="p-confirm__text"><?php echo getFormData('contact');?></p>
                  </div>
                </div>
              </div>
              <button class="c-btn" type="submit" name="send" value="send">
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
      </section>
      <!-- end Contact -->
</div>

<?php

// footer.php 読み込み
require('footer.php');

?>