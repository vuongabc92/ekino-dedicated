<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section data-vertical-middle="true" data-get-height=".description-block-1 .container .desc" data-set-padding=".container .desc" class="description-block description-block-1 .editor-1 bg-light-gray">
  <div class="container">
    <div class="wrap">
      <div class="inner">
        <div class="desc text-dark-gray-1">
          <p>
            <?php
            $descriptions = variable_get('thu_develop_description');
            print $descriptions['value'];
            ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>