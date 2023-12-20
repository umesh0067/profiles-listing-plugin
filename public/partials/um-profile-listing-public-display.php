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

// Query arguments
$args = array(
    'post_type' => 'profile_listing',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'title',
);
?>
<div class="um_profile_listing_main">
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <form id="um_profile_li_form" class="um_profile_li_form um_ajax_form" name="um_profile_li_form" action="" type="post" enctype="multipart/form-data">
                <div class="form-row mb-5">
                    <div class="form-group gap-row col-md-12 d-inline-flex align-items-center">
                        <label for="keyword">Keyword</label>
                        <input type="text" class="form-control" id="keywordinput" placeholder="keyword">
                    </div>
                </div>
                <div class="form-row gap-row mb-5 col-md-12 d-inline-flex align-items-center">
                    <div class="form-group gap-row col-md-6 d-inline-flex align-items-center">
                        <label for="skills">Skills</label>
                        <?php 
                        $taxonomy_name = 'skills';
                        // Get terms for the 'Skills' taxonomy
                        $skills_terms = get_terms(array(
                            'taxonomy' => $taxonomy_name,
                            'hide_empty' => false, // Set to true to hide empty terms
                        ));
                        // Check if terms were found
                        if (!empty($skills_terms) && !is_wp_error($skills_terms)) { ?>
                            <select class="selectskills" placeholder="Choose skills"  multiple="multiple">
                            <?php 
                            foreach ($skills_terms as $term) {  ?>  
                            <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                            <?php } ?>
                            </select>
                        <?php }
                        ?>  
                    </div>
                    <div class="form-group gap-row col-md-6 d-inline-flex align-items-center">
                        <label for="Education">Education</label>
                        <?php 
                        $taxonomy_name = 'education';
                        // Get terms for the 'Skills' taxonomy
                        $edu_terms = get_terms(array(
                            'taxonomy' => $taxonomy_name,
                            'hide_empty' => false, // Set to true to hide empty terms
                        ));
                        // Check if terms were found
                        if (!empty($edu_terms) && !is_wp_error($edu_terms)) { ?>
                            <select class="selecteduction" placeholder="select education"  multiple="multiple">
                            <?php 
                            foreach ($edu_terms as $term) {  ?>  
                            <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                            <?php } ?>
                            </select>
                        <?php }
                        ?>
                    </div>
                </div>
                <div class="form-row gap-row mb-5 col-md-12 d-inline-flex align-items-center">
                    <div class="form-group gap-row col-md-6 d-inline-flex align-items-center">
                        <label for="age">Age</label>
                        <input type="range" id="inputage" min="0" max="100" value="0" step="1">
                        <div class="slider_age_val">
                            <span id="agevalue"></span>
                        </div>
                    </div>
                    <div class="form-group gap-row col-md-6 d-inline-flex align-items-center">
                        <label for="ratings">Ratings</label>
                        <div class="star-rating" data-rating="3">
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1"></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2"></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3"></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4"></label>
                            <input type="radio" id="star5" name="rating" value="5">
                            <label for="star5"></label>
                        </div>
                    </div>
                </div>
                <div class="form-row gap-row mb-5 col-md-12 d-inline-flex align-items-center">
                    <div class="form-group gap-row col-md-6 d-inline-flex align-items-center">
                        <label for="no_of_jobs_completed">No of jobs completed</label>
                        <input type="number" class="form-control" id="inputnojobs" placeholder="">
                    </div>
                    <div class="form-group gap-row mb-5 col-md-6 d-inline-flex align-items-center">
                        <label for="yearofexperience">Years of experience</label>
                        <input type="number" class="form-control" id="inputexperience" placeholder="">
                    </div>
                </div>
                <div class="um_search_btn_wrap">
                    <input type="submit" class="btn btn-primary um_filter_btn" value="Search" />
                    <div class="ajax-loader" style="display:none;"></div>
                </div>
                <div class="um_message" style="display:none;color:red;"></div>
            </form>
        </div>
        <?php
        // The Query
        $profile_query = new WP_Query($args);
        // The Loop
        if ($profile_query->have_posts()) {
        ?>
        <div class="col-md-12 um_datatable_wrapper">
        <table id="profile_lists" class="display profile_lists" style="width:100%">
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
        <tbody>
        <?php while ($profile_query->have_posts()) { 
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
            
            ?>
            <tr>
                <td></td>
                <td><?php echo esc_html(get_the_title()); ?></td>
                <td><?php echo esc_attr( $age ); ?></td>
                <td><?php echo esc_attr( $years_of_experience ); ?></td>
                <td><?php echo esc_attr( $jobs_completed ); ?></td>
                <td>
                <div class="star-rating" style="pointer-events: none;" data-rating="<?php echo $ratings; ?>">
                    <?php
                    // Maximum rating value
                    $maxRating = 5;
                    // Loop to generate stars
                    for ($i = 1; $i <= $maxRating; $i++) {
                        $filledStarClass = ($i <= $ratings) ? 'filled' : ''; // Add 'filled' class
                        echo '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '">';
                        echo '<label for="star' . $i . '" class="' . $filledStarClass . '"></label>';
                    }
                    ?>
                </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>    
        </table>
        </div>
        <?php
        } else {
            _e('No profile listings found.', 'um-profile-listing');
        }
        ?>
    </div>
</div>
</div>

