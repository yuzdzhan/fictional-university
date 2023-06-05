<?php

get_header();
pageBanner([
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world.'
]);
?>

<div class="container container--narrow page-section">
<?php

              $today = date('Ymd');
$pastEvents = new WP_Query(array(
    'paged' => get_query_var('paged', 1),
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => [
            ['key' => 'event_date', 'compare' => '<', 'value' => $today, 'type' => 'numeric' ]
        ]
    ));

while($pastEvents->have_posts()) {
    $pastEvents->the_post();
    get_template_part('template-parts/content', 'event');
}
echo paginate_links([
    'total' => $pastEvents->max_num_pages
]);
?>
</div>

<?php get_footer();

?>
