<?php
/****************************************
 共通関数読み込み
*****************************************/
require 'Library/function.php';

// head.php 読み込み
require 'head.php';

// header.php 読み込み
require 'header.php';

// IPアドレスを取得
getIP();

// ページ宣言
$mode = 'contact';

if (isset($_SESSION['mode']) && $_SESSION['mode'] !== $mode) {
    $_SESSION = []; // セッションをする前に空にする
  session_destroy(); // この時点ではセッションは削除されない
  debug(' contact.php' . print_r($_SESSION, true));
    debug('   ');
}

// POST送信されていた場合
if (!empty($_POST)) {
    debug('POST送信されている処理です。');
    debug('   ');

    // POST時の値をフォームに表示させるので、確認画面から戻ってきた場合に
    // SESSIONの値を表示させているものをクリアする
    clearSession('name');
    clearSession('email');
    clearSession('subject');
    clearSession('contact');

    // 変数にフォームの値を格納
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $contact = $_POST['contact'];

    // 入力必須
    validRequire($name, 'name');
    validRequire($email, 'email');
    validRequire($subject, 'subject');
    validRequire($contact, 'contact');

    // バリデーションエラーが無い場合
    if (empty($err_msg)) {
        debug('未入力バリデーションが通った時の処理です。');
        debug('   ');

        // Email形式チェック
        validEmail($email, 'email');
        // 名前が全角かチェック
        validNameText($name, 'name');

        // 各フォーム文字数チェック
        validMaxLen($name, 'name', 50);
        validMaxLen($email, 'email');
        validMaxLen($subject, 'subject', 50);
        validContactMaxLen($contact, 'contact');

        if (empty($err_msg)) {
            debug('バリデーションOKの時の処理です。');
            debug('   ');

            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['subject'] = $subject;
            $_SESSION['contact'] = $contact;
            $_SESSION['transition'] = true;
            $_SESSION['mode'] = $mode;

            header("Location:confirm.php");
            exit();
        }
    }
}
?>

    <div class="l-main">
      <div class="c-load js-loading">
        <div class="c-load__icon">Loading...</div>
      </div>
      <section class="p-eyecatch">
        <div class="p-eyecatch__title__wrapp" id="particles-js">
          <h1 class="p-eyecatch__title animate__fadeOutDown">Welcome To MyPortfolio</h1>
        </div>
      </section>
      <section class="p-contents p-contents__about" id="about">
        <div class="l-container">
          <h2 class="p-contents__title u-js-fadeIn">About Me</h2>
          <div class="p-about__img u-js-fadeIn">
            <div class="p-about__img__inner">
              <img class="p-about__img__profile" src="./img/img_01.png" alt="プロフィール画像" />
            </div>
          </div>
          <div class="p-about__profile u-js-fadeIn">
            <p class="p-about__name">Hisafumi Nishihara</p>
            <p class="p-about__text">1987年9月10日生まれ、愛媛県出身、兵庫県在住。</p>
            <p class="p-about__text">
              現職でVBAを使用した業務改善ツールや、ホームページ制作依頼を受けたことをきっかけにプログラミングに興味を持ちました。
            </p>
            <p class="p-about__text">
              独学、オンラインプログラミングスクールにて、HTML、CSS、JavaScript、PHP言語を学び、その他開発ツールやフレームワークを用いてWebサービスの開発を行いました。現在も継続的に学習しています。
            </p>
          </div>
          <!-- <button class="c-btn js-modal-open">
            <span class="c-btn__text">Profile Detail</span>
          </button> -->
        </div>

        <?php
        // 切り出しファイルを読み込み
        require 'profile_modal.php'; ?>

      </section>

    <?php
    // 切り出したパーツを読み込む
    require 'work.php';

    // 作品紹介用のモーダル
    require 'work_modal.php';
    ?>

      <!-- Skill -->
      <section class="p-contents p-contents__skill" id="skill">
        <div class="l-container l-container__skill">
          <h2 class="p-contents__title">Skill</h2>
          <div class="p-skill__wrapp">
            <div class="p-skill__card u-js-fadeIn">
              <div class="p-skill__card__inner">
                <p class="p-skill__title">コーディング</p>
                <!-- html -->
                <div class="p-skill__card__detail">
                  <img src="./img/html_logo.svg" alt="htmlロゴ" />
                  <p>HTML5</p>
                </div>
                <!-- end html -->
                <!-- css -->
                <div class="p-skill__card__detail">
                  <img src="./img/css_logo.svg" alt="cssロゴ" />
                  <p>CSS</p>
                </div>
                <!-- end sass -->
                <!-- sass -->
                <div class="p-skill__card__detail">
                  <img src="./img/sass_logo.svg" alt="sassロゴ" />
                  <p>SASS</p>
                </div>
                <!-- end sass -->
                <div class="p-skill__text__inner">
                  <p class="p-skill__text">Adobe XD等のデザインデータからコーディングを行うことが出来ます。</p>
                  <p class="p-skill__text">また、レスポンシブデザインやも実装することが出来ます。CSS設計は主にFLOCSSを使用しています。</p>
                </div>
              </div>
            </div>
            <div class="p-skill__card u-js-fadeIn">
              <div class="p-skill__card__inner">
                <p class="p-skill__title">フロントエンド</p>
                <!-- javascript -->
                <div class="p-skill__card__detail">
                  <img src="./img/javascript_logo.svg" alt="javascriptロゴ" />
                  <p>JavaScript</p>
                </div>
                <!-- end javascript -->
                <!-- jquery -->
                <div class="p-skill__card__detail">
                  <img src="./img/jquery_logo.svg" alt="jqueryロゴ" />
                  <p>jquery</p>
                </div>
                <!-- end jquery -->
                <!-- vue -->
                <div class="p-skill__card__detail">
                  <img src="./img/vue_logo.svg" alt="vue.jsロゴ" />
                  <p>Vue.js</p>
                </div>
                <!-- end jquery -->
                <!-- react -->
                <!-- <div class="p-skill__card__detail">
                  <img src="./img/react_logo.svg" alt="react.jsロゴ" />
                  <p>React.js</p>
                </div> -->
                <!-- end react -->
                <div class="p-skill__text__inner">
                  <p class="p-skill__text">
                    JavaScriptでは基本的な言語仕様を学び、JavaScriptやjQueryでTODOリストを作成することで、DOM操作及びCRUD処理の基本を習得しました。
                  </p>
                  <p class="p-skill__text">また、ステップアップを目指してJavaScriptフレームワークを学習しています。</p>
                </div>
              </div>
            </div>
            <div class="p-skill__card u-js-fadeIn">
              <div class="p-skill__card__inner">
                <p class="p-skill__title">バックエンド</p>
                <!-- php -->
                <div class="p-skill__card__detail">
                  <img src="./img/php_logo.svg" alt="phpロゴ" />
                  <p>php</p>
                </div>
                <!-- end php -->
                <!-- mysql -->
                <div class="p-skill__card__detail">
                  <img src="./img/mysql_logo.svg" alt="mysqlロゴ" />
                  <p>MySQL</p>
                </div>
                <!-- end mysql -->
                <!-- laravel -->
                <div class="p-skill__card__detail">
                  <img src="./img/laravel_logo.svg" alt="laravelロゴ" />
                  <p>laravel</p>
                </div>
                <!-- end laravel -->
                <div class="p-skill__text__inner">
                  <p class="p-skill__text">
                    フレームワークを使用せず、フルスクラッチでWebサービスの開発の練習を行うことで、基礎的な知識を養ってきました。
                  </p>
                  <p class="p-skill__text">その後、より実践を意識してフレームワークを使用したWebサービスの開発を行いました。</p>
                </div>
              </div>
            </div>
            <div class="p-skill__card u-js-fadeIn">
              <div class="p-skill__card__inner">
                <p class="p-skill__title">インフラ</p>
                <!-- apache -->
                <div class="p-skill__card__detail">
                  <img src="./img/apache_logo.svg" alt="apacheロゴ" />
                  <p>apache</p>
                </div>
                <!-- end apache -->
                <!-- aws -->
                <div class="p-skill__card__detail">
                  <img src="./img/aws_logo.svg" alt="awsロゴ" />
                  <p>AWS</p>
                </div>
                <!-- end aws -->
                <p class="p-skill__text">
                  ローカル環境でサービスを開発して終わるのではなく、より実践を意識してレンタルサーバやクラウドコンピューティングサービスにデプロイして運用しています。
                </p>
              </div>
            </div>
            <div class="p-skill__card u-js-fadeIn">
              <div class="p-skill__card__inner">
                <p class="p-skill__title">開発ツール</p>
                <!-- webpack -->
                <div class="p-skill__card__detail">
                  <img src="./img/webpack_logo.svg" alt="webpackロゴ" />
                  <p>Webpack</p>
                </div>
                <!-- end webpack -->
                <!-- Gulp -->
                <div class="p-skill__card__detail">
                  <img src="./img/gulp_logo.svg" alt="Gulpロゴ" />
                  <p>Gulp</p>
                </div>
                <!-- end Gulp -->
                <!-- Git -->
                <div class="p-skill__card__detail">
                  <img src="./img/git_logo.svg" alt="Gitロゴ" />
                  <p>Git</p>
                </div>
                <!-- end Git -->
                <p class="p-skill__text">効率よく開発が行えるように、各種ツールを使って開発を行っています。</p>
                <p class="p-skill__text">
                  アウトプット時のGitを使ったソースコード管理ではチーム開発を意識して、Issueを立て、Branchを切ってPull
                  Requestまで行うようにしてきました。
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- end Skill -->
      <!-- Contact -->
      <section class="p-contents p-contents__contact" id="contact">
        <div class="l-container l-container__contact">
          <h2 class="p-contents__title">Contact</h2>
          <div class="p-contact p-contact__group__wrapp">
            <form action="" method="post">
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お名前</span>
                  <span class="p-contact__form__icon p-contact__form__icon--require">必須</span>
                </label>
                <div class="p-contact__form">
                  <input class="c-form js-form-name <?php if (
                    !empty($err_msg['name'])
                  ) {
        echo 'c-error';
    } ?>" type="text" name="name"  value="<?php echo getFormData(
        'name'
    ); ?>"/>
                  <div class="c-error__msg">
                  <?php if (!empty($err_msg['name'])) {
        echo sanitize('お名前は') . $err_msg['name'];
    } ?>
                  </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">メールアドレス</span>
                  <span class="p-contact__form__icon p-contact__form__icon--require">必須</span>
                </label>
                <div class="p-contact__form">
                  <input class="c-form <?php if (!empty($err_msg['email'])) {
        echo 'c-error';
    } ?>" type="text" name="email" value="<?php echo getFormData(
        'email'
    ); ?>"/>
                    <div class="c-error__msg">
                    <?php if (!empty($err_msg['email'])) {
        echo sanitize('メールアドレスは') . $err_msg['email'];
    } ?>
                    </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">タイトル</span>
                  <span class="p-contact__form__icon p-contact__form__icon--require">必須</span>
                </label>
                <div class="p-contact__form">
                  <input class="c-form <?php if (!empty($err_msg['subject'])) {
        echo 'c-error';
    } ?>" type="text" name="subject" value="<?php echo getFormData(
        'subject'
    ); ?>"/>
                    <div class="c-error__msg">
                    <?php if (!empty($err_msg['subject'])) {
    echo sanitize('タイトルは') . $err_msg['subject'];
} ?>
                    </div>
                </div>
              </div>
              <div class="p-contact__form__wrapp">
                <label class="p-contact__form__title" for="">
                  <span class="p-contact__form__text">お問い合わせ内容</span>
                  <span class="p-contact__form__icon p-contact__form__icon--require">必須</span>
                </label>
                <div class="p-contact__form">
                  <textarea class="c-form c-form__textarea <?php if (
                    !empty($err_msg['contact'])
                  ) {
    echo 'c-error';
} ?>" type="text" name="contact"><?php echo getFormData(
    'contact'
); ?></textarea>
                  <div class="c-error__msg">
                    <?php if (!empty($err_msg['contact'])) {
    echo sanitize('お問い合わせ内容は') . $err_msg['contact'];
} ?>
                    </div>
                </div>
              </div>
              <button class="c-btn">
                <span class="c-btn__text">送信内容を確認する</span>
              </button>
            </form>
          </div>
        </div>
      </section>
      <!-- end Contact -->
    </div>

<?php // footer.php 読み込み
require 'footer.php';
?>
