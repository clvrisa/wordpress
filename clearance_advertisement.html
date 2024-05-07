<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot Deal of the Day!</title>
    <?php wp_head(); ?>
</head>
<body>

<div class="container">
    <h1>Hot Deal of the Day!</h1>
    
    <?php
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 1,
        'orderby'        => 'rand',
        'meta_query'     => array(
            array(
                'key'     => 'clearance_item',
                'value'   => 'yes',
                'compare' => '=',
            ),
        ),
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            global $product;
            ?>
            
            <div class="product">
                <h2><?php the_title(); ?></h2>
                <div class="product-image">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="product-price">
                    <?php echo $product->get_price_html(); ?>
                </div>
                <div class="product-description">
                    <?php the_excerpt(); ?>
                </div>
                <div class="product-link">
                    <a href="<?php the_permalink(); ?>" class="button">View Product</a>
                </div>
            </div>
            
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'No clearance products found.';
    endif;
    ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
