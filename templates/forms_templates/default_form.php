<form class="<?php echo $this->getCssClass($form_id);?>" method="POST" action="<?php echo $this->get_confirmationpage_url($form_id); ?>">
<?php
	foreach ($additionalsinputs_data as $groupe) : ?>
	<table>
<?php	foreach($groupe as $input): ?>
		<?php if (!empty($input["name"])) : ?>
		<tr>
			<td><label for="<?php echo $input['name']; ?>"><?php echo $input['label']; ?></label></td>
			<td>
				<input type="text" id="<?php echo $input['name']; ?>" name="<?php echo $input['name']; ?>" value="<?php echo $input['value']; ?>" />
			</td>
		</tr>
	<?php endif; ?>
<?php		endforeach; ?>
	</table>
<?php	endforeach; ?>
	<input type="submit"/>
</form>