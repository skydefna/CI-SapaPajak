<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <?php $uri = service('uri'); ?>

    <?php
    // =========================================================
    // CURRENT URL
    // =========================================================
    $currentController = strtolower($uri->getSegment(1));
    $currentMethod     = strtolower($uri->getSegment(2));

    // =========================================================
    // DASHBOARD
    // =========================================================
    $dashboardMenu = null;

    // =========================================================
    // GROUP MENU
    // =========================================================
    $groupedMenus = [];

    foreach ($menus as $m) {

        // dashboard dipisah
        if (strtolower($m['menu']) == 'dashboard') {

            $dashboardMenu = $m;
            continue;
        }

        $group = $m['group_label'] ?: 'MENU';

        $groupedMenus[$group][] = $m;
    }
    ?>

    <!-- =========================================================
         LOGO
    ========================================================== -->
    <div class="text-center mb-4 mt-4">

        <a href="<?= base_url('/') ?>"
           class="display-6 fw-bold">

            <span class="text-secondary">Sapa</span><span class="text-primary">Pajak</span>      

        </a>

        <br>

        <small>
            Sarana Pendaftaran Konsultasi Pajak
        </small>

    </div>

    <!-- =========================================================
         MENU
    ========================================================== -->
    <ul class="menu-inner py-1">

        <!-- =====================================================
             DASHBOARD (TANPA DROPDOWN)
        ====================================================== -->

        <?php if ($dashboardMenu) : ?>

            <?php
            $dashboardActive =
                (
                    $currentController ==
                    strtolower($dashboardMenu['controllers'])
                    &&
                    $currentMethod ==
                    strtolower($dashboardMenu['url'])
                );
            ?>

            <li class="menu-item mb-2 <?= $dashboardActive ? 'active' : '' ?>">

                <a href="<?= site_url(
                                $dashboardMenu['controllers']
                                . '/'
                                . $dashboardMenu['url']
                            ) ?>"
                   class="menu-link">

                    <i class="menu-icon tf-icons <?= esc($dashboardMenu['icon']); ?>"></i>

                    <div><?= esc($dashboardMenu['menu']); ?></div>

                </a>

            </li>

        <?php endif; ?>

        <!-- =====================================================
             GROUP DROPDOWN
        ====================================================== -->

        <?php foreach ($groupedMenus as $group => $groupMenus) : ?>

            <?php
            // =====================================================
            // GROUP ACTIVE
            // =====================================================
            $groupActive = false;

            foreach ($groupMenus as $gm) {

                if (
                    $currentController ==
                    strtolower($gm['controllers'])
                    &&
                    $currentMethod ==
                    strtolower($gm['url'])
                ) {

                    $groupActive = true;
                    break;
                }

                // cek submenu
                $groupSubs = array_filter(
                    $submenus,
                    function ($s) use ($gm) {
                        return
                            $s['id_menu'] == $gm['id']
                            &&
                            $s['aktif'] == 1;
                    }
                );

                foreach ($groupSubs as $gs) {

                    if (
                        $currentMethod ==
                        strtolower($gs['url'])
                    ) {

                        $groupActive = true;
                        break 2;
                    }
                }
            }
            ?>

            <!-- =====================================================
                 GROUP
            ====================================================== -->

            <li class="menu-item mb-2 <?= $groupActive ? 'open active' : '' ?>">

                <!-- TOGGLE -->
                <a href="javascript:void(0);"
                   class="menu-link menu-toggle">

                    <div class="text-uppercase fw-bold small">

                        <?= esc($group) ?>

                    </div>

                </a>

                <!-- =====================================================
                     GROUP CONTENT
                ====================================================== -->

                <ul class="menu-sub">

                    <?php foreach ($groupMenus as $menu) : ?>

                        <?php
                        // =================================================
                        // SUBMENU
                        // =================================================
                        $menuSubs = array_filter(
                            $submenus,
                            function ($s) use ($menu) {

                                return
                                    $s['id_menu'] == $menu['id']
                                    &&
                                    $s['aktif'] == 1;
                            }
                        );

                        // =================================================
                        // SUB ACTIVE
                        // =================================================
                        $isSubActive = false;

                        foreach ($menuSubs as $sub) {

                            if (
                                $currentMethod ==
                                strtolower($sub['url'])
                            ) {

                                $isSubActive = true;
                                break;
                            }
                        }

                        // =================================================
                        // MENU ACTIVE
                        // =================================================
                        $isActive =
                            (
                                $currentController ==
                                strtolower($menu['controllers'])
                                &&
                                $currentMethod ==
                                strtolower($menu['url'])
                            )
                            || $isSubActive;
                        ?>

                        <!-- =============================================
                             MENU
                        ============================================== -->

                        <li class="menu-item <?= $isActive ? 'active open' : '' ?>">

                            <?php if (!empty($menuSubs)) : ?>

                                <!-- =====================================
                                     WITH SUBMENU
                                ====================================== -->

                                <a href="javascript:void(0);"
                                   class="menu-link menu-toggle">

                                    <i class="menu-icon tf-icons <?= esc($menu['icon']); ?>"></i>

                                    <div>

                                        <?= esc($menu['menu']); ?>

                                    </div>

                                </a>

                                <!-- SUBMENU -->
                                <ul class="menu-sub">

                                    <?php foreach ($menuSubs as $sub) : ?>

                                        <?php
                                        $isSub =
                                            (
                                                $currentMethod ==
                                                strtolower($sub['url'])
                                            );
                                        ?>

                                        <li class="menu-item <?= $isSub ? 'active' : '' ?>">

                                            <a href="<?= site_url(
                                                            $menu['controllers']
                                                            . '/'
                                                            . $sub['url']
                                                        ) ?>"
                                               class="menu-link">

                                                <div>

                                                    <?= esc($sub['subMenu']); ?>

                                                </div>

                                            </a>

                                        </li>

                                    <?php endforeach; ?>

                                </ul>

                            <?php else : ?>

                                <!-- =====================================
                                     WITHOUT SUBMENU
                                ====================================== -->

                                <a href="<?= site_url(
                                                $menu['controllers']
                                                . '/'
                                                . $menu['url']
                                            ) ?>"
                                   class="menu-link">

                                    <i class="menu-icon tf-icons <?= esc($menu['icon']); ?>"></i>

                                    <div>

                                        <?= esc($menu['menu']); ?>

                                    </div>

                                </a>

                            <?php endif; ?>

                        </li>

                    <?php endforeach; ?>

                </ul>

            </li>

        <?php endforeach; ?>

    </ul>

</aside>