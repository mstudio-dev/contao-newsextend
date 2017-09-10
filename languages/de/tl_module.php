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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['skipX'] = array('Beiträge bei Ausgabe überspringen', 'Geben Sie an, wieviele Beiträge insgesamt bei der Ausgabe der Newsliste übersprungen werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['invertSortOrder'] = array('Sortierung umkehren', 'Wählen Sie diese Option, wenn die News aufsteigend nach dem Sortierkriterium sortiert werden sollen.');
$GLOBALS['TL_LANG']['tl_module']['sortBy'] = array('Sortieren nach', 'Geben Sie an, nach welchem Feld die Newsliste sortiert werden soll.');
$GLOBALS['TL_LANG']['tl_module']['filterBy'] = array('Filtern nach', 'Geben Sie an, nach welchem Feld gefiltert werden soll.');
$GLOBALS['TL_LANG']['tl_module']['filterTerm'] = array('Filterausdruck', 'Geben Sie an, welche Bedingung das Feld erfüllen muss.');
$GLOBALS['TL_LANG']['tl_module']['newsListedEndDate'] = array('Referenzdatum', 'Geben Sie hier etwas an, wenn Sie eine Seite einrichten wollen, die einen festen Zeitraum mit News abdeckt. LEEREN sie dieses Feld, wenn sie das NICHT wollen!');
$GLOBALS['TL_LANG']['tl_module']['newsListedInterval'] = array('Anzeigezeitraum', 'Geben Sie an, welcher Zeitraum vor dem Referenzdatum einbezogen werden soll.');
$GLOBALS['TL_LANG']['tl_module']['addVisibilityPeriods'] = array('Sichtbarkeitszeiträume angeben', 'Wählen Sie diese Option, wenn Ihre Angaben zur zeitraumbezogenen Anzeige von News beachtet werden sollen!');
$GLOBALS['TL_LANG']['tl_module']['skipPeriod'] = array('Zeitraum überspringen', 'Mit dieser Option können Sie dynamisch einen Zeitraum überspringen wollen (falls kein Referenzdatum angegeben wurde; ansonsten wird dieses Feld vom Referenzdatum abgezogen!).');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_module']['advancedconfig_legend'] = 'Erweiterte Modulkonfiguration';