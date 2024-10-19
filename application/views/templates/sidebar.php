<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? '' : 'collapsed' ?>" href="<?= site_url('dashboard') ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <?php if ($this->session->userdata('role') == 'admin') : ?>
                <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= site_url('siswa') ?>">
                            <i class="bi bi-circle"></i><span>Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('user') ?>">
                            <i class="bi bi-circle"></i><span>User</span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>

            <?php if ($this->session->userdata('role') == 'bendahara') : ?>
                <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= site_url('siswa') ?>">
                            <i class="bi bi-circle"></i><span>Siswa</span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
            <a class="nav-link <?= $this->uri->segment(1) == 'periode' ? '' : 'collapsed' ?>" href="<?= site_url('periode') ?>">
                <i class="bi bi-bar-chart"></i><span>Kas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'setting' ? '' : 'collapsed' ?>" href="<?= site_url('user/setting') ?>">
                <i class="bi bi-menu-button-wide"></i><span>Setting</span>
            </a>
        </li><!-- End Charts Nav -->
    </ul>

</aside><!-- End Sidebar-->