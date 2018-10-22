<?php
// Blogmap plugin, https://github.com/datenstrom/yellow-plugins/tree/master/blogmap
// Copyright (c) 2013-2017 Datenstrom, https://datenstrom.se
// This file may be used and distributed under the terms of the public license.

class YellowBlogmap
{
	const VERSION = "0.7.6";
	var $yellow;			//access to API
	
	// Handle initialisation
	function onLoad($yellow)
	{
		$this->yellow = $yellow;
		$this->yellow->config->setDefault("blogmapPaginationLimit", "1000");
		$this->yellow->config->setDefault("blogmapLocation", "/blogmap/");
		$this->yellow->config->setDefault("blogmapFileXml", "blogmap.xml");
		$this->yellow->config->setDefault("blogmapFilter", "blog");
	}

	// Handle page parsing
	function onParsePage()
	{
		if($this->yellow->page->get("template")=="blogmap")
		{
			$blogmapFilter = $this->yellow->config->get("blogmapFilter");
			$chronologicalOrder = ($this->yellow->config->get("blogmapFilter")!="blog");
			$pagination = $this->yellow->config->get("contentPagination");
			if($_REQUEST[$pagination]==$this->yellow->config->get("blogmapFileXml"))
			{
				$pages = $this->yellow->pages->index(false, false);
				if(!empty($blogmapFilter)) $pages->filter("template", $blogmapFilter);
				$pages->sort($chronologicalOrder ? "modified" : "published", false);
				$pages->limit($this->yellow->config->get("blogmapPaginationLimit"));
				$this->yellow->page->setLastModified($pages->getModified());
				$this->yellow->page->setHeader("Content-Type", "text/xml; charset=utf-8");
				$output = "<?xml version=\"1.0\" encoding=\"utf-8\"\077>\r\n";
				$output .= "<urlset	xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"	xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
				//$output .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
				foreach($pages as $page)
				{
					$timestamp = strtotime($page->get($chronologicalOrder ? "modified" : "published"));
					$output .= "<url><loc>".$page->getUrl()."</loc></url>\r\n";			
				}
				$output .= "</urlset>\r\n";
				$this->yellow->page->setOutput($output);
			} else {
				$pages = $this->yellow->pages->index(false, false);
				if(!empty($blogmapFilter)) $pages->filter("template", $blogmapFilter);
				$pages->sort($chronologicalOrder ? "modified" : "published");
				$pages->pagination($this->yellow->config->get("blogmapPaginationLimit"));
				if(!$pages->getPaginationNumber()) $this->yellow->page->error(404);
				$this->yellow->page->set("blogmapChronologicalOrder", $chronologicalOrder);
				$this->yellow->page->setPages($pages);
				$this->yellow->page->setLastModified($pages->getModified());
			}
		}
	}
	
	// Handle page extra HTML data
	function onExtra($name)
	{
		$output = NULL;
		if($name=="header")
		{
			$pagination = $this->yellow->config->get("contentPagination");			
			$locationBlogmap = $this->yellow->config->get("serverBase").$this->yellow->config->get("blogmapLocation");
			$locationBlogmap .= $this->yellow->toolbox->normaliseArgs("$pagination:".$this->yellow->config->get("blogmapFileXml"), false);
			$output = "<link rel=\"sitemap\" type=\"text/xml\" href=\"$locationBlogmap\" />\n";
		}
		return $output;
	}
}

$yellow->plugins->register("blogmap", "YellowBlogmap", YellowBlogmap::VERSION);
?>