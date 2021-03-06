<?php

/**
 * SEO Metadata Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2018 Alfredo Ramos
 * @license GNU GPL-2.0-only
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @ignore
 */
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_SEO_METADATA' => 'SEO Metadata settings',
	'ACP_SEO_METADATA_EXPLAIN' => 'After changing these values, you might need to purge the cache.',
	'ACP_SEO_METADATA_DESC_LENGTH' => 'Description length',
	'ACP_SEO_METADATA_DESC_LENGTH_EXPLAIN' => 'Maximum length for description that will be used in meta tags such as <samp>og:description</samp>. It has a hard limit of <samp>255</samp> characters.',
	'ACP_SEO_METADATA_DESC_HANDLING' => 'Description handling',
	'ACP_SEO_METADATA_DESC_HANDLING_EXPLAIN' => 'Exact - cuts description at exact position if it exceeds maximum length.<br>Ellipsis - Adds "..." to the end of description if it exceeds maximum length.<br>Break - Fits as many words as possible without exceeding the maximum length.',
	'ACP_SEO_METADATA_DEFAULT_IMAGE' => 'Default image',
	'ACP_SEO_METADATA_DEFAULT_IMAGE_EXPLAIN' => 'Default image URL for meta tags such as <samp>og:image</samp>. It will only be used if an image cannot be found within the current page. It must be relative to <samp>%s</samp>',
	'ACP_SEO_METADATA_SETTINGS_SAVED' => 'SEO Metadata settings have been succesfully saved.',

	'ACP_SEO_METADATA_DATA_EXPLAIN' => 'Metadata are dynamically generated from your board data.',

	'ACP_GLOBAL_SETTINGS' => 'Global settings',

	'ACP_OPEN_GRAPH_SETTINGS' => 'Open Graph settings',
	'ACP_OPEN_GRAPH' => 'Enable Open Graph',

	'ACP_JSON_LD_SETTINGS' => 'JSON+LD settings',
	'ACP_JSON_LD' => 'Enable JSON+LD',

	'LOG_SEO_METADATA_DATA' => '<strong>SEO Metadata data changed</strong><br />» %s'
]);
