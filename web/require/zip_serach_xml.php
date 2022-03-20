<?php
/****************************************************************************

郵便番号から住所入力補助を行うスクリプト(XML用) Ver1.00
(C) 郵便番号検索API 松田将志
2006/12/14 Ver1.00公開
WEB:http://zip.cgis.biz/

本スクリプトは fopen() 関数で指定されたURL（郵便番号検索API）と通信し、
情報(XMLデータ)を取得。郵便番号から住所入力補助を行うサンプルスクリプトです。

本ファイルは各種入力フォームとして利用するには不完全です。
改造して利用するか、既存のスクリプト改造の際の参考としてご利用ください。

改造、各種関数の再利用などはご自由に行っていただいて結構です。

*****************************************************************************/

// ■設定
// 本ファイル名
define('THIS_FILE','zip_serach_xml.php');
// 受け取りファイル・出力するページの文字コード
define('STR_CODE','utf-8');
// GET送信先URL(XML取得先URL)
define('REQUEST_URL','http://zip.cgis.biz/xml/zip.php');

// =====================================================================================================

// 各種メッセージ用
$message = '&nbsp;';
// 住所情報格納用
$re_address = array();

if($_POST['search']) {
	// ■検索ボタンがクリックされたとき

	// 入力値チェック
	$err_message = CheckValueZIP($_POST['zip1'],$_POST['zip2']);

	if($err_message == '') {

		// エラーがない場合住所情報取得
		$result = GetAddress($_POST['zip1'],$_POST['zip2']);

		// $result['result']['result_values_count'] は、該当住所数
		if($result['result']['result_values_count']) {

			// ここでは住所情報が複数あった場合、最初の情報を表示することとする

			$result_single = ChangeSingle($result['values']);  // 住所情報を１つにする

			// none は空欄にする
			if($result_single['address_kana'] == 'none') {
				$result_single['address_kana'] = '';
			}
			if($result_single['address'] == 'none') {
				$result_single['address'] = '';
			}
			$message = '住所を入力補助しました';
		}
		else {
			// 住所情報が存在しなかった場合
			$message = '該当する住所がありませんでした';
		}
	}
	else {
		// エラーがある場合
		$message = $err_message;
	}
}
elseif($_POST['send']) {
	// ■送信ボタンがクリックされたとき

	// 実際は内容を記録したりメール送信する？ルーチンをここに記述

	$message = '送信完了';
}


$html .= '<html>'."\n";
$html .= '<head>'."\n";
$html .= '<meta http-equiv="Content-Type" content="text/html; charset='.STR_CODE.'">'."\n";
$html .= '<title>XMLを利用して住所入力補助を行う</title>'."\n";
$html .= '</head>'."\n";
$html .= '<body>'."\n";
$html .= '<p>XMLを利用して住所入力補助を行う</p>'."\n";
$html .= '<p>※郵便番号を入力して検索ボタンをクリックすると、各種住所入力が入力補助されます。</p>'."\n";
$html .= '<p><font color="#ff3333">'.$message.'</font></p>'."\n";
$html .= '<form method="post" action="'.THIS_FILE.'">'."\n";
$html .= '<table border="1">'."\n";
$html .= '<tr>'."\n";
$html .= '<th bgcolor="#ffffcc">郵便番号(3桁+4桁)</th>'."\n";
$html .= '<td>'."\n";
$html .= '〒<input type="text" name="zip1" value="'.$_POST['zip1'].'" size="3">'."\n";
$html .= '-<input type="text" name="zip2" value="'.$_POST['zip2'].'" size="4"> '."\n";
$html .= '<input type="submit" name="search" value="入力補助">'."\n";
$html .= '</td>'."\n";
$html .= '</tr>'."\n";
$html .= '<tr>'."\n";
$html .= '<th bgcolor="#ffffcc">都道府県</th>'."\n";
$html .= '<td><input type="text" name="state" value="'.htmlspecialchars($result_single['state']).'"></td>'."\n";
$html .= '</tr>'."\n";
$html .= '<tr>'."\n";
$html .= '<th bgcolor="#ffffcc">都道府県カナ</th>'."\n";
$html .= '<td><input type="text" name="state_kana" value="'.htmlspecialchars($result_single['state_kana']).'"></td>'."\n";
$html .= '</tr>'."\n";
$html .= '<tr>'."\n";
$html .= '<th bgcolor="#ffffcc">市区町村</th>'."\n";
$html .= '<td><input type="text" name="city" value="'.htmlspecialchars($result_single['city']).'"></td>'."\n";
$html .= '</tr>'."\n";
$html .= '<tr>'."\n";
$html .= '<th bgcolor="#ffffcc">市区町村カナ</th>'."\n";
$html .= '<td><input type="text" name="city_kana" value="'.htmlspecialchars($result_single['city_kana']).'"></td>'."\n";
$html .= '</tr>'."\n";
$html .= '<tr>'."\n";
$html .= '<th bgcolor="#ffffcc">その他住所</th>'."\n";
$html .= '<td><input type="text" name="address" value="'.htmlspecialchars($result_single['address']).'"></td>'."\n";
$html .= '</tr>'."\n";
$html .= '<tr>'."\n";
$html .= '<th bgcolor="#ffffcc">その他住所カナ</th>'."\n";
$html .= '<td><input type="text" name="address_kana" value="'.htmlspecialchars($result_single['address_kana']).'"></td>'."\n";
$html .= '</tr>'."\n";
$html .= '</table>'."\n";
$html .= '<input type="submit" name="send" value="送信">'."\n";
$html .= '</form>'."\n";
$html .= '</body>'."\n";
$html .= '</html>'."\n";

