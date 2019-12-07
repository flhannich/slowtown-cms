<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
  public function readingTime($words) {
    $t = round($words / 200);
    if($t == 0) {
      $result = 'less than a minute';
    }
    else {
      $result = $t . ' min read';
    }
    return $result;
  }


  public function printDate($date) {
    if(date('Y') != substr($date, 0,-15)) {
      echo substr($date, 8,-9) . '. ' . substr($date, 5,-12) . '. ' . substr($date, 0,-15);
    } else {
      echo substr($date, 8,-9) . '. ' . substr($date, 5,-12);
    }
  }

  public function printDateTime($date) {
    if(date('Y') != substr($date, 0,-15)) {
      echo substr($date, 8,-9) . '. ' . substr($date, 5,-12) . '. ' . substr($date, 0,-15) . ' ' . substr($date, 0,-9);
    } else {
      echo substr($date, 8,-9) . '.' . substr($date, 5,-12) . ' ' . substr($date, 11,-3);
    }
  }

  public function elapsedTime($value) {
    $time = strtotime($value);
    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1)? 1 : $time;
    $tokens = array (
      31536000 => 'year',
      2592000 => 'month',
      604800 => 'week',
      86400 => 'day',
      3600 => 'hour',
      60 => 'min',
      1 => 'sec'
    );
    foreach ($tokens as $unit => $text) {
      if ($time < $unit) continue;
      $numberOfUnits = floor($time / $unit);
      if($time < 86400)  {
        return $numberOfUnits.' '.$text.(($numberOfUnits > 1)?'s':'') . ' ago';
      }
      else {
        return printDate($value);
      }
    }
  }
}
