<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class = "card-body">
                <div class = "card">
                    <div class = "card-body">
                        <div class = "row float-right">
                            <a href="<?= base_url() ?>employee/create" class = "btn btn-lg btn-primary">Add</a>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <table id = "empTable" class="table table-bordered table-hover">
                        <thead>
                            <tr class = "text-center">
                                <th>Sr No</th>
                                <th>Emp Name</th>
                                <th>Emp Email</th>
                                <th>Emp Mobile</th>
                                <th>Department</th>
                                <th>Type</th>
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

<?php $this->load->view('includes/footer'); ?>
<script>
    $(function () {
        // let datatable = 
        $("#empTable").DataTable({
            "processing": true,
            "serverSide": true,
            "searchable": true,
            "responsive": true,
            "serverMethod": 'post',
            "ajax": {
                url: "<?= base_url(); ?>employee/getData",
                type: "POST",
            },
            "columns": [
                { data: 'sr_no'},
                { data: 'emp_name'},
                { data: 'emp_email'},
                { data: 'emp_mobile'},
                { data: 'department'},
                { data: 'emp_type'},
                { data: 'date_added'},
                { data: 'action'},
            ]
        });
    });

    $(document).on("click", ".delete", function() {
        var emp_id = $(this).data("emp_id");
        var status = $(this).data("status");
        
        $.ajax({
            type: "POST",
            url: '<?= base_url(); ?>employee/deleteEmp',
            data: {"empid": emp_id, "status": status},
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
                        location.href = "<?= base_url(); ?>employee/"
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
    })
</script>