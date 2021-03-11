<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class = "card-body">
                <div class = "card">
                    <div class = "card-body">
                        <div class = "row float-right">
                            <a href="<?= base_url() ?>levels/create" class = "btn btn-lg btn-primary">Add</a>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <table id = "levelTable" class="table table-bordered table-hover">
                        <thead>
                            <tr class = "text-center">
                                <th>Sr No</th>
                                <th>Level Name</th>
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
        $("#levelTable").DataTable({
            "processing": true,
            "serverSide": true,
            "searchable": true,
            "responsive": true,
            "serverMethod": 'post',
            "ajax": {
                url: "<?= base_url(); ?>levels/getData",
                type: "POST",
            },
            "columns": [
                { data: 'sr_no'},
                { data: 'level_name'},
                { data: 'date_added'},
                { data: 'action'},
            ]
        });
    });

    $(document).on("click", ".delete", function() {
        var level_id = $(this).data("level_id");
        var status = $(this).data("status");
        $.ajax({
            type: "POST",
            url: '<?= base_url(); ?>levels/deleteLevel',
            data: {"levelid": level_id, "status": status},
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
    });
</script>