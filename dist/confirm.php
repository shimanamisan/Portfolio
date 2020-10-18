<?php
/****************************************
 共通関数読み込み
*****************************************/
require('Library/function.php');

// head.php 読み込み
require('head.php');

// header.php 読み込み
require('header.php');
?>


<div class="l-main">
<section class="p-contents p-contents__contact" id="contact">
        <div class="l-container l-container__contact">
          <h2 class="p-contents__title">Confirm</h2>
          <div class="p-contact p-contact__group__wrapp">
            <form action="" method="post">
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お名前</span>
                  
                </label>
                <div class="p-contact__form">
                  <input class="c-form js-form-name <?php
                    if (!empty($err_msg['name'])) {
                        echo 'c-error';
                    }
                    ?>" type="text" name="name"  value="<?php echo getFormData('name');?>"/>
                  <div class="c-error__msg">
                  <?php
                    if (!empty($err_msg['name'])) {
                        echo sanitize('お名前は') . $err_msg['name'];
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">メールアドレス</span>
               
                </label>
                <div class="p-contact__form">
                  <input class="c-form <?php
                    if (!empty($err_msg['email'])) {
                        echo 'c-error';
                    }
                    ?>" type="text" name="email" value="<?php echo getFormData('email');?>"/>
                    <div class="c-error__msg">
                    <?php
                      if (!empty($err_msg['email'])) {
                          echo sanitize('メールアドレスは') . $err_msg['email'];
                      }
                      ?>
                    </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">タイトル</span>
              
                </label>
                <div class="p-contact__form">
                  <input class="c-form <?php
                    if (!empty($err_msg['subject'])) {
                        echo 'c-error';
                    }
                    ?>" type="text" name="subject" value="<?php echo getFormData('subject');?>"/>
                    <div class="c-error__msg">
                    <?php
                      if (!empty($err_msg['subject'])) {
                          echo sanitize('タイトルは') . $err_msg['subject'];
                      }
                      ?>
                    </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お問い合わせ内容</span>
                  
                </label>
                <div class="p-contact__form">
                  <textarea class="c-form c-form__textarea <?php
                    if (!empty($err_msg['contact'])) {
                        echo 'c-error';
                    }
                    ?>" type="text" name="contact"><?php echo getFormData('contact');?></textarea>
                  <div class="c-error__msg">
                    <?php
                      if (!empty($err_msg['contact'])) {
                          echo sanitize('お問い合わせ内容は') . $err_msg['contact'];
                      }
                      ?>
                    </div>
                </div>
              </div>
              <button class="c-btn c-btn__back">
                <span class="c-btn__text">戻る</span>
              </button>
              <button class="c-btn">
                <span class="c-btn__text">送信内容を確認する</span>
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