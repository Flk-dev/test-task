<?php

/**
 * Text + Image Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$image = get_field( 'image' );

$subtitle = get_field( 'subtitle' );
$title = get_field( 'title' );
$advantages = get_field( 'advantages' );
$calculator_title = get_field( 'calculator_title' );

?>

<div class="calculate">
	<div class="container flex acenter">
		<?php if ( $image ) { ?>
			<img src="<?= $image; ?>" alt="">
		<?php } ?>
		<div class="calculate__content">
			<?php if ( $subtitle ) { ?>
				<div class="calculate__subtitle"><?= $subtitle; ?></div>
			<?php } ?>
			<?php if ( $title ) { ?>
				<div class="calculate__title"><?= $title; ?></div>
			<?php } ?>
			<?php if ( $advantages ) { ?>
				<div class="calculate__advantages flex acenter">
					<?php foreach ( $advantages as $advantage ) { ?>
						<div>
							<span><?= $advantage['number']; ?></span>
							<p><?= $advantage['text']; ?></p>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<div class="calculate__form">
				<?php if ($calculator_title){ ?>
					<div class="calculate__form-title"><?= $calculator_title; ?></div>
				<?php } ?>
				<form method="post">
					<div class="flex acenter">
						<input type="number" name="start" value="1200">
						<div class="select">
							<div class="select__result">
								<span>+</span>
								<svg width="18" height="9" viewBox="0 0 18 9" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M0.999966 0.999999L7.51997 7.52C8.28997 8.29 9.54997 8.29 10.32 7.52L16.84 1" stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="select__list">
								<div class="select__item" data-value="+">+</div>
								<div class="select__item" data-value="-">-</div>
								<div class="select__item" data-value="*">*</div>
								<div class="select__item" data-value="/">/</div>
							</div>
							<input type="hidden" name="operator" value="+">
						</div>
						<input type="number" name="end" value="1100">
					</div>
					<div class="calculate__result">
						Result: <span><?= task_calculate(1200, 1100, '+'); ?></span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
