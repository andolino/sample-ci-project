	<div class="row">
		<div class="col-12">
      <table class="table font-12 w-100" id="tbl-loan-req-attchments">
        <thead>
          <tr>
            <!-- <th scope="col"><input type="checkbox" id="chk-const-list-tbl-all" name="chk-const-list-tbl-all"></th> -->
            <th scope="col">FILE NAME</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($attachments) == 0): ?>
          <tr>
            <td colspan="2" class="text-center">NO DATA..</td>
          </tr>
          <?php else: ?>
            <?php foreach ($attachments as $row): ?>
              <tr>
                <td><?php echo $row->file_name; ?></td>
                <td><a href="<?php echo base_url() . 'assets/image/uploads/' . $row->file_name; ?>" class="btn btn-sm btn-success font-12" download>Download</a></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
		</div>
		
	</div>