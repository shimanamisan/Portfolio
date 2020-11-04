// ライブラリを読み込み
import $ from "jquery";
import "particles.js/particles";
const particlesJS = window.particlesJS;

particlesJS.load("particles-js", "../particles.json", function () {
  console.log("callback - particles.js config loaded");
});


$(function () {
  
  // Cookie読み出し用の関数
  function getCookie(key) {
    // Cookieから値を取得する
    let cookieString = document.cookie;
    // 要素ごとに ; で区切られているので、 ; で切り出しを行う。新しく配列として生成
    // ここでは前後にスペースが入っている
    let cookieKeyArray = cookieString.split(";");
  
    // 要素分ループを行う
    for (let i = 0; i < cookieKeyArray.length; i++) {
      let targetCookie = cookieKeyArray[i];
  
      // 前後のスペースをカットする
      targetCookie = targetCookie.replace(/^\s+|\s+$/g, "");
  
      // indexOf("=") とすると、= という文字が何番目にあるのか、というのが返ってくる
      let valuIndex = targetCookie.indexOf("=");
      console.log(valuIndex);
  
      if (targetCookie.substring(0, valuIndex) == key) {
        // キーが引数と一致した場合値を返す
        console.log(valuIndex); // 4
        console.log(targetCookie.substring(0, valuIndex)); // name
        console.log(typeof targetCookie);
        console.log("targetCookieのif文でtrueの判定です " + targetCookie);
        return decodeURIComponent(targetCookie.slice(valuIndex + 1));
      }
    }
  
    // 一致するものがなければ空文字を返す
    return "";
  }
  
  console.log("getCookie関数：" + getCookie("name"));
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
ローデイングアニメーション（初回のみ表示）
*****************************************/
  let $jsLoading = $(".js-loading");
  // ローディングアイコンの表示の制御にcookieを使用
  if(getCookie("name") === ""){
    // スタイリングで opacity: 0; にしているのでローディングアイコンを表示させる
    $jsLoading.css("opacity","1")
    $(window).on("load", function(){
      console.log("load!!")
      $jsLoading.fadeOut('slow');
    })

    // Cookieに初回アクセス時か判定する値を記述する
    // 2回目以降のアクセスの際は、この値がcookieにセットされているのでローディングアイコンは非表示になる
    document.cookie = "name=" + encodeURIComponent("first_access");
    
  } else {
    // 2回目以降のアクセスではローディングアイコンは表示させない
    $jsLoading.css("display", "none");
    console.log("2回目以降のアクセスです")
  }

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
フッターの固定
*****************************************/
  var $ftr = $("#footer");
  if (window.innerHeight > $ftr.offset().top + $ftr.outerHeight()) {
    $ftr.attr({
      style: "position:fixed; top:" + (window.innerHeight - $ftr.outerHeight()) + "px; width: 100%;",
    });
  }

  /****************************************
 スクロールアニメーション
*****************************************/
  $(window).on("scroll", function () {
    console.log("scroll!!");
    $(".u-js-fadeIn").each(function () {
      let position = $(this).offset().top, // 指定した要素のY座標を取得
        scroll = $(window).scrollTop(), // スクロール位置を取得
        windowHeight = $(window).height(); // ウィンドウの高さを取得

      // 要素が画面中央に来た時に発火
      if (scroll > position - windowHeight + 200) {
        console.log("scroll :" + scroll);
        console.log("position :" + position);
        console.log("windowHeight :" + windowHeight);
        $(this).addClass("u-js-fadeIn--active");
      }
    });
  });
  //  $(window).scroll(function(){
  //   $('.js-fadeIn').each(function(){
  //     var elemPos = $(this).offset().top,
  //         scroll = $(window).scrollTop(),
  //         windowHeight = $(window).height();
  //     if(scroll > elemPos -windowHeight + 200){
  //       $(this).addClass('fadeIn');
  //     }
  //   });

  // });

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
  let $modalBg = $(".js-modal__bg"),
    $workModalOpen = $(".js-modal__open"),
    $closeIcon = $(".js-close-icon");

  $workModalOpen.on("click", function () {
    let target = $(this).data("modal-link");
    console.log("クリックした要素 " + target);
    let showModal = document.querySelector("." + target);
    console.log(showModal);
    $(showModal).toggleClass("c-modal--active");
    $body.css({ overflow: "hidden" });
  });

  $modalBg.on("click", function () {
    // モーダル背景要素の親要素を取得して、モーダルの表示用クラスを切り替えている
    $(this).parents(".c-modal").toggleClass("c-modal--active");
    $body.css({ overflow: "" });
  });
  $closeIcon.on("click", function () {
    // モーダル背景要素の親要素を取得して、モーダルの表示用クラスを切り替えている
    $(this).parents(".c-modal").toggleClass("c-modal--active");
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
  let contact_position = 0;
  let contact = $("#contact");
  if ($(".c-error").length) {
    console.log("バリデーションエラーが発生しています。");
    console.log("contact要素のトップからの位置 " + contact.offset().top);
    contact_position = contact.get(0).offsetTop;
    $("body,html").animate(
      {
        scrollTop: contact_position,
      },
      0
    );
    console.log("contact_positionの値 " + contact_position);
  }

  /***********************************************
メール送信後、トップページへリダイレクトさせる処理
*************************************************/
  let element = document.querySelectorAll("#js-top-redirect");
  // console.log(element.length);
  if (element.length !== 0) {
    setTimeout(function () {
      window.location.href = "/";
    }, 3000);
  }
});