header ("Content-Type: text/html; charset=".STR_CODE);
echo $html;

exit;

// =====================================================================================================

// 郵便番号検索時の入力値をチェックする
function CheckValueZIP($zip1,$zip2,$ver=0) {

	$err = ''; // 入力値に誤りがある場合、メッセージを格納する

	// 連結
	$zip = $zip1.$zip2;

	if($zip == '') {
		$err .= '郵便番号が未入力です。<br>';
	}
	else {

		// ver=0 で現行郵便番号形式のチェック
		// ver=1 で旧郵便番号形式のチェック
		if($ver == 0) {

			if(!preg_match('/^[0-9]{7}$/',$zip)) {
				$err .= '郵便番号の形式に誤りがあります。<br>';
			}
		}
		elseif($ver == 1) {
			if(!preg_match('/^[0-9]{3}$/',$zip) && !preg_match('/^[0-9]{5}$/',$zip)) {
				$err .= '郵便番号の形式に誤りがあります。<br>';
			}
		}
	}

	return $err;

}

// APIと通信してXMLを配列に格納
function GetAddress($zip1,$zip2,$ver=0) {

	// 念のため再度、形式チェック
	if(CheckValueZIP($_POST['zip1'],$_POST['zip2'])) {
		die('zip format Error');
	}

	// アクセスするURL作成
	$url = REQUEST_URL.'?zn='.$zip1.$zip2;
	if($ver == 1) {
		$url .= '&ver=1';
	}
	echo $url;

	// XML処理 // 初めて使うがいまいちわからん...
	$GLOBALS['xml']['ADDRESS_value'] = array();
	$GLOBALS['xml']['values'] = array(); // 住所情報格納用
	$GLOBALS['xml']['result'] = array(); // その他情報格納用
	function startElement($parser, $name, $attrs) {

		// $name  は要素名
		// $attrs は属性名をキーとした連想配列

		if($name == 'ADDRESS_value') {
			$GLOBALS['xml']['ADDRESS_value'][] = $attrs;
		}
		elseif($name == 'value') {
			// ADDRESS_value出現ごとにカウントアップしつつ、住所情報を格納
			// 0 からスタートしたいので -1 する。
			$i = count($GLOBALS['xml']['ADDRESS_value']) - 1;
			foreach($attrs as $key=>$val) {
				$GLOBALS['xml']['values'][$i][$key] = $val;
				break;
			}
		}
		elseif($name == 'result') {
			foreach($attrs as $key=>$val) {
				$GLOBALS['xml']['result'][$key] = $val;
				break;
			}
		}
	}

	function endElement($parser, $name) {
		// なにもしない
	}

	$xml_parser = xml_parser_create();
	xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);
	xml_set_element_handler($xml_parser, "startElement", "endElement");
	if (!($fp = fopen($url,"r"))) {
		die('could not open XML');
	}
	while ($data = fread($fp, 4096)) {

		// 文字コード変換
		$data = mb_convert_encoding($data,STR_CODE,'utf-8');

		if (!xml_parse($xml_parser, $data, feof($fp))) {
			die(sprintf("XML error: %s at line %d",xml_error_string(xml_get_error_code($xml_parser)),xml_get_current_line_number($xml_parser)));
		}

	}
	xml_parser_free($xml_parser);

	$result = $GLOBALS['xml'];
	unset($GLOBALS['xml']);

	// result_code 正常=>1 異常=>0
	if($result['result']['result_code'] == 0) {
		die('Application Error: code '.$result['result']['error_code'].' / message '.$result['result']['error_note']);
	}

	return $result;
}

// 住所データを１つにする
function ChangeSingle($result_values) {
	if(count($result_values)) {
		foreach($result_values as $value) {
			$result_values_single = $value;
			break;
		}
		return $result_values_single;
	}
	else {
		return false;
	}
}

?>
