<?php
namespace T4\Helper;

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Registry\Registry;

class Author {
	public static function render($item, $params, $displayType,$templateParams) {
		$params = self::getTypeListSiteConfig();

		if($params->get('author_position','') == $displayType){
			$model = \JModelLegacy::getInstance('Author', 'ContentModel', array('ignore_request' => true));
			$author = $model->getAuthor($item->created_by);

			return LayoutHelper::render('t4.content.author_info', ["author"=> $author,'link' =>true,'class'=>'author-block-post-detail pos_'.$displayType] , T4PATH_BASE . '/html/layouts');
		}
		return "";
	}

	public static function authorInfo($items){
		$params = self::getTypeListSiteConfig();
		$model = \JModelLegacy::getInstance('Author', 'ContentModel', array('ignore_request' => true));
		$author = $model->getAuthor($items->created_by);
		if ($params->get('author_link','') != 1){
			$author->link = (isset($items->contact_link) && $items->params->get('link_author') == true) ? $items->contact_link : '';
		}
		if ($params->get('author_show_avatar','')){
			$proParams = $author->profile;
			if(!empty($proParams->get('user_avatar'))){
				$avatar = \JUri::base(). $proParams->get('user_avatar');
			}else{
				if(file_exists(JPATH_ROOT . "/media/t4/author/default.jpg")){
					$avatar = \JUri::base().'/media/t4/author/default.jpg';
				}else {
					$avatar = "//www.gravatar.com/avatar";
				}
			}
			$author->author_avatar = $avatar;
		}
		return $author;
	}

	public static function getTypeListSiteConfig(){
		$templateParams = JFactory::getApplication()->getTemplate('site')->params; 
		$siteConfig = Path::getFileContent('etc/site/' . $templateParams->get('typelist-site') . '.json');
		if(!$siteConfig){
			$siteConfig = Path::getFileContent('etc/site/default.json');
		}
		$params = new Registry(json_decode($siteConfig,true));
		return $params;
	}
}