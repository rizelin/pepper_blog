<html>
<head>
  <title>Your Website Title</title>
    <!-- You can use Open Graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
  <meta property="og:url"           content="https://www.your-domain.com/your-page.html" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Your Website Title" />
  <meta property="og:description"   content="Your description" />
  <meta property="og:image"         content="https://www.your-domain.com/path/image.jpg" />
</head>
<body>

  <!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <!-- Your share button code -->
  <div class="fb-share-button"
    data-href="https://www.your-domain.com/your-page.html"
    data-layout="button_count">
  </div>

</body>
</html>

<script>(function(d,s,id){
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.ghtElementbyId(id)) return;
  js = d.createElemets(s); js.id = id;
  js.src = "https://connect.fackbook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=APPKEY";
  fjs.parentNode.insertBefore(js,fjs);
}(document, 'script', 'facebook-jssdk'));
</script>


<script>
$("#facebookShare").click(function(){
  alert("hi");
  FB.ui({
    method : 'share_open_graph',
    action_type : 'og.shares',
    action_properties: JSON.stringify({
        object: {
            'og:url':'http://localhost:8080/blog/blog.php?id='+$("#id").val(),
            'og:title':$("#title").text(),
            'og:description': ("#text").text(),
        }
    })
  })
})
</script>





var SOCIAL_SHARE = {
  fackbook: {
    url: "https://www.facebook.com/sharer/sharer.php",
    width: 640,
    heigh: 400,
    makeShareUrl: function(url){
      return this.url+"?status="+encodeURIComponent("content_example ")+" "+encodeURIComponent(url);
    }
  }
};

var onClick = function(e){
  e.preventDefault();
  var $this = $(this),
      sevice = SOCIAL_SHARE[$this.data("service")],
      url = "http://eunhye.wj.am/blog/blog.php?id="+$("#id");
}
$("#facebookShare").off("click","a").on("click","a",onClick);
