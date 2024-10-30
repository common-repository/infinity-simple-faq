<?php 
/*
Plugin Name: Infinity Simple FAQ
Plugin URI: https://www.anahian.com
Description: Showcase useful elements with card style for Elementor page builder.
Version: 1.0.13
Author: Abdullah Nahian
Author URI: https://www.anahian.com/about-us
Donate link: https://www.anahian.com/donate
Tags: elementor, elementor addon
Requires at least: 5.8
Tested up to: 6.4.1
Stable tag: 1.0.13
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


// Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');


function ifs_faq_style() {
?>
<style type="text/css">
    .accordion {
		color: #333;
		cursor: pointer;
		padding: 18px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
		transition: 0.4s;
	}

.accordion:after {
    content: '\002B';
    color: #fff;
    font-weight: bold;
    float: right;
    margin-left: 5px;
}

.active:after {
    content: '\2212';
}

.panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
	margin-bottom: 20px;
}
button.theme-blue {
	background-color: #3498db;
}
.accordion {
	color: #fff !important;
	text-transform: capitalize;
	font-size: 14px;
}
.panel p {
	background-color: #fff;
	color: #333;
	padding: 10px 0px;
}
</style>
<?php
}
add_action( 'wp_head', 'ifs_faq_style');


function ifs_faq_script() {
?>
<script>
  var acc = document.getElementsByClassName("accordion");
  var i;
	
  // Open the first accordion
  var firstAccordion = acc[0];
  var firstPanel = firstAccordion.nextElementSibling;
  firstAccordion.classList.add("active");
  firstPanel.style.maxHeight = firstPanel.scrollHeight + "px";

  // Add onclick listener to every accordion element
  for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
      // For toggling purposes detect if the clicked section is already "active"
      var isActive = this.classList.contains("active");

      // Close all accordions
      var allAccordions = document.getElementsByClassName("accordion");
      for (j = 0; j < allAccordions.length; j++) {
        // Remove active class from section header
        allAccordions[j].classList.remove("active");

        // Remove the max-height class from the panel to close it
        var panel = allAccordions[j].nextElementSibling;
        var maxHeightValue = getStyle(panel, "maxHeight");
      
      if (maxHeightValue !== "0px") {
          panel.style.maxHeight = null;
        }
      }

      // Toggle the clicked section using a ternary operator
      isActive ? this.classList.remove("active") : this.classList.add("active");

      // Toggle the panel element
      var panel = this.nextElementSibling;
      var maxHeightValue = getStyle(panel, "maxHeight");
      
      if (maxHeightValue !== "0px") {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    };
  }
  
  // Cross-browser way to get the computed height of a certain element. Credit to @CMS on StackOverflow (http://stackoverflow.com/a/2531934/7926565)
  function getStyle(el, styleProp) {
  var value, defaultView = (el.ownerDocument || document).defaultView;
  // W3C standard way:
  if (defaultView && defaultView.getComputedStyle) {
    // sanitize property name to css notation
    // (hypen separated words eg. font-Size)
    styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
    return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
  } else if (el.currentStyle) { // IE
    // sanitize property name to camelCase
    styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
      return letter.toUpperCase();
    });
    value = el.currentStyle[styleProp];
    // convert other units to pixels on IE
    if (/^\d+(em|pt|%|ex)?$/i.test(value)) { 
      return (function(value) {
        var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;
        el.runtimeStyle.left = el.currentStyle.left;
        el.style.left = value || 0;
        value = el.style.pixelLeft + "px";
        el.style.left = oldLeft;
        el.runtimeStyle.left = oldRsLeft;
        return value;
      })(value);
    }
    return value;
  }
}
</script>
<?php
}

add_action( 'wp_footer', 'ifs_faq_script');


/* FAQ Loop */
function ifs_get_faq(){
	$ifs_faq= '<div id="faq-accordion">';
	query_posts('post_type=ifs-faq&posts_per_page=-1');
	if (have_posts()) : while (have_posts()) : the_post(); 
		$faqtitle= get_the_title(); 
		$faqcontent= get_the_content(); 
		$ifs_faq.='
		<button class="accordion">'.$faqtitle.'</button>
		<div class="panel theme">
		  <p>'.$faqcontent.'</p>
		</div>';		
			endwhile; endif; wp_reset_query();
			$ifs_faq.= '</div>';
			return $ifs_faq;
			}


			/**add the shortcode for the FAQ- for use in editor**/
			function ifs_insert_faq($atts, $content=null){
				$ifsfaq= ifs_get_faq();
				return $ifsfaq;
			}
			add_shortcode('ifs_faq', 'ifs_insert_faq');

			/*Files to Include*/
			require_once('ifs-faq-type.php');


