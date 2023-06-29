<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $apiKey = "85AvEwrm7eF5rFSpEoM4sW1W";

    
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        
        $endpoint = "https://api.remove.bg/v1.0/removebg";

        
        $file = $_FILES["image"]["tmp_name"];

        
        $curl = curl_init();

       
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "X-Api-Key: " . $apiKey
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            "image_file" => new CURLFILE($file)
        ]);

        
        $result = curl_exec($curl);

       
        if ($result !== false) {
            
            $outputFile = "output.png";
            file_put_contents($outputFile, $result);

            
            echo "<h2>Processed Image:</h2>";
            echo "<img src='$outputFile' alt='Processed Image'>";

            
            echo "<h2>Download:</h2>";
            echo "<a href='$outputFile' download>Download Processed Image</a>";
        } else {
            
            echo "An error occurred: " . curl_error($curl);
        }

        
        curl_close($curl);
    } else {
        
        echo "Please upload an image file.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Background Removal</title>
    <script>
        function scrollToTop() {
            window.scrollTo(0, 0);
        }
    </script>
</head>
<body>
    <h2>Upload an image and remove the background</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*">
        <input type="submit" value="Process">
    </form>
</body>
</html>
