async function ajaxBarChart() {
  let url = `json.php`; /* name of the JSON file */
  try {
    const response = await fetch(url, {
      method: `POST`,
      headers: {
        'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8',
      },
    });

    updateWebpage(await response.json());
  } catch (error) {
    console.log('Fetch failed: ', error);
  }

  /* use the fetched data to change the content of the webpage */
  function updateWebpage(jsonData) {
    let label = [];
    let nums = [];

    jsonData.map((obj) => {
      label.push(obj.name);
    });
    jsonData.map((obj) => {
      nums.push(obj.Inventory);
    });

    let nums2 = [...label];

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: label,
        datasets: [
          {
            label: '# of Votes',
            data: nums,
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)',
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
            },
          ],
        },
      },
    });
  }
}
