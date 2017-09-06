<form action="<?php echo home_url( '/' ); ?>" method="get" class="form-inline panel-body">
    <fieldset>
		<div class="input-group">
			<div class="input-group-addon"><i class="fa fa-search"></i></div>
			<input type="text" name="s" id="search" placeholder="<?php echo esc_attr__( 'Keywords' ); ?>" value="<?php the_search_query(); ?>" />
			<span class="input-group-btn">
				<button type="submit"><?php echo esc_attr__( 'Search' ); ?></button>
			</span>
		</div>
    </fieldset>
</form>
