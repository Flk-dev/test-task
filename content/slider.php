<?php

/**
 * Slider Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$field = get_field( 'slider' );
if ( empty( $field ) ) {
	return;
} ?>

<div class="slider">
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php foreach ( $field as $item ) { ?>
				<div class="swiper-slide">
					<div class="slider__item" style="background-image: url(<?= $item['image']; ?>)">
						<div class="slider__content">
							<div class="container">
								<?php if ( $item['title'] ) { ?>
									<div class="slider__title"><?= $item['title']; ?></div>
								<?php } ?>
								<?php if ( $item['text'] ) { ?>
									<div class="slider__text"><?= $item['text']; ?></div>
								<?php } ?>
								<a href="#" class="btn-default _white slider__button"><?= ( $item['button'] ? $item['button'] : 'Book a tour' ); ?></a>
								<?php if ( $item['advantages'] ) { ?>
									<ul class="slider__advantages">
										<?php foreach ( $item['advantages'] as $advantage ) { ?>
											<li><?= $advantage['title']; ?></li>
										<?php } ?>
									</ul>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="slider__nav flex">
		<div class="slider__nav-scroll">
			<span class="_start">01</span>
			<div class="slider__nav-line"><div></div></div>
			<span class="_end">03</span>
		</div>
		<div class="slider__nav-arrows">
			<div class="swiper-button-prev">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15 19.92L8.48003 13.4C7.71003 12.63 7.71003 11.37 8.48003 10.6L15 4.07996" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
			<div class="swiper-button-next">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M8.91 19.92L15.43 13.4C16.2 12.63 16.2 11.37 15.43 10.6L8.91 4.07996" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
	</div>
</div>