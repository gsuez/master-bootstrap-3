<?php

$document = JFactory::getDocument();
// unsetting Default Joomla scripts
unset($document->_scripts[JURI::root(true).'/media/system/js/caption.js']);
unset($document->_scripts[JURI::root(true).'/media/system/js/core.js']);
unset($document->_scripts[JURI::root(true).'/media/system/js/mootools-core.js']);
unset($document->_scripts[JURI::root(true).'/media/system/js/mootools-more.js']);
unset($document->_styleSheets[JURI::root(true).'/media/system/css/modal.css']);
?>
