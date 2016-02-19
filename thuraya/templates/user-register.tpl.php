<?php
unset($form['account']['name']['#title']);
unset($form['account']['mail']['#title']);
unset($form['account']['name']['#description']);
unset($form['account']['mail']['#description']);
unset($form['profile_main']['field_first_name']['und'][0]['#title']);
unset($form['profile_main']['field_first_name']['und'][0]['value']['#title']);

unset($form['profile_main']['field_last_name']['und'][0]['#title']);
unset($form['profile_main']['field_last_name']['und'][0]['value']['#title']);
unset($form['profile_main']['field_driving_license']['und'][0]['#title']);
unset($form['profile_main']['field_driving_license']['und'][0]['value']['#title']);
unset($form['profile_main']['field_mobile_number']['und'][0]['#title']);
unset($form['profile_main']['field_mobile_number']['und'][0]['value']['#title']);

unset($form['profile_main']['field_profile_address']['und'][0]['#title']);
unset($form['profile_main']['field_profile_address']['und'][0]['value']['#title']);

unset($form['profile_main']['field_company']['und'][0]['#title']);
unset($form['profile_main']['field_company']['und'][0]['value']['#title']);

unset($form['profile_main']['field_position']['und'][0]['#title']);
unset($form['profile_main']['field_position']['und'][0]['value']['#title']);

unset($form['profile_main']['field_current_salary']['und'][0]['#title']);
unset($form['profile_main']['field_current_salary']['und'][0]['value']['#title']);

unset($form['profile_main']['field_notice_period']['und'][0]['#title']);
unset($form['profile_main']['field_notice_period']['und'][0]['value']['#title']);

unset($form['profile_main']['field_notice_period_new']['und'][0]['#title']);
unset($form['profile_main']['field_notice_period_new']['und'][0]['value']['#title']);

unset($form['profile_main']['field_available_date']['und'][0]['#title']);
unset($form['profile_main']['field_available_date']['und'][0]['value']['#title']);

unset($form['profile_main']['field_multi_company']['und'][0]['#title']);
unset($form['profile_main']['field_multi_company']['und'][0]['value']['#title']);

unset($form['profile_main']['field_multi_position']['und'][0]['#title']);
unset($form['profile_main']['field_multi_position']['und'][0]['value']['#title']);

unset($form['profile_main']['field_period']['und'][0]['#title']);
unset($form['profile_main']['field_period']['und'][0]['value']['#title']);

unset($form['profile_main']['field_upload_your_complete_cv']['und'][0]['#title']);
unset($form['profile_main']['field_upload_your_complete_cv']['und'][0]['value']['#title']);

unset($form['profile_main']['field_information_technology']['und']['#title']);
unset($form['profile_main']['field_technology_development']['und']['#title']);
unset($form['profile_main']['field_software_solutions_develop']['und']['#title']);
unset($form['profile_main']['field_satellite_network_operatio']['und']['#title']);

unset($form['profile_main']['field_market_development']['und']['#title']);
unset($form['profile_main']['field_inter_carrier_relations']['und']['#title']);
unset($form['profile_main']['field_products_management']['und']['#title']);
unset($form['profile_main']['field_marketing_communications_b']['und']['#title']);

unset($form['profile_main']['field_marketing_communications_b']['und']['#title']);
unset($form['profile_main']['field_area_account_management']['und']['#title']);
unset($form['profile_main']['field_sales_customer_support']['und']['#title']);
unset($form['profile_main']['field_others']['und']['#title']);

unset($form['profile_main']['field_accounting']['und']['#title']);
unset($form['profile_main']['field_billing_systems']['und']['#title']);
unset($form['profile_main']['field_supply_contracts']['und']['#title']);
unset($form['profile_main']['field_financial_control_planning']['und']['#title']);
unset($form['profile_main']['field_administration']['und']['#title']);
unset($form['profile_main']['field_human_capital']['und']['#title']);
unset($form['profile_main']['field_gmpcs_affairs']['und']['#title']);
unset($form['profile_main']['field_strtgy_bus_dev_others']['und']['#title']);

unset($form['profile_main']['field_internal_audit']['und']['#title']);
unset($form['profile_main']['field_industry_experience']['und']['#title']);

unset($form['profile_main']['field_gender']['und']['#title']);
unset($form['profile_main']['field_visa_status']['und']['#title']);
unset($form['profile_main']['field_nationality']['und']['#title']);
unset($form['profile_main']['field_visa_status']['und']['#title']);
unset($form['profile_main']['field_country_p_o_box']['und']['#title']);

