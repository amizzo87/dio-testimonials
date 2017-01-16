<?php

/**
* Plugin Name: Discuss.io Testimonials Embed
* Description: Allows testimonials to be embedded on app.discuss.io
* Version: 1.0
* Author: Anthony Izzo
*/

class WPWidgetEmbed
{
public function __construct()
{
add_action(‘template_redirect’, array($this, ‘catch_widget_query’));
add_action(‘init’, array($this, ‘widget_add_vars’));
}

/**
* Adds our widget query variable to WordPress $vars
*/
public function widget_add_vars()
{
global $wp;
$wp->add_query_var(’em_embed’);
$wp->add_query_var(’em_domain’);
}

private function export_posts()
{
$outstring  = ‘<html>’;
$outstring .= ‘<head><style>’;
$outstring .= ‘ul {
padding:0;
margin:0;
}
li {
list-style-type:none;
}’;
$outstring .= ‘</style></head><body>’;

/* Here we get recent testimonials for the blog */
$args = array(
‘numberposts’ => 5,
‘offset’ => 0,
‘category’ => 0,
‘orderby’ => ‘post_date’,
‘order’ => ‘DESC’,
‘post_type’ => ‘thegem_testimonial’,
‘post_status’ => ‘publish’,
‘suppress_filters’ => true
);

$recent_posts = wp_get_recent_posts($args);

$outstring .= ‘<div class=”widget-testimonials”>’;
foreach($recent_posts as $recent)
{
$outstring .= ‘<div class="testimonial"><p class="testimonial-author">$recent["post_title"]</p><p class="testimonial-content">$recent["post_content"]</p></div><br />’;
}

$outstring .= ‘</div>’;
$outstring .= ‘</body></html>’;

return $outstring;
}

/**
* Catches our query variable. If it’s there, we’ll stop the
* rest of WordPress from loading and do our thing, whatever
* that may be.
*/
public function catch_widget_query()
{
/* If no ’embed’ parameter found, return */
if(!get_query_var(’em_embed’)) return;

/* ’embed’ variable is set, export any content you like */

if(get_query_var(’em_embed’) == ‘posts’)
{
$data_to_embed = $this->export_posts();
echo $data_to_embed;
}

exit();
}
}

$widget = new WPWidgetEmbed();

?>