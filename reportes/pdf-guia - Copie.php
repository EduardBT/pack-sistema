<?php
include_once '../vendor/autoload.php' ;
require_once '../dompdf/autoload.inc.php';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pack Express</title>
    <meta name="keywords" content="">
    <meta name="description" content="Gestión de Cheques">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    <!--iconos-->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
  .guia {
    text-align: left;
  }

  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }

  p {
    font-size: 14px;
  }

  hr {
    page-break-after: always;
    border: 0;
    margin: 0;
    padding: 0;
  }
  #image-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 300px;
    }
    #image-container img {
      max-width: 100%;
      max-height: 100%;
    }
</style>

</head>

<body>
   <div id="image-container">
    <img id="last-image" src="" alt="Last Image">
  </div>

  <script>
    // Replace with the actual directory path
    var directory = "/pack-sistema/reportes/phpqrcodemaster/temp/";

    var imageContainer = document.getElementById ("last-image");

    // Fetch the list of files in the directory
    fetch(directory)
      .then(response => response.text())
      .then(html => {
        var parser = new DOMParser();
        var doc = parser.parseFromString(html, "text/html");
        var fileList = doc.querySelectorAll("a");

        // Filter the files for image extensions
        var imageFiles = Array.from(fileList)
          .map(file => file.href)
          .filter(href => /\.(jpg|png|gif)$/i.test(href));

        // Get the last image file
        var lastImage = imageFiles.pop();

        if (lastImage) {
          imageContainer.src = lastImage;
        } else {
          imageContainer.alt = "No image found.";
        }
      })
      .catch(error => {
        imageContainer.alt = "Error occurred.";
        console.error(error);
      });
  </script> 