unset($form['profile_main']['field_po_box']['und'][0]['#title']);
unset($form['profile_main']['field_po_box']['und'][0]['value']['#title']);
unset($form['profile_main']['field_experience_level']['und']['#title']);
?>
<div class="in-container">
    <h1>Registration</h1>

    <ul class="tabs-div">
        <?php print render($form['step']); ?>	   	   
    </ul>

    <?php if ($form['step_level']['#default_value'] == '1') { ?>
      <div class="personal-info">
          <h3>Personal Information</h3>
          <div class="contact-us-form">

              <ul>
                  <li>
                      <?php
                      print render($form['profile_main']['field_first_name']);
                      ?>
                  </li>
                  <li class="right">
                      <?php print render($form['profile_main']['field_last_name']); ?>
                  </li>
                  <li>
                      <div class="select_box">
                          <span class="select selectbox-bg" id="genderselect">Gender*</span>
                          <label for="gender">Gender*</label>
                          <?php print render($form['profile_main']['field_gender']); ?>
                      </div>
                  </li>
                  <li class="right">
                      <div class="date-text">Birthday</div>
                      <?php print render($form['profile_main']['field_birthday']); ?>
                  </li>

                  <li>
                      <div class="select_box">
                          <span class="select selectbox-bg" id="visa-status">Visa Status</span>
                          <label for="visastatus">Visa Status</label>
                          <?php print render($form['profile_main']['field_visa_status']); ?>
                      </div>
                  </li>
                  <li class="right">
                      <div class="select_box">
                          <span class="select selectbox-bg" id="nationality">Nationality</span>
                          <label for="nation">Nationality</label>
                          <?php print render($form['profile_main']['field_nationality']); ?>
                      </div>
                  </li>
                  <li>
                      <?php print render($form['profile_main']['field_driving_license']); ?>
                  </li>
                  <li class="right">
                      <div class="select_box">
                          <span class="select selectbox-bg" id="maritialstatus">Maritial Status</span>
                          <label for="marital">Maritial Status</label>
                          <?php print render($form['profile_main']['field_marital_status']); ?>
                      </div>
                  </li>

              </ul>

              <div class="border-bottom"></div>
          </div>

          <h3>Contact Information</h3>
          <div class="contact-us-form">
              <ul>
                  <li>
                      <?php print render($form['account']['mail']); ?>
                  </li>
                  <li class="right">
                      <?php print render($form['profile_main']['field_mobile_number']); ?>
                  </li>

                  <li>
                      <?php print render($form['profile_main']['field_profile_address']); ?>
                  </li>
                  <li class="right">
                      <!-- <div class="select_box">
                           <span class="select selectbox-bg" id="countrypobox">Country P.O. Box</span>
                           <label for="countrybox">Country P.O. Box</label>
                      <?php //print render($form['profile_main']['field_country_p_o_box']); ?>
                       </div> -->
                      <?php print render($form['profile_main']['field_po_box']); ?>
                  </li>

              </ul>
              <div class="border-bottom"></div>
          </div>
          <!-- <h3>Career Level</h3>
          <div class="contact-us-form">
             <ul>
              <li>
          <?php //print render($form['profile_main']['field_company']); ?>
              </li>
              <li class="right">
          <?php //print render($form['profile_main']['field_position']); ?>
              </li>
              <li>
          <?php //print render($form['profile_main']['field_current_salary']); ?>
              </li>
              <li class="right">
                           <div class="select_box">
                      <span class="select selectbox-bg" id="notice_period">Notice Period</span>

          <?php //print render($form['profile_main']['field_notice_period_new']); ?>
                  </div>

              </li>
              <li>
                  <div class="date-text">Available Date</div>
                  <div class="date-select-box">
          <?php //print render($form['profile_main']['field_available_date']); ?>
                 </div>
                  </li>
              <li class="right">

             </li>
             </ul>
              <div class="border-bottom"></div>
          </div> -->
          <h3>Professional Experience</h3>
          <div class="contact-us-form">
              <div class="multi-input">

                  <?php
                  print render($form['profile_main']['fgm_profile2_main_form_group_professional_experiences']);
                  ?>
              </div>

              <div class="border-bottom"></div>
          </div>
          <h3>Education/Certification</h3>
          <div class="contact-us-form">
              <div class="multi-input">

                  <?php print render($form['profile_main']['fgm_profile2_main_form_group_education']);
                  ?>
              </div>
              <div class="border-bottom"></div>
          </div>
          <h3>Skills</h3>
          <div class="contact-us-form">
              <div class="multi-input">
                  <?php print render($form['profile_main']['fgm_profile2_main_form_group_skills']); ?>
              </div>
              <div class="border-bottom"></div>
          </div>
          <h3>Language</h3>
          <div class="contact-us-form">
              <div class="multi-input">

                  <?php print render($form['profile_main']['fgm_profile2_main_form_group_language']); ?>

              </div>

              </ul>
              <div class="border-bottom"></div>
          </div>
          <h3>Upload your complete CV</h3>
          <div class="contact-us-form border-bottom">

              <?php print render($form['profile_main']['field_upload_your_complete_cv']); ?>

          </div>

          <div class="form-btns">
              <ul><li class="btn-sub">
                      <?php print render($form['actions']); ?>
                      <div style="display:none">
                          <?php
                          print drupal_render_children($form);
                          ?>
                      </div>
                  </li>
              </ul>
          </div>

      </div><!-- end of main container-->
    <?php }
    else {
      ?>
      <div class="personal-info">
          <h3>Current / Preferred Functional Area </h3>
          <div class="border-bottom"></div>
          <div class="careers-list">
              <ul>
                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">
                                  Experience level
                              </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">
                              <div class="select_box">
                                  <span class="select selectbox-bg" id="experiencelevel">Experience Level</span>
                                  <label for="edit-profile-main-field-experience-level-und">Experience Level</label>
                                  <?php print render($form['profile_main']['field_experience_level']); ?>    </div>

                          </div>
                      </div>
                  </li>
                  <li>
                      <h3 class="hline"><a href="javascript:void(0)">
                              <span class="text">Technology</span>
                              <span class="ui-icon minus"></span></a></h3>
                      <div class="carrer-holder show_div" style="display: block;">
                          <div class="regis-form">                                                      <h3>Information Technology </h3>
                              <?php print render($form['profile_main']['field_information_technology']); ?>         <h3>Technology Development</h3>
                              <?php print render($form['profile_main']['field_technology_development']); ?>          <h3>Software Solutions Development & Support</h3>
                              <?php print render($form['profile_main']['field_software_solutions_develop']); ?>
                          </div>
                      </div>
                  </li>
                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">Satellite Network Operations </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">

                              <?php print render($form['profile_main']['field_satellite_network_operatio']); ?>

                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">Marketing</span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">
                              <h3>Market Development</h3>
                              <?php print render($form['profile_main']['field_market_development']); ?>
                              <h3>Inter-Carrier Relations</h3>
                              <?php print render($form['profile_main']['field_inter_carrier_relations']); ?>
                              <h3>Products Management </h3>
                              <?php print render($form['profile_main']['field_products_management']); ?>


                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">Communications & Branding </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">

                              <?php print render($form['profile_main']['field_marketing_communications_b']); ?>

                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">Sales & Distribution </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">
                              <h3>Area Account Management </h3>

                              <?php print render($form['profile_main']['field_area_account_management']); ?>

                              <h3>Sales &amp; Customer Support</h3>

                              <?php print render($form['profile_main']['field_sales_customer_support']); ?>

                              <h3>Others</h3>

                              <?php print render($form['profile_main']['field_others']); ?>

                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">Finance </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">
                              <h3>Accounting</h3>
                              <?php print render($form['profile_main']['field_accounting']); ?>
                              <h3>Billing Systems</h3>
                              <?php print render($form['profile_main']['field_billing_systems']); ?>
                              <h3>Supply & Contracts</h3>
                              <?php print render($form['profile_main']['field_supply_contracts']); ?>


                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">
                                  Financial Control & Planning
                              </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">

                              <?php print render($form['profile_main']['field_financial_control_planning']); ?>

                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">
                                  Administration & Human Capital
                              </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">
                              <h3>Administration</h3>
                              <?php print render($form['profile_main']['field_administration']); ?>   <h3>Human Capital</h3>
                              <?php print render($form['profile_main']['field_human_capital']); ?>
                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">
                                  Strategy & Business Development
                              </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">
                              <h3>GMPCS Affairs</h3>
                              <?php print render($form['profile_main']['field_gmpcs_affairs']); ?>   <h3>Others</h3>
                              <?php print render($form['profile_main']['field_strtgy_bus_dev_others']); ?>
                          </div>
                      </div>
                  </li>

                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">
                                  Internal Audit
                              </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">

                              <?php print render($form['profile_main']['field_internal_audit']); ?>

                          </div>
                      </div>
                  </li>
                  <li>
                      <h3 class="hline"><a href="javascript:void(0)"><span class="text">
                                  Industry Experience
                              </span>
                              <span class="ui-icon plus"></span></a></h3>
                      <div class="carrer-holder" style="display:none;">
                          <div class="regis-form">
                              <div class="select_box">
                                  <span class="select selectbox-bg" id="industryexperience">Industry Experience</span>
                                  <label for="edit-profile-main-field-industry-experience-und">Industry Experience</label>
                                  <?php print render($form['profile_main']['field_industry_experience']); ?>    </div>

                          </div>
                      </div>
                  </li>
              </ul>
          </div>
          <div class="form-btns careers-submit">
              <ul>
                  <li class="btn-sub">
                      <span class="left">
                          <?php print render($form['actions']['back']); ?>
                      </span>
                      <span>
                          <?php print render($form['actions']); ?>
                      </span></li>
              </ul>
              <div style="display:none">
                  <?php print drupal_render_children($form); ?>
              </div>
          </div>
      </div>
    <?php } ?>
</div>