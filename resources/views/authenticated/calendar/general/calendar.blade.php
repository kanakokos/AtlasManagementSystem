@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5 blockquote" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="calendar_content" style="margin-bottom:-17px;">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts" style="margin-top:10px;">
    </div>
  </div>
</div>


<!-- 投稿編集モーダル -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="post">
      @csrf
      <div class="w-100">
        <div class="modal-inner-title w-50 m-auto">
          <p>予約日：<span class="reserve_date"><input type="hidden" name="date" class="reserve_date" value=""></p>
          <p>時間：<span class="reserve_part_text"><input type="hidden" name="part" class="reserve_part" value=""></p>
          <p>上記の予約をキャンセルしてもよろしいですか？</p>
        </div>
        <div class="w-50 m-auto delete-modal-btn d-flex">
          <a class="js-modal-close btn btn-primary d-inline-block" href="">閉じる</a>
          <input type="submit" class="m-auto btn btn-danger d-block" href="/delete/calendar"  value="キャンセル">
          <!-- <input type="hidden" class="delete-modal-hidden" name="date" value="">
          <input type="hidden" class="delete-modal-hidden" name="part" value=""> -->
          <input type="hidden" name="date" class="reserve_date" value="">
          <input type="hidden" name="part" class="reserve_part" value="">
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
