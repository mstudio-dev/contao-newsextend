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
 * @author     Patrick Bisenius
 * @author     Markus Milkereit <markus@computino.de>
 * @package    NewsExtend
 * @license    LGPL
 * @filesource
 */

/**
 * Class ModuleNewsListExtend
 *
 * Extends the front end module "news list".
 * 
 * @copyright  computino.de Webservice 2009
 * @author     Patrick Bisenius
 * @author     Markus Milkereit <markus@computino.de>
 * @package    Controller
 */
class ModuleNewslistExtend extends ModuleNewsList
{

  /**
   * Template
   * @var string
   */
  protected $strTemplate = 'mod_newslist';


  /**
   * Display a wildcard in the back end
   * @return string
   */
  public function generate()
  {
        if (TL_MODE == 'BE')
    {
      $objTemplate = new BackendTemplate('be_wildcard');

      $objTemplate->wildcard = '### NEWS LIST ###';
      $objTemplate->title = $this->headline;
      $objTemplate->id = $this->id;
      $objTemplate->link = $this->name;
      $objTemplate->href = 'contao/main.php?do=modules&act=edit&id=' . $this->id;

      return $objTemplate->parse();
    }

    $this->news_archives = $this->sortOutProtected(deserialize($this->news_archives, true));

    // Return if there are no archives
    if (!is_array($this->news_archives) || count($this->news_archives) < 1)
    {
      return '';
    }

    return parent::generate();
  }


  /**
   * Generate module
   */
  protected function compile()
  {
    $limit = null;
    $offset = 0;

    $skipFirst = $this->skipFirst ? 1 : 0;
    $skipX = $this->skipX + $skipFirst;

    $sortOrder = $this->invertSortOrder ? 'ASC' : 'DESC';
    $sortBy = !empty($this->sortBy) ? $this->sortBy : 'date';    

    $filterBy = $this->filterBy;
    $filterTerm = $this->filterTerm;

    $additionalFilters = '';

    // Visibility periods

    $newsListedEndDate = $this->newsListedEndDate;
    $newsListedInterval = ($this->newsListedInterval) ? deserialize($this->newsListedInterval) : false;
    $skipPeriod = ($this->skipPeriod) ? deserialize($this->skipPeriod) : false;

    if($this->addVisibilityPeriods) 
    {
      $base = ($newsListedEndDate > 0) ? $newsListedEndDate : time();

      if($skipPeriod['value'] > 0)
      {
        $base = strtotime('-' . $skipPeriod['value'] . ' ' . $skipPeriod['unit'], $base);
      }
      if(!empty($newsListedInterval) AND $newsListedInterval['value'] > 0) 
      {
        $start = strtotime('-' . $newsListedInterval['value'] . ' ' . $newsListedInterval['unit'], $base);
        $additionalFilters .= ' AND date BETWEEN ' . $start . ' AND ' . $base . ' ';
      }
      elseif(empty($newsListedInterval) OR $newsListedInterval['value'] <= 0)
      {
        $additionalFilters .= ' AND date < ' . $base . ' '; 
      }
    }
    
    // Define filter operator
    if(!empty($filterBy) AND $filterBy != '-' AND $filterTerm) 
    {
      // Datumsfeld
      if(in_array($filterBy, array('tstamp', 'time', 'date'))) 
      {
        $filterTerm = new Date(strtotime($filterTerm));
        $additionalFilters .= " AND (" . $filterBy  . " BETWEEN " . $filterTerm->dayBegin . " AND " . $filterTerm->dayEnd . ") ";
      }
      else
      {
        $additionalFilters .= " AND " . $filterBy . " LIKE '%" . $filterTerm . "%'";
      }
    }        

    // Maximum number of items
    if ($this->news_numberOfItems > 0)
    {
      $limit = $this->news_numberOfItems + $skipX;
    }

    $time = time();

    // Split result
    if ($this->perPage > 0)
    {
      // Get total number of items
      $objTotalStmt = $this->Database->prepare("SELECT id AS count FROM tl_news WHERE pid IN(" . implode(',', $this->news_archives) . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . $additionalFilters . " ORDER BY " . $sortBy . " " . $sortOrder);

      if (!is_null($limit))
      {
        $objTotalStmt->limit($limit);
      }

      $objTotal = $objTotalStmt->execute($time, $time);
      $total = $objTotal->numRows - $skipX;

      // Get the current page
      $page = $this->Input->get('page') ? $this->Input->get('page') : 1;

      if ($page > ($total/$this->perPage))
      {
        $page = ceil($total/$this->perPage);
      }

      // Set limit and offset
      $limit = ((is_null($limit) || $this->perPage < $limit) ? $this->perPage : $limit) + $skipX;
      $offset = ((($page > 1) ? $page : 1) - 1) * $this->perPage;

      // Add pagination menu
      $objPagination = new Pagination($total, $this->perPage);
      $this->Template->pagination = $objPagination->generate("\n  ");
    }

    $objArticlesStmt = $this->Database->prepare("SELECT *, author AS authorId, (SELECT title FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS archive, (SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo,(SELECT name FROM tl_user WHERE id=author) AS author FROM tl_news WHERE pid IN(" . implode(',', $this->news_archives) . ")" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1" : "") . $additionalFilters . " ORDER BY " . $sortBy . " " . $sortOrder);

    // Limit result
    if ($limit)
    {
      $objArticlesStmt->limit($limit, $offset);
    }

    $objArticles = $objArticlesStmt->execute($time, $time);

    // Skip x articles
    for($i = 0; $i < $skipX; $i++)
    {
      $objArticles->next();
    }

    $this->Template->articles = $this->parseArticles($objArticles);
    $this->Template->archives = $this->news_archives;
  }
}