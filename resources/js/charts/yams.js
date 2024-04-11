import Chart from 'chart.js/auto';
import axios from 'axios';

if ($('#winner').length > 0) axios.get($('#winner').data('url'))
  .then(response => {
    const data = response.data;
    const ctx = $('#winner').get(0).getContext('2d');

    if (ctx) new Chart(ctx, {
      type: $('#winner').data('type'),
      options: {
        scales: {
          y: {
            border: { display: false },
            grid: { display: false }
          },
          x: {
            border: { display: false },
            grid: { display: false }
          },
        },
        responsive: true,
        plugins: {
          legend: { display: false },
          title: { display: false },
        }
      },
      data: {
        labels: data.length > 0 ? data.map(row => row.name) : [],
        datasets: [{
          label: $('#winner').data('label'),
          data: data.length > 0 ? data.map(row => row.count) : [],
          backgroundColor: data.length > 0 ? data.map(row => row.color) : [],
        }]
      }
    });
  })
  .catch(error => {
    console.error('Error fetching chart data:', error);
  });