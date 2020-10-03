// ライブラリを読み込み
import $ from "jquery";
import "particles.js/particles";
const particlesJS = window.particlesJS;

particlesJS.load("particles-js", "../particles.json", function () {
  console.log("callback - particles.js config loaded");
});

$(function () {
  let $menu = $(".js-menu");
  let $nav_bg = $(".js-nav-background");
  let $nav = $(".js-nav");

  /****************************************
ハンバーガーメニューの開閉
*****************************************/
  $menu.on("click", function () {
    // アロー関数だとthisが束縛されないので注意
    $nav_bg.toggleClass("p-header__nav__background--active");
    $(this).toggleClass("burger--active"); // アロー関数にしていると、ここのthisがdocumentオブジェクトが指定される
    $nav.toggleClass("p-header__nav--active");
  });

  /****************************************
リンク内のスムーズスクロール
*****************************************/
  // #で始まる要素をクリックした場合に処理を実行
  $('a[href^="#"]').on("click", function () {
    // 表示されているメニューを非表示にする
    $nav_bg.toggleClass("p-header__nav__background--active");
    $menu.toggleClass("burger--active"); // アロー関数にしていると、ここのthisがdocumentオブジェクトが指定される
    $nav.toggleClass("p-header__nav--active");
    let href = $(this).attr("href"),
      target = $(href == "#" || href == "" ? "html" : href),
      position = target.offset().top;
    console.log("href変数の中 " + href);
    console.log("target変数の中 " + JSON.stringify(target));
    console.log("position変数の中 " + position);
    $("body,html").animate(
      {
        scrollTop: position,
      },
      0
    );
    return false; // aタグの挙動を無効化する
  });

  /****************************************
プロフィール詳細用モーダルの表示
*****************************************/
  let $modalOpen = $(".js-modal-open"); // プロフィール用のモーダル表示ボタン
  let $profileModal = $(".js-profile-modal"); // プロフィール用のモーダル
  let $body = $("body");
  // プロフィール用のモーダル表示処理
  $modalOpen.on("click", function () {
    $profileModal.toggleClass("c-modal--active");
    $body.css({ overflow: "hidden" });
  });
  // モーダル表示時に背景をクリックしてもモーダルを非表示にする
  $profileModal.on("click", function () {
    $profileModal.toggleClass("c-modal--active");
    $body.css({ overflow: "" });
  });

  /****************************************
作品紹介詳細用のモーダルの表示
*****************************************/
  let $container = $(".js-modal__container"),
    $modalBg = $(".js-modal__bg"),
    $crypt = $(".js-crypt-modal__open"),
    $taskApp = $(".js-taskApp-modal__open"),
    $lineup = $(".js-lineup-modal__open");

  const domArray = [$crypt, $taskApp, $lineup];


  domArray.forEach((element) => {
    element.on("click", function () {
      $modalBg.toggleClass("c-modal--active");
      $container.toggleClass("c-modal--active");
      $body.css({ overflow: "hidden" });
     
    });
  });

  $modalBg.on("click", function () {
    $modalBg.toggleClass("c-modal--active");
    $container.toggleClass("c-modal--active");
    $body.css({ overflow: "" });
  
  });

  /****************************************
お問い合わせフォームのバリデーション
*****************************************/
  let $jsFormName = $(".js-form-name");
  let val = "";
  $jsFormName.on({
    blur: function () {
      console.log(val);

      if (val === "") {
        $(this).text("入力必須です。");
      }
    },
    focus: function () {},
  });

  /****************************************
バリデーションの際に指定の要素までスクロール
*****************************************/
  let contact = $("#contact");
  if ($(".c-error").length) {
    console.log("バリデーションエラーが発生しています。");
    console.log("contact要素のトップからの位置 " + contact.offset().top);
    let contact_position = contact.offset().top;
    $("body,html").animate(
      {
        scrollTop: contact_position,
      },
      0
    );
    console.log("contact_positionの値 " + contact_position);
    contact_position = 0; // 移動後に値を初期化
  }
});
