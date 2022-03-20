//maps
window.onload = function(){
  var latitude = 35.63153923;
  var longitude = 138.56992493;
   var ymap = new Y.Map($("#map"),{
                               "configure":{
                                      "scrollWheelZoom": true
                                      ,"doubleClickZoom" : true
                                      ,"singleClickPan" : true
                              }
   });
   var label = new Y.Label(new Y.LatLng(latitude,longitude), "Pepperアトリエサテライト甲府");
   var marker = new Y.Marker(new Y.LatLng(latitude, longitude),{icon:new Y.Icon('/common/img/mapsPin.png')});
   //コントロールの追加
   ymap.addControl(new Y.SliderZoomControlVertical());
   ymap.drawMap(new Y.LatLng(latitude, longitude), 17, Y.LayerSetId.NORMAL);
   ymap.addFeature(marker);
   ymap.addFeature(label);
}

//manager
function detailInfo(id){
    $("#detali_btn"+id).css('display','none');
    $("#close_btn"+id).fadeIn();
    $("#close_btn"+id).show();
    $("#detail"+id).fadeIn('fast');
    $("#detail"+id).show();
}

function closeInfo(id){
    $("#close_btn"+id).css('display','none');
    $("#detali_btn"+id).fadeIn();
    $("#detali_btn"+id).show();
    $("#detail"+id).fadeOut('fast');
}

function confirm(id){
  $.ajax({
         type: 'POST',
         url: './checkConfirm.php',
         data: {confirm:id},
         success: function(result) {
            $('.checked'+id).html(result);
        },
         error: function () {
            $('.checked'+id).html("確定処理失敗");
        }
  });
}

function cancel(id){
  $.ajax({
         type: 'POST',
         url: "./checkConfirm.php",
         data: {cancel:id},
         success: function(result) {
            $('.checked'+id).html(result);
        },
         error: function () {
            $('.checked'+id).html("キャンセル処理失敗");
        }
  });
}

//SNS 共有
var url = 'https://eunhye.wj.am/blog/blog.php?id=';

function facebook(num){
  window.open('https://www.facebook.com/sharer/sharer.php?u='+url+num,'testWindow','width=300px, heigh=150px', '_blank');
}
function twitter(num){
  window.open('https://twitter.com/share?url='+url+num,'twitter','width=300px, heigh=150px', '_blank');

}function line(num){
  window.open('http://line.me/R/msg/text/','testWindow','width=300px, heigh=150px', '_blank');
}

//郵便番号で住所検索
var selected = 0;
$(function () {
    //検索ボタンをクリックされたときに実行
    $("#search_btn").click(function () {
        //入力値をセット
        var param = {zipcode: $('#zipcode').val()}
        //zipcloudのAPIのURL
        var send_url = "http://zipcloud.ibsnet.co.jp/api/search";
        $.ajax({
            type: "GET",
            cache: false,
            data: param,
            url: send_url,
            dataType: "jsonp",
            success: function (res) {
                //結果によって処理を振り分ける
                if (res.status == 200) {
                    //処理が成功したとき
                    //該当する住所を表示
                    var html = '';
                    $("#prefectures"+selected).prop('selected','false');
                    for (var i = 0; i < res.results.length; i++) {
                        var result = res.results[i];
                        $("#prefectures"+result.prefcode).prop('selected','true');
                        $("#address1").val(result.address2+result.address3);
                    }
                    selected = result.prefcode;
                } else {
                    //エラーだった時
                    //エラー内容を表示
                    $('#zip_result').html(res.message);

                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            }
        });
    });
});

//profile内容追加
var num = 0;
function addForm(){
  num = document.getElementById("subTxtCnt").value;
  num++;
  var addedFormDiv = document.getElementById("addedFormDiv");

  var str = "";
  str+="<dt><span>タイトル"+num+"</span><input type='text' name='dt["+num+"]'></dt>";
  str+="<dd><span>内容"+num+"</span><textarea name='dd["+num+"]'></textarea></dd>";
  // 추가할 폼(에 들어갈 HTML)

  var addedDiv = document.createElement("dl"); // 폼 생성
  addedDiv.id = "added_"+num; // 폼 Div에 ID 부여 (삭제를 위해)
  addedDiv.innerHTML  = str; // 폼 Div안에 HTML삽입
  addedFormDiv.appendChild(addedDiv); // 삽입할 DIV에 생성한 폼 삽입
  $("#subTxtCnt").val(num);
}

function delForm(){
    num = document.getElementById("subTxtCnt").value;
    var addedFormDiv = document.getElementById("addedFormDiv");

    if(num >0){ // 현재 폼이 두개 이상이면
               var addedDiv = document.getElementById("added_"+(num));
               // 마지막으로 생성된 폼의 ID를 통해 Div객체를 가져옴
               addedFormDiv.removeChild(addedDiv); // 폼 삭제
               num--;
                $("#subTxtCnt").val(num);
    }
}
