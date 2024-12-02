<?php

// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.

// This line protects the file from being accessed by a URL directly.                                                               
defined('MOODLE_INTERNAL') || die();

// We will add callbacks here as we add features to our theme.

function theme_gexcon_get_main_scss_content($theme) {
    global $CFG;
    $scss = file_get_contents($CFG->dirroot . '/theme/gexcon/scss/main.scss');
    debugging('can not return maincss',DEBUG_DEVELOPER);
    return $scss;
}


function theme_gexcon_get_precompiled_css() {
    global $CFG;
    debugging('Precompiled CSS content: ' . $css, DEBUG_DEVELOPER);
    return file_get_contents($CFG->dirroot . '/theme/gexcon/style/moodle.css');
}


function theme_gexcon_get_course_categories(){
    global $DB;
    // Fetch categories (parent category = 0 for top-level categories)
    $sql_categories = "SELECT * FROM {course_categories} WHERE parent = :parent";
    $params = ['parent' => 0];  // Change the parent ID to get subcategories if needed
    $categories = $DB->get_records_sql($sql_categories, array('parent'=>0));

    // Initialize the array to hold categories with their courses
    $categories_with_courses = [];

    // Fetch courses for each category
    foreach ($categories as $category) {
        // Fetch courses for this category
        $sql_courses = "SELECT * FROM {course} WHERE category = :categoryid";
        $courses = $DB->get_records_sql($sql_courses, ['categoryid' => $category->id]);

        // Add the category and its courses to the array
        $categories_with_courses[] = [
            'category' => $category,  // The category object
            'courses' => $courses     // Array of courses associated with this category
        ];
    }
    return $categories_with_courses;
}
