<?php

/**
 * FAQ Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$title    = get_field( 'title' );
$subtitle = get_field( 'subtitle' );

$list = get_field( 'list' );
if ( empty( $list ) ) {
	return;
} ?>

<div class="faq">
    <div class="container flex jbetween">
        <div class="faq__left">
			<?php if ( $subtitle ) { ?>
                <div class="block-subtitle"><?= $subtitle; ?></div>
			<?php } ?>
			<?php if ( $title ) { ?>
                <div class="block-title"><?= $title; ?></div>
			<?php } ?>
        </div>
        <div class="faq__right">
			<?php foreach ( $list as $item ) { ?>
                <div class="faq__item">
                    <div class="faq__item-title">
						<?= $item['title']; ?>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12H18" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M12 18V6" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="faq__item-body">
						<?= $item['text']; ?>
                    </div>
                </div>
			<?php } ?>
        </div>
    </div>
</div>
