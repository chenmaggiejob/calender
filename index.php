<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="#">
  <title>萬年曆作業</title>
  <style>
    * {
      box-sizing: border-box;
      border-collapse: collapse;
    }

    .container {
      width: 80%;
      /* height: 300px; */
      margin: auto;
      /* background-color: lightcoral; */
      display: flex;
    }

    .contentL {
      width: 30%;
      /* height: 100%; */
      background-color: black;
      display: flex;
      flex-direction: column;
    }

    .contentR {
      width: 70%;
      /* height: 100%; */
      /* background-color: lightgray; */
      display: flex;
      flex-wrap: wrap;
    }

    .weektitle,
    .item {
      width: 14%;
      height: 45px;
      margin: auto;
      display: flex;
      justify-content: center;
      align-items: center;
      border: 1px solid black;
    }

    .ymtitle {
      width: 100%;
      height: 10%;
      background-color: lightblue;
    }

    .nav {
      width: 100%;
      height: 10%;
      /* background-color: lightgoldenrodyellow; */
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: auto;
    }

    .gray.holiday {
      color: gray;
      background-color: lightpink;
    }

    .holiday {
      background-color: lightpink;
    }

    .gray {
      color: gray;
    }
  </style>
</head>

<body>
  <?php
  // 如果_GET有傳值回來，變數month就會等於傳回來的值，否則month就會等於當月
  $month = $_GET['month'] ?? date('m');

  // 如果_GET有傳值回來，變數year就會等於傳回來的值，否則year就會等於當年
  $year = $_GET['year'] ?? date('Y');

  //取得當月1號的日期
  $firstday = date("$year-$month-01");

  //在將當月1號的日期格式轉成時間戳
  $firstday_stemp = strtotime($firstday);

  //找當月份的1號是星期幾(如果date裡面要計算時間，必需要使用時間戳)
  $firstWeekStartDay = date("w", $firstday_stemp);

  //找當月份總共有幾天
  $days = date("t", $firstday_stemp);

  //找到當月最後一天
  $lastday = date("$year-$month-$days");

  //將當月的最後一天轉成時間戳
  $lastday_stemp = strtotime($lastday);

  //先設一個可以儲存每個日期的陣列
  $days = [];

  //月份的最大週數為6週，6*7=42所以i值設定<42
  for ($i = 0; $i < 42; $i++) {
    $diff = $i - $firstWeekStartDay;
    $days[] = date("Y-m-j", strtotime("$diff day", $firstday_stemp));
  }

  /*上個月的月份判斷
  當月份-1<1，是去年的12月，月份為12，年份-1
  如果
  當月份-1<1，是當年的月份+1
  */
  if ($month - 1 < 1) {
    $prev_month = 12;
    $prev_year = $year - 1;
  } else {
    $prev_month = $month - 1;
    $prev_year = $year;
  }

  /* 下個月的月份判斷
  當月份＋1>12，就是來年的月份，月份即為1月，年份+1
  如果
  當月份＋1<12，就是當年的月份+1
  */
  if ($month + 1 > 12) {
    $next_month = 1;
    $next_year = $year + 1;
  } else {
    $next_month = $month + 1;
    $next_year = $year;
  }

  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";

  ?>


  <div class="container">
    <div class="contentL">

      <div class="ymtitle">
        <?= $year; ?>年 <?= $month; ?>月
      </div>

      <div class="nav">
        <a href="?year=<?= $prev_year; ?>&month=<?= $prev_month ?>"> LAST </a>
        <a href="?year=<?= $next_year; ?>&month=<?= $next_month ?>"> NEXT </a>
      </div>

    </div>
    <div class="contentR">
      <?php
      $str = "日 一 二 三 四 五 六";
      $weektitle = explode(" ", $str);
      foreach ($weektitle as $weekstr) {
        echo "<div class='weektitle'> $weekstr </div>";
      }

      foreach ($days as $day) {
        $day_timestamp = strtotime($day); // 將日期轉換為時間戳
        $current_month = date("m", $day_timestamp); // 從時間戳中獲取月份
        $date = explode("-", $day)[2];
        $whatDay = date("w", strtotime($day)); //判斷是否為六日

        // 如果不是當月份的日期，日期則反灰
        if ($current_month != $month) {
          // 如果是六日，文字反灰，背景顏色保留
          if ($whatDay == 0 || $whatDay == 6) {
            echo "<div class='item holiday gray'> $date </div>";
          } else {
            echo "<div class='item gray'> $date </div>";
          } 
          } elseif ($whatDay == 0 || $whatDay == 6) {
            echo "<div class='item holiday'> $date </div>";
          } else {
            echo "<div class='item'> $date </div>";
          }
        }


          



      ?>

    </div>

  </div>

  <?php



  ?>

</body>

</html>