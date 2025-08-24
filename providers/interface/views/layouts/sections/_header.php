<?php

use yii\helpers\Url;
?> <header class="main_menu home_menu bg-info">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg navbar-light">
              <a class="navbar-brand" href="index.html">
                <img src="img/logo.jpeg"  style=" border-radius: 50%; /* Makes the logo fully round */
  width: 80px;        /* Adjust the width to make it smaller */
  height: 80px;       /* Adjust height to keep it proportional */
  object-fit: cover;  /* Ensures image fits within the rounded shape */"  alt="logo" />
              </a>
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="navbar-toggler-icon"></span>
              </button>

              <div
                class="collapse navbar-collapse main-menu-item justify-content-end"
                id="navbarSupportedContent"
              >
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/index']) ?>">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/about']) ?>">About</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/menu']) ?>">Menu</a>
                  </li>
                     <li class="nav-item">
    <a class="dropdown-item" href="<?= Url::to(['site/blog']) ?>">Blog</a>
                  </li>
              
                  <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact</a>
                  </li>
                </ul>
              </div>
              <div class="social_icon d-none d-lg-block">
                <a href="#" class="single_social_icon"
                  ><i class="fab fa-facebook-square"></i
                ></a>
                <a href="#" class="single_social_icon"
                  ><i class="fab fa-instagram"></i
                ></a>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>