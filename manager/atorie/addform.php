<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>폼 추가/삭제 예제</title>


<div id="parah"></div>
<script>
  var arrInput = new Array(0);
  var arrInputValue = new Array(0);

//변수에 길이, 공백값을 줌
function addInput() {
  arrInput.push(arrInput.length);
  arrInputValue.push("");
  display();
}

//div태그의값을 공백으로, 변수길이만큼 div에 createInput함수를 추가
function display() {
  document.getElementById('parah').innerHTML="";
  for (intI=0;intI<arrInput.length;intI++) {
    document.getElementById('parah').innerHTML+=createInput(arrInput[intI], arrInputValue[intI]);
  }
}

function saveValue(intId,strValue) {
  arrInputValue[intId]=strValue;
}

function createInput(id,value) {
  return "<input type='text' id='test "+ id +"' onChange='javascript:saveValue("+ id +",this.value)' value='"+
  value +"'><br>";
}

function deleteInput() {
  if (arrInput.length > 0) {
     arrInput.pop();
     arrInputValue.pop();
  }
  display();
}
</script>

<form method="post" action="test.jsp">
    <input type="button" value="추가" onclick="addInput();" />
    <input type="button" value="삭제" onclick="deleteInput();"/>
    <input type="submit" value="전송"/>
</form>

<!--2번-->
<script type="text/javascript">
           var count = 0;

           function addForm(){
                     var addedFormDiv = document.getElementById("addedFormDiv");

                     var str = "";
                     str+="<br>값1-"+count+" <input type='text' name='dt["+count+"]'>";
                     str+="<br>값2-"+count+" <input type='textarea' name='dd["+count+"]'><BR>";
                     // 추가할 폼(에 들어갈 HTML)

                     var addedDiv = document.createElement("div"); // 폼 생성
                     addedDiv.id = "added_"+count; // 폼 Div에 ID 부여 (삭제를 위해)
                     addedDiv.innerHTML  = str; // 폼 Div안에 HTML삽입
                     addedFormDiv.appendChild(addedDiv); // 삽입할 DIV에 생성한 폼 삽입

                     count++;
                     document.baseForm.count.value=count;
                     // 다음 페이지에 몇개의 폼을 넘기는지 전달하기 위해 히든 폼에 카운트 저장
           }

           function delForm(){
                     var addedFormDiv = document.getElementById("addedFormDiv");

                     if(count >0){ // 현재 폼이 두개 이상이면
                                var addedDiv = document.getElementById("added_"+(--count));
                                // 마지막으로 생성된 폼의 ID를 통해 Div객체를 가져옴
                                addedFormDiv.removeChild(addedDiv); // 폼 삭제
                     }else{ // 마지막 폼만 남아있다면
                                document.baseForm.reset(); // 폼 내용 삭제
                     }
           }

</script>
</head>

<body onload="addForm();">
<center>

<form name="baseForm" action="" method="post">
           <input type="hidden" name="count" value="0">
           <div id="addedFormDiv"></div><BR> <!-- 폼을 삽입할 DIV -->
           <input type="Button" value="追加" onclick="addForm()">
           <input type="Button" value="削除" onclick="delForm()">
           <input type="Submit" value="완료">
</form>

</center>
</body>
</html>
<?php
  $str ="";
  if ($_POST['dt']) {
     echo var_dump($_POST['dt']);
     echo var_dump($_POST['dd']);
     foreach ($_POST['dt'] as $key => $value) {
      $str .= "<dt>".$value."</dt><dd>".$_POST['dd'][$key]."</dd>";
     }
  }
  echo $str;
?>
