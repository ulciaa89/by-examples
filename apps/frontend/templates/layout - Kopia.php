<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>

<?php use_helper('Crosslinks') ?>
<p>
    <a href="<?php echo link_to_backend('homepage') ?>">go to backend</a>
</p>

<ul>
    <li><a href="<?php echo url_for('sfGuardRegister/index') ?>">register</a></li>
    <li><a href="<?php echo url_for('sfGuardAuth/signin') ?>">login</a></li>
    <li><a href="<?php echo url_for('sfGuardAuth/signout') ?>">logout</a></li>
    <li><a href="<?php echo url_for('main/show') ?>">show</a></li>
    <li><a href="<?php echo url_for('main/lorem/ipsum') ?>">error 404</a></li>
    <li><a href="<?php echo url_for('main/error500') ?>">error 500</a></li>
    <li><a href="<?php echo url_for('main/index') ?>">index</a></li>
    <li><a href="<?php echo url_for('sample/index') ?>">sample</a></li>
</ul>


<p>
<?php if ($sf_user->isAuthenticated()): ?>
    Logged in as <strong><?php echo $sf_user->getUsername() ?></strong>
<?php else: ?>
    You are not logged in
<?php endif; ?>
</p>



    <?php echo $sf_content ?>
  </body>
</html>
