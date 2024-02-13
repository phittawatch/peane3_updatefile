// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Function to fetch data from PHP script using AJAX
function fetchDataAndUpdateChart() {
    // AJAX request
    $.ajax({
        url: 'fetch_data.php', // PHP script URL
        type: 'GET',
        dataType: 'json', // Data type expected from the server
        success: function(data) {
            // Update the chart with fetched data
            updateChart(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

// Function to update the pie chart with fetched data
function updateChart(data) {
  // Extract numerical values from the data object
  var downCount = parseInt(data.down_count);
  var upCount = parseInt(data.up_count);

  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels: ["Down Switches", "Up Switches"],
          datasets: [{
              data: [downCount, upCount], // Use the numerical values here
              backgroundColor: ['red', '#1cc88a'], // Adjusted colors
              hoverBackgroundColor: ['black', '#17a673'], // Adjusted hover colors
          }],
      },
      options: {
          maintainAspectRatio: false,
          tooltips: {
              backgroundColor: "rgba(0, 0, 0, 0.8)", // Adjusted tooltip background color
              bodyFontColor: "#fff", // Adjusted tooltip font color
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
          },
          legend: {
              display: true, // Show legend
              position: 'bottom', // Position of the legend
          },
          cutoutPercentage: 70, // Adjusted cutout percentage
      },
  });
}


// Call the function to fetch data and update chart on page load
fetchDataAndUpdateChart();
