<?php

/**
 * SEO Metadata Extension for phpBB.
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright 2018 Alfredo Ramos
 * @license GNU GPL-2.0-only
 */

namespace alfredoramos\seometadata\includes;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;

class helper
{

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $root_path;

	/** @var array */
	protected $metadata;

	public function __construct(config $config, template $template, user $user, $root_path)
	{
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->root_path;

		$current_page = $this->user->extract_current_page($this->root_path);
		$current_url = vsprintf('%1$s/%2$s', [generate_board_url(), $current_page['page']]);

		$this->metadata = [
			'open_graph' => [
				'og:locale' => $this->config['default_lang'],
				'og:site_name' => $this->config['sitename'],
				'og:title' => '',
				'og:description' => $this->clean_description(
					$this->config['site_desc']
				),
				'og:type' => 'website',
				'og:image' => $this->clean_image(
					$this->config['seo_metadata_default_image']
				),
				'og:url' => $current_url
			],
			'json_ld' => [
				'@context' => 'http://schema.org',
				'@type' => 'DiscussionForumPosting',
				'@id' => $current_url,
				'headline' => '',
				'description' => $this->clean_description(
					$this->config['site_desc']
				),
				'image' => $this->clean_image(
					$this->config['seo_metadata_default_image']
				)
			]
		];

	}

	public function set_metadata($data = [], $key = '')
	{
		if (!empty($key) && !empty($this->metadata[$key]))
		{
			$this->metadata = array_replace($this->metadata[$key], $data);
		}
		else
		{
			$this->metadata = array_replace_recursive($this->metadata, $data);
		}
	}

	public function get_metadata($key = '')
	{
		if (!empty($key) && !empty($this->metadata[$key]))
		{
			return $this->metadata[$key];
		}

		return $this->metadata;
	}

	public function metadata_template_vars()
	{
		$this->template->destroy_block_vars('SEO_METADATA');
		$data = $this->get_metadata();

		foreach ($data as $key => $value)
		{
			if (!((int) $this->config[sprintf('seo_metadata_%s', $key)] === 1))
			{
				continue;
			}

			$this->template->assign_block_vars(
				'SEO_METADATA',
				[
					'NAME' => strtoupper($key),
				]
			);

			foreach ($value as $k => $v)
			{
				$this->template->assign_block_vars(
					sprintf('SEO_METADATA.%s', strtoupper($key)),
					[
						'PROPERTY' => $k,
						'CONTENT' => $v
					]
				);
			}
		}
	}

	public function clean_description($description = '')
	{
		// Cast values
		$description = (string) $description;
		$max_length = (int) $this->config['seo_metadata_desc_length'];
		$handling = (int) $this->config['seo_metadata_desc_handling'];

		if (empty($description))
		{
			return '';
		}

		// Remove BBCode
		strip_bbcode($description);

		// Remove whitespaces
		$description = preg_replace('/\s+/', ' ', $description);
		$description = trim($description);

		// Check description length
		if (mb_strlen($description, 'UTF-8') > $max_length)
		{
			if ($handling == 1) // Exact
			{
				$description = mb_substr($description, 0, $max_length, 'UTF-8');
			}
			else if ($handling == 2) // Ellipsis
			{
				$description = mb_substr($description, 0, $max_length, 'UTF-8') . "...";
			}
			else if ($handling == 3) // Break
			{
				$last_space_pos = mb_strrpos(substr($description, 0, $max_length), ' ');
				$description = mb_substr($description, 0, ($last_space_pos ? $last_space_pos : $max_length), 'UTF-8');
			}
		}

		return trim($description);
	}

	public function clean_image($uri = '')
	{
		if (empty($uri))
		{
			return '';
		}

		// Clean URI
		$uri = preg_replace('/^\.\//', '', $uri);

		return vsprintf(
			'%1$s/images/%2$s',
			[
				generate_board_url(),
				$uri
			]
		);
	}
}
