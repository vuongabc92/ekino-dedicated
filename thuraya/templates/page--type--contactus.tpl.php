<?php
/**
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['navigation']: Items for the navigation region, below the main menu (if any).
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['footer']: Items for the footer region.
 * - $page['bottom']: Items to appear at the bottom of the page below the footer.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see zen_preprocess_page()
 * @see template_process()
 */
 global $base_url;
 //drupal_add_js($base_url.'/'.path_to_theme() . '/js/thuraya_forms.js');
?>
<div class="ui-page">
  <!--  Header Section -->
<?php  print $mod_header;?>
  <!--  /Header Section -->
  <!--  Content Section -->
  <div class="ui-content">
  <div class="ui-page-content">
    <!-- Solutions  -->   
   <div class="main-container">	
    <!-- Solutions  -->   
   <div class="contact-us">
		<div class="breadcrumbs">
			<?php $breadcrumb=str_replace('href="//"','href="/"',$breadcrumb); ?>
			<?php print $breadcrumb; ?>
		</div>
            <h1>Contact Us</h1>
            <div class="col1">
            	<?php print render($page['support_leftmenu']);  ?>
            </div>
            <div class="col2">
            	<h2>Submit by web</h2>
				<div class="contact-us-form">
                	<ul>
                      <li>
                        <div class="select_box"> <span id="complaintservice" class="select selectbox-blue-bg">Select a subject</span>
                          <label for="complaint">Complaint</label>
                          <select name="complaintservice" class="styled" id="complaint">
                            <option value="Select a Subject" selected="selected">Select a subject</option>
                            <option value="Product or Service Inquiry">Product or Service Inquiry</option>
                            <option value="Business Proposal or Sales Inquiry">Business Proposal or Sales Inquiry</option>
                            <option value="Complaint or Service Request" >Complaint or Service Request</option>
                            <option value="Feedback" >Feedback</option>
                          </select>
                        </div>
                      </li>
					</ul>
				</div>
                <div class="contact-us-form" id="form1" style="display:none">
					<?php
					$formnode = node_load('453');					
					webform_node_view($formnode,'full');
					print theme_webform_view($formnode->content);
				    ?>                	
                </div>
				<div class="contact-us-form" id="form2" style="display:none">
					<?php
					$formnode = node_load('454');					
					webform_node_view($formnode,'full');
					print theme_webform_view($formnode->content);
				    ?>                	
                </div>
				<div class="contact-us-form" id="form3" style="display:none">
					<?php
					$formnode = node_load('455');					
					webform_node_view($formnode,'full');
					print theme_webform_view($formnode->content);
				    ?>                	
                </div>
				<div class="contact-us-form" id="form4" style="display:none">
					<?php
					$formnode = node_load('456');					
					webform_node_view($formnode,'full');
					print theme_webform_view($formnode->content);
				    ?>                	
                </div>
            </div>
          </div>
   </div>
  </div>
  </div>
  <!--  /Content Section -->
  <!-- Footer -->
 <?php  print $mod_footer;?>
 <!-- /Footer -->
</div>
