<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Edit Sub Department</h4>
                <h6 class="card-subtitle"></h6>
                <form id="subdepartment_form" class="m-t-40">
                    <section>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                    <label for="deptName">Main Department *</label>
                                        <select name="deptName" id="deptName" class = "form-control">
                                        <option value="0">Select Department</option>
                                        <?php
                                            if($deptId != ''){
                                                foreach($departmentData as $ind => $value){
                                                    if($value['dept_id'] == $deptId){
                                                        echo "<option value = '".$value['dept_id']."' selected>".$value['department_name']."</option>";
                                                    }else{
                                                        echo "<option value = '".$value['dept_id']."'>".$value['department_name']."</option>";
                                                    }   
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
                                        <?php
                                            if($dataOfSubDept != '')
                                            {
                                                foreach($dataOfSubDept as $index => $val){
                                        ?>
                                                    <tr class = "text-center">
                                                        <td><input type="text" name = "subDeptName[]" class = "form-control" placeholder = "Sub Department Name" value = "<?= $val['sub_name'] ?>" required><input type = "hidden" name = "subId" value = "<?= $subId; ?>"></td>
                                                        <td>
                                                            <span class = "DeleteRow" data-subdeptid = "<?= $val['sub_id']; ?>" data-toggle="tooltip" title="Delete Row"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                        </td>
                                                    </tr>  
                                        <?php        
                                                }
                                            }else{
                                                echo '<tr class = "text-center">
                                                        <td>
                                                            <input type="text" name = "subDeptName[]" class = "form-control" placeholder = "Sub Department Name" required><input type = "hidden" name = "subId" value = "'.$subId.'">
                                                        </td>
                                                        <td></td>
                                            </tr>';
                                            }
                                        ?>
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


        //Delete Row
        $(document).on("click", ".DeleteRow", function(){
            
           var subdeptId = $(this).data('subdeptid');

           $.ajax({
            type: "POST",
            url: '<?= base_url(); ?>SubDepartment/removeSubDept',
            data: {"subdeptId": subdeptId},
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
                        location.reload();
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
            
        })

        jQuery.validator.addMethod("lettersonly", function (value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Letters only please");

        jQuery.validator.addMethod("notEqual", function (value, element, param) { // Adding rules for Amount(Not equal to zero)
            return this.optional(element) || value != '0';
        });

        $("#subdepartment_form").validate({
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
                    var form_data = new FormData(document.getElementById("subdepartment_form"));

                    $.ajax({
                        type: "POST",
                        url: '<?= base_url(); ?>SubDepartment/editSubDepartment',
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