
$(function () {

    // Alpha numeric validation
    $('#imei').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9_]*$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    // init the validator
    // validator files are included in the download package
    // otherwise download from http://1000hz.github.io/bootstrap-validator

    $('#contact-form').validator();


    // when the form is submitted
    $('#contact-form').on('submit', function (e) {

        // if the validator does not prevent form submit
        if (!e.isDefaultPrevented()) {
            var data = {};
            $.each($("form").serializeArray(), function (i, field) {
                data[field.name] = field.value;
            });
            if(data.ice_core_name < 0 || data.ice_core_name > 62){
                $('#ice_core_error').append(document.createTextNode('Any number between 0 to 62'));
                return false;
            }
            if((data.number_of_slaves < 0) || (data.number_of_slaves > 3)){
                $('#slaves_error').append(document.createTextNode('Any number between 0 to 3'));
                return false;
            }

            var url = "contact.php";
            // POST values in the background the the script URL
            $.ajax({
                url: url,
                dataType : "json",
                type : "POST",
                data : data,
                success: function (res)
                {
                    $("#result").html('');                    
                    if(res.status == 1){
                        $("#result").html('<div class="alert alert-success" style="padding: 5px; margin-bottom: 0px !important;"><button type="button" class="close">×</button>'+res.data+'</div>');
                        window.setTimeout(function() {
                            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                                $(this).remove(); 
                            });
                        }, 5000);

                        $('.alert .close').on("click", function(e){
                            $(this).parent().parent().fadeTo(500, 0).slideUp(500);
                        });
                    } else {
                        $("#result").html(res.data); 
                        $("#result").addClass("alert alert-success");
                    }
                }
            });
            return false;
        }
    })
});