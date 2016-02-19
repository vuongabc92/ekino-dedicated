<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sliders = array_shift($sliders);
//krumo($sliders);
//die;
if ($sliders->field_sector_landing_type[LANGUAGE_NONE][0]['value'] == 2) :
    $video = field_collection_item_load($sliders->field_video_collection[LANGUAGE_NONE][0]['value']);
    $video_id = isset($video->field_slider_video[LANGUAGE_NONE][0]['video_id']) ? $video->field_slider_video[LANGUAGE_NONE][0]['video_id'] : '';
    ?>
    <section class="block video-block m2m-video">
        <div data-video-embed="true" class="video-group" data-src="<?php print ($video_id !== '') ? 'https://www.youtube.com/embed/' . $video_id : ''; ?>">
            <figure class="bg-gray-5"></figure>
            <h2 class="title-4 text-white text-center">
                <a href="#" class="link-3 text-gray-1">
                    <?php print ($video->field_slider_video_description[LANGUAGE_NONE][0]['value']) ? $video->field_slider_video_description[LANGUAGE_NONE][0]['value'] : ''; ?>
                    <span class="wi-icon wi-icon-play-1"></span>
                </a>
            </h2>
        </div>
    </section>
    <?php
else :
    ?>
    <section class="block-4 campaign-block m2m-campaign list-slider">
        <div data-slider data-type="sync" data-slide-for=".carousel-campaign" name="carousel-campaign" data-set-same-height="true" class="slider">
            <div data-dots="true" class="carousel-campaign">
                <?php
                $data = $sliders->field_sliders_collection[LANGUAGE_NONE];
                if (is_array($data) && count($data)) :
                    $i = 0;
                    foreach ($data as $slider) :
                        $data_slider = field_collection_item_load($slider['value']);
                        $slider_text_color = isset($data_slider->field_color_for_landing_text[LANGUAGE_NONE][0]['rgb']) ? $data_slider->field_color_for_landing_text['und'][0]['rgb'] : '';
                        ?>
                        <div class="slide <?php print ($i === 0) ? 'move-in' : ''; ?>">
                            <figure>
                                <a href="#">
                                    <img src="<?php print file_create_url($data_slider->field_slider_image[LANGUAGE_NONE][0]['uri']); ?>" alt="<?php print substr($data_slider->field_slider_image[LANGUAGE_NONE][0]['filename'], 0, -4); ?>"/>
                                </a>
                            </figure>
                            <div class="container">
                                <div class="inner">
                                    <div class="block-3">
                                        <h2 class="title-1" style="color:<?php print $slider_text_color; ?>"><?php print (isset($data_slider->field_title_for_slide[LANGUAGE_NONE][0]['value'])) ? $data_slider->field_title_for_slide[LANGUAGE_NONE][0]['value'] : ''; ?></h2>
                                        <p class="hidden-xs hidden-sm hidden-md decs" style="color:<?php print $slider_text_color; ?>"><?php print (isset($data_slider->field_introduction_for_slide[LANGUAGE_NONE][0]['value'])) ? $data_slider->field_introduction_for_slide[LANGUAGE_NONE][0]['value'] : ''; ?></p>
                                        <a style="color:<?php print $slider_text_color; ?>" href="<?php print (isset($data_slider->field_landing_url[LANGUAGE_NONE][0]['url'])) ? $data_slider->field_landing_url[LANGUAGE_NONE][0]['url'] : '#'; ?>" class="link-1" >
                                            <?php print $data_slider->field_title_for_slide[LANGUAGE_NONE][0]['value']; ?>
                                            <span class="icon-moon-arrow-right2"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>