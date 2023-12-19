<?php get_header(); ?>

<section class="news">
    <div class="container">
        <div class="news_filter">
        <button class="news_filter-btn">Filter</button>
            <?php
                $taxonomy = 'genre'; // ваша таксономия
                $terms = get_terms($taxonomy);
                if (!empty($terms) && !is_wp_error($terms)) {
                    echo '<ul class="news_filter-list">';
                    foreach ($terms as $term) {
                        echo '<li data-term="' . esc_attr($term->slug) . '">' . $term->name . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'Термины не найдены.';
                }
            ?>
            
           
        </div>
        <div class="news_inner">          
            <?php 
                $args = array(
                    'post_type'      => 'news',
                    'posts_per_page' => 5,
                    'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
                );

                $wp_query = new WP_Query($args);

                if ($wp_query->have_posts()) :
                    while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <div class="news_item">
                            <h4><?= the_title(); ?></h4>
                        </div>
                    <?php endwhile; 
                    
                    

                    wp_reset_postdata(); 
                endif;
            ?>      
          
        </div>
        <button class="load-more-btn" id="load-more">Load More</button>
    </div>
</section>
<?php get_footer(); ?>	



