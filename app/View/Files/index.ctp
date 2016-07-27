<h1>Upload File</h1>
<div class="content">
  <?php $this->Flash->render() ?>
  <div class="upload-frm">
    <?php echo $this->Form->create('File', ['type' => 'file']); ?>
    <?php echo $this->Form->input('file', ['type' => 'file', 'class' => 'form-control']); ?>
    <?php echo $this->Form->button(__('Upload File'), ['type'=>'submit', 'class' => 'form-controlbtn btn-default']); ?>
    <?php echo $this->Form->end(); ?>
  </div>
</div>

<h1>Uploaded Files</h1>

<div class="content">
  <!-- Table -->
  <table class="table">
    <tr>
      <th width="1%">#</th>
      <th width="15%">File</th>
      <th width="5%">Upload Date</th>
      <th width="5%">IP Address</th>
    </tr>
    <?php if(!empty($files):$count = 0; foreach($files as $file): $count++;?>
      <tr>
        <td><?php echo $count; ?></td>
        <td><a href="<?= $file['Files']['path'] . $file['Files']['name'] ?>"><?php echo $file['Files']['name']?></a></td>
        <td><?php echo $file['Files']['created']; ?></td>
        <td><?php echo $file['Files']['ip_address']; ?></td>
      </tr>
    <?php endforeach; else:?>
      <tr><td colspan="4">No file(s) found......</td>
    <?php endif; ?>
  </table>
</div>
