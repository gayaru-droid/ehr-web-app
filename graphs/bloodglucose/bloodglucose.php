
<?php
/*echo 'Height graph goes here';*/
include('../dbcon.php');

$stmt=$conn->prepare('SELECT glucose,date_time FROM measurements WHERE patient_id=? ORDER BY date_time ASC;');
$stmt->bind_param('i',$patientdetails['patient_id']);
$stmt->execute();

$res=$stmt->get_result();
/*echo $patientdetails['patient_id'];*/

$glucose=[];
$dates=[];

while($row=$res->fetch_assoc()){
    $datesonly=date('y/m/d',strtotime($row['date_time']));
    /*echo $datesonly.'<br>';*/
    $dates[]=$datesonly;
    $glucose[]=$row['glucose'];
}

$datesJSON=json_encode($dates);
$glucoseJSON=json_encode($glucose);

?>
<div class="graphwrapper">
    <canvas id="graph1"></canvas>
</div>
<script>
{
    const ctx=document.getElementById('graph1');

    const dates= <?php echo $datesJSON; ?>;
    const glucose= <?php echo $glucoseJSON; ?>;

    new Chart(ctx,{
        type:'line',
        data:{
            labels: dates,
            datasets:[{
                label: "Glucose Graph",
                data: glucose,
                borderColor:'#0022fc',
                borderWidth:1,
                backgroundColor:'rgba(28, 104, 255, 0.5)',
                fill:true,
                tension:0.3
            }]
        },
        options:{
            maintainAspectRatio: false,
            scales:{
                y:{
                    beginAtZero:true
                }
            },
            responsive:true,
            plugins:{
                legend:{display:false}
            }
        }
        
    });
}
</script>