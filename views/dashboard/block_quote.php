<?php if (isset($elements['quote']) && is_array($elements['quote']) && !empty($elements['quote'])) { ?>

<div class="col-md-4">
  <h2>Posakiai</h2>
  <blockquote class="pull-right">
    <?php echo $elements['quote'][array_rand($elements['quote'])];?>
  </blockquote>
</div>

<?php } ?>
