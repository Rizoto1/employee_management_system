<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <script src="<?= $link->asset('js/script.js') ?>"></script>
</head>
<body>
<div class="container-fluid vh-100">
    <div class="row h-100 flex-nowrap"> <!-- h-100 - to have sidebar and others full height, flex-nowrap - helped with fixed topbar -->

        <!-- SIDEBAR -->
        <div class="col-2 bg-dark text-white p-3 d-flex flex-column align-items-center">

            <a href="<?= $link->url("employee.index")?>">
                <button type="button" class="btn btn-primary m-2">Home</button>
            </a>

            <button type="button" class="btn btn-primary m-2">Home</button>
            <button type="button" class="btn btn-primary m-2">Home</button>
            <button type="button" class="btn btn-primary m-2">Home</button>
            <button type="button" class="btn btn-primary m-2">Home</button>
            <button type="button" class="btn btn-primary m-2">Home</button>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-10 d-flex flex-column p-0">

            <!-- TOPBAR -->
            <div class="bg-secondary text-white p-3">
                <nav class="navbar navbar-expand-sm bg-light">
                    <div class="container-fluid">
                        <?php if ($user->isLoggedIn()) { ?>
                            <span class="navbar-text">Logged in user: <b><?= $user->getName() ?></b></span>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $link->url('auth.logout') ?>">Log out</a>
                                </li>
                            </ul>
                        <?php } else { ?>
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= App\Configuration::LOGIN_URL ?>">Log in</a>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                </nav>
            </div>

            <!-- CONTENT -->
            <div class="flex-grow-1 overflow-auto p-3">
                <div class="web-content">
                    <?= $contentHTML ?>
                </div>
            </div>

        </div>

    </div>
</div>
</body>
</html>
