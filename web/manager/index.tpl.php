
<?php
require_once("./require/header.php");
?>
<h2 class="title_h2">LOGIN</h1>
<div class="main_body">
<form class="login_form" action="./" method="post">
    <dl>
        <dt><span>I D</span></dt>
        <dd><input type="text" name="id"></dd>
    </dl><br>
    <dl>
        <dt><span>P W</span></dt>
        <dd><input type="password" name="password"></dd>
    </dl><br>
        <p class="page"><input type="submit" name="login_btn" value="ログイン"></p>
</form>
</div>

<?php
require_once("./require/footer.php");
?>
