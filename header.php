<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo( 'rdf_url' ); ?>"/>
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo( 'rss_url' ); ?>"/>
    <link rel="alternate" type="application/rss+xml" title="Comments RSS"
          href="<?php bloginfo( 'comments_rss2_url' ); ?>"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <title>
		<?php
		global $page, $paged;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			echo " | $site_description";
		}
		if ( $paged >= 2 || $page >= 2 ) {
			echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
		}
		?>
    </title>
	<?php wp_head(); ?>
</head>
<body>

<div class="header">
    <div class="container flex acenter jbetween">
        <div class="header__left flex acenter">
            <a href="/" class="header__logo logo">
                <span></span>
                SAFARI
            </a>
			<?php
			wp_nav_menu( [
				'theme_location' => 'header-menu',
				'container'      => '',
				'menu_class'     => 'header__menu',
				'depth'          => 0,
			] );
			?>
        </div>
        <a href="#" class="btn-default header__button">Book a tour</a>
        <a href="#" class="header__mobile_toggle">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 7H21" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M3 12H21" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M3 17H21" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </a>
    </div>
</div>