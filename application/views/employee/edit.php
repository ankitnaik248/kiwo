<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Edit Employee</h4>
                <h6 class="card-subtitle"></h6>
                <form id="employee_form" class="m-t-40">
                    <section>
                      <div class = "card">
                        <div class = "card-body">
                            <div class = "row">
                                <div class = "col-4">
                                    <label for="empName">Full Name *</label>
                                    <input type="hidden" name="emp_id" value = "<?= $empData[0]['emp_id']; ?>">
                                    <input id="name" name="name" type="text" class="required form-control" placeholder = "Enter Full Name" value = "<?= $empData[0]['emp_name']; ?>">
                                </div>
                                <div class = "col-4">
                                    <label for="email">Email *</label>
                                    <input id="email" name="email" type="email" class="required form-control" placeholder = "Enter Email" value = "<?= $empData[0]['emp_email']; ?>">
                                </div>
                                <div class = "col-4">
                                    <label for="mobile">Mobile *</label>
                                    <input id="mobile" name="mobile" type="text" class="required form-control" placeholder = "Enter Mobile No." value = "<?= $empData[0]['emp_mobile']; ?>">
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
                                        <?php 
                                            if($empData[0]['emp_type'] == '1'){
                                                echo '<option value="1" selected>Admin</option><option value="2">Employee</option>';
                                            }else{
                                                echo '<option value="2" selected>Employee</option><option value="1">Admin</option>';
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                                <div class = "col-4">
                                    <label for="department">Department *</label>
                                    <select name="department" id="department" class = "form-control" required>
                                        <option value="0">Select Department</option>
                                        <?php 

                                            foreach ($deptData as $keyDept => $valueDept) {
                                                if($empData[0]['emp_dept'] == $valueDept['dept_id']){
                                                    echo "<option value = '".$valueDept['dept_id']."' selected>".$valueDept['department_name']."</option>";
                                                }else{
                                                    echo "<option value = '".$valueDept['dept_id']."'>".$valueDept['department_name']."</option>";
                                                }
                                            }

                                        ?>
                                    </select>
                                </div>
                                <div class = "col-4">
                                    <label for="password">Password</label>
                                    <input type="password" name = "password" id = "password" class = "form-control" placeholder = "Enter Password">
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
                    email: true
                },
                mobile: {
                    required: true,
                    minlength:9,
                    maxlength:10,
                    number: true
                },
            },
            messages: {
                name: "Enter Full Name",
                email: "Enter Email",
                mobile: "Enter Mobile Number"
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
                    url: '<?= base_url(); ?>employee/editEmp',
                    data: form_data,
                    processData:false, 
                    contentType:false, 
                    cache:false,
                    async:false,
                    success: response => {
                        console.log(response);
                    }
                })
            }
        });
    });
</script>