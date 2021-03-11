<!DOCTYPE html>
<html lang="en" dir = "ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png"> -->
    <title>Login</title>
    <link href="<?= base_url(); ?>dist/css/style.min.css" rel="stylesheet">
</head>
<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><img src="<?= base_url(); ?>assets/images/kiwologo.png" alt="logo" / width = "178"></span>
                    </div>
                    <!-- Form -->
                    <form id="loginform_kiwo" class="form-horizontal m-t-20">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="email" name = "email" id = "email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" name = "password" id = "password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="text-center" style = "color:#fff">
                                    <label class="form-check-label">
                                        <input class="radio-inline" type="radio" name="usertype" id="usertype1" value="1" checked>Admin
                                    </label>
                                    <label class="form-check-label">
                                        <input class="radio-inline" type="radio" name="usertype" id="usertype2" value="2">Employee
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <!-- <button class="btn btn-info" id="to-recover" type="button"><i class="fa fa-lock m-r-5"></i> Lost password?</button> -->
                                        <button class="btn btn-success float-right" type="submit">Login</button>
                                        <!-- <a href = "<?= base_url() ?>home/dashboard" class="btn btn-success float-right">Login</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url(); ?>assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>dist/js/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $(".preloader").fadeOut();
            
            $('#to-login').click(function(){
                
                $("#recoverform").hide();
                $("#loginform").fadeIn();
            });

            $("#loginform_kiwo").validate({
                rules: {
                    email: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    usertype: {
                        required: true
                    }
                },
                messages: {
                    email: "Enter Username",
                    password: "Enter Password"
                },
                errorPlacement: (error, element) => {
                    error.addClass( "ui red pointing label transition" );
                    error.css({'color':'red', 'font-size':'14', 'font-weight': 'bold'});
                    error.insertAfter( element.after() );
                },
                invalidHandler: (event, validator) => {
                        var errors = validator.numberOfInvalids();
                        if(errors) {
                                var message = errors == 1
                                ? 'You missed 1 field. It has been highlighted'
                                : 'You missed ' + errors + ' fields. They have been highlighted';
                                $("div.error span").html(message);
                                $("div.error").show();
                        } else {
                                $("div.error").hide();
                        }
                },
                submitHandler: function(form,event) {
                    
                    var form_data = new FormData(document.getElementById("loginform_kiwo"));

                    $.ajax({
                        type: "POST",
                        url: '<?= base_url(); ?>home/logincheck',
                        data: form_data,
                        processData:false, 
                        contentType:false, 
                        cache:false,
                        async:false,
                        dataType: 'json',
                        success: response => {
                            // console.log(response);
                            if(response.success == '1'){
                                Swal.fire({
                                  title: 'Success!',
                                  text: response.message,
                                  icon: 'success',
                                  confirmButtonText: 'Ok'
                                }).then(function(){
                                    location.href = "<?= base_url(); ?>home/dashboard"
                                });
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'ok'
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>