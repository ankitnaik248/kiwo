<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Edit Ticket</h4>
                <h6 class="card-subtitle"></h6>
                <form id="ticket_form" class="m-t-40">
                    <section>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                        <label for="ticket_no">Ticket No *</label>
                                        <input type="text" name = "ticket_no" id = "ticket_no" class = "form-control" value = "<?= $ticketData[0]['ticket_no']; ?>" readonly>
                                    </div>
                                    <div class = "col-4">
                                        <label for="department">Department *</label>
                                        <select name="department" id="department" class = "form-control">
                                            <option value="0">Select Department</option>
                                            <?php
                                                foreach($dep_data as $k => $valDept){
                                                    if($ticketData[0]['ticket_assigned_to'] == $valDept['dept_id']){
                                                        echo "<option value = '".$valDept['dept_id']."' selected>".$valDept['department_name']."</option>";
                                                    }else{
                                                        echo "<option value = '".$valDept['dept_id']."'>".$valDept['department_name']."</option>";
                                                    }
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

                                                    if($ticketData[0]['req_type'] == $valKey['request_id']){
                                                        echo "<option value = '".$valKey['request_id']."' selected>".$valKey['req_name']."</option>";
                                                    }else{
                                                        echo "<option value = '".$valKey['request_id']."'>".$valKey['req_name']."</option>";
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
                                    <div class = "col-4">
                                        <label for="body">Request Summary *</label>
                                        <textarea name="ticket_body" id="ticket_body" class = "form-control" placeholder = "Enter Ticket Body" value = "<?= $ticketData[0]['ticket_remark']; ?>"></textarea>
                                    </div>
                                    <div class = "col-4">
                                        <label for="behalf">Raising On Behalf (optional)</label><?= $ticketData[0]['behalf'] ?>
                                        <select name="emp" id="emp" class = "form-control">
                                            <option value="0">Select Employee</option>
                                            <?php
                                                foreach ($dept_emp as $kem => $valemp) {
                                                    if($ticketData[0]['behalf'] == '1'){
                                                        if($ticketData[0]['ticket_added_by'] == $valemp['emp_id']){
                                                            echo "<option value = '".$valemp['emp_id']."' selected>".$valemp['emp_name']."</option>";
                                                        }else{
                                                            echo "<option value = '".$valemp['emp_id']."'>".$valemp['emp_name']."</option>";    
                                                        }
                                                    }else{
                                                        echo "<option value = '".$valemp['emp_id']."'>".$valemp['emp_name']."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class = "col-4">
                                        <label for="attachment">Attachment (optional)</label>
                                        <input type="file" class = "form-control">
                                        <a href="<?= base_url().'uploads/'.$ticketData[0]['file_attach']; ?>" target = "_blank"><?= $ticketData[0]['file_attach']; ?></a>;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "card">
                            <div class = "card-body">
                                <div class = "row">
                                    <div class = "col-4">
                                        <label for = "start_date">Start Date</label>
                                        <input type = "text" name = "start_date" class = "form-control start_date datepicker" placeholder = "Select Start Date" value = "<?= $ticketData[0]['start_date'] ?>" required>
                                    </div>
                                    <div class = "col-4">
                                        <label for = "end_date">End Date</label>
                                        <input type = "text" name = "end_date" class = "form-control end_date datepicker" placeholder = "Select End Date" value = "<?= $ticketData[0]['start_date'] ?>" required>
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
        $(".datepicker").datepicker({dateFormat: 'mm-dd-yy'});
    })
</script>