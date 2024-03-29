<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left" style="height:80px;">';
    if($one_part){
      //dd($one_part);

      // $html[] = '<a href="{{ route(calendar.admin.detail,[$date->date,$part->part])}}" class="day_part m-0 pt-1">1部</a><br>';
      $html[] = '<a href="'.route('calendar.admin.detail', ['date'=>$ymd,'part'=>'1']).'" class="day_part">1部 </a><a class="day_part m-0 pt-1">'.$one_part->users->count().'</a><br>';
    }
    if($two_part){
      // $html[] = '<a href="/calendar/{date}/{part}" class="day_part m-0 pt-1">2部</a><br>';
      $html[] = '<a href="'.route('calendar.admin.detail', ['date'=>$ymd,'part'=>'2']).'" class="day_part m-0 pt-1">2部 </a><a class="day_part m-0 pt-1">'.$two_part->users->count().'</a><br>';
    }
    if($three_part){
      // $html[] = '<a href="/calendar/{date}/{part}" class="day_part m-0 pt-1">3部</a><br>';
      $html[] = '<a href="'.route('calendar.admin.detail', ['date'=>$ymd,'part'=>'3']).'" class="day_part m-0 pt-1">3部 </a><a class="day_part m-0 pt-1">'.$three_part->users->count().'</a><br>';
    }
    $html[] = '</p>';

    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
