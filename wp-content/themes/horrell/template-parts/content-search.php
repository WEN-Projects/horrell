<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package horrell
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="col-sm-4">
				<?php
				the_post_thumbnail( 'medium' );
				?>
			</div>
			<div class="col-sm-8">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<p><?php the_excerpt(); ?></p>
				<a href="<?php the_permalink(); ?>" class="readmore">Continue Reading</a>
			</div>
			<hr>
		<?php } else { ?>
			<div class="col-sm-12">
				<div class="blog-title">
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				</div>
				<p><?php the_excerpt(); ?></p>
				<a href="<?php the_permalink(); ?>" class="readmore">Continue Reading</a>
			</div>
			<hr>
		<?php } ?>
	</div>

	<?php /*
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			horrell_posted_on();
			horrell_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php horrell_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php horrell_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	*/?>
</article><!-- #post-<?php the_ID(); ?> -->
