
<header>
    <div class="inner">
        <nav class="navigation">
            <div class="container"><a href="<?php print $base_path; ?>" class="logo"><img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>" class="img-responsive"/></a>

                <button class="navbar-toggle" type="button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                <div class="menu-right-block">            
                    <?php print render($page['thu_custom_search']); ?>
                    <div class="basket hidden"><a href="javascript:;" class="wi-icon wi-icon-basket hidden"><?php print t('Basket'); ?></a><a href="javascript:;" class="number-product">0</a>
                    </div>
                </div>
                <div class="main-menu">
                    <?php print render($page['main_menu']); ?>
                    <div class="header-top background-dark-gray clearfix">
                        <div class="container">
                            <?php print render($page['menu_top_menu']); ?>
                        </div>
                    </div>
                </div>

            </div>
        </nav>
    </div>
</header>