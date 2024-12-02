<?php
require_once($CFG->dirroot . '/config.php');
require_once($CFG->dirroot . '/course/lib.php');

$courseid = required_param('id', PARAM_INT); // Course ID.

$PAGE->set_url('/course/view.php', ['id' => $courseid]);
$PAGE->set_context(context_course::instance($courseid));
// $PAGE->theme->name = 'theme_gexcon';
$PAGE->set_pagelayout('course'); // Maintains side-pre and side-post regions.

$course = get_course($courseid);

// Get all course data
$modinfo = get_fast_modinfo($course); 
$sections = $modinfo->get_section_info_all();

$topics = [];
foreach ($sections as $section) {
    if ($section->uservisible) { // Only include visible sections
        $activities = [];

        if (isset($modinfo->sections[$section->section])) {
            foreach ($modinfo->sections[$section->section] as $cmid) {
                $cm = $modinfo->cms[$cmid]; // Get course module details
                if ($cm->uservisible) {
                    $activities[] = [
                        'name' => $cm->name, // Activity name
                        'modname' => $cm->modname, // Module type (e.g., "quiz", "assignment")
                        'url' => $cm->url ? $cm->url->out() : '', // Activity URL
                    ];
                }
            }
        }

        $topics[] = [
            'name' => get_section_name($course->id, $section),
            'summary' => format_text($section->summary),
            'activities' => $activities, // Add activities to the section
        ];
    }
}
// print_r($topics);  

// Ensure the user is logged in and can access the course.
require_login($course);
// $PAGE->set_heading(format_string($course->fullname));
// $PAGE->set_title(format_string($course->fullname));

// Output starts here.
echo $OUTPUT->header();
// print_r($course);
echo $OUTPUT->render_from_template('theme_gexcon/course', [
    'courseid' => $courseid,
    'coursename' => $course->fullname,
    'sections' => get_fast_modinfo($course)->get_section_info_all(),
    'summary' => $course->summary,
    'topics' => $topics
]);
echo $OUTPUT->footer();