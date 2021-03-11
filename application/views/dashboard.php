<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

    <div class="page-wrapper">
        <div class = "row">
            <div class = "col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                        <i class="fa fa-paper-plane"></i>
                            Total Tickets Raised To Department
                        </h3>
                        
                    </div><!-- /.card-header -->
                    <div class = "card-body">
                        <canvas id="graph" width="400" height="200"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                        <i class="fa fa-thumbs-up"></i>
                            Ticket Resolving Status
                        </h3>
                    </div>
                    <div class = "card-body">
                        <center>
                            
                            <?php
                                foreach($data['department'] as $k => $value){
                                    echo "<h4>".$value." : </h4><h5>Maximum Ticket Solved By Employee : ".$data['max_empname'][$k]."</h5><h5>Maximum Ticket Solved By Employee : ".$data['min_empname'][$k]."</h5>";        
                                }
                            ?>
                            
                        </center>
                    </div>
                </div>
            </div>
            <div class = "col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                        <i class="fa fa-thumbs-up"></i>
                            Tickets Raised By Department
                        </h3>
                    </div>
                    <div class = "card-body">
                        <center>
                            <canvas id="graph_dept" width="400" height="200"></canvas>   
                        </center>
                    </div>
                <!-- /.card-footer -->
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>

<?php $this->load->view('includes/footer'); ?>
<linl rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css">
<script src = "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>

<script>
    var ctxLine = document.getElementById("graph").getContext("2d");
    var lineGraph = new Chart(ctxLine, {
        type: 'line',
        data: {
        labels: <?php echo json_encode($data['department']); ?>,
        datasets: [{
            label: "Total Tickets",
            data: <?php echo json_encode($data['total_ticket']); ?>,
            backgroundColor: "Red",
            borderColor: "Red",
            fill: false,
            lineTension: 0,
            radius: 5
            },
            {
            label: "Tickets Resolved",
            data: <?php echo json_encode($data['ticket_resolved']); ?>,
            backgroundColor: "green",
            borderColor: "green",
            fill: false,
            lineTension: 0,
            radius: 5
            },
            {
            label: "Tickets Pending",
            data: <?php echo json_encode($data['ticket_pending']); ?>,
            backgroundColor: "black",
            borderColor: "black",
            fill: false,
            lineTension: 0,
            radius: 5
            },
            {
            label: "Average Time of Ticket Resolution",
            data: <?php echo json_encode($data['average']); ?>,
            backgroundColor: "blue",
            borderColor: "blue",
            fill: false,
            lineTension: 0,
            radius: 5
            }
        ],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            title: {
            display: true,
            text: "Request Till Date"
            }
        }
    });
    $(document).find("#graph").css({'height': '320px'});

    var ctxLine_dept = document.getElementById("graph_dept").getContext("2d");
    var lineGraph_dept = new Chart(ctxLine_dept, {
        type: 'line',
        data: {
        labels: <?php echo json_encode($data['department']); ?>,
        datasets: [{
            label: "Tickets Raised",
            data: <?php echo json_encode($data['tickets_raised']); ?>,
            backgroundColor: "lightred",
            borderColor: "lightred",
            fill: false,
            lineTension: 0,
            radius: 5
            },
            {
            label: "Tickets Resolved In Raised",
            data: <?php echo json_encode($data['ticket_resolved_dept']); ?>,
            backgroundColor: "lightgreen",
            borderColor: "lightgreen",
            fill: false,
            lineTension: 0,
            radius: 5
            },
            {
            label: "Tickets Pending In Raised",
            data: <?php echo json_encode($data['ticket_pending_dept']); ?>,
            backgroundColor: "lightblue",
            borderColor: "lightblue",
            fill: false,
            lineTension: 0,
            radius: 5
            },
            {
            label: "Average Time of Ticket Resolution",
            data: <?php echo json_encode($data['average_dept']); ?>,
            backgroundColor: "lightblue",
            borderColor: "lightblue",
            fill: false,
            lineTension: 0,
            radius: 5
            }
        ],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            title: {
            display: true,
            text: "Request Till Date"
            }
        }
    });
    $(document).find("#graph_dept").css({'height': '320px'});
    
    // var ctxLine_status = document.getElementById("myChartRequest").getContext("2d");
    // var lineGraph_status = new Chart(ctxLine_status, {
    //     type: 'line',
    //     data: {
    //     labels: <?php echo json_encode($data['department']); ?>,
    //     datasets: [{
    //             label: "Maximum",
    //             data: <?php echo json_encode($data['max_empname']); ?>,
    //             backgroundColor: "Blue",
    //             borderColor: "blue",
    //             fill: false,
    //             lineTension: 0,
    //             radius: 5
    //         },
    //         {
    //             label: "Minimum",
    //             data: <?php echo json_encode($data['min_empname']); ?>,
    //             backgroundColor: "green",
    //             borderColor: "green",
    //             fill: false,
    //             lineTension: 0,
    //             radius: 5
    //         }
    //     ],
    //     },
    //     options: {
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero: true
    //                 }
    //             }]
    //         },
    //         title: {
    //         display: true,
    //         text: "Ticket Solving Status"
    //         }
    //     }
    // });
    // $(document).find("#myChartRequest").css({'height': '320px'});
</script>