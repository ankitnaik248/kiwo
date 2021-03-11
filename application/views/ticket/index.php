<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class = "card-body">
                <div class = "card">
                    <div class = "card-body">
                        <div class = "row float-right">
                            <div class = "col-6">
                                <label>Request Status</label>
                                <select class = "form-control" name = "requestType" id = "requestType">
                                    <option value = '1' selected>Incoming</option>
                                    <option value = '2'>Outgoing</option>
                                </select>
                            </div>
                            <div class = "col-4">
                                <label>Ticket Status</label>
                                <select class = "form-control" name = "statusType" id = "statusType">
                                    <option value = '1' selected>Open</option>
                                    <option value = '2'>Closed</option>
                                </select>
                            </div>
                            <div class = "col-2">
                                <br>
                                <a href="<?= base_url() ?>ticket/create" class = "btn btn-lg btn-primary">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <table id = "ticketTable" class="table table-bordered table-hover">
                        <thead>
                            <tr class = "text-center">
                                <th>Sr No</th>
                                <th>Ticket No</th>
                                <th>Request Type</th>
                                <th>Request Summary</th>
                                <th>Added By</th>
                                <th>Added By Department</th>
                                <th>Assigned To Department</th>
                                <th>Closed By</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Days</th>
                                <th>Remarks</th>
                                <!-- <th>Closure Status</th> -->
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>        

<!-- Approval -->
<div id="addRemark" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id = "approveForm">
            <div class = "form-group">
                <label for="status">Closure Status</label>
                <input type="hidden" name="ticket_ids" id = "ticket_ids">
                <select name="status" id="status" class = "form-control">
                    <option value="0">Select Status</option>
                    <option value="1">Pending</option>
                    <option value="2">Closed</option>
                </select>
            </div>
            <!-- <div class = "form-group">
                <label for="forward">Assign Forward</label>
                <select name="forward" id="forward" class = "form-control">
                    <option value="0">No</option>
                    <?php
                        foreach($dep_data as $depKey => $valDept){
                            echo "<option value = '".$valDept['dept_id']."'>".$valDept['department_name']."</option>";
                        }
                    ?>
                </select>
            </div> -->
            <div class = "form-group">
                <label for="remark">Remark</label>
                <textarea name="remark" id="remark" cols="30" rows="10" class = "form-control" placeholder = "Enter Remarks"></textarea>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- End Approval -->

<!-- Remarks -->
<div id="remarksAdded" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class = "table">
            <thead class = 'text-center'>
                <th>Sr NO</th>
                <th>Remark</th>
                <th>Remark By</th>
                <th>Approvers Department</th>
                <th>Date Added</th>
            </thead>
            <tbody class = "remarks-body">
                
            </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
<!-- End Remarks -->

<?php $this->load->view('includes/footer'); ?>
<script>
        $(function () {
            // let datatable = 
            let table = $("#ticketTable").DataTable({
                "processing": true,
                "serverSide": true,
                "searchable": true,
                "responsive": true,
                "serverMethod": 'post',
                "ajax": {
                    url: "<?= base_url(); ?>ticket/getData",
                    type: "POST",
                    data: function(d){
                        d.statusType = $(document).find('#statusType').val(),
                        d.requestType = $(document).find('#requestType').val()    
                    }
                },
                "columns": [
                    { data: 'sr_no'},
                    { data: 'ticket_no'},
                    { data: 'request_type'},
                    { data: 'request_summary'},
                    { data: 'added_by'},
                    { data: 'added_by_dept'},
                    { data: 'assigned_to'},
                    { data: 'closed_by'},
                    { data: 'start_date'},
                    { data: 'end_date'},
                    { data: 'total_days'},
                    { data: 'remarks'},
                    // { data: 'closure_status'},
                    { data: 'date_added'},
                    { data: 'action'},
                ]
            });
            // new $.fn.dataTable.FixedHeader( table );
            $(document).on('change', "#statusType", function(){
              table.draw();
            });
            
            $(document).on('change', "#requestType", function(){
              table.draw();
            });
        });
        
    

    $(document).on("click", ".approval", function (){
        //approval form
        $(document).find("#ticket_ids").val($(this).data('tckt_id'))
        $("#addRemark").modal();
    });

    $(document).on("submit", "#approveForm", function(e){
        e.preventDefault();
        var formData = new FormData(document.getElementById("approveForm"));
        if($("#remark").val() != '' && $("#status").val() != '0'){
            $.ajax({
                type: "POST",
                url: '<?= base_url(); ?>ticket/add_remarks',
                data: formData,
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
        }else{
            Swal.fire({
                title: 'Error!',
                text: "All Fields Are Required",
                icon: 'error',
                confirmButtonText: 'ok'
            });
        }    
    });

    $(document).on("click", ".remarksBtn", function(){

        //remarks added
        var ticket_id = $(this).data('tckt_id');

        $.ajax({
            url: "<?= base_url(); ?>ticket/getremarks",
            type: "POST",
            dataType: "json",
            data: {'ticket_id': ticket_id},
            async: false,
            success: function(res){
              
              if(res.success == 1){
                $(document).find(".remarks-body").html(res.rows);
              }else{
                $(document).find(".remarks-body").html(res.rows);
              }
            }
        });

        $("#remarksAdded").modal();
    });

    $(document).ready(function() {
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    });

    $(document).on("click", ".delete", function() {
        $.ajax({
            url: "<?= base_url(); ?>ticket/delete",
            type: "POST",
            dataType: "json",
            data: {'ticket_id': $(this).data('tckt_id')},
            async: false,
            success: function(res){
              
              if(res.success == '1'){
                    Swal.fire({
                      title: 'Success!',
                      text: res.message,
                      icon: 'success',
                      confirmButtonText: 'Ok'
                    }).then(function(){
                        location.href = "<?= base_url(); ?>ticket/"
                    });
                }else{
                    Swal.fire({
                        title: 'Error!',
                        text: res.message,
                        icon: 'error',
                        confirmButtonText: 'ok'
                    });
                }
            }
        });
    });

    $(document).on("click", ".closeFile", function() {
        $.ajax({
            url: "<?= base_url(); ?>ticket/closeFile",
            type: "POST",
            dataType: "json",
            data: {'ticket_id': $(this).data('tckt_id')},
            async: false,
            success: function(res){
              
              if(res.success == '1'){
                    Swal.fire({
                      title: 'Success!',
                      text: res.message,
                      icon: 'success',
                      confirmButtonText: 'Ok'
                    }).then(function(){
                        location.href = "<?= base_url(); ?>ticket/"
                    });
                }else{
                    Swal.fire({
                        title: 'Error!',
                        text: res.message,
                        icon: 'error',
                        confirmButtonText: 'ok'
                    });
                }
            }
        });
    });
</script>