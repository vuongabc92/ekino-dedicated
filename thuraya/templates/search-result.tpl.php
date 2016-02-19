<li class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="search-snippet-info">
  <?php print render($title_prefix); ?>
  <h3 class="title"<?php print $title_attributes; ?>>
    <a href="<?php print $url; ?>"><?php print $title; ?></a>
  </h3>
  <?php print render($title_suffix); ?>
 
    <?php if ($snippet): ?>
      <p class="search-snippet"<?php print $content_attributes; ?>><?php print $snippet; ?></p>
    <?php endif; ?>
   
  </div>
  <div class="searchmore">
	<a href="<?php print $url;?>"><span>Read more </span><span class="ui-icon arrow"></span></a>
				
  </div>
</li>
