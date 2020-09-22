// ライブラリを読み込み
const $ = require("jquery");
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
    $("body,html").animate(
      {
        scrollTop: position,
      },
      0
    );
    return false; // aタグの挙動を無効化する
  });

  /****************************************
モーダルの表示
*****************************************/
  let $modalOpen = $(".js-modal-open"); // プロフィール用のモーダル表示ボタン
  let $profileModal = $(".js-profile-modal"); // プロフィール用のモーダル
  let $body = $('body');
  // プロフィール用のモーダル表示処理
  $modalOpen.on("click", function () {
    $profileModal.toggleClass("c-modal--active");
    $body.css({ 'overflow': 'hidden' })
  });
  // モーダル表示時に背景をクリックしてもモーダルを非表示にする
  $profileModal.on("click", function () {
    $profileModal.toggleClass("c-modal--active");
    $body.css({ 'overflow': '' })
  });
});
