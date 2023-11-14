<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diabetes Prediction Form</title>
</head>

<body>
    <h2>Diabetes Prediction Form</h2>
    <form method="get" action="Submit.php">

        <label for="arg_pregnant">Pregnancies:</label>
        <input type="text" name="arg_pregnant" ><br>

        <label for="arg_glucose">Glucose:</label>
        <input type="text" name="arg_glucose" ><br>

        <label for="arg_pressure">Blood Pressure:</label>
        <input type="text" name="arg_pressure" ><br>

        <label for="arg_triceps">Triceps Thickness:</label>
        <input type="text" name="arg_triceps" ><br>

        <label for="arg_insulin">Insulin Level:</label>
        <input type="text" name="arg_insulin" ><br>

        <label for="arg_mass">Body Mass Index:</label>
        <input type="text" name="arg_mass" ><br>

        <label for="arg_pedigree">Diabetes Pedigree Function:</label>
        <input type="text" name="arg_pedigree" ><br>

        <label for="arg_age">Age:</label>
        <input type="text" name="arg_age" ><br>

        <button type="submit">Predict Diabetes</button>

    </form>
    <?php
    if (isset($_POST['submit'])) {
        // Process form data
        $apiUrl = 'http://127.0.0.1:5022/diabetes';

        // Extracting values from the form
        $params = array(
            'arg_pregnant' => $_POST['arg_pregnant'],
            'arg_glucose' => $_POST['arg_glucose'],
            'arg_pressure' => $_POST['arg_pressure'],
            'arg_triceps' => $_POST['arg_triceps'],
            'arg_insulin' => $_POST['arg_insulin'],
            'arg_mass' => $_POST['arg_mass'],
            'arg_pedigree' => $_POST['arg_pedigree'],
            'arg_age' => $_POST['arg_age']
        );

        // Initiate a new cURL session/resource
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $apiUrl = $apiUrl . '?' . http_build_query($params);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);

        // Make a GET request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            // Handle the error appropriately
            die("cURL Error: $error");
        }

        // Close cURL session/resource
        curl_close($curl);

        // Process the response
        $data = json_decode($response, true);

        // Check if the response was successful
        if (isset($data['0'])) {
            // API request was successful
            // Access the data returned by the API
            echo "<br>The predicted diabetes status is:<br>";
            foreach ($data as $repository) {
                echo $repository['0'], $repository['1'], $repository['2'], "<br>";
            }
        } else {
            // API request failed or returned an error
            echo "API Error: " . $data['message'];
        }
    }
    ?>

</body>
</html>