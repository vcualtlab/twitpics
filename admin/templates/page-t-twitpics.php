<?php 
/*
 Template Name: ALT Lab Twitpics
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div class="content">

				<div class="inner-content">

					<main class="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title"><?php the_title(); ?></h1>

								</header>

								<section class="entry-content" itemprop="articleBody">
									<?php
										the_content();
									?>
								</section>

							</article>

							<?php endwhile; ?>

							<?php endif; ?>


							<?php 
							// Run a new query for the twitpics
							
							$args = array(
								'post_type' => 'twitpic',
								'post_per_page' => 20
							);

							$the_query = new WP_Query( $args );

							// The Loop
							if ( $the_query->have_posts() ) : ?>

								<div class="masonry">
								  <div class="grid-sizer"></div>
							
							<?php
							while ( $the_query->have_posts() ) : $the_query->the_post();
							?>
	
								  <div class="brick">
								  	<?php
										if ( has_post_thumbnail() ) {
											the_post_thumbnail('large');
											the_content();
										}
									?>
								  </div>
	
							<?php
							endwhile;
							?>
								</div>
							<?php 
							endif;
							wp_reset_postdata();	
							?>

						</main>

						<?php get_sidebar(); ?>

				</div>

			</div>


<?php get_footer(); ?>
