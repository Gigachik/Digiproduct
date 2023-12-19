<?php
    add_action('wp_ajax_filter_by_terms', 'filter_by_terms');
    add_action('wp_ajax_nopriv_filter_by_terms', 'filter_by_terms');

    function filter_by_terms() {
        $nonce = $_POST['nonce'];
        if (!wp_verify_nonce($nonce, 'filter-by-terms-nonce')) {
            die('No nonce found');
        }


        $terms = isset($_POST['terms']) ? $_POST['terms'] : array();
        $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
        $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : get_option('posts_per_page');

        $tax_query = array('relation' => 'OR');
        foreach ($terms as $term) {
            $tax_query[] = array(
                'taxonomy' => 'genre',
                'field'    => 'slug',
                'terms'    => $term,
            );
        }

        $args = array(
            'post_type'      => 'news',
            'tax_query'      => $tax_query,
            'posts_per_page' => $posts_per_page,
            'paged'          => $paged,
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ob_start();

            while ($query->have_posts()) {
                $query->the_post(); ?>
                <div class="news_item">
                    <h4><?= the_title(); ?></h4>
                </div>
            <?php }
            
            wp_reset_postdata();
            $content = ob_get_clean(); 
        } else {
            $content = 'No more posts found.';
        }

        $total_posts = $query->found_posts;
        wp_send_json_success(array('content' => $content, 'total_posts' => $total_posts));
    }

?>
