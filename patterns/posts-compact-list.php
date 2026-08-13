<?php
/**
 * Title: Posts: Compact List
 * Slug: modern-catholic/posts-compact-list
 * Categories: posts
 * Description: A compact archive list with title, author, date, excerpt, and pagination.
 * Block Types: core/query
 */
?>
<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","className":"church-post-list"} -->
<div class="wp-block-query alignwide church-post-list">
	<!-- wp:post-template -->
		<!-- wp:group {"style":{"border":{"bottom":{"color":"var:preset|color|border-subtle","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--border-subtle);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
			<!-- wp:post-title {"isLink":true,"level":2} /-->
			<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"fontSize":"small"} -->
			<div class="wp-block-group has-small-font-size">
				<!-- wp:post-author {"showAvatar":false,"byline":"By"} /-->
				<!-- wp:post-date /-->
			</div>
			<!-- /wp:group -->
			<!-- wp:post-excerpt {"moreText":"Read more"} /-->
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
