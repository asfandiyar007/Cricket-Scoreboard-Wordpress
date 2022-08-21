<?php
/*
* Plugin Name: Hello Cricket
* Plugin URI: https://github.com/mskian/hello-cricket
* Description: Simple Plugin to Display Live Cricket Score on your Wordpress site.
* Version: 1.0
* Author: Santhosh veer
* Author URI: https://sanweb.info/
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl.html
*/

## register admin script
add_action( 'admin_enqueue_scripts', 'hellocri_enqueue_color_picker' );
function hellocri_enqueue_color_picker() {
wp_enqueue_style('wp-color-picker');
wp_enqueue_script('hellocri-color-picker', plugin_dir_url( __FILE__ ) . 'assets/js/color.js', array( 'wp-color-picker' ), false);
}

## CSS for Scorecard
add_action('wp_head','hellockt_css');
function hellockt_css() {
$bg_color = get_option('hellocri_bg_color');
$bg_color1 = get_option('hellocri_bg_color1');
$bg_text = get_option('hellocri_text_color');
$output="<style>
#hello-score {
  font-size: 15px;
}
</style>";

$output1="<style>
#hello-score1 {
  font-size: 13px;
}
</style>";
echo $output1;
echo $output;
}

## plugin open registration
function activate_hellocri() {
  add_option('hellocri_bg_color', '#7158e2');
  add_option('hellocri_bg_color1', '#7158e2');
  add_option('hellocri_text_color', '#ffffff');
}

## Regsister user input
function admin_init_mmhellocricket() {
  register_setting('hellocric_mskc_topt', 'hellocric_match_url');
  register_setting('hellocric_mskc_topt', 'hellocric_match_url1');
  register_setting('hellocric_mskc_topt', 'hellocri_bg_color');
  register_setting('hellocric_mskc_topt', 'hellocri_bg_color1');
  register_setting('hellocric_mskc_topt', 'hellocri_text_color');
}

## Setup Admin Page
function admin_menu_mmhellocricket() {
  add_options_page('Hello Cricket', 'Hello Cricket', 'manage_options', 'hellocricket_mskc_topt', 'options_page_mmhellocricket');
}

## plugin register hooks
register_activation_hook(__FILE__, 'activate_hellocri');

## init Admin
if (is_admin()) {
  add_action('admin_init', 'admin_init_mmhellocricket');
  add_action('admin_menu', 'admin_menu_mmhellocricket');

}

## Options Page
function options_page_mmhellocricket() {
  include( plugin_dir_path( __FILE__ ) .'options.php');
}

## Shortcode to Display Score
function wpb_hellocric_shortcode(){

  ## Check Empty Input
  if (empty(get_option('hellocric_match_url'))) {
    return '<div id="hello-score">Match URL Not Found</div>';
  }

  ## Get Score URL
  $match_url = get_option('hellocric_match_url');
 
  ## Generate Scorecard
  $scorecard = "<script>
     async function fetchscore() {
       const helloCricketClass = document.getElementsByClassName('hello_cricket');
         try {
             const response = await fetch('https://circket.herokuapp.com/cri.php?url=$match_url');
             const data = await response.json();
             console.log(data);
             if (data === false || data === '') {
               if (helloCricketClass != null) {
                 let score_msg = '<p>Match URL Empty</p>';
                  score_text(helloCricketClass, score_msg);
              }
             } else if (helloCricketClass != null) {
                 let score_msg = '🏏 Match: \t' + data.livescore.title +'<br>🔶 Team #1: \t' + data.livescore.teamone +'<br>🔷 Team #2: \t' + data.livescore.teamtwo +'<br>📉 Run Rate: \t' + data.livescore.runrate +'<br>📊 Status: \t' + data.livescore.update +'<br>';
                 score_text(helloCricketClass, score_msg);
             }
          
         }
          catch (exception) {
             if (helloCricketClass != null) {
                 let score_msg = '<p>Connection Lost or Enter a valid Match URL</p>';
                 score_text(helloCricketClass, score_msg);
             }
         }
     }
     function score_text(helloCricketClass, text) {
       for (let i = 0; i < helloCricketClass.length; i++) {
         helloCricketClass[i].innerHTML = '<p>Fetching the Live Score 📦</p>';
         setTimeout(() => {
             helloCricketClass[i].innerHTML = text;
         }, 1000);
       }
     }
     fetchscore();
     setInterval(fetchscore, 60 * 2000);
    </script>
    <div class=\"hello_cricket\" id=\"hello-score\"></div>";
   
   ## Print Scorecard via Shortcode
   return $scorecard;
}
add_shortcode('hellocricket', 'wpb_hellocric_shortcode');
###############################################################################################################

##############################################################################################################
##################################################### Delte below ############################################
## Shortcode to Display Score
function wpb_hellocric_shortcode1(){

  ## Check Empty Input
  if (empty(get_option('hellocric_match_url1'))) {
    return '<div id="hello-score1">Match URL Not Found</div>';
  }

  ## Get Score URL
  $match_url1 = get_option('hellocric_match_url1');
 
  ## Generate Scorecard
  $scorecard1 = "<script>
     async function fetchscore() {
       const helloCricketClass = document.getElementsByClassName('hello_cricket1');
         try {
             const response = await fetch('https://circket.herokuapp.com/cri.php?url=$match_url1');
             const data1 = await response.json();
             console.log(data1);
             if (data1 === false || data1 === '') {
               if (helloCricketClass != null) {
                 let score_msg = '<p>Match URL Empty</p>';
                  score_text(helloCricketClass, score_msg);
              }
             } else if (helloCricketClass != null) {
                 let score_msg = '🏏 Match: \t' + data1.livescore.title +'<br>🔶 Team #1: \t' + data1.livescore.teamone +'<br>🔷 Team #2: \t' + data1.livescore.teamtwo +'<br>📉 Run Rate: \t' + data1.livescore.runrate +'<br>📊 Status: \t' + data1.livescore.update +'<br>';
                 score_text(helloCricketClass, score_msg);
             }
         } catch (exception) {
             if (helloCricketClass != null) {
                 let score_msg = '<p>Connection Lost or Enter a valid Match URL</p>';
                 score_text(helloCricketClass, score_msg);
             }
         }
     }
     function score_text(helloCricketClass, text) {
       for (let i = 0; i < helloCricketClass.length; i++) {
         helloCricketClass[i].innerHTML = '<p>Fetching the Live Score 📦</p>';
         setTimeout(() => {
             helloCricketClass[i].innerHTML = text;
         }, 1000);
       }
     }
     fetchscore();
     setInterval(fetchscore, 60 * 2000);
    </script>
    <div class=\"hello_cricket1\" id=\"hello-score1\"></div>";
   ## Print Scorecard via Shortcode
   return $scorecard1;
}
add_shortcode('hellocricket1', 'wpb_hellocric_shortcode1');




##############################################################################################################
##############################################################################################################
## Settings Page link
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'hellocrikt_optge_links' );

function hellocrikt_optge_links ( $helloclinks ) {
 $myhelloclinks = array(
 '<a href="' . admin_url( 'options-general.php?page=hellocricket_mskc_topt' ) . '">Plugin Settings</a>',
 );
return array_merge( $helloclinks, $myhelloclinks );
}
