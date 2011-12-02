<h1>Articles List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Title</th>
      <th>Lead</th>
      <th>Contents</th>
      <th>Created by</th>
      <th>Updated by</th>
      <th>Slug</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($articles as $article): ?>
    <tr>
      <td><a href="<?php echo url_for('art/edit?id='.$article->getId()) ?>"><?php echo $article->getId() ?></a></td>
      <td><?php echo $article->getTitle() ?></td>
      <td><?php echo $article->getLead() ?></td>
      <td><?php echo $article->getContents() ?></td>
      <td><?php echo $article->getCreatedBy() ?></td>
      <td><?php echo $article->getUpdatedBy() ?></td>
      <td><?php echo $article->getSlug() ?></td>
      <td><?php echo $article->getCreatedAt() ?></td>
      <td><?php echo $article->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('art/new') ?>">New</a>
