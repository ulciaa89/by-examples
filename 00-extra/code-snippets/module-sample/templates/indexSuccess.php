<h1>Samples List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Created by</th>
      <th>Updated by</th>
      <th>Slug</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($samples as $sample): ?>
    <tr>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getId() ?></a></td>
      <td><?php echo $sample->getTitle() ?></td>
      <td><?php echo $sample->getCreatedBy() ?></td>
      <td><?php echo $sample->getUpdatedBy() ?></td>
      <td><?php echo $sample->getSlug() ?></td>
      <td><?php echo $sample->getCreatedAt() ?></td>
      <td><?php echo $sample->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('sample/new') ?>">New</a>
