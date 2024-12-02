<?php
// Add Read Time to Post
// // Include the necessary WordPress admin file for is_plugin_active() function
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 
if ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) {
    // Elementor Pro is active, so register your dynamic tag action
    add_action('elementor/dynamic_tags/register_tags', function( $dynamic_tags ) {
        // Include the Tag class file
        include_once 'path_to_your_reading_time_tag_class.php';
 
        // Finally register the tag
        $dynamic_tags->register_tag( 'Reading_Time_Tag' );
    });
 
    class Reading_Time_Tag extends \Elementor\Core\DynamicTags\Tag {
 
        public function get_name() {
            return 'reading-time';
        }
 
        public function get_title() {
            return __('Reading Time', 'text-domain');
        }
 
        public function get_group() {
            return 'post';
        }
 
        public function get_categories() {
            return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
        }
 
        protected function register_controls() {
            // Add any necessary controls for your dynamic tag here
        }
 
        public function render() {
            $post_id = get_the_ID();
            $content = get_post_field('post_content', $post_id);
            echo estimate_reading_time($content);
        }
    }
}
 
// Estimate_reading_time() function
function estimate_reading_time($content) {
    $word_count = str_word_count(strip_tags($content));
    $words_per_minute = 200; // Average reading speed (words per minute)
    $reading_time = ceil($word_count / $words_per_minute);
    return $reading_time . ' minute' . ($reading_time === 1 ? '' : 's') . ' read';
}
// Add Read Time to Post
