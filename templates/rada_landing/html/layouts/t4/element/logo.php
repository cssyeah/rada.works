<?php
$doc = $displayData->doc;
$conf = JFactory::getConfig();
$width = $height = "auto";
$site_settings = $doc->params->get('site-settings');

$site_name = $site_settings->get('site_name', $conf->get('sitename'));
$site_slogan = $site_settings->get('site_slogan', '');
$logo = $site_settings->get('site_logo');
$logo_small = $site_settings->get('site_logo_small');
$logo_cls = $logo ? 'logo-image' : 'logo-text';
$logo_sm_cls = '';
if ($logo_small) {
    $logo_cls .= ' logo-control';
    $logo_sm_cls = ' d-none d-sm-block';
    if(version_compare(JVERSION,'4','ge')){
      $logo_small = \T4\Helper\Metadata::cleanImageURL($logo_small)->url;
    }
}
if(version_compare(JVERSION,'4','ge') && $logo){
  $logo_arr = \T4\Helper\Metadata::cleanImageURL($logo);
  $logo = $logo_arr->url;
}
if(file_exists(JPATH_ROOT."/".$logo)){

  list($width, $height) = getimagesize(JPATH_ROOT."/".$logo);
}

$hasLink = !empty($displayData->params) && !empty($displayData->params['nolink']) ? false : true;
?>
<div class="navbar-brand <?php echo $logo_cls; ?>">
  <?php if ($hasLink): ?>
  <a href="<?php echo JUri::base(); ?>" title="<?php echo strip_tags($site_name); ?>">
  <?php endif; ?>

    <img class="logo-img-sm" src="images/rada-network.svg" alt="<?php echo strip_tags($site_name); ?>" />
  
  <?php if ($hasLink): ?>
  </a>
  <?php endif; ?>
</div>
