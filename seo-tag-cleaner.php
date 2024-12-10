<?php

/**
 * Plugin Name: SEO Tag Cleaner
 *
 * Description: Optimizes H1, footer, and header tags for better SEO by managing duplicates.
 *
 * Version: 1.0.0
 *
 * Author: hassan Ali Askari
 * Author URI: https://t.me/hassan7303
 * Plugin URI: https://github.com/hassan7303
 *
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 * Email: hassanali7303@gmail.com
 * Domain Path: https://hsnali.ir
 */

 add_action('template_redirect', 'seo_tag_cleaner_buffer_start');
 add_action('shutdown', 'seo_tag_cleaner_buffer_end');
 
 function seo_tag_cleaner_buffer_start() {
     ob_start('seo_tag_cleaner_process');
 }
 
 function seo_tag_cleaner_buffer_end() {
     if (ob_get_length()) {
         ob_end_flush();
     }
 }
 
 function seo_tag_cleaner_process($html) {
     libxml_use_internal_errors(true); 
     $dom = new DOMDocument();
     $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
     libxml_clear_errors();
 
     $xpath = new DOMXPath($dom);
 
     // Fix duplicate H1 tags
     $h1Tags = $xpath->query('//h1');
     foreach ($h1Tags as $index => $h1) {
         if ($index > 0) {
             $h1->tagName = 'h2';
         }
     }
 
     // Fix duplicate footer tags
     $footerTags = $xpath->query('//footer');
     if ($footerTags->length > 1) {
         $mainFooter = find_main_element($footerTags, 'footer');
         foreach ($footerTags as $footer) {
             if ($footer !== $mainFooter) {
                 replace_tag_with_div($footer);
             }
         }
     }
 
     // Fix duplicate header tags
     $headerTags = $xpath->query('//header');
     if ($headerTags->length > 1) {
         $mainHeader = find_main_element($headerTags, 'header');
         foreach ($headerTags as $header) {
             if ($header !== $mainHeader) {
                 replace_tag_with_div($header);
             }
         }
     }
 
     return $dom->saveHTML();
 }
 
 // Helper function to find the main element
 function find_main_element($elements, $type) {
     $maxContentLength = 0;
     $mainElement = $elements[0];
 
     foreach ($elements as $element) {
         $contentLength = strlen($element->textContent);
         if ($contentLength > $maxContentLength) {
             $maxContentLength = $contentLength;
             $mainElement = $element;
         }
     }
 
     return $mainElement;
 }
 
 // Helper function to replace a tag with a <div>
 function replace_tag_with_div($element) {
     $newDiv = $element->ownerDocument->createElement('div', $element->textContent);
 
     // Copy attributes
     foreach ($element->attributes as $attr) {
         $newDiv->setAttribute($attr->name, $attr->value);
     }
 
     // Replace element
     $element->parentNode->replaceChild($newDiv, $element);
 }




  /**
 * Checks for plugin updates from GitHub and notifies WordPress.
 *
 * Fetches the latest release information from GitHub. If a newer version is available,
 * it adds the update to the WordPress update queue.
 *
 * @param object $transient The transient object containing update information.
 * @return object Modified transient object with update details if available.
 */
function check_for_plugin_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }
  
    $plugin_slug = plugin_basename(__FILE__);
    $github_url = 'https://api.github.com/repos/hassan7303/seo-tag-cleaner/releases/latest';
  
    $response = wp_remote_get($github_url, ['sslverify' => false]);
    if (is_wp_error($response)) {
        return $transient;
    }
  
    $release_info = json_decode(wp_remote_retrieve_body($response), true);
  
    if (isset($release_info['tag_name']) && isset($transient->checked[$plugin_slug])) {
        $new_version = $release_info['tag_name'];
        if (version_compare($transient->checked[$plugin_slug], $new_version, '<')) {
            $transient->response[$plugin_slug] = (object) [
                'slug' => $plugin_slug,
                'new_version' => $new_version,
                'package' => $release_info['zipball_url'],
                'url' => 'https://github.com/hassan7303/seo-tag-cleaner',
            ];
        }
    }
  
    return $transient;
  }
  add_filter('pre_set_site_transient_update_plugins', 'check_for_plugin_update');
  
  /**
  * Adjust plugin folder name after installation to maintain original name.
  */
  function fix_plugin_folder_name($response, $hook_extra, $result) {
    global $wp_filesystem;
  
    $plugin_slug = 'seo-tag-cleaner';
    $original_folder = WP_PLUGIN_DIR . '/' . $plugin_slug;
    $new_folder = $result['destination'];
  
    if (basename($new_folder) !== $plugin_slug) {
        $wp_filesystem->move($new_folder, $original_folder);
        $result['destination'] = $original_folder;
    }
  
    return $response;
  }
  add_filter('upgrader_post_install', 'fix_plugin_folder_name', 10, 3);
  