<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Create Sub Department</h4>
                <h6 class="card-subtitle"></h6>
                <form id="department_form" class="m-t-40">
                    <section>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                    <label for="deptName">Main Department *</label>
                                        <select name="deptName" id="deptName" class = "form-control">
                                        <option value="0">Select Department</option>
                                        <?php
                                            if(!empty($departmentData)){
                                                foreach($departmentData as $ind => $value){
                                                 echo "<option value = '".$value['dept_id']."'>".$value['department_name']."</option>";   
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <table class = "table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th class = "text-center font-weight-bold">Sub Department</th>
                                            <th class = "text-center font-weight-bold">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody class = "tableBody">
                                            <tr class = "text-center">
                                                <td><input type="text" name = "subDeptName[]" class = "form-control" placeholder = "Sub Department Name" required></td>
                                                <td>
                                                    <span class = "addRow" data-toggle="tooltip" title="Add Row"><i class="fa   fa-plus" aria-hidden="true"></i></span>
                                                        &nbsp&nbsp&nbsp
                                                    <span class = "DeleteRow" data-toggle="tooltip" title="Delete Row"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "card-body text-center">
                                <a class = "btn btn-lg btn-danger" href = "<?= base_url(); ?>SubDepartment/">Cancel</a>
                                <button type="submit" class = "btn btn-lg btn-info" id = "submitdept">Submit</button>
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

        //add Row
        $(document).on("click", ".addRow", function() {
            var cloneRow = $(".tableBody tr:last").clone().find("input").val("").end();
            $(".tableBody").append(cloneRow);
            $(this).remove();
        });

        //Delete Row
        $(document).on("click", ".DeleteRow", function(){
            
            if($(".tableBody tr").length > 1){
                $(this).parent().parent().remove();
                
                if($(".tableBody:last tr").has("span.addRow").length == 0){
                    $(".tableBody:last").find(".DeleteRow").parent().prepend('<span class = "addRow" data-toggle="tooltip" title="Add Row"><i class="fa fa-plus" aria-hidden="true"></i></span>')
                }
            }
        })

        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Letters only please");

        jQuery.validator.addMethod("notEqual", function (value, element, param) { // Adding rules for Amount(Not equal to zero)
            return this.optional(element) || value != '0';
        });

        $("#department_form").validate({
            rules: {
                name: {
                    required: true,
                    lettersonly: true
                },
                deptName: {
                    required: true,
                    notEqual: '0'
                }
            },
            messages: {
                name: "Enter Sub-Department Name",
                deptName: {
                    notEqual: "Main Department Is Required"
                }
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
                var isValid = true;
                $(".tableBody input").each(function() {
                    var element = $(this);
                    if (element.val() == "") {
                        isValid = false;
                        element.parent().append(`<label id="subDeptName[]-error" class="error ui red pointing label transition" for="subDeptName[]" style="color: rgb(255, 0, 0); font-weight: bold;">This field is required.</label>`);
                    }
                });
                
                if(isValid){
                    var form_data = new FormData(document.getElementById("department_form"));

                    $.ajax({
                        type: "POST",
                        url: '<?= base_url(); ?>SubDepartment/createSubDepartment',
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
                                    location.href = "<?= base_url(); ?>SubDepartment/"
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
            }
        });

        //deactivate sub-department

    })
</script>