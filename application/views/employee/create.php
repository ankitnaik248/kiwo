<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Create Employee</h4>
                <h6 class="card-subtitle"></h6>
                <form id="employee_form" class="m-t-40">
                    <section>
                      <div class = "card">
                        <div class = "card-body">
                            <div class = "row">
                                <div class = "col-4">
                                    <label for="empName">Full Name *</label>
                                    <input id="name" name="name" type="text" class="required form-control" placeholder = "Enter Full Name">
                                </div>
                                <div class = "col-4">
                                    <label for="mobile">Mobile *</label>
                                    <input id="mobile" name="mobile" type="text" class="required form-control" placeholder = "Enter Mobile No.">
                                </div>
                                <div class = "col-4">
                                    <label for="alternate-no">Alternate No. </label>
                                    <input id="alternate_no" name="alternate_no" type="text" class="form-control" placeholder = "Enter Alternate No. ">
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class = "card">
                        <div class = "card-body">
                            <div class = "row">
                                <div class = "col-6">
                                    <label for="telephone">Telephone No. *</label>
                                    <input id="telephone" name="telephone" type="text" class="form-control" placeholder = "Enter Telephone No.">
                                </div>
                                <div class = "col-6">
                                    <label for="email">Email *</label>
                                    <input id="email" name="email" type="email" class="required form-control" placeholder = "Enter Email">
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label for="permanent-address">Permanent Address *</label>
                                    <textarea name="permanent_address" id="permanent_address" cols="30" rows="10" placeholder = "Enter Permanent Address" class = "required form-control"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="temporary-address">Temporary Address </label>
                                    <textarea name="temporary_address" id="temporary_address" cols="30" rows="10" placeholder = "Enter Temporary Address" class = "form-control"></textarea>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <label for="company-name">Company Name *</label>
                                    <input type="text" name = "company_name" id = "company_name" class = "form-control required" placeholder = "Enter Company Name">
                                </div>
                                <div class="col-4">
                                    <label for="company-address">Company Address *</label>
                                    <textarea name="company_address" id="company_address" cols="30" rows="10" class = "form-control required" placeholder = "Enter Company Address"></textarea>
                                </div>
                                <div class = "col-4">
                                    <label for="contact-no">Company Contact No. *</label>
                                    <input type="text" name = "com_cnt_no" id = "com_cnt_no" class = "form-control required" placeholder = "Enter Company Contact No.">
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class = "card">
                        <div class = "card-body">
                            <div class = "row">
                                <div class = "col-4">
                                    <label for="type">Type Of Employee *</label>
                                    <select name="type" id="type" class = "form-control" required>
                                        <option value="0">Select Type</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Employee</option>
                                    </select>
                                </div>
                                <div class = "col-4">
                                    <label for="department">Department *</label>
                                    <select name="department" id="department" class = "form-control" required>
                                        <option value="0">Select Department</option>
                                        <?php 
                                            foreach($dept as $keydept => $valueDept){
                                                echo "<option value = '".$valueDept['dept_id']."'>".$valueDept['department_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="sub-dept">Sub Department *</label>
                                    <select name="sub_department" id="sub_department" class = "form-control" required>
                                            <option value="0"> Select Sub Department </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-body">
                            <div class = "row">
                                <div class = "col-4">
                                    <label for="designation">Designation *</label>
                                    <select name="designation" id="designation" class = "form-control" required>
                                        <option value="0"> Select Designation </option>
                                    </select>
                                </div>
                                <div class = "col-4">
                                    <label for="password">Password *</label>
                                    <input type="password" name = "password" id = "password" class = "form-control" placeholder = "Enter Password" required>
                                </div>
                            </div>
                        </div>
                      </div>  
                      <!-- <div class = "card">
                        <div class = "card-body">
                            <div class = "row">
                                <div class = "col-4">
                                    <label for="profile">Profile Image (Optional)</label>
                                    <input type="file" name = "profile" id = "profile" class = "form-control">
                                </div>
                            </div>
                        </div>
                      </div> -->
                      <div class = "card">
                        <div class = "card-body text-center">
                            <a class = "btn btn-lg btn-danger" href = "<?= base_url(); ?>employee/">Cancel</a>
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

<script>
    $(document).ready(function(){
        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Letters only please");

        $("#employee_form").validate({
            rules: {
                name: {
                    required: true,
                    lettersonly: true
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?= base_url(); ?>employee/checkemail",
                        type: "POST",
                    }
                },
                mobile: {
                    required: true,
                    minlength:9,
                    maxlength:10,
                    number: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                name: "Enter Full Name",
                email: {
                        required: "Enter Email",
                        remote: "Email is already in use",
                    },
                mobile: "Enter Mobile Number",
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
                var form_data = new FormData(document.getElementById("employee_form"));
                $.ajax({
                    type: "POST",
                    url: '<?= base_url(); ?>employee/createemp',
                    data: form_data,
                    processData:false, 
                    contentType:false, 
                    cache:false,
                    async:false,
                    dataType: 'json',
                    success: response => {
                        console.log(response);
                        if(response.success == '1'){
                            Swal.fire({
                              title: 'Success!',
                              text: response.message,
                              icon: 'success',
                              confirmButtonText: 'Ok'
                            }).then(function(){
                                location.href = "<?= base_url(); ?>ticket/"
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
    });
</script>