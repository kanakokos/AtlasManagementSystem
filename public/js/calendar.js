$(function () {

  $('.delete-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    // 押されたボタンから投稿内容を取得し変数へ格納
    var reservePart = $(this).attr('reserve_part');
    var reserveDate = $(this).attr('reserve_date');
    // var recipient = button.data('reserve');

    // 取得した投稿内容をモーダルの中身へ渡す
    $('.reserve_part').val(reservePart);
    $('.reserve_date').val(reserveDate);

    if (reservePart == 1) {
      $('.reserve_part_text').text('リモ１部');
    } else if (reservePart == 2) {
      $('.reserve_part_text').text('リモ２部');
    } else if (reservePart == 3) {
      $('.reserve_part_text').text('リモ３部');
    }
    $('.reserve_date').text(reserveDate);
    return false;
  });

  // 背景部分や閉じるボタン(js-modal-close)が押されたら発火
  $('.js-modal-close').on('click', function () {
    // モーダルの中身(class="js-modal")を非表示
    $('.js-modal').fadeOut();
    return false;
  });
});
