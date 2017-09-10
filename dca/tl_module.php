<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * Extension for: TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  computino.de Webservice 2009
 * @author   Patrick Bisenius
 * @author   Markus Milkereit <markus@computino.de>
 * @package  NewsExtend
 * @license  LGPL
 * @filesource
 */

$this->loadLanguageFile('tl_news');
$this->loadLanguageFile('tl_calendar_events');

$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']  = '{title_legend},name,headline,type;{config_legend},news_archives,skipX,news_numberOfItems,perPage;{advancedconfig_legend},sortBy,invertSortOrder,filterBy,filterTerm,addVisibilityPeriods;{template_legend:hide},news_metaFields,news_template;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] =  'addVisibilityPeriods';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['addVisibilityPeriods'] = 'newsListedEndDate,skipPeriod,newsListedInterval';

$GLOBALS['TL_DCA']['tl_module']['fields']['skipX'] = array
(
  'label'             => &$GLOBALS['TL_LANG']['tl_module']['skipX'],
  'default'           => 0,
  'exclude'           => true,
  'inputType'         => 'text',
  'eval'              => array('mandatory'=>true, 'rgxp'=>'digit')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['invertSortOrder'] = array
(
  'label'             => &$GLOBALS['TL_LANG']['tl_module']['invertSortOrder'],
  'exclude'           => true,
  'filter'            => true,
  'inputType'         => 'checkbox',
  'eval'              => array('tl_class' => 'w50 m12')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['sortBy'] = array
(
  'label'             => &$GLOBALS['TL_LANG']['tl_module']['sortBy'],
  'exclude'           => true,
  'filter'            => true,
  'inputType'         => 'select',
  'options_callback'  => array('ModuleNewslistExtendDB', 'getNewsFields'),
  'eval'              => array('tl_class' => 'w50'),
  'reference'         => &$GLOBALS['TL_LANG']['tl_news']
);
$GLOBALS['TL_DCA']['tl_module']['fields']['filterBy'] = array
(
  'label'             => &$GLOBALS['TL_LANG']['tl_module']['filterBy'],
  'exclude'           => true,
  'filter'            => true,
  'inputType'         => 'select',
  'default'           => '-',
  'options_callback'  => array('ModuleNewslistExtendDB', 'getNewsFields'),
  'reference'         => &$GLOBALS['TL_LANG']['tl_news'],
  'eval'              => array('tl_class' => 'w50')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['filterTerm'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_module']['filterTerm'],
  'default'         => '',
  'exclude'         => true,
  'inputType'         => 'text',
  'eval'          => array('tl_class' => 'w50')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['newsListedEndDate'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_module']['newsListedEndDate'],
  'default'         => '',
  'exclude'         => true,
  'inputType'         => 'text',
  'eval'          => array('datepicker' => $this->getDatePickerString(), 'tl_class' => 'w50 wizard', 'rgxp' => 'date')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['newsListedInterval'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_module']['newsListedInterval'],
  'default'         => 0,
  'exclude'         => true,
  'inputType'         => 'timePeriod',
  'options'         => array('days', 'weeks', 'months', 'years'),
  'reference'         => &$GLOBALS['TL_LANG']['tl_calendar_events'],
  'eval'          => array('tl_class' => 'w50')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['addVisibilityPeriods'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_module']['addVisibilityPeriods'],
  'exclude'         => true,
  'inputType'         => 'checkbox',
  'eval'          => array('submitOnChange' => true)
);
$GLOBALS['TL_DCA']['tl_module']['fields']['skipPeriod'] = array
(
  'label'           => &$GLOBALS['TL_LANG']['tl_module']['skipPeriod'],
  'default'         => 0,
  'exclude'         => true,
  'inputType'         => 'timePeriod',
  'options'         => array('days', 'weeks', 'months', 'years'),
  'reference'         => &$GLOBALS['TL_LANG']['tl_calendar_events'],
  'eval'          => array('tl_class' => 'w50')
);


class ModuleNewslistExtendDB extends Backend
{  
  public function __construct()
  {
    parent::__construct();
  }

  public function getNewsFields() 
  {    
    $fields = $this->Database->listFields('tl_news');
        
    $return = array('-');    
    foreach($fields AS $field)
    {
      $return[] = $field['name'];
    }

    sort($return);
    return $return;
  }
}
