<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://umeshwp.com
 * @since      1.0.0
 *
 * @package    Um_Profile_Listing
 * @subpackage Um_Profile_Listing/public/partials
 */
?>
    <?php 
    //get metadata and texonomies values
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $skills = isset($_POST['skills']) ? $_POST['skills'] : '';
    $skills_arr = json_decode(stripslashes($skills));

    $education = isset($_POST['education']) ? $_POST['education'] : '';
    $education_arr = json_decode(stripslashes($education));

    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $ratings = isset($_POST['ratings']) ? $_POST['ratings'] : '';
    $no_of_jobs_completed = isset($_POST['no_of_jobs_completed']) ? $_POST['no_of_jobs_completed'] : '';
    $yearofexperience = isset($_POST['yearofexperience']) ? $_POST['yearofexperience'] : '';

    $args = array(
        'post_type' => 'profile_listing',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
        's' => $keyword,
    );
    // Taxonomy filters
    if (!empty($skills_arr)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'skills',
            'field' => 'id',
            'terms' => $skills_arr,
            'operator' => 'AND',
        );
    }
    if (!empty($education_arr)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'education',
            'field' => 'id',
            'terms' => $education_arr,
            'operator' => 'AND',
        );
    }
    if (!empty($skills_arr) && !empty($education_arr)) {
        $args['tax_query']['relation'] = 'AND';
    }
    // Meta field filters
    if (!empty($age)) {
        $args['meta_query'][] = array(
            'key' => '_age',
            'value' => $age,
            'compare' => '=',
        );
    }
    // Meta field filters
    if (!empty($ratings)) {
        $args['meta_query'][] = array(
            'key' => '_ratings',
            'value' => $ratings,
            'compare' => '=',
        );
    }
    // Meta field filters
    if (!empty($no_of_jobs_completed)) {
        $args['meta_query'][] = array(
            'key' => '_jobs_completed',
            'value' => $no_of_jobs_completed,
            'compare' => '=',
        );
    }
    // Meta field filters
    if (!empty($yearofexperience)) {
        $args['meta_query'][] = array(
            'key' => '_years_of_experience',
            'value' => $yearofexperience,
            'compare' => '=',
        );
    }
    // The Query
    $profile_query = new WP_Query($args);

    // The Loop
    if ($profile_query->have_posts()) { 
    $html = '';
    $html .= '<table id="profile_lists" class="display profile_lists" style="width:100%">
    <thead>
        <tr>
            <th>No.</th>
            <th>Profile Name</th>
            <th>Age</th>
            <th>Year of experience</th>
            <th>No of jobs completed</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>';
    while ($profile_query->have_posts()) { 
        $profile_query->the_post();
        global $post;
        //get custom meta data 
        $dob = get_post_meta($post->ID, '_dob', true);
        $age = get_post_meta($post->ID, '_age', true);
        $hobbies = get_post_meta($post->ID, '_hobbies', true);
        $interests = get_post_meta($post->ID, '_interests', true);
        $years_of_experience = get_post_meta($post->ID, '_years_of_experience', true);
        $ratings = get_post_meta($post->ID, '_ratings', true);
        $jobs_completed = get_post_meta($post->ID, '_jobs_completed', true);
    
        $html .= '<tr>
            <td></td>
            <td>' .esc_html(get_the_title()). '</td>
            <td>' .esc_attr( $age ). '</td>
            <td>' .esc_attr( $years_of_experience ). '</td>
            <td>' .esc_attr( $jobs_completed ). '</td>
            <td>
            <div class="star-rating" style="pointer-events: none;" data-rating="' .$ratings. '">';
            // Maximum rating value
            $maxRating = 5;

            // Loop to generate stars
            for ($i = 1; $i <= $maxRating; $i++) {
                $filledStarClass = ($i <= $ratings) ? 'filled' : ''; // Add 'filled' class
                $html .= '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '">';
                $html .= '<label for="star' . $i . '" class="' . $filledStarClass . '"></label>';
            }
            $html .= '</div>
            </td>
        </tr>';
    }
    $html .= '</tbody>    
    </table>';
    } else {
        wp_send_json_error( array('html' => '<p style="color:red;"> No profile listings found.</p>') );
    }
    wp_send_json_success(array(
        'html' => $html
    ));

    wp_die();
