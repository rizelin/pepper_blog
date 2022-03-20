<?php
require_once("../require/mysql.php");

//email送信
$subject = "［Pepperアトリエサテライト甲府］体験授業の申し込み完了のお知らせ";
$body = "Pepperアトリエサテライト甲府の体験授業の申し込みいただきありがとうございます。
\n下記のとおり受付いたしました。\n\n";
$endOfBody = "\n\n※申し込み内容の確認・変更・取り消しは、下記お問い合わせ先へお電話にてご連絡ください。
\n＜お問い合わせ先＞\n株式会社ワールドブレインズ　園原\n電話番号：053-244-0022
\n\n※本メールは配信専用のため、返信メールには回答できませんのでご承知おきください。\nPepperアトリエサテライト甲府";


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $to = $email['email'];
    $sendInfo = array(
                      'title' => '体験授業',
                      'address' => '開催地',
                      'start_time' => '開始時間',
                      'end_time' => '終了時間',
                      'entry_fee' => '参加費',
                      'limit_count' => '定員',
                      'company' => '御社',
                      'name' => 'お名前',
                      'reservation_count' => '参加予約人数'
                      );
    $addExplain = array('title','address','start_time','end_time','entry_fee','limit_count','reservation_count');

//email内容
    foreach ($sendInfo as $key => $value) {
        if (in_array($key,$addExplain)) {
            if ($key == 'start_time') {
                    $middleOfBody[$key] = "$value : $email[$key] ~ ";
            }elseif ($key == 'end_time') {
                    $middleOfBody[$key] = "$email[$key]\n";
            }elseif ($key == 'limit_count' || $key == 'reservation_count') {
                    $middleOfBody[$key] = "$value : $email[$key]名\n";
            }else {
                    $middleOfBody[$key] = "$value : $email[$key]\n";
            }
        }else {
              $middleOfBody[$key] = "$email[$key]";
        }
    }

    $middleOfBody['start_time'] .= $middleOfBody['end_time'];
    $middleOfBody['name'] .= "様の";
    unset($middleOfBody['end_time']);
    $body .= implode("",$middleOfBody).$endOfBody;
  //  $to = "wb.eunhye18@gmail.com";

    mailSend($to,$subject,$body);
}

function mailSend($to,$subject,$body){
    $errorFlg = false;
    if(isset($to,$subject,$body)){
        $from = "sonohara@wb.to";
        $bcc = array($from);
      //内部エンコーディング設定
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
      //送信者のアドレスを設定
        $from = mb_encode_mimeheader($from,"UTF-8","iso-2022-jp");
        $header = "From: {$from} \n";
      //BCCの値があればセットする
        $header .= is_null($bcc) ? "" : "Bcc: ".implode(',',$bcc)." \n";
      //メールの文字コードの記述
        $header .= "Content-Type: text/plain; charset=iso-2022-jp \n";
        $header .= "Content-Transfer-Encoding: 8bit \n";
      //送信後にエラーが発生した場合のエラー通知先メールアドレス
        $fParam = "-f {$from}";
        $errorFlg = mb_send_mail($to,$subject,$body,$header,$fParam);
    }
    if ($errorFlg) {
        $_SESSION['emailConfirmMsg'] ="確認用メールをお送りました。";
    }else {
        header("location:../index.php");
        exit();
    }
}

require_once("inquiryConfirmMessage.tpl.php");
?>
