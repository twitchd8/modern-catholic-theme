<?php
/**
 * Title: Posts: Card Grid
 * Slug: twitch3d-modern-catholic/posts-card-grid
 * Categories: posts
 * Description: A responsive post-card grid with featured image, title, author, date, excerpt, and pagination.
 * Block Types: core/query
 */
?>
<!-- wp:query {"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","className":"church-post-card-grid"} -->
<div class="wp-block-query alignwide church-post-card-grid">
	<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
		<!-- wp:group {"className":"church-post-card","style":{"border":{"color":"currentColor","width":"1px","radius":"0.75rem"},"spacing":{"blockGap":"0","padding":{"bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group church-post-card has-border-color" style="border-color:currentColor;border-width:1px;border-radius:0.75rem;padding-bottom:var(--wp--preset--spacing--40)">
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","style":{"border":{"radius":{"topLeft":"0.75rem","topRight":"0.75rem"}}}} /-->
			<!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|40","left":"var:preset|spacing|40","top":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"large"} /-->
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"fontSize":"small"} -->
				<div class="wp-block-group has-small-font-size">
					<!-- wp:post-author {"showAvatar":false,"byline":"By"} /-->
					<!-- wp:post-date /-->
				</div>
				<!-- /wp:group -->
				<!-- wp:post-excerpt {"moreText":""} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->
	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p>No posts have been published yet.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
	<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
