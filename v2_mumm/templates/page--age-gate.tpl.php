<?php
/**
 * @file
 * page--age-gate.tpl.php.
 */
?>
<div id="wrapper-agegate">
  <main>
    <?php print render($page['content']); ?>
  </main>
</div>
<!-- region popup -->
<?php
if ($page['popup']) :
  print render($page['popup']);
endif;
?>
<!-- end -->