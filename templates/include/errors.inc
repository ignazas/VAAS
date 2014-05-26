<?php require_once dirname(__FILE__) . '/../../helpers/messages.inc'; ?>

<?php if ($errors = Messages::get_messages('errors')) { ?>
<div class="alert alert-danger">
	<?php foreach ($errors as $error) { ?>
	<div><?php echo $error; ?></div>
	<?php } ?>
</div>
<?php } ?>