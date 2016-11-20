<?php
  defined('_JEXEC') or die; ?>

<nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="<?php echo JUri::base() ?>" title="<?php echo strip_tags($sitename) ?>">
                Bookbook
            </a>
        </li>
        <?php if($this->countModules('sidenav-menu')): ?>
          <jdoc:include type="modules" name="sidenav-menu" />
        <?php endif ?>
    </ul>
</nav>
