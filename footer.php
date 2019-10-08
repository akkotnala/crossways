<footer>
    <!--The footer typically contains links to things like About Us, Privacy Policy, Contact Us and so forth. It may also contain a nav, address, section, or aside element.--> <address>
        <!--Put an address element in the footer and you're indicating that the contact info within the element is for the owner of the website rather than the author of the article.--> </address> </footer>

<!-- jQuery, Popper, Bootstrap.min JS -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- Custom JS -->
<script src="js/validation.js">

</script>

<script>
    $(function() {

        // Single Select
        $("#autocomplete").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "functions.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term,
                        type: 'search',
                        "userID": <?php echo $userID; ?>
                    },
                    success: function(data) {
                        if (!data.length) {
                            var result = [{
                                label: 'No matches found',
                                value: response.term
                            }];
                            response(result);
                        } else {
                            // normal response
                            response($.map(data, function(item) {
                                return {
                                    label: item.fName + " " + item.lName + "",
                                    value: item.id
                                }
                            }));
                        }
                    }
                });
            },
            html: true,
            select: function(event, ui) {
                // similar behavior as clicking on a link
                window.location.href = "profile.php?userID=" + ui.item.value;
                return false;
            }
        });
    });

    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        return split(term).pop();
    }

</script>

	
<script>
 
$(document).ready(function(){
 
// updating the view with notifications using ajax
 
function load_unseen_notification()
 
{
 
 $.ajax({
 
  url:"fetch.php",
  method:"POST",
  data:{userID:<?php echo $userID; ?>},
  dataType:"json",
  success:function(data)
 
  {
 
 
   if(data.unseen_notification > 0)
   {
	   $(".badge-notify").html(data.unseen_notification).show();
   }
 else {
	  $(".badge-notify").html(data.unseen_notification).hide();
  }
  }
 });
 
}
setInterval(function(){
 
 load_unseen_notification();
 
}, 2000);
 load_unseen_notification();
});
</script>

<!-- Birthdate Select -->
<script>
    $(document).ready(function() {


        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {

            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
    });

</script>
</body>

</html>
