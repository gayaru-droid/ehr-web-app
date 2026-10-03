<!--Required Php Variabals

$charts=[
    ['id'=> 'chart1', 'name'=> 'Universal Graph', 'type'=> 'line', 'data'=> [1, 2, 3, 4, 5], 'labels'=>['A','B','C','D','E']],
    ['id'=> 'chart2', 'name'=> 'Universal Graph 2', 'type'=> 'bar', 'data'=> [5, 4, 3, 2, 1], 'labels'=> ['V','W','X','Y','Z']]
]
-->

<!DOCTYPE html>
<html lang="en">
<body>
    <?php foreach ($charts as $chart): ?>
    <div class='chart'>
        <canvas id="<?= $chart['id'] ?>"></canvas>
    </div>
    <?php endforeach; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        <?php
        foreach ($charts as $chart):?>
        const <?= $chart['id'] ?> = new Chart(document.getElementById('<?=$chart['id']?>'),{
            type: '<?=$chart['type']?>',
            data:{
                labels: <?= json_encode($chart['labels']) ?>,
                datasets:[{
                    label: '<?=$chart['name'][0]?>' ?? '',
                    data: <?= json_encode($chart['data'][0]) ?> ?? [],
                    fill: <?= json_encode($chart['fill'][0] ?? false) ?>,
                    borderColor: '<?=$chart['borderColor'][0] ?? 'rgba(75, 192, 192, 1)'?>',
                    backgroundColor: '<?=$chart['backgroundColor'][0] ?? 'rgba(75, 192, 192, 0.2)'?>',
                    tension: 0.4,
                    },
                    {
                    label: '<?=$chart['name'][1]?>' ?? '',
                    data: <?= json_encode($chart['data'][1]) ?> ?? [],
                    fill: <?= json_encode($chart['fill'][1] ?? false) ?>,
                    borderColor: '<?=$chart['borderColor'][1] ?? 'rgba(75, 192, 192, 1)'?>',
                    backgroundColor: '<?=$chart['backgroundColor'][1] ?? 'rgba(75, 192, 192, 0.2)'?>',
                    tension: 0.4,
                    }
            
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Allows it to fit your container's height/width
                plugins: {
                    legend: {
                        position: 'bottom', // Options: 'top', 'bottom', 'left', 'right'
                        //display: false // Uncomment this line if you want to hide the legend entirely
                        }
                    },
            scales: {
                y: {                            // <-- Add this 'y' scale object
                    beginAtZero: 0,          // <-- Forces the Y-axis to start at 0
                    ticks: {
                        precision: 0            // Optional: prevents decimal steps if your vitals are integers
                        }
                    },
                x: {
                    ticks: {
                        maxRotation: 45, // Tilts the dates so they don't crash into each other
                        minRotation: 45
                        }
                    }
                }
            }
        })
        <?php endforeach; ?>
    </script>
</body>
</html>