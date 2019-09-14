$(document).ready(function () {

    $('#search-box').keypress(function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == '13') {
            window.location.href = '/menu/search/' + $(this).val();
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-upload-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#img-upload").change(function () {
        readURL(this);
    });

});
