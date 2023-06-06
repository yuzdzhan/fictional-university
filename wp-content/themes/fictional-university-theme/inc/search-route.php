<?php

add_action('rest_api_init', 'university_register_search');

function university_register_search()
{
    register_rest_route('university/v1', 'search', [
      'methods'=> WP_REST_Server::READABLE,
			'callback' => 'university_search_results',
			'permission_callback' => '__return_true'
    ]);
}

function university_search_results(WP_REST_Request $data)
{
    $mainQuery = new WP_Query([
        'post_type' => ['post', 'page', 'professor', 'program', 'event'],
        's' => sanitize_text_field($data['term'])
    ]);


    $results = [
        'generalInfo' => [],
        'professors' => [],
        'programs' => [],
        'events' => [],
    ];

    $programsMetaQuery = ['relation' => 'OR'];

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if(get_post_type() == 'post' || get_post_type() == 'page') {
            array_push($results['generalInfo'], [
                    'title' => get_the_title(),
                    'postType' => get_post_type(),
                    'authorName' => get_the_author(),
                    'permalink' => get_the_permalink(),
            ]);
        }

        if(get_post_type() == 'professor') {
            array_push($results['professors'], [
                    'title' => get_the_title(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
                    'permalink' => get_the_permalink()
            ]);
        }

        if(get_post_type() == 'event') {

            $eventDate = new DateTime(get_field('event_date'));
            $description = wp_trim_words(get_the_content(), 18);
            if (has_excerpt()) {
                $description = get_the_excerpt();
            }

            array_push($results['events'], [
                    'title' => get_the_title(),
                    'day' => $eventDate->format('M'),
                    'month' => $eventDate->format('d'),
                    'description' => $description,
                    'permalink' => get_the_permalink()
            ]);
        }

        if(get_post_type() == 'program') {

            array_push($programsMetaQuery, [
							['key' => 'related_programs', 'compare' => 'LIKE', 'value' => '"'.get_the_ID().'"']
						]);

            array_push($results['programs'], [
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
            ]);
        }


    }

		if($results['programs']){
				$programRelationshipQuery = new WP_Query([
								'post_type' => ['professor', 'event'],
								'meta_query' => $programsMetaQuery
				]);

				while($programRelationshipQuery->have_posts()) {
						$programRelationshipQuery->the_post();

						if(get_post_type() == 'professor') {
								array_push($results['professors'], [
												'title' => get_the_title(),
												'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
												'permalink' => get_the_permalink()
								]);
						}

					if(get_post_type() == 'event') {

							$eventDate = new DateTime(get_field('event_date'));
							$description = wp_trim_words(get_the_content(), 18);
							if (has_excerpt()) {
									$description = get_the_excerpt();
							}

							array_push($results['events'], [
											'title' => get_the_title(),
											'day' => $eventDate->format('M'),
											'month' => $eventDate->format('d'),
											'description' => $description,
											'permalink' => get_the_permalink()
							]);
					}

				}

				$results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
				$results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));

		}

    return $results;

}
