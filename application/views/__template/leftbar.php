<!-- #Top Bar -->
<section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url() ?>res/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $nama_member ?></div>
                    <div class="email"><?= $email_member ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?= base_url(). '/user/logout' ?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class=" <?= $title == HOME_TITLE ? 'active' : '' ?> ">
                        <a href="<?= base_url(). 'home' ?>">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class=" <?= $title == KEGIATAN_TITLE ? 'active' : '' ?> ">
                        <a href="<?= base_url(). 'kegiatan' ?>">
                            <i class="material-icons">date_range</i>
                            <span>Kegiatan</span>
                        </a>
                    </li>
                    <li class=" <?= $title == PANITIA_TITLE ? 'active' : '' ?> ">
                        <a href="<?= base_url(). 'panitia' ?>">
                            <i class="material-icons">group</i>
                            <span>Panitia</span>
                        </a>
                    </li>
                    <li class=" <?= $title == KRITERIA_TITLE ? 'active' : '' ?> ">
                        <a href="<?= base_url(). 'kriteria' ?>">
                            <i class="material-icons">toc</i>
                            <span>Kriteria</span>
                        </a>
                    </li>
                    <li class=" <?= $title == PENILAIAN_TITLE ? 'active' : '' ?> ">
                        <a href="<?= base_url(). 'kriteria' ?>">
                            <i class="material-icons">done</i>
                            <span>Penilaian</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>