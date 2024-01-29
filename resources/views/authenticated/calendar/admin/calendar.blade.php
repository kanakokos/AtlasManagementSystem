@extends('layouts.sidebar')
<!-- スクール予約確認画面 -->
@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5 blockquote" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="calendar_content">
        {!! $calendar->render() !!}
      </div>
    </div>
  </div>
</div>
@endsection
