<?php
    include('../dbcon.php');

    $stmt=$conn->prepare('SELECT systolic,diastolic FROM measurements WHERE patient_id=? ORDER BY date_time DESC LIMIT 30;');
    $stmt->bind_param('i',$patientdetails['patient_id']);
    $stmt->execute();

    $res=$stmt->get_result();
    
    $normal=0;
    $elevated=0;
    $stage1=0;
    $stage2=0;

    while($row=$res->fetch_assoc()){
        $sys=$row['systolic'];
        $dias=$row['diastolic'];

        if ($sys<120 && $dias<80){
            $normal++;
        } elseif($sys>=120 && $sys<=129 && $dias<80){
            $elevated++;
        } elseif(($sys >= 130 && $sys <= 139) || ($dias >= 80 && $dias <= 89)){
            $stage1++;
        } else{
            $stage2++;
        }
    }

    $bpcounts=json_encode([$normal,$elevated,$stage1,$stage2]);
    /*echo $bpcounts;*/
?>
<canvas id='bpresuredest'></canvas>
<script>
{
const ctx=document.getElementById('bpresuredest');
const counts=<?php echo $bpcounts;?>;

new Chart(ctx,{
    type:'doughnut',
    data:{
        labels:['Normal','Elevated','Stage1','Stage2'],
        datasets:[{
            label:'Reading Count',
            data: counts,
            backgroundColor:[
                '#2b9348', // Green for Normal
                '#f39c12', // Yellow for Elevated
                '#e67e22', // Orange for Stage 1
                '#e63946'  // Red for Stage 2
            ],
            borderRadius:6
        }]
    },
    options:{
        animation: {
        duration: 1500, // Time in milliseconds
        easing: 'easeOutBounce' // Animation style
        },
        maintainAspectRatio:true,
        responsive:true,
        plugins:{
            legend:{
                display:true,
                position: 'bottom',      // moves it below the chart
                align: 'center',
                labels: {
                    boxWidth: 12,          // width of the color swatch
                    boxHeight: 12,         // height of the color swatch
                    font: {
                        size: 9           // text size
                    },
                    padding: 5,            // spacing between legend items
                    usePointStyle: false   // set true for circles instead of rectangles
                }
            }
        }
    }
})

}
</script>