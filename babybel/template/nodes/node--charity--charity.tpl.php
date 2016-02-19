<?php
global $language, $base_root;
$image_uri = isset($node->field_pictures[LANGUAGE_NONE][0]['uri']) ? $node->field_pictures[LANGUAGE_NONE][0]['uri'] : '';
$video_nid = isset($node->field_video_player[LANGUAGE_NONE][0]['nid']) ? $node->field_video_player[LANGUAGE_NONE][0]['nid']:'';
$content = isset($node->field_contents[LANGUAGE_NONE][0]['value']) ? $node->field_contents[LANGUAGE_NONE][0]['value'] : '';
$intro = isset($node->field_intro[LANGUAGE_NONE][0]['value']) ? $node->field_intro[LANGUAGE_NONE][0]['value'] : '';
?>
<?php print render($title_prefix); ?>
<?php print render($title_suffix); ?>
  <h2 class="title-1"><?php print $node->title; ?></h2>
  <!-- .introduce -->
  <?php if($intro) { ?>
  <div class="text-description">
      <p><?php print $intro; ?></p>
  </div>
  <?php }?>
  <!-- .thumb -->
  <?php
    if($image_uri) {
      print '<div class="thumb">';
      print '<img src="' . image_style_url('1440x801', $image_uri) . '" alt="' . $node->title . '">';
      print '</div>';
    }
  ?>
  <!-- .content -->
  <?php if($content) { ?>
  <div class="content custom-editor">
    <?php print $content; ?>
  </div>
<?php } ?>
<!-- .video -->
<?php
if($video_nid){
  $video_nid = babybel_variable_get_nid_node_translated($video_nid, $node->nid);
  $video = node_load($video_nid);
  $video_status = isset($video->status) ? $video->status : 0;
  if($video && $video_status) {
    $view_video = node_view($video, 'video_player_charity');  
    print drupal_render($view_video);
  }
}

?>
