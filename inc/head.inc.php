<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PHP Kundenverwaltung">
    <meta name="author" content="Fabian Gläßer">
    <title>Kundenverwaltung</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

</head>

<body class="d-flex text-center text-white bg-dark">

    <div class="cover-container d-flex w-100 p-3 mx-auto flex-column">
        <header class="mb-auto d-flex flex-column">
            <div>
                <h3 class="float-md-start"><a class="nav-link active" aria-current="page" href="index.php">Kundenverwaltung</a></h3>
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    <?php
                    logout();
                    login($db);
                    ?>