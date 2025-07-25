<?php

use Yii;
use yii\helpers\Url;

$basePath = \yii::$app->request->baseUrl . '/providers/interface/assets/admin/';
?>
<div class="header header-one">
    <a href="index.html"
        class="d-inline-flex d-sm-inline-flex align-items-center d-md-inline-flex d-lg-none align-items-center device-logo">
        <img src="assets/img/logo.png" class="img-fluid logo2" alt="Logo" />
    </a>
    <div class="main-logo d-inline float-start d-lg-flex align-items-center d-none d-sm-none d-md-none">
        <div class="logo-white">
            <a href="index.html">
                <img src="<?= $basePath ?>assets/img/logo-full-white.png" class="img-fluid logo-blue" alt="Logo" />
            </a>
            <a href="index.html">
                <img src="<?= $basePath ?>assets/img/logo-small-white.png" class="img-fluid logo-small" alt="Logo" />
            </a>
        </div>
        <div class="logo-color">
            <a href="<?= Url::to(['home/index']) ?>">
                <img src="<?= $basePath ?>assets/img/logo.png" class="img-fluid logo-blue" alt="Logo" />
            </a>
            <a href="<?= Url::to(['home/index']) ?>">
                <img src="<?= $basePath ?>assets/img/logo-small.png" class="img-fluid logo-small" alt="Logo" />
            </a>
        </div>
    </div>
    <!-- Sidebar Toggle -->
    <a href="javascript:void(0);" id="toggle_btn">
        <span class="toggle-bars">
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
        </span>
    </a>
    <!-- /Sidebar Toggle -->


    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->

    <!-- Header Menu -->
    <ul class="nav nav-tabs user-menu">
        <li class="nav-item dropdown flag-nav dropdown-heads">
            <a class="nav-link" data-bs-toggle="dropdown" href="index.html#" role="button">
                <i class="fa-regular fa-bell icon"></i>
                <span class="badge rounded-pill"></span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <div class="notification-title">
                        Notifications <a href="notifications.html">View all</a>
                    </div>
                    <a href="javascript:void(0)" class="clear-noti d-flex align-items-center">Mark all as read <i
                            class="fe fe-check-circle"></i></a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="profile.html">
                                <div class="d-flex">
                                    <span class="avatar avatar-md active">
                                        <img class="avatar-img rounded-circle" alt="avatar-img"
                                            src="<?= $basePath ?>assets/img/profiles/avatar-02.jpg" />
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details">
                                            <span class="noti-title">Lex Murphy</span> requested
                                            access to
                                            <span class="noti-title">UNIX directory tree hierarchy</span>
                                        </p>
                                        <div class="notification-btn">
                                            <span class="btn btn-primary">Accept</span>
                                            <span class="btn btn-outline-primary">Reject</span>
                                        </div>
                                        <p class="noti-time">
                                            <span class="notification-time">Today at 9:42 AM</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="profile.html">
                                <div class="d-flex">
                                    <span class="avatar avatar-md active">
                                        <img class="avatar-img rounded-circle" alt="avatar-img"
                                            src="<?= $basePath ?>assets/img/profiles/avatar-10.jpg" />
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details">
                                            <span class="noti-title">Ray Arnold</span> left 6
                                            comments
                                            <span class="noti-title">on Isla Nublar SOC2 compliance report</span>
                                        </p>
                                        <p class="noti-time">
                                            <span class="notification-time">Yesterday at 11:42 PM</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="index.html#">Clear All</a>
                </div>
            </div>
        </li>
        <li class="nav-item has-arrow dropdown-heads">
            <a href="javascript:void(0);" class="win-maximize">
                <i class="fa-solid fa-compress"></i>
            </a>
        </li>
        <!-- User Menu -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="user-link nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img src="<?= $basePath ?>assets/img/profiles/avatar-07.jpg" alt="img" class="profilesidebar" />
                    <span class="animate-circle"></span>
                </span>
                <span class="user-content">
                    <span class="user-name"><?= ucfirst(Yii::$app->user->identity->username) ?></span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilemenu">
                    <div class="subscription-menu">
                        <ul>
                            <li>
                                <a class="dropdown-item" href="profile.html">Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="settings.html">Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subscription-logout">
                        <ul>
                            <li class="pb-0">
                                <a class="dropdown-item" href="<?= Url::to(['iam/logout']) ?>">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
        <!-- /User Menu -->
    </ul>

    <!-- /Header Menu -->
</div>