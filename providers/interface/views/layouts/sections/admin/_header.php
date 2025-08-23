<?php
use yii\helpers\Url;

$basePath = \yii::$app->request->baseUrl . '/providers/interface/assets/admin/';
?>

<header class="main_menu home_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="<?= Url::to(['/site/index']) ?>">
                        <img src="<?= $basePath ?>assets/img/logo.png" alt="Logo" class="img-fluid" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/home-sections/index']) ?>">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/site/about']) ?>">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/menu/index']) ?>">Menu</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="<?= Url::to(['/blog/index']) ?>" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Blog
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?= Url::to(['/blog/index']) ?>">Blog</a>
                                    <a class="dropdown-item" href="<?= Url::to(['/blog/view', 'id' => 1]) ?>">Single blog</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/contact/index']) ?>">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="social_icon d-none d-lg-block">
                        <a href="#" class="single_social_icon"><i class="fab fa-facebook-square"></i></a>
                        <a href="#" class="single_social_icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
