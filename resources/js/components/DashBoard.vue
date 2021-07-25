<template>
   <div>
     <apexchart 
     height="500"
      type="bar" 
      :series="series"
     :options="chartOptions" 
     >
     </apexchart>
   </div>
</template>

<script>
export default {
    data: function() {
      return {
          chartOptions: {
            chart: {
              type: 'bar',
              height: 50,
              stacked: true,
              stackType: '100%'
            },
            responsive: [{
              breakpoint: 480,
              options: {
                legend: {
                  position: 'bottom',
                  offsetX: -9,
                  offsetY: 0
                }
              }
            }],
            xaxis: {
              categories: ['MIT', 'QA', 'ASSEMBLY', 'PRESS', 'TDM', 'WAREHOUSE',
                'QC', 'ADMIN','PC','PURCHASING','GA','ACCOUNTING','IS'
              ],
            },
            fill: {
              opacity: 1
            },
            legend: {
              position: 'top',
              offsetX: 0,
              offsetY: 20
            },
          },
        series: [{
            name: 'PRODUCTION',
            data: [44, 55, 41, 67, 22, 43, 21, 49, 50, 30, 40]
          }, {
            name: 'HOLD',
            data: [13, 23, 20, 8, 13, 27, 33, 12, 50, 30, 40]
          }, {
            name: 'DEVELOPMENT',
            data: [11, 17, 15, 15, 21, 14, 15, 13, 50, 30, 40]
          }],
      }
    },
};
</script>

