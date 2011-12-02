<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $sample->getId() ?></td>
    </tr>
    <tr>
      <th>Title:</th>
      <td><?php echo $sample->getTitle() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $sample->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $sample->getUpdatedBy() ?></td>
    </tr>
    <tr>
      <th>Slug:</th>
      <td><?php echo $sample->getSlug() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $sample->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $sample->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('sample/edit?id='.$sample->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('sample/index') ?>">List</a>
