<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Edit Department</h4>
                <h6 class="card-subtitle"></h6>
                <form id="req_form" class="m-t-40">
                    <section>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                    <label for="empName">Request Type *</label>
                                    <input type="hidden" name="req_id" value = "<?= $dataOfReq['0']['request_id']; ?>">
                                    <input id="req_type" name="req_type" type="text" class="required form-control" placeholder = "Enter Request Type" value = "<?= $dataOfReq['0']['req_name']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "card-body text-center">
                                <a class = "btn btn-lg btn-danger" href = "<?= base_url(); ?>reqtypeController/">Cancel</a>
                                <button type="submit" class = "btn btn-lg btn-info" id = "submitemp">Submit</button>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>       
    </div>
</div>    

<?php $this->load->view('includes/footer'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Letters only please");

        $("#req_form").validate({
            rules: {
                req_type: {
                    required: true,
                    lettersonly: true
                },
            },
            messages: {
                name: "Enter Request Type",
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
                var form_data = new FormData(document.getElementById("req_form"));

                $.ajax({
                    type: "POST",
                    url: '<?= base_url(); ?>reqtypeController/editReqSubmit',
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
                                location.href = "<?= base_url(); ?>reqtypecontroller/"
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
        });
    })
</script>