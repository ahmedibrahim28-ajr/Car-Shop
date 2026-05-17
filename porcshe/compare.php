<?php
require "../db_connection.php";

// Get car ID from the request
$car_name = $_GET['car_name'];  // For example: '911 Carrera'

$conn = get_db_connection();

// Query to fetch car details based on car name
$query = "
    SELECT cm.car_name, cm.topspeed, cm.horsepower, cm.price, cmi.car_model_image
    FROM car_model cm
    LEFT JOIN car_model_image cmi ON cm.car_model_images_id = cmi.id
    WHERE cm.car_name = '$car_name'
";

$result = mysqli_query($conn, $query);

if ($result) {
    $car = mysqli_fetch_assoc($result);
    echo json_encode($car);  // Return car data as JSON
} else {
    echo json_encode(['error' => 'Car not found']);
}

close_db_connection($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="compare.css">
  <title>Car Comparison</title>
</head>

<body>
  <header id="compare-header">
    <div class="content">
      <img src="./Porsche-logo.png" alt="Porsche Logo" class="logo">
      <h1>Compare Cars</h1>
      <p>Select two cars to compare between</p>
    </div>
  </header>

  <section id="compare-section">
    <div class="compare-container">
      <form id="compare-form">
        <h2>Choose Cars</h2>

        <div class="dropdowns">
          <div class="dropdown">
            <label for="car1">Select Car 1</label>
            <select id="car1" name="car1">
              <option value="" disabled selected>Choose a car</option>
              <option value="911 Carrera">Porsche 911 Carrera</option>
              <option value="Taycan">Porsche Taycan</option>
              <option value="Macan">Porsche Macan</option>
              <option value="Cayenne">Porsche Cayenne</option>
            </select>
          </div>

          <div class="dropdown">
            <label for="car2">Select Car 2</label>
            <select id="car2" name="car2">
              <option value="" disabled selected>Choose a car</option>
              <option value="911 Carrera">Porsche 911 Carrera</option>
              <option value="Taycan">Porsche Taycan</option>
              <option value="Macan">Porsche Macan</option>
              <option value="Cayenne">Porsche Cayenne</option>
            </select>
          </div>
        </div>

        <button type="button" class="btn btn-primary" onclick="compareCars()">Compare</button>
      </form>

      <div id="comparison-result">
        <h2>Comparison Result</h2>
        <div class="cards">
          <div id="car1-details" class="card"></div>
          <div id="car2-details" class="card"></div>
        </div>
      </div>
    </div>
  </section>

  <footer id="footer">
    <p>© 2024 Porsche Official. All Rights Reserved.</p>
  </footer>

  <script>
    const carData = {
      "911 Carrera": {
        name: "Porsche 911 Carrera",
        engine: "3.0L Twin-Turbocharged Boxer-6",
        horsepower: "379 hp",
        price: "$106,100",
        image: "./img/porsche-normal(1).webp"
      },
      Taycan: {
        name: "Porsche Taycan",
        engine: "Electric",
        horsepower: "402 hp",
        price: "$90,900",
        image: "./img/Porche taycaan.jpg"
      },
      Macan: {
        name: "Porsche Macan",
        engine: "2.0L Turbocharged Inline-4",
        horsepower: "261 hp",
        price: "$57,500",
        image: "./img/macan.png"
      },
      Cayenne: {
        name: "Porsche Cayenne",
        engine: "3.0L Turbocharged V6",
        horsepower: "355 hp",
        price: "$79,200",
        image: "./img/newcayenne.jpg"
      }
    };

    function compareCars() {
      const car1 = document.getElementById("car1").value;
      const car2 = document.getElementById("car2").value;

      const car1Details = document.getElementById("car1-details");
      const car2Details = document.getElementById("car2-details");

      if (!car1 || !car2) {
        alert("Please select two cars to compare!");
        return;
      }

      const car1Data = carData[car1];
      const car2Data = carData[car2];

      car1Details.innerHTML = `
        <img src="${car1Data.image}" alt="${car1Data.name}">
        <h3>${car1Data.name}</h3>
        <p><strong>Engine:</strong> ${car1Data.engine}</p>
        <p><strong>Horsepower:</strong> ${car1Data.horsepower}</p>
        <p><strong>Price:</strong> ${car1Data.price}</p>
      `;

      car2Details.innerHTML = `
        <img src="${car2Data.image}" alt="${car2Data.name}">
        <h3>${car2Data.name}</h3>
        <p><strong>Engine:</strong> ${car2Data.engine}</p>
        <p><strong>Horsepower:</strong> ${car2Data.horsepower}</p>
        <p><strong>Price:</strong> ${car2Data.price}</p>
      `;
    }
  </script>
</body>

</html>
