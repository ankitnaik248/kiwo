<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Create Level</h4>
                <h6 class="card-subtitle"></h6>
                <form id="level_form" class="m-t-40">
                    <section>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                    <label for="levelName">Level Name *</label>
                                    <input id="name" name="name" type="text" class="required form-control" placeholder = "Enter Level Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "card-body text-center">
                                <a class = "btn btn-lg btn-danger" href = "<?= base_url(); ?>levels/">Cancel</a>
                                <button type="submit" class = "btn btn-lg btn-info" id = "submitLevel">Submit</button>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>       
    </div>
</div>    

<?php $this->load->view('includes/footer'); ?>

<script>
    $(document).ready(function(){
        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z0-9\s]+$/i.test(value);
        }, "Letters only please");

        $("#level_form").validate({
            rules: {
                name: {
                    required: true,
                },
            },
            messages: {
                name: "Enter Level Name",
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
                var form_data = new FormData(document.getElementById("level_form"));

                $.ajax({
                    type: "POST",
                    url: '<?= base_url(); ?>levels/createLevel',
                    data: form_data,
                    processData:false, 
                    contentType:false, 
                    cache:false,
                    async:false,
                    dataType: 'json',
                    success: response => {
                        
                        if(response.success == '1'){
                            Swal.fire({
                              title: 'Success!',
                              text: response.message,
                              icon: 'success',
                              confirmButtonText: 'Ok'
                            }).then(function(){
                                location.href = "<?= base_url(); ?>levels/"
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
                })
            }
        })
    })
</script>