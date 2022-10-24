<div class="login">

    <!-- Login -->
    <div class="login__block active" id="l-login">
        <div class="login__block__header" style="background-color: #29477F;">
            <i class="zmdi zmdi-account-circle"></i>
            Silahkan Masuk
        </div>
        <form id="formlogin">
            <div class="login__block__body">
                <div class="form-group form-group--float form-group--centered">
                    <input type="email" name="email" class="form-control">
                    <label>email</label>
                    <i class="form-group__bar"></i>
                </div>

                <div class="form-group form-group--float form-group--centered">
                    <input type="password" name="password" class="form-control">
                    <label>Password</label>
                    <i class="form-group__bar"></i>
                </div>
                <button type="submit" class="btn btn--icon login__block__btn" style="background-color: #29477F;"><i
                        class="zmdi zmdi-long-arrow-right"></i></button>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
    }, 1500)
});

$("#formlogin").on("submit", (function(b) {
    $.ajax({
        url: "",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(a) {
            if (a > 0) {
                location.href = "<?php echo base_url();?>home";
            } else {
                swal("Error", "email/password salah", "error")
            }
        },
        error: function(a, e, f) {
            console.log(a);
            swal("Error", "", "error")
        }
    });
    return false
}));
</script>