<?php 
?>
<html>
<head>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.esm.js" integrity="sha512-IPqefcmFCuGcYxl/uIjvyCXwh5T9+EB2MFT7W9RUZd20d7PLfgdT975xdhyesvdXH6Au8SyXOw1236LY1lFl5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.esm.min.js" integrity="sha512-2Vi/lCX8NaXlAhzc28RAoteYAiJVoz4y3Xq/IpHQCw7KU25I34fDqJSVSUml2tQRVYFnf3IMy6O59zKJh79hiw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.js" integrity="sha512-b3xr4frvDIeyC3gqR1/iOi6T+m3pLlQyXNuvn5FiRrrKiMUJK3du2QqZbCywH6JxS5EOfW0DY0M6WwdXFbCBLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/helpers.esm.js" integrity="sha512-/2SCtwX/TWXQ8kJN8MhCXL5GQJkBhh5J184Uy/totMp+1pFXTQhV/hMMYHuSl+juR5WO9i11AvywRgYFotRIug==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/helpers.esm.min.js" integrity="sha512-b3xZ1Eh852+/Ltha4XJd59YP2d+I+B6NPdB4H+Wns29GX9x5pLwlp8jnQtJYog3d5Xk1SWvhT2lgJDDBvpV0ow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
-->
</head>
<body>
<div >
<canvas id="myChart" width="200" height="200"></canvas>
</div>
<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>