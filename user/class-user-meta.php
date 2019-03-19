<?php

namespace nebula\socials;

class user_meta {

	public function __construct( ) {
		add_action('wp_head', array ($this,'social_links'));
	}

	public function social_links() {
    global $post;
    $my_options = new options_admin();

    // page or single post
    if ( ((is_page()) && ($my_options->GetOption('user-pages') == 1)) || ((is_single()) && ($my_options->GetOption('user-posts') == 1)) ) {

       // thumbnail / options_image
       if(has_post_thumbnail($post->ID)) {
           $image_attributes = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
           $img_src = $image_attributes[0];
       } else {
           $img_src = $my_options->GetOption('meta-thumbnail-src');
       }
       if($excerpt = $post->post_excerpt) {
           $excerpt = strip_tags($post->post_excerpt);
           $excerpt = str_replace("", "'", $excerpt);
       } else {
           // $excerpt = get_bloginfo('description');
           // $excerpt = "Click here to read more from our blog.";
           $excerpt = wp_trim_words( get_the_content(), 20, '...' );
        }
        if (strlen($excerpt)<5) {
            $excerpt = apply_filters( 'the_content', $post->post_content );
        }
       $excerpt = wp_trim_words( $post->post_content, 25, '...' );
       $excerpt = strip_tags($excerpt);
       $excerpt = str_replace("", "'", $excerpt);
     ?>

<meta property="og:title" content="<?php echo the_title(); ?>"/>
<meta property="og:description" content="<?php echo $excerpt; ?>"/>
<meta property="og:type" content="<?php echo $my_options->GetOption('ob_type'); ?>"/>

      <?php
       switch($my_options->GetOption('fb_url')) {
       case 'SSL':
       ?>

<meta property="og:url" content="<?php echo str_replace('http','https',get_permalink()); ?>"/>

      <?php
       break;
       case 'http':
       ?>

<meta property="og:url" content="<?php echo str_replace('https:','http:',get_permalink()); ?>"/>

<?php  break;
       default:?>

<meta property="og:url" content="<?php echo get_permalink(); ?>"/>

<?php
       break;
       }
?>

<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
<meta property="og:image" content="<?php echo $img_src; ?>"/>
<meta property="article:section" content="News" />
<meta property="article:published_time" content="<?php echo get_the_date( 'Y-m-d' ).'T'; the_time( 'H:i:s' ); echo'+00:00'?>" />
<meta property="article:modified_time" content="<?php echo get_the_modified_date( 'Y-m-d' ).'T'.get_the_modified_time( 'H:i:s' ).'+00:00'?>" />
<meta property="og:updated_time" content="<?php echo get_the_modified_date( 'Y-m-d' ).'T'.get_the_modified_time( 'H:i:s' ).'+00:00'?>" />
<meta name="twitter:card" content="summary_large_image">

<?php if ( strlen($my_options->GetOption('twitter_site')) >2) { ?>

<meta name="twitter:site" content="<?php echo $my_options->GetOption('twitter_site'); ?>">

<?php }if ( strlen($my_options->GetOption('twitter_creator')) >2) { ?>

<meta name="twitter:creator" content="<?php echo $my_options->GetOption('twitter_creator'); ?>">

<?php } ?>

<meta name="twitter:title" content="<?php echo the_title(); ?>"/>
<meta name="twitter:description" content="<?php echo $excerpt; ?>"/>
<meta name="twitter:image" content="<?php echo $img_src; ?>"/>

<?php } else { ?>

<?php if ( strlen($my_options->GetOption('site_title')) >2)  { ?>

<meta property="og:title" content="<?php echo $my_options->GetOption('site_title'); ?>"/>

<?php } else { ?>

<meta property="og:title" content="<?php echo get_bloginfo('name'); ?>"/>

<?php } if ( strlen($my_options->GetOption('site_desc')) >2)  { ?>

<meta property="og:description" content="<?php echo $my_options->GetOption('site_desc'); ?>"/>

<?php } else { ?>

<meta property="og:description" content="<?php echo get_bloginfo('description'); ?>"/>

<?php } ?>

<meta property="og:type" content="website"/>

<?php
       switch($my_options->GetOption('fb_url')) {
       case 'SSL': ?>

<meta property="og:url" content="<?php echo str_replace('http','https',get_permalink()); ?>"/>

<?php
       break;
       case 'http': ?>

<meta property="og:url" content="<?php echo str_replace('https:','http:',get_permalink()); ?>"/>

<?php  break;
       default:?>

<meta property="og:url" content="<?php echo get_permalink(); ?>"/>

<?php
       break;
       }
?>

<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
<meta property="og:image" content="<?php echo $my_options->GetOption('meta-thumbnail-src'); ?>"/>
<meta property="article:section" content="News" />
<meta property="article:published_time" content="<?php echo get_the_date( 'Y-m-d' ).'T'; the_time( 'H:i:s' ); echo'+00:00'?>" />
<meta property="article:modified_time" content="<?php echo get_the_modified_date( 'Y-m-d' ).'T'.get_the_modified_time( 'H:i:s' ).'+00:00'?>" />
<meta property="og:updated_time" content="<?php echo get_the_modified_date( 'Y-m-d' ).'T'.get_the_modified_time( 'H:i:s' ).'+00:00'?>" />
<meta name="twitter:card" content="summary_large_image">

<?php if ( strlen($my_options->GetOption('twitter_site')) >2) { ?>

<meta name="twitter:site" content="<?php echo $my_options->GetOption('twitter_site'); ?>">

<?php }if ( strlen($my_options->GetOption('twitter_creator')) >2) { ?>

<meta name="twitter:creator" content="<?php echo $my_options->GetOption('twitter_creator'); ?>">

<?php } ?>

<meta name="twitter:title" content="<?php echo get_bloginfo('name');  ?>"/>
<meta name="twitter:description" content="<?php echo get_bloginfo('description');  ?>"/>
<meta name="twitter:image" content="<?php echo $my_options->GetOption('meta-thumbnail-src'); ?>"/>

<?php
    return;
    }
  }

}
