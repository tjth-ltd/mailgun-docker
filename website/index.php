<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<div class="contact-form">
  <form id="contactform" name="contactform" method="post">
      <div class="row">
          <div class="col-sm-6">
              <input name="name" class="form-control" type="text" placeholder="Name*"/>
          </div>
          <div class="col-sm-6">
              <input name="email" class="form-control" type="email" placeholder="Email*"/>
          </div>
          <div class="clearfix"></div>
          <div class="col-sm-12">
              <textarea name="message" cols="5" class="form-control"
                        placeholder="Message*"></textarea>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-12">
              <button type="submit" class="btn btn-blue contact-submit">Submit</button>
          </div>
      </div>
  </form>
</div> <!--contact form-->
<script>
$('#contactform').on('submit', function (e) {
    $(this).attr("disabled", true);
    $('.contact-submit').text('Sending Message...');
    var dataString = $(".contact-form form").serialize();
    $.ajax({
        type: 'POST',
        url: "contact.php",
        data: dataString,
        success: function () {
            $('.contact-form form').hide();
            $('.contact-form').html("<div id='message'></div>");
            $('#message').html("<h2>Thanks, We got your Message!</h2>")
                .append("<p>We will be in touch soon.</p>");
        },
        error: function (data) {
            console.log('Silent failure.');
        }
    });
    return false;
});
</script>
</html>