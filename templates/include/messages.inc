<?php require_once dirname(__FILE__) . '/../../helpers/messages.inc'; ?>

<?php if ($messages = Messages::get_messages('messages')) { ?>
<div class="alert alert-success">
    <?php foreach ($messages as $message) { ?>
    <div><?php echo $message; ?></div>
    <?php } ?>
</div>
<?php } ?>