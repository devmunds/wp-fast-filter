<article class="filter-post-wrap">                            
    <h2 class="entry-title"><a href="' <?php echo  get_post_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
    <?php the_excerpt(); ?> 
    <div class="align-right"><span>Publicado: <?php echo get_the_date(); ?></span></div>                      
</article>