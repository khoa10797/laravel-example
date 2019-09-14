$(document).ready(function () {

    $('#search-box').keypress(function (event) {
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == '13') {
            window.location.href = '/menu/search/' + $(this).val();
        }
    });

    $("#img-upload").change(function () {
        if (this.files && this.files[0]){
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);

            reader.onload = function (e) {
                $('#img-upload-tag').attr('src', reader.result);
            }
        }
    });

});
