<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Generate Ticket</h4>
                <h6 class="card-subtitle"></h6>
                <form id="ticket_form" class="m-t-40">
                    <section>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                        <label for="ticket_no">Ticket No *</label>
                                        <input type="text" name = "ticket_no" id = "ticket_no" class = "form-control" value = "<?= rand(1000, 9999) ?>" readonly>
                                    </div>
                                    <div class = "col-4">
                                        <label for="department">To Department *</label>
                                        <select name="department" id="department" class = "form-control">
                                            <option value="0">Select Department</option>
                                            <?php
                                                foreach($dep_data as $keyDept => $valDept){
                                                    echo "<option value = '".$valDept['dept_id']."'>".$valDept['department_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class = "col-4">
                                        <label for="subject">Request Type *</label>
                                        <select class = "form-control" id = "req_type" name = "req_type" required="">
                                            <option value = "0">Select Request Type</option>
                                            <?php
                                                foreach($getreqtype as $keyreq => $valKey){
                                                    echo "<option value = '".$valKey['request_id']."'>".$valKey['req_name']."</option>";
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
                                    <div class = "col-4">
                                        <label for="body">Request Summary *</label>
                                        <textarea name="ticket_body" id="ticket_body" class = "form-control" placeholder = "Enter Request Summary"></textarea>
                                    </div>
                                    <div class = "col-4">
                                        <label for="behalf">Raising On Behalf (optional)</label>
                                        <select name="emp" id="emp" class = "form-control">
                                            <option value="0">Select Employee</option>
                                            <?php 
                                                foreach ($dept_emp as $keyemp => $valemp) {
                                                    echo "<option value = '".$valemp['emp_id']."'>".$valemp['emp_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class = "col-4">
                                        <label for="attachment">Attachment (optional)</label>
                                        <input type="file" name = "req_attach" id = "req_attach" class = "form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                        <label for = "start_date">Start Date</label>
                                        <input type = "text" name = "start_date" class = "form-control start_date datepicker" placeholder = "Select Start Date" required>
                                    </div>
                                    <div class = "col-4">
                                        <label for = "end_date">End Date</label>
                                        <input type = "text" name = "end_date" class = "form-control end_date datepicker" placeholder = "Select End Date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "card-body text-center">
                                <a class = "btn btn-lg btn-danger" href = "<?= base_url(); ?>ticket/">Cancel</a>
                                <button type="submit" class = "btn btn-lg btn-info" id = "submitticket">Submit</button>
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
        
        $(".datepicker").datepicker({dateFormat: 'mm-dd-yy'});

        $("#ticket_form").validate({
            rules: {
                ticket_no: {
                    required: true
                },
                ticket_body: {
                    required: true,
                },
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true
                }
            },
            messages: {
                ticket_no: "Enter Ticket Number",
                ticket_body: "Enter Request Summary",
                start_date: "Select Start Date",
                end_date: "Select End Date"
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
                var status = true;
                if(new Date($(".start_date").val()) > new Date($('.end_date').val())){
                    Swal.fire({
                        title: 'Error!',
                        text: "Please Select Proper Dates",
                        icon: 'error',
                        confirmButtonText: 'ok'
                    });
                    status = false;
                }
                
                if(status){
                    var form_data = new FormData(document.getElementById("ticket_form"));
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url(); ?>ticket/ticket_form_submit',
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
            }
        });
    });
</script>