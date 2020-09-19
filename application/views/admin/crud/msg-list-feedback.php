<?php if(count($msg) == 0): ?>
  <li class="list-group-item font-12 text-center">NO MESSAGE</li>
<?php else: ?>
<?php foreach($msg as $row): ?>
  <li class="list-group-item font-12"><?php echo $row->msg; ?></li>
<?php endforeach; ?>
<?php endif; ?>