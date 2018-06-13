<?php wp_head(); ?>

<?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
?>

<?php wp_footer(); ?>