<style type="text/css">
	.font-9{
		font-size: 9px !important;
	}
	.font-11{
		font-size: 11px !important;
	}
	.name{

	}
	.position{
		margin-top: 0;
	}
	.address{

	}
	.date-joined span{
		font-weight: 800;
	}
	img {
		object-fit: cover !important;
		width: 100%;
		height: 163px;
	}
</style>

<table style="padding-top: 85px;" cellspacing="8">
	<tr>
		<td style="width: 33%;">
			<br><br><br>
			<?php if ($dUploads && @file_exists('assets/image/uploads/' . $dUploads[$data->lgu_constituent_id])): ?>
				<img width="200" src="<?php echo 'assets/image/uploads/' . $dUploads[$data->lgu_constituent_id]; ?>" style="padding-right: 20px;">
			<?php else: ?>
				<img width="200" src="<?php echo 'assets/image/misc/default-user-member-image.png'; ?>">
			<?php endif; ?>
		</td>
		<td style="width: 40%;">
			<br>
			<h4 class="name font-11"><?php echo strtoupper($data->last_name.', '.$data->first_name.' '.$data->middle_name); ?></h4>
			<p class="position font-9"><?php echo strtoupper($data->email); ?></p>
			<p class="address font-9"><?php echo $data->residential_address; ?></p>
			<p class="date-joined font-9">Date Joined: <br><span><strong><?php echo date('F j, Y', strtotime($data->transaction_date)); ?>	</strong></span></p>
		</td>
		<td style="text-align: right;line-height: 4;width: 27.5%;">
			<br>
			<?php echo str_pad($data->lgu_constituent_id, 8, '0', STR_PAD_LEFT); ?>
		</td>
	</tr>
</table